@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
       
            <div class="card b-radius--10">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                <div class="card-body p-0">

                    <div class="table-responsive--lg table-responsive">
                        <table class="table--light style--two table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Lead')</th>
                                    @if (can('admin.loan.details') || can('admin.loan.installments'))
                                    <th>@lang('Action')</th>
                                @endif
                                <th>Lead </th>
                                <th>@lang('Lead Assign')</th>
                                <th>@lang('Activity')</th>
                                <th>@lang('Source')</th>
                                <th>@lang('Category')</th>
                                   
                                   
                                    <th>@lang('KW Plant')</th>
                                   
                                    
                                    <th>@lang('History')</th>
                                    <th>Remarks</th>
                                  
                                    

                                  
                                    
                                  
                                   
                                </tr>
                            </thead>

                            <tbody>
                                @php
$sno=1;
                                @endphp
                                @forelse($loans as $loan)
                            
                                    <tr>
                                        <td>{{ $sno++ }}</td>
                                        <td style="font-size: 13px;">
                                            <b>Name-</b> {{$loan->first_name }} {{$loan->last_name}}<br>
                                            <b>Phone-</b> {{$loan->phone }}<br>
                                            <b>Gmail-</b> {{$loan->email ?? '' }}<br>
                                            <b>Lead-</b> {{$loan->id ?? '' }}<br>
                                       
                                            
                                          </td>
                                        
                                            

                                            <td>
                                                <div class="button--group">
                                                    
                                                        <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.users.detail', $loan->id) }}">
                                                            <i class="las la-desktop"></i> @lang('Details')
                                                        </a>
                                              
                                                 
                                                </div>
                                            </td>
                                            @php
                                
                                            $user=DB::table('admins')->where('id',$loan->owner_id)->orderBy('id','desc')->first();
                                            
                                            @endphp


<td>
    {{ ucfirst($user->name ??'')}}
</td>
                                            
                                        <td>

                                            
                                        
                                            <div class="button--group">
                                              
                                           
                                                <a class="btn btn-sm btn-outline--success" onclick="assign({{$loan->id}})" 
                                                     data-bs-toggle="modal" data-bs-target="#addSubModal">
                                                    <i class="las la-history"></i> @lang('Assign')
                                                </a>
                                          
                                        </div>

                                        </td>

                                        <td>
                                            <a data-bs-toggle="modal" data-bs-target="#addSubModal3"  onclick="history({{$loan->id}})" data-toggle="tooltip" data-original-title="History" class="historyBtn btn btn-warning"
                                            >
                                                <i class="fa fa-history icon-white"></i></a>
                                                     <a data-bs-toggle="modal" data-bs-target="#addSubModal2" lead_id="36375" incid="20579" id="ni" data-toggle="tooltip"
                                            
                                            onclick="not({{$loan->id}})"
                                            
                                            data-original-title="Not Interested" class="openBtn btn btn-danger">
                                                <i class="fa fa-user-times icon-white"></i></a>
                                                


                                                <a href="#" data-bs-toggle="modal" data-bs-target="#addSubModal4"
                                                mobile="" lead_id="36375" incid="20579"  onclick="follow({{$loan->id}})"
                                                data-toggle="tooltip" data-original-title="Follow UP" class="openBtn btn btn-warning">
                                                <i class="fa fa-phone-square icon-white"></i>
                                                </a>
                                                
                                                
                                                
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#addSubModal5" onclick="pickup({{$loan->id}})"  
                                                    
                                                   data-toggle="tooltip" mobile="" 
                                                    lead_id="36375" incid="20579" id="np" data-toggle="tooltip" 
                                                    data-original-title="Not Pickup and Not Reachable" class="openBtn btn btn-danger">
                                                    <i class="fa fa-phone-square icon-white"></i></a>
                                                
                                             
                                               </td>

                                       <td>
                                            Facebook
                                        </td>
                                        <td >
                                         <a onclick="status({{$loan->id}})" style="color:green" data-bs-toggle="modal" data-bs-target="#userStatusModal">{{$pageTitle ?? ''}}</a>
                                        
                                        </td>
                                        <td>
                                            {{$loan->plant ?? ''}}
                                        </td>
                                      
                                        
                                               @php
                                
                                               $history=DB::table('lead_acvitity')->where('lead_id',$loan->id)->orderBy('id','desc')->first();
                                               
                                               @endphp
                                               <td>
                                                 {{ $history->acvitiy ?? ''}}
                                                 {{ $history->date ?? ''}} 
                                                 {{ $history->time ?? ''}} 
                                                 
                                                 {{ $history->remarks ?? ''}} 
                                                   
                                               </td>

                                               <td>{{$loan->note ?? ''}}</td>
                                     
                                     

                                     



                                    

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @if ($loans->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($loans) }}
                    </div>
                @endif --}}
            </div>
        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" id="statuspop">
           
        </div>
    </div>

  
    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" id="assignpop">
         
        </div>
    </div>


    <div id="addSubModal2" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" id="popup1">
         
        </div>
    </div>
<div id="addSubModal3" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" id="popup2">
         
        </div>
    </div>
      
    <div id="addSubModal4" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" id="popup4">
         
        </div>
    </div>

    <div id="addSubModal5" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" id="popup3">
         
        </div>
    </div>
      

    
     

      
      <!---->
    
      
      
      <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" id="popup5">
         
        </div>
      </div>



    
@endsection


<script>

    function not($id){
    var id=$id;
    $.ajax({
        url:'{{url("admin/lead/interest")}}',
        type:'get',
        data:{id:id},
        success:function(data){
           
         
            $('#popup1').html(data);
            
        }
    })
    
        
    }
    </script>
    
    
    <script>
    
    function history($id){
    var id=$id;
    $.ajax({
        url:'{{url("admin/lead/tracking")}}',
        type:'get',
        data:{id:id},
        success:function(data){
         $('#popup2').html(data);
            
        }
    })
    
        
    }
    </script>
    
    
    <script>
    
    function pickup($id){
    var id=$id;
    $.ajax({
        url:'{{url("admin/lead/pickup")}}',
        type:'get',
        data:{id:id},
        success:function(data){
         $('#popup3').html(data);
            
        }
    })
    
        
    }
    </script>
    
    <script>
    
    function follow($id){
    var id=$id;
    $.ajax({
        url:'{{url("admin/lead/follow")}}',
        type:'get',
        data:{id:id},
        success:function(data){
         $('#popup4').html(data);
            
        }
    })
    
        
    }
    </script>
    
    <script>
    
    function assign($id){
    var id=$id;
    $.ajax({
        url:'{{url("/lead/assgin_lead")}}',
        type:'get',
        data:{id:id},
        success:function(data){
           
         $('#popup5').html(data);
            
        }
    })
    
        
    }
    </script>


<script>
    function status(id){
       
      var id=id;
        $.ajax({
            url:"{{url('admin/loan/update')}}",
            type:'get',
            data:{id},
            success:function(data){
           $('#statuspop').html(data)
            }
        })
    }

    </script>

<script>


    function assign(id){
      
      var id=id;
        $.ajax({
            url:"{{url('admin/loan/assign')}}",
            type:'get',
            data:{id},
            success:function(data){
            
               
           $('#assignpop').html(data)
            }
        })
    }
</script>




@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' placeholder="Loan No." />
@endpush
