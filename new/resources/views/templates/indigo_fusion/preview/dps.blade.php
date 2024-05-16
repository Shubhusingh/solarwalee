@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-xl-7 col-lg-12">
                <div class="card custom--card">
                    <div class="card-body">
                        <h5 class="text-center">
                            @lang('Your DPS invest information')
                        </h5>

                        <ul class="caption-list-two mt-3">
                            <li>
                                <span class="caption">@lang('DPS No.')</span>
                                <span class="value">{{ $dps->dps_number }}</span>
                            </li>
                            <li>
                                <span class="caption">@lang('Plan')</span>
                                <span class="value">{{ __($dps->plan->name) }}</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Installment Interval')</span>
                                <span class="value">{{ $dps->plan->installment_interval }} @lang('Days')</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Total Installment')</span>
                                <span class="value">{{ $dps->plan->total_installment }}</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Per Installment')</span>
                                <span
                                    class="value">{{ $general->cur_sym . showAmount($dps->plan->per_installment) }}</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Total Deposit')</span>
                                <span
                                    class="value">{{ $general->cur_sym . showAmount($dps->plan->per_installment * $dps->plan->total_installment) }}</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Profit Rate')</span>
                                <span class="value">{{ getAmount($dps->plan->interest_rate) }}%</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Withdrawable Amount')</small></span>
                                <span
                                    class="value fw-bold">{{ $general->cur_sym . showAmount($dps->plan->final_amount) }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-end mt-3 gap-2">
                            <a href="{{ route('user.dps.download', $dps->id) }}" type="button"
                                class="btn btn--base btn-sm"><i class="las la-file-download"></i>@lang('Download')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('bottom-menu')
    <li><a href="{{ route('user.dps.plans') }}">@lang('DPS Plans')</a></li>
    <li><a href="{{ route('user.dps.list') }}">@lang('My DPS List')</a></li>
@endpush
