<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadPreviewController extends Controller
{
    public function fdrPreview(Request $request)
    {

        $fdr = auth()->user()->fdr()->where('fdr_number', $request->fdr_number)->with('plan:id,name,interest_rate')->orderBy('id', 'DESC')->firstOrFail();
        $pageTitle = "FDR Details";
        return view($this->activeTemplate . 'preview.fdr', compact('pageTitle', 'fdr'));
    }

    public function fdrDownload($id)
    {
        $pageTitle = "FDR Details";
        $fdr = auth()->user()->fdr()->where('id', $id)->with('plan:id,name,interest_rate')->orderBy('id', 'DESC')->firstOrFail();
        return downloadPDF($this->activeTemplate . 'pdf.fdr', compact('pageTitle', 'fdr'));
    }

    public function dpsPreview(Request $request)
    {
        $dps = auth()->user()->dps()->where('dps_number', $request->dps_number)->with('plan')->orderBy('id', 'DESC')->firstOrFail();
        $pageTitle = "DPS Details";
        return view($this->activeTemplate . 'preview.dps', compact('pageTitle', 'dps'));
    }

    public function dpsDownload($id)

    {
        $pageTitle = "DPS Details";
        $dps = auth()->user()->dps()->where('id', $id)->with('plan')->orderBy('id', 'DESC')->firstOrFail();
        return downloadPDF($this->activeTemplate . 'pdf.dps', compact('pageTitle', 'dps'));
    }

    public function loanPreview(Request $request)
    {
        $loan = auth()->user()->loan()->where('loan_number', $request->loan_number)->with('plan')->orderBy('id', 'DESC')->firstOrFail();
        $pageTitle = "Loan Details";
        return view($this->activeTemplate . 'preview.loan', compact('pageTitle', 'loan'));
    }

    public function loanDownload($id)
    {
        $pageTitle = "Loan Details";
        $loan = auth()->user()->loan()->where('id', $id)->with('plan')->orderBy('id', 'DESC')->firstOrFail();
        return downloadPDF($this->activeTemplate . 'pdf.loan', compact('pageTitle', 'loan'));
    }
    public function transferPreview(Request $request)
    {
        $transfer = auth()->user()->transfer()->where('id', $request->transfer_no)->with(['user', 'beneficiary'])->orderBy('id', 'DESC')->firstOrFail();
        $otherBank    = $request->other_bank;
        $wireTransfer = $request->wire_transfer;
        $pageTitle    = "Transfer Information";
        
        return view($this->activeTemplate . 'preview.transfer', compact('pageTitle', 'transfer', 'otherBank'));
    }

    public function transferDownload($id)
    {
        $transfer = auth()->user()->transfer()->where('id', $id)->with(['user', 'beneficiary'])->orderBy('id', 'DESC')->firstOrFail();
        $otherBank = false;
        if (@$transfer->beneficiary->beneficiaryOf->name) {
            $otherBank = true;
        }
        $pageTitle = "Transfer Information";
        return downloadPDF($this->activeTemplate . 'pdf.transfer', compact('pageTitle', 'transfer', 'otherBank'));
    }
}