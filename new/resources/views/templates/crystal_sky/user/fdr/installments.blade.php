@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12 col-xl-4">
            <div class="card custom--card">
                <div class="card-body">
                    <ul>
                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ $fdr->fdr_number }}</span>
                            <span>@lang('FDR Number')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ $fdr->plan->name }}</span>
                            <span>@lang('Plan')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ showAmount($fdr->amount) }} {{ $general->cur_text }}</span>
                            <span>@lang('Deposited')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ getAmount($fdr->interest_rate) }}%</span>
                            <span>@lang('Interest Rate')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold text--base">{{ showAmount($fdr->per_installment) }} {{ $general->cur_text }}</span>
                            <span>@lang('Per Installment')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ $fdr->installments->count() }} </span>
                            <span>@lang('Received Installment')</span>
                        </li>

                        <li class="pricing-card__list flex-between">
                            <span class="fw-bold">{{ getAmount($fdr->profit) }} {{ $general->cur_text }}</span>
                            <span>@lang('Profit Received')</span>
                        </li>
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
            <a href="{{ route('user.fdr.plans') }}" class="btn btn-outline--base">@lang('FDR Plans')</a>
            <a href="{{ route('user.fdr.list') }}" class="btn btn--base active">@lang('My FDR List')</a>
        </div>
    </div>
@endpush
