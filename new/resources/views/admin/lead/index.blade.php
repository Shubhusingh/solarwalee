@extends('layouts.admin')

@section('content')

<div class="card">
	<div class="d-sm-flex align-items-center justify-content-between py-3">
	<h5 class=" mb-0 text-gray-800 pl-3">{{ __('Leads') }}</h5>
	<ol class="breadcrumb m-0 py-0">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
		<li class="breadcrumb-item"><a href="{{ route('admin.loan.index') }}">{{ __('Lead') }}</a></li>
	</ol>
	</div>
</div>


<div class="row mt-3">
  <div class="col-lg-12">

	@include('includes.admin.form-success')

	<div class="card mb-4">
	    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
	  <div class="table-responsive p-3">
		<table id="geniustable" class="table table-hover table-responsive" cellspacing="0" width="100%">
		  <thead class="thead-light">
			<tr>
				<th>{{__('S.No')}}</th>
				<th>{{__('Lead Detail')}}</th>
				<th>{{__('Date of birth')}}</th>
				<th>{{__('Address Detail')}}</th>
				<th>{{__('Detail')}}</th>
				<th>{{__('Loan')}}</th>
					<th>{{__('Loan Required')}}</th>
				<th>{{__('Monthly Income')}}</th>
			
			
					<th>{{__('Type')}}</th>
						
			
			</tr>
		  </thead>
		  
		   <tbody>
		       
 @foreach ($lead as $key => $item)


 <tr>
      <th scope="row">{{$key + 1}}</th>
      <td><b>Name:</b> {{$item->Name ?? ''}} <br>
     <b>Email:</b>{{$item->Email ?? ''}}<br>
      <b>Phone:</b>{{$item->Mobile ?? ''}}<br>
       <b>Gender:</b> {{$item->Gender ?? ''}}
      </td>
      <td>{{$item->date ?? ''}}</td>
      <td>
         <b>City:</b> {{$item->City ?? ''}}<br>
          <b>Pin:</b> {{$item->Pincode ?? ''}}<br>
          <b>State:</b> {{$item->state ?? ''}}<br>
          
      </td>
       <td>
          <b>PanCard:</b>  {{$item->PanCard ?? ''}}<br>
         <b>AadharCard:</b>   {{$item->Aadhar ?? ''}}
          
      </td>
       <td><b>Emp Status:</b> {{$item->emp_status ?? ''}} <br>
     <b>Purpose:</b>  {{$item->p_loan ?? ''}}
     
     
      </td>
      <td>
         {{$item->loan_re ?? ''}}
      </td>
      <td>
            {{$item->m_incom ?? ''}}
      </td>
      
      <!--<td style="color:green">-->
          
      <!--</td>-->
      
       <td style="color:green">
           <form action="{{route('status.update')}}" method="post">
               @csrf
               <input type="hidden" value="{{$item->id}}" name="id" />
           
           <select name="leadstatus" >
               <option value="2">No Answer Leads</option>
                <option value="3">Fresh Leads</option>
                 <option value="4">Interested Leads</option>
                  <option value="5">Less Salary</option>
                   <option value="6">Not Eligible</option>
                    <option value="7">Docs Received</option>
                    
                    <option value="8">Incomplete Docs</option>
                    
                     <option value="9"> PayDay Loan Pending</option>
                  
           </select>
           
           <input type="submit" value="Update" class="btn btn-info" />
           
           </form>
      </td>
    </tr>
@endforeach
   
   
  </tbody>
		</table>
	  </div>
	</div>
  </div>
</div>

{{-- STATUS MODAL --}}
<div class="modal fade confirm-modal" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ __("Update Status") }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<p class="text-center">{{ __("You are about to change the status.") }}</p>
				<p class="text-center">{{ __("Do you want to proceed?") }}</p>
			</div>

			<div class="modal-footer">
				<a href="javascript:;" class="btn btn-secondary" data-dismiss="modal">{{ __("Cancel") }}</a>
				<a href="javascript:;" class="btn btn-success btn-ok">{{ __("Update") }}</a>
			</div>
		</div>
	</div>
</div>
{{-- STATUS MODAL ENDS --}}


@endsection


@section('scripts')

<script type="text/javascript">
	"use strict";

    var table = $('#geniustable').DataTable({
         
           
           
               layout: {
        topStart: {
            buttons: [ 'excel', 'pdf', 'print']
        }
    }
        });

</script>

@endsection


