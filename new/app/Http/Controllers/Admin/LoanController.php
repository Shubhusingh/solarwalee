<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Lead;

use App\Models\Acvitity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class LoanController extends Controller
{
    protected $pageTitle;

    public function index()
    {
        $this->pageTitle = 'All Lead';
        return $this->loanData(1);
    }

    public function runningLoans()
    {
        $this->pageTitle = 'Fresh Lead';
        return $this->loanData(3);
    }

    public function pendingLoans()
    {
        $this->pageTitle = 'Pending Lead';
        return $this->loanData(2);
    }

    public function paidLoans()
    {
        $this->pageTitle = 'Less Salery Loans';
        return $this->loanData(5);
    }

    public function Not_Eligible(){
        $this->pageTitle = 'Not Eligible';
        return $this->loanData(6);

    }
    public function rejectedLoans()
    {
        $this->pageTitle = 'Rejected Loans';
        return $this->loanData("rejected");
    }

    public function dueInstallment()
    {
        $this->pageTitle = 'Interested Lead';
        return $this->loanData(4);
    }

    public function details($id)
    {

     
        $loan      = Lead::where('id', $id)->with('plan', 'user')->firstOrFail();

        
        $pageTitle = 'Lead Details';
        return view('admin.loan.details', compact('pageTitle', 'loan'));
    }

    public function approve($id)
    {
        $loan              = Loan::with('user', 'plan')->findOrFail($id);
        $loan->status      = Status::LOAN_RUNNING;
        $loan->approved_at = now();
        $loan->save();
        Installment::saveInstallments($loan, now()->addDays($loan->installment_interval));

        $user = $loan->user;
        $user->balance += getAmount($loan->amount);
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $loan->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Loan taken';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'loan_taken';
        $transaction->save();

        $shortCodes                          = $loan->shortCodes();
        $shortCodes['next_installment_date'] = now()->addDays($loan->installment_interval);

        notify($user, "LOAN_APPROVE", $loan->shortCodes());

        $notify[] = ['success', 'Loan approved successfully'];
        return back()->withNotify($notify);
    }

    public function reject(Request $request, $id)
    {

        $request->validate([
            'reason' => 'required|string',
        ]);

        $loan                 = Loan::where('id', $request->id)->with('user', 'plan')->firstOrFail();
        $loan->status         = 3;
        $loan->admin_feedback = $request->reason;
        $loan->save();

        notify($loan->user, "LOAN_REJECT", $loan->shortCodes());

        $notify[] = ['success', 'Loan rejected successfully'];
        return back()->withNotify($notify);
    }

    protected function loanData($scope = null)
    {
        
        $loans = Lead::orderBy('id', 'DESC')->where('lead_status',$scope);

        // if ($scope) {
        //     $query->$scope();
        // }

        $pageTitle = $this->pageTitle;
      

        if (request()->download == 'pdf') {
            $loans = $loans->get();
            return downloadPdf('admin.pdf.loan.index', compact('pageTitle', 'loans'));
        }
        if (request()->download == 'csv') {
            $filename = $this->downloadCsv($pageTitle, $loans->get());
            return response()->download(...$filename);
        }



        $loans = $loans->paginate(getPaginate());

       
     

        $pdfCsvButton = false;
        if (request()->date) {
            $pdfCsvButton = true;
        }
        return view('admin.loan.index', compact('pageTitle', 'loans', 'pdfCsvButton'));
    }
    protected function downloadCsv($pageTitle, $data)
    {
        $filename = "assets/files/csv/example.csv";
        $myFile   = fopen($filename, 'w');
        $column   = "Loan No,Plan,A/C No., Username,Amount,Receivable Amount, Installment Amount,Installment For, Total Installment, Given Installment, Next Installment,Created,Status\n";
        $curSym   = gs('cur_sym');

        foreach ($data as $loan) {
            $planName          = @$loan->plan->name;
            $userName          = @$loan->user->username;
            $accountNumber     = @$loan->user->account_number;
            $amount            = $curSym . getAmount($loan->amount);
            $receivableAmount  = $curSym . getAmount($loan->payable_amount);
            $installmentAmount = $curSym . getAmount($loan->per_installment);
            $installmentFor    = $loan->installment_interval . ' Days';
            $nextInstallment   = showDateTime(@$loan->nextInstallment->installment_date, 'd-m-Y') ?? 'N/A';
            $createdAt         = showDateTime($loan->created_at, 'd-m-Y');
            if ($loan->status == Status::LOAN_PENDING) {
                $status = 'Pending';
            } elseif ($loan->status == Status::LOAN_RUNNING) {
                $status = 'Running';
            } elseif ($loan->status == Status::LOAN_PAID) {
                $status = 'Paid';
            } else {
                $status = 'Rejected';
            }
            $column .= "$loan->loan_number,$planName,$userName,$accountNumber,$amount,$receivableAmount,$installmentAmount,$installmentFor,$loan->total_installment,$loan->given_installment,$nextInstallment,$createdAt,$status\n";
        }
        fwrite($myFile, $column);
        $headers = [
            'Content-Type' => 'application/csv',
        ];
        $name  = $pageTitle . time() . '.csv';
        $array = [$filename, $name, $headers];
        return $array;
    }

    public function installments($id)
    {
        $loan         = Loan::with('installments')->findOrFail($id);
        $installments = $loan->installments()->paginate(getPaginate());
        $pageTitle    = "Installments";
        return view('admin.loan.installments', compact('pageTitle', 'installments', 'loan'));
    }

    public function leadall(){
        $lead=Lead::where('status','Lead')->orderBy('id','desc')->get();
    
         return view('admin.lead.index',compact('lead'));
       }

       public function status_update(Request $request){

        $id=$request->id;
        $lead=Lead::where('id',$id)->first();
        return view('admin.loan.popup',compact('lead','id'));



       }

       public function update_status(Request $request){


        $id=$request->id;
        $update=Lead::find($id);
        $update->status=$request->leadstatus;
    
        $update->save();

        return redirect()->back()->with('success','Status Updated Successfully');


       }
       
       public function assign_update(Request $request){

        $id=$request->id;
        $lead=Lead::where('id',$id)->first();
        return view('admin.loan.assign',compact('lead','id'));



       }


       public function assignlead(Request $request){
      
        $id=$request->id;
        $update=Lead::find($id);
        $update->assign=$request->leadstatus;

    
        $update->save();

        $notify[] = ['success', 'Lead Assign  Successfully'];
        return back()->withNotify($notify);



       }

       public function loanapprove(Request $request){
        $id=$request->id;
        $update=Loan::find($id);
        $update->status=$request->loanstatus;
        $update->save();


       }

       public function interest(Request $request){
        $id=$request->id;
            
        return view('admin.loan.popup.interest',compact('id'));
        
    }
      public function follow(Request $request){
        $id=$request->id;
            
        return view('admin.loan.popup.follow',compact('id'));
        
    }
    
     public function pickupstatus(Request $request){
        $id=$request->id;
            
        return view('admin.loan.popup.pickupstatus',compact('id'));
        
    }
    public function leadstatus2(Request $request){
          $today= Carbon::now();
	       date_default_timezone_set('Asia/Kolkata');
$currentTime = date( 'h:i A', time () );
        $user = Auth::user();
       $act= new Acvitity();
       $act->acvitiy= $request->vehicle3 ?? '';
    
        $act->lead_id= $request->id ?? '';
        $act->user_id= $user->id ?? '';
            $act->current_time=$currentTime ?? '';
       $act->save();
       return back();
    }
    
    
    
    public function leadtracking(Request $request){
        $id=$request->id;
        $tracking=Acvitity::where('lead_id',$id)->orderBy('id','desc')->get();
    
        return view('admin.loan.popup.tracking',compact('tracking'));
    }
    
    public function leadstatus1(Request $request){

   
          $today= Carbon::now();
	       date_default_timezone_set('Asia/Kolkata');
$currentTime = date( 'h:i A', time () );
        $user = Auth::user();
       $act= new Acvitity();
     
       $act->acvitiy= $request->vehicle3 ?? '';
       $act->remarks= $request->remark ?? '';
        $act->lead_id= $request->id ?? '';
        $act->user_id= $user->id ?? '';
         $act->current_time=$currentTime ?? '';
       $act->save();
       return back()->with('success','Lead Activity Update');
    }
    
    public function leadstatus4(Request $request){
          $today= Carbon::now();
	       date_default_timezone_set('Asia/Kolkata');
$currentTime = date( 'h:i A', time () );
        $user = Auth::user();
       $act= new Acvitity();
       $act->acvitiy= 'Follow Up' ?? '';
       $act->remarks= $request->remark ?? '';
        $act->date= $request->date ?? '';
       $act->time= $request->time ?? '';
        $act->lead_id= $request->id ?? '';
        $act->user_id= $user->id ?? '';
         $act->current_time=$currentTime ?? '';
       $act->save();
       return back();
    }
    
    public function statusupdate(Request $request){
         $today= Carbon::now();
	       date_default_timezone_set('Asia/Kolkata');
$currentTime = date( 'h:i A', time () );
        
        $update=Lead::find($request->id);
        
     
        $update->lead_status=$request->update ?? '';
        $update->save();
       $user = Auth::user();
       $act= new Acvitity();
       $act->acvitiy= 'Status Update' ?? '';
       $act->remarks= $request->update ?? '';
        $act->lead_id= $request->id ?? '';
        $act->user_id= $user->id ?? '';
          $act->current_time=$currentTime ?? '';
       $act->save();  
       return back()->with('success','Status Update Successfully');
        
        
    }
    
    
    public function lead_assign(Request $request){
        
        $id=$request->id;
        
          
             $tracking = User::whereIn('role_id',['2','3'])->where('status','active')->get();
    
        return view('crm.lead.popup.assign',compact('tracking','id'));
        
        
    }
    
    public function statusassign(Request $request){
       
         $today= Carbon::now();
	       date_default_timezone_set('Asia/Kolkata');
            $currentTime = date( 'h:i A', time () );
        
              $update=Lead::find($request->id);
        
        $update->owner_id=$request->ownerid ?? '';
        $update->save();
         $user=User::where('id',$request->ownerid)->first();
         
         
     
         $act= new Acvitity();
        $username="Assigned to"  .$user->name;
        $act->acvitiy=$username ?? '';
        $act->remarks=  '';
        $act->date=   '';
        $act->time=  '';
        $act->current_time=$currentTime ?? '';
        $act->lead_id= $request->id ?? '';
        $act->user_id= $user->id ?? '';
       $act->save(); 
      return back()->with('success','Lead Assign  Successfully');
        }
}

