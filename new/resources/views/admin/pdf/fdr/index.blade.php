@extends('admin.pdf.layouts.master')
@section('main-content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('S.N.')</th>
                <th>@lang('FDR No.') | @lang('Plan')</th>
                <th>@lang('User')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Profit')</th>
                <th>@lang('Next Installment')</th>
                <th>@lang('Lock-In Period')</th>
                <th>@lang('Created')</th>
                <th>@lang('Status')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($fdr as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <span class="fw-bold">{{ __($data->data_number) }}</span>
                        <span class="d-block text-muted">{{ __(@$data->plan->name) }}</span>
                    </td>

                    <td>
                        {{ __(@$data->user->fullname) }}
                    </td>

                    <td>
                        <span class="fw-bold">{{ $general->cur_sym . showAmount($data->amount) }}</span>
                        <span class="d-block">@lang('Profit') {{ getAmount($data->interest_rate) }}% </span>
                    </td>

                    <td>
                        <span class="fw-bold">{{ $general->cur_sym . showAmount($data->per_installment) }}</span>
                        <span class="d-block text-muted">@lang('Per') {{ $data->installment_interval }}
                            @lang('Days')</span>
                    </td>

                    <td>
                        @if ($data->status != 2)
                            <span>{{ showDateTime($data->next_installment_date, 'd M, Y') }}</span>
                        @else
                            @lang('N/A')
                        @endif
                    </td>

                    <td>
                        <span class="fw-bold"> {{ showDateTime($data->locked_date, 'd M, Y') }} </span>
                        <span class="d-block text-muted">{{ diffForHumans($data->locked_date, 'd M, Y') }}</span>
                    </td>

                    <td>{{ showDateTime($data->created_at, 'm/d/Y') }}</td>

                    <td>@php echo $data->statusBadge; @endphp</td>

                </tr>
            @empty
                <tr>
                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
