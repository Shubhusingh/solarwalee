<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Dps;

class DpsController extends Controller
{
    protected $pageTitle;

    public function index()
    {
        $this->pageTitle = 'All DPS (Deposit Pension Scheme)';
        return $this->dpsData();
    }

    public function runningDps()
    {
        $this->pageTitle = 'Running DPS (Deposit Pension Scheme)';
        return $this->dpsData('running');
    }

    public function maturedDps()
    {
        $this->pageTitle = 'Matured DPS (Deposit Pension Scheme)';
        return $this->dpsData('matured');
    }

    public function closedDps()
    {
        $this->pageTitle = 'Closed DPS (Deposit Pension Scheme)';
        return $this->dpsData('closed');
    }

    public function dueInstallment()
    {

        $this->pageTitle = 'Due Installment DPS (Deposit Pension Scheme)';
        return $this->dpsData('due');
    }

    public function installments($id)
    {
        $dps          = Dps::with('installments')->findOrFail($id);
        $installments = $dps->installments()->paginate(getPaginate());
        $pageTitle    = "DPS Installments";
        return view('admin.dps.installments', compact('pageTitle', 'installments', 'dps'));
    }

    protected function dpsData($scope = null)
    {
        $query = Dps::orderBy('id', 'DESC');
        if ($scope) {
            $query->$scope();
        }
        $pageTitle = $this->pageTitle;
        $data      = $query->searchAble(['dps_number'])->with('user', 'plan')->dateFilter()->with('nextInstallment')->withCount('dueInstallments');

        if (request()->download == 'pdf') {
            $dps = $data->get();
            return downloadPdf('admin.pdf.dps.index', compact('pageTitle', 'dps'));
        }
        if (request()->download == 'csv') {
            $filename = $this->downloadCsv($pageTitle, $data->get());
            return response()->download(...$filename);
        }

        $data = $data->paginate(getPaginate());

        $pdfCsvButton = false;
        if (request()->date) {
            $pdfCsvButton = true;
        }

        return view('admin.dps.index', compact('pageTitle', 'data', 'pdfCsvButton'));
    }

    protected function downloadCsv($pageTitle, $data)
    {
        $filename = "assets/files/csv/example.csv";
        $myFile   = fopen($filename, 'w');
        $column   = "DPS No,Plan,Username,Amount,Amount For, Total Installment,Given Installment,Next Installment,After Matured,Created,Status\n";
        $curSym   = gs('cur_sym');

        $dpsStatusRunning = Status::DPS_RUNNING;
        $dpsStatusMatured = Status::DPS_MATURED;

        foreach ($data as $dps) {
            $planName        = @$dps->plan->name;
            $userName        = @$dps->user->username;
            $amount          = $curSym . getAmount($dps->per_installment);
            $amountFor       = $dps->installment_interval . ' Days';
            $nextInstallment = showDateTime(@$dps->nextInstallment->installment_date, 'd-m-Y') ?? 'N/A';
            $afterMatured    = $curSym . getAmount($dps->depositedAmount() + $dps->profitAmount());
            $createdAt       = showDateTime($dps->created_at, 'd-m-Y');
            if ($dps->due_installments_count > 0) {
                $status = 'Due';
            } elseif ($dps->status == $dpsStatusRunning) {
                $status = 'Running';
            } elseif ($dps->status == $dpsStatusMatured) {
                $status = 'Matured';
            } else {
                $status = 'Closed';
            }
            $column .= "$dps->dps_number,$planName,$userName,$amount,$amountFor,$dps->total_installment,$dps->given_installment,$nextInstallment, $afterMatured,$createdAt,$status\n";
        }
        fwrite($myFile, $column);
        $headers = [
            'Content-Type' => 'application/csv',
        ];
        $name  = $pageTitle . time() . '.csv';
        $array = [$filename, $name, $headers];
        return $array;
    }
}
