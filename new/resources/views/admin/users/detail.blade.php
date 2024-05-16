@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4 mb-30">
        <div class="col-12">
            <div class="row gy-4">
               
               

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget style="2" color="warning" icon="la la-exchange-alt" title="Total Transferred" value="{{ $general->cur_sym }}{{ showAmount($widget['total_transferred']) }}"  query_string="search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>



                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget style="2" color="warning" icon="la la-hand-holding-usd" title="Approve Loan" value="{{ $user->appoveloan ?? 0 }}"  query_string="search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                
            </div>
        </div>

        <div class="col-12">
            <div class="d-flex flex-wrap gap-3">
                @can('admin.users.add.sub.balance')
                    <div class="flex-fill">
                        <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                            <i class="las la-plus-circle"></i> @lang('Approve Loan Price')
                        </button>
                    </div>

                    @dd($user->loan_status);

                    @if($user->loan_status==1)
                    <div class="flex-fill">
                        <button  class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                            <i class="las la-plus-circle"></i> @lang('Approve Loan')
                        </button>
                    </div>
                   
                    @else
                   
                    <div class="flex-fill">
                        
                        <a href="{{route('loan/approve/',$user->id)}}" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" onclick="return confirm('Are you sure you want to Appove Loan');"><i class="las la-minus-circle"></i>  @lang('Approve Loan')</a>
                    </div>
                    @endif
                @endcan

               

           

            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-3 col-lg-5 col-md-5">
            <div class="row">
                <div class="col-6 col-sm-6 col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="card-title d-flex justify-content-center gap-3">
                                <h6>
                                    @if ($user->ev)
                                        <i class="la la-check-circle text--success"></i>
                                    @else
                                        <i class="la la-times-circle text--danger"></i>
                                    @endif
                                    @lang('Email')
                                </h6>
                                <h6>
                                    @if ($user->sv)
                                        <i class="la la-check-circle text--success"></i>
                                    @else
                                        <i class="la la-times-circle text--danger"></i>
                                    @endif
                                    @lang('Mobile')
                                </h6>
                                <h6>
                                    @if ($user->kv)
                                        <i class="la la-check-circle text--success"></i>
                                    @else
                                        <i class="la la-times-circle text--danger"></i>
                                    @endif
                                    @lang('KYC')
                                </h6>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <img class="account-holder-image rounded border w-100" src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, null, true) }}" alt="account-holder-image">
                        </div>
                    </div>
                </div>

                <div class="col-6 col-sm-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">@lang('Basic Information')</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">@lang('Full Name')</small>
                                    <h6>{{ $user->Name ?? '' }}</h6>
                                </div>

                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">Customer Id :</small>
                                    <h6>{{ $user->id }} </h6>
                                </div>


                                
                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">Email Id :</small>
                                    <h6>{{ $user->Email ?? '' }} </h6>
                                </div>

                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">Date Of Birth</small>
                                    <h6>{{ $user->date ?? ''}}</h6>
                                </div>

                                @if ($user->referrer)
                                    <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                        <small class="text-muted">@lang('Referred By')</small>
                                        @can('admin.users.detail')
                                            <a href="{{ route('admin.users.detail', $user->ref_by) }}">
                                                <h6 class="text--primary">{{ $user->referrer->username }}</h6>
                                            </a>
                                        @else
                                            <h6 class="text--primary">{{ $user->referrer->username }}</h6>
                                        @endcan
                                    </div>
                                @endif

                                @if ($user->branch)
                                    <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                        <small class="text-muted">@lang('Registered By')</small>
                                        <h6>{{ $user->branchStaff->name }} </h6>
                                    </div>
                                @endif

                                {{-- <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">@lang('Joined On')</small>
                                    <h6>{{ showDateTime($user->created_at, 'd M Y, h:i A') }} </h6>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7">

            
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between">
                    <h5 class="card-title mb-0"> Application Details</h5>
                    <span>
                        @php echo $user->status_badge @endphp
                    </span>
                </div>
                <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Loan Perpose :  {{$user->p_loan ?? ''}}</th>
                        <th scope="col">Monthly Income:  {{$user->m_incom ?? ''}}</th>
                        <th scope="col">Loan Required :  {{$user->loan_re ?? ''}}</th>
                       
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="col">Loan Tenure : 0</th>
                        <th scope="col">City:  {{$user->City ?? ''}}</th>
                        <th scope="col">State :  {{$user->state ?? ''}}</th>
                      </tr>

                      <tr>
                        <th scope="col">Pin Code :  {{$user->Pincode ?? ''}}</th>
                        <th scope="col">Current Status: Fresh Lead</th>
                        <th scope="col">Source : Website</th>
                      </tr>

                      <tr>
                        <th scope="col">Application Date :  {{ showDateTime($user->created_at, 'd M Y, h:i A') }}</th>
                        <th scope="col">Lead Assign: Akash</th>

                        <th scope="col">PanCard: {{$user->PanCard ?? ''}}</th>
                      
                      </tr>

                      <tr>
                        <th scope="col">Aadhar No :  {{$user->Aadhar ?? ''}}</th>
                        <th scope="col">Phone No :  {{$user->Mobile ?? ''}}</th>
                     
                      
                      </tr>
                   
                    </tbody>
                  </table>
                </div>
                <div class="card-header d-flex flex-wrap justify-content-between">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                    <span>
                        @php echo $user->status_badge @endphp
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                          

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address Detail')</label>
                                    <input class="form-control" type="text" name="address" value="{{ @$user->addressdetail }}">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Company Detail')</label>
                     
                                    <input class="form-control" type="text" name="compnaydetail" value="{{ @$user->companydetail }}">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                          

                     
                            <div class="form-group col-lg-12 col-xxl-3">
                                <label>@lang('KYC') </label>
                                @if($user->kyc == 'on')
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="kv"  checked >

                                @else
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="kv" @if ($user->kv == 1) checked @endif>


                                @endif
                            </div>
                        </div>

                        @can('admin.users.update')
                            <button type="submit" class="btn btn--primary w-100 h-45 mt-3">@lang('Submit')
                            </button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>

    @can('admin.users.add.sub.balance')
        {{-- Add Sub Balance MODAL --}}
        <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.users.add.sub.balance', $user->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="act">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>@lang('Amount')</label>
                                <div class="input-group">
                                    <input type="number" step="any" name="amount" class="form-control" placeholder="@lang('Please provide positive amount')" required>
                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('Remark')</label>
                                <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @can('admin.users.status')
        <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                           
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            @if ($user->status == Status::USER_ACTIVE)
                                <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                                <div class="form-group">
                                    <label>@lang('Reason')</label>
                                    <textarea class="form-control" name="reason" rows="4" required></textarea>
                                </div>
                            @else
                                <p><span>@lang('Ban reason was'):</span></p>
                                <p>{{ $user->ban_reason }}</p>
                                <h4 class="text-center mt-3">@lang('Are you sure to unban this user?')</h4>
                            @endif
                        </div>
                        <div class="modal-footer">
                            @if ($user->status == Status::USER_ACTIVE)
                                <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                            @else
                                <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                                <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.bal-btn').click(function() {
                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');

            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            $('select[name=country]').val('{{ @$user->country_code }}');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $user->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

        })(jQuery);
    </script>
@endpush
