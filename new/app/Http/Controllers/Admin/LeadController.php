<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\InstallmentLog;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Carbon;
use App\Models\Lead;

class LeadController extends Controller
{
    public function __construct()
    {

    }
    
    
    public function statusupdate(Request $request){
        $id=$request->id;
        $update=Lead::find($id);
        $update->status=$request->leadstatus;
        $update->save();
        return back()->with('success','Lead Status Update');
    }

   
   

    public function index(){
     $lead=Lead::where('status','Lead')->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }

    public function running(){
     
     $lead=Lead::where('status',3)->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }

    public function completed(){
     $lead=Lead::where('status',4)->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }

 public function Not_Eligible(){
     $lead=Lead::where('status',6)->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }
     public function lesssalery(){
     $lead=Lead::where('status',5)->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }
    
    public function docrevi(){
     $lead=Lead::where('status',7)->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }
    
        
    public function Incomplete_Docs(){
     $lead=Lead::where('status',8)->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }
    
     public function paydayloan(){
     $lead=Lead::where('status',9)->orderBy('id','desc')->get();
      return view('admin.lead.index',compact('lead'));
    }
    public function pending(){
        
      $lead=Lead::where('status',2)->orderBy('id','desc')->get();
 
      return view('admin.lead.index',compact('lead'));
    }

    public function rejected(){
      return view('admin.loan.rejected');
    }

   


  

    

    public function takeLoanAmount($userId,$installment){
      $user = User::whereId($userId)->first();
      if($user && $user->balance>=$installment){
        $user->balance -= $installment;
        $user->update();
      }
    }

}
