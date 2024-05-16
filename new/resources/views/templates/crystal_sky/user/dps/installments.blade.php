@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12 col-xl-4">
            <div class="card custom--card">

                <div class="card-body">
                    <ul>
                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ $dps->dps_number }}</span>
                            <span>@lang('DPS Number')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ $dps->plan->name }}</span>
                            <span>@lang('Plan')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ getAmount($dps->interest_rate) }}%</span>
                            <span>@lang('Interest Rate')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="value text--base text--base fw-bold">{{ getAmount($dps->per_installment) }} {{ $general->cur_text }}</span>
                            <span class="caption">@lang('Per Installment')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ $dps->given_installment }}</span>
                            <span>@lang('Given Installment')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ $dps->total_installment }}</span>
                            <span>@lang('Total Installment')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ showAmount($dps->depositedAmount()) }} {{ $general->cur_text }}</span>
                            <span>@lang('Total Deposit')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ showAmount($dps->profitAmount()) }} {{ $general->cur_text }}</span>
                            <span>@lang('Profit')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ showAmount($dps->depositedAmount() + $dps->profitAmount()) }} {{ $general->cur_text }}</span>
                            <span>@lang('Including Profit')</span>
                        </li>

                        @if (getAmount($dps->charge_per_installment))
                            <li class="pricing-card__list flex-between">
                                <span class="fw-bold">{{ showAmount($dps->charge_per_installment) }} {{ $general->cur_text }} /@lang('Day')</span>
                                <span>@lang('Delay Charge')</span>
                                <small class="text--danger mt-2">@lang('Charge will be applied if an installment delayed for') {{ $dps->delay_value }} @lang(' or more days')</small>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-8">
            @include($activeTemplate . 'partials.installment_table')
        </div>
    </div>
@endsection

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('user.dps.plans') }}" class="btn btn-outline--base">@lang('DPS Plans')</a>
            <a href="{{ route('user.dps.list') }}" class="btn btn--base active">@lang('My DPS List')</a>
        </div>
    </div>
@endpush
