<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction(Request $request)
    {
        $pageTitle = 'Transaction Logs';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::searchable(['trx', 'user:username'])->filter(['trx_type', 'remark'])->dateFilter()->orderBy('id', 'desc')->with('user');
        if (request()->download == 'pdf') {
            $transactions = $transactions->get();
            return downloadPdf('admin.pdf.report.transaction', compact('pageTitle', 'transactions'));
        }
        if (request()->download == 'csv') {
            $filename = $this->downloadCsv($transactions->get());
            return response()->download(...$filename);
        }
        $transactions = $transactions->paginate(getPaginate());

        $pdfCsvButton = false;
        if (request()->date) {
            $pdfCsvButton = true;
        }
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks', 'pdfCsvButton'));
    }

    protected function downloadCsv($transactions)
    {
        $filename = "assets/files/csv/example.csv";
        $myFile = fopen($filename, 'w');
        $column = "User,TRX,Transacted,Amount,Post Balance,Details\n";
        foreach ($transactions as $data) {
            $user = @$data->user->fullname;
            $transacted = showDateTime($data->created_at, 'd-m-Y');
            $amount = $data->trx_type . gs('cur_sym') . showAmount($data->amount);
            $postBalance = gs('cur_sym') . showAmount($data->post_balance);
            $column .= "$user,$data->trx,$transacted,$amount,$postBalance,$data->details\n";
        }
        fwrite($myFile, $column);
        $headers = [
            'Content-Type' => 'application/csv',
        ];
        $name = 'Transaction-' . time() . '.csv';
        $array = [$filename, $name, $headers];
        return $array;
    }


    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs', 'ip'));
    }

    public function notificationHistory(Request $request)
    {
        $pageTitle = 'Notification History';
        $logs = NotificationLog::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }
}