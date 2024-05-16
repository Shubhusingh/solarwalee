@extends('admin.pdf.layouts.master')

@section('main-content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('S.N.')</th>
                <th>@lang('DPS No.') | @lang('Plan')</th>
                <th>@lang('User')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Installment')</th>
                <th>@lang('Next Installment')</th>
                <th>@lang('After Matured')</th>
                <th>@lang('Created')</th>
                <th>@lang('Status')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dps as $data)
                <tr>
                    <td>{{ __($loop->iteration) }}</td>

                    <td>
                        <span class="fw-bold">{{ __($data->dps_number) }}</span>
                        <span class="d-block text--info">{{ __(@$data->plan->name) }}</span>
                    </td>

                    <td>
                        <span class="fw-bold d-block">{{ __(@$data->user->fullname) }}</span>
                        @if ($data->user)
                            <span class="small">
                                {{ @$data->user->username }}
                            </span>
                        @endif
                    </td>

                    <td>
                        <span>{{ $general->cur_sym . showAmount($data->per_installment) }}</span>
                        <span class="text--info d-block">@lang('Per')
                            {{ __($data->installment_interval) }}
                            @lang('days')
                        </span>
                    </td>

                    <td>
                        <span>@lang('Total') : {{ __($data->total_installment) }}</span>
                        <span class="text--info d-block">@lang('Given') : {{ __($data->given_installment) }}</span>
                    </td>

                    <td>
                        @if (@$data->nextInstallment->installment_date)
                            {{ showDateTime($data->nextInstallment->installment_date, 'd M, Y') }}
                        @endif
                    </td>

                    <td>
                        {{ $general->cur_sym }}{{ showAmount($data->depositedAmount() + $data->profitAmount()) }}

                        <span class="text--info d-block">
                            {{ $general->cur_sym }}{{ showAmount($data->depositedAmount()) }}
                            + {{ getAmount($data->interest_rate) }}%
                        </span>
                    </td>
                    <td>{{ showDateTime($data->created_at, 'm/d/Y') }}</td>
                    <td>@php echo $data->statusBadge;@endphp</td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
