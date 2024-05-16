@extends($activeTemplate . 'layouts.master')
@section('content')
    @if ($user->kv != Status::KYC_VERIFIED)
        @php
            $kyc = getContent('kyc_content.content', true);
        @endphp
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12">
                @if ($user->kv == 0)
                    <div class="alert alert--danger" role="alert">
                        <h4 class="text--base">@lang('KYC Verification Required')</h4>
                        <hr>
                        <p class="mb-0">{{ __(@$kyc->data_values->unverified_content) }} <a
                                href="{{ route('user.kyc.form') }}" class="text--base">@lang('Click Here to Verify')</a></p>
                    </div>
                @elseif($user->kv == 2)
                    <div class="alert alert--warning" role="alert">
                        <h4 class="text--base">@lang('KYC Verification Pending')</h4>
                        <hr>
                        <p class="mb-0">{{ __(@$kyc->data_values->pending_content) }} <a
                                href="{{ route('user.kyc.data') }}" class="text--base">@lang('See KYC Data')</a></p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="row gy-lg-4 gy-md-3 gy-3 align-items-center">

        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
            <a href="{{ route('user.transaction.history') }}" class="d-block">
                <div class="dashboard-widget ballance">
                    <div class="dashboard-widget__content">
                        <span class="dashboard-widget__text">@lang('Balance')</span>
                        <h3 class="dashboard-widget__number">{{ $general->cur_sym }}{{ showAmount($user->balance) }}</h3>
                    </div>
                </div>
            </a>
        </div>

        @if ($general->modules->referral_system)
            <div class="col-xl-8 col-lg-12 col-md-8 order-xl-0 order-lg-first order-md-0 order-sm-first">
                <div class="dashboard-widget refer">
                    <div class="custom-border flex-align flex-between">
                        <div class="refer__content">
                            <h5 class="refer__title">@lang('My Referral Link'):</h5>
                            <h5 class="refer__link" id="ref">{{ route('home') . '?reference=' . $user->username }}
                            </h5>
                        </div>
                        <span class="refer__icon dashboard-widget__icon flex-center copy-icon copyBtn">
                            <i class="icon-copy"></i>
                        </span>
                    </div>
                </div>
            </div>
        @endif

        @if (@$general->modules->deposit)
            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-xsm-6">
                <a href="{{ route('user.deposit.history') }}?status={{ Status::PAYMENT_PENDING }}" class="d-block">
                    <div class="dashboard-widget">
                        <div class="dashboard-widget__content flex-align">
                            <span class="dashboard-widget__icon flex-center">
                                <i class="las la-wallet"></i>
                            </span>
                            <span class="dashboard-widget__text">@lang('Pending Deposits')</span>
                        </div>
                        <h4 class="dashboard-widget__number">
                            {{ $general->cur_sym }}{{ showAmount(@$widget['total_deposit']) }}</h4>
                    </div>
                </a>
            </div>
        @endif

        @if (@$general->modules->withdraw)
            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-xsm-6">
                <a href="{{ route('user.withdraw.history') }}?status={{ Status::PAYMENT_PENDING }}" class="d-block">
                    <div class="dashboard-widget">
                        <div class="dashboard-widget__content flex-align">
                            <span class="dashboard-widget__icon flex-center">
                                <i class="las la-money-check"></i>
                            </span>
                            <span class="dashboard-widget__text">@lang('Pending Withdrawals')</span>
                        </div>
                        <h4 class="dashboard-widget__number">
                            {{ $general->cur_sym }}{{ showAmount(@$widget['total_withdraw']) }}</h4>
                    </div>
                </a>
            </div>
        @endif
        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-xsm-6">
            <a href="{{ route('user.transaction.history') }}?today=1" class="d-block">
                <div class="dashboard-widget">
                    <div class="dashboard-widget__content flex-align">
                        <span class="dashboard-widget__icon flex-center">
                            <i class="las la-exchange-alt"></i>
                        </span>
                        <span class="dashboard-widget__text">@lang('Today Transactions')</span>
                    </div>
                    <h4 class="dashboard-widget__number">{{ @$widget['total_trx'] }}</h4>
                </div>
            </a>
        </div>
        @if ($general->modules->fdr)
            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-xsm-6">
                <a href="{{ route('user.fdr.list') }}?status={{ Status::FDR_RUNNING }}" class="d-block">
                    <div class="dashboard-widget">
                        <div class="dashboard-widget__content flex-align">
                            <span class="dashboard-widget__icon flex-center">
                                <i class="las la-money-bill"></i>
                            </span>
                            <span class="dashboard-widget__text">@lang('Running FDR')</span>
                        </div>
                        <h4 class="dashboard-widget__number">{{ @$widget['total_fdr'] }}</h4>
                    </div>
                </a>
            </div>
        @endif
        @if ($general->modules->dps)
            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-xsm-6">
                <a href="{{ route('user.dps.list') }}?status={{ Status::FDR_RUNNING }}" class="d-block">
                    <div class="dashboard-widget">
                        <div class="dashboard-widget__content flex-align">
                            <span class="dashboard-widget__icon flex-center">
                                <i class="las la-box-open"></i>
                            </span>
                            <span class="dashboard-widget__text">@lang('Running DPS')</span>
                        </div>
                        <h4 class="dashboard-widget__number">{{ @$widget['total_dps'] }}</h4>
                    </div>
                </a>
            </div>
        @endif
        @if ($general->modules->loan)
            <div class="col-xl-4 col-lg-12 col-md-4 col-sm-12 col-xsm-6">
                <a href="{{ route('user.loan.list') }}?status={{ Status::LOAN_PENDING }}" class="d-block">
                    <div class="dashboard-widget">
                        <div class="dashboard-widget__content flex-align">
                            <span class="dashboard-widget__icon flex-center">
                                <i class="las la-hand-holding-usd"></i>
                            </span>
                            <span class="dashboard-widget__text">@lang('Running Loan')</span>
                        </div>
                        <h4 class="dashboard-widget__number">{{ @$widget['total_loan'] }}</h4>
                    </div>
                </a>
            </div>
        @endif
    </div>

    <div class="pt-60">
        <div class="row gy-4 justify-content-center">
            <div class="col-xxl-6">
                <div class="dashboard-table">
                    <h5 class="dashboard-table__title card-header__title text-dark">
                        @lang('Latest Credits')
                    </h5>
                    <table class="table table--responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Trx')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($credits as $credit)
                                <tr>
                                    <td>{{ __($loop->iteration) }}</td>
                                    <td>
                                        {{ showDateTime($credit->created_at, 'd M, Y h:i A') }}
                                    </td>
                                    <td>{{ __($credit->trx) }}</td>
                                    <td class="fw-bold">
                                        {{ showAmount($credit->amount) }} {{ __($general->cur_text) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xxl-6">
                <div class="dashboard-table">
                    <h5 class="dashboard-table__title card-header__title text-dark">
                        @lang('Latest Debits')
                    </h5>
                    <table class="table table--responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Trx')</th>
                                <th>@lang('Amount')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($debits as $debit)
                                <tr>
                                    <td>{{ __($loop->iteration) }}</td>
                                    <td>{{ showDateTime($debit->created_at, 'd M, Y h:i A') }}</td>
                                    <td>{{ __($debit->trx) }}</td>
                                    <td class="fw-bold">
                                        {{ showAmount($debit->amount) }}{{ __($general->cur_text) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.copyBtn').click(function() {
                const urlText = $('#ref').text();
                const tempTextArea = $('<textarea>');
                tempTextArea.val(urlText);
                $('body').append(tempTextArea);
                tempTextArea.select();
                document.execCommand('copy');
                tempTextArea.remove();
                notify('success', `Copied - ${urlText}`)
            });
        })(jQuery);
    </script>
@endpush
