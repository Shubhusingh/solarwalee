@extends('admin.pdf.layouts.master')

@section('main-content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('DPS No.') | @lang('Plan')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Installment')</th>
                <th>@lang('Next Installment')</th>
                <th>@lang('After Matured')</th>
                <th>@lang('Status')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allDps as $dps)
                <tr>

                    <td>
                        {{ $dps->dps_number }}
                        <small class="d-block text--success">{{ __(@$dps->plan->name) }}</small>
                    </td>

                    <td>
                        {{ $general->cur_sym . showAmount($dps->per_installment) }}
                        <small class="d-block">@lang('Per')
                            {{ __($dps->installment_interval) }} @lang('days')</small>
                    </td>

                    <td>
                        @lang('Total') : {{ $dps->total_installment }}
                        <small class="d-block">@lang('Given') :
                            {{ $dps->given_installment }}</small>
                    </td>

                    <td>{{ showDateTime(@$dps->nextInstallment->installment_date, 'd M, Y') }}</td>

                    <td>
                        {{ $general->cur_sym }}{{ showAmount($dps->depositedAmount() + $dps->profitAmount()) }}
                        <small class="d-block">
                            {{ $general->cur_sym }}{{ showAmount($dps->depositedAmount()) }}
                            + {{ getAmount($dps->interest_rate) }}%
                        </small>
                    </td>

                    <td>@php echo $dps->statusBadge;@endphp</td>

                </tr>
            @empty
                <tr>
                    <td colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
