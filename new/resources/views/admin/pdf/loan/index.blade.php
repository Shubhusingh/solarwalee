@extends('admin.pdf.layouts.master')

@section('main-content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('S.N.')</th>
                <th>@lang('Loan No.') | @lang('Plan')</th>
                <th>@lang('User')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Installment Amount')</th>
                <th>@lang('Installment')</th>
                <th>@lang('Created') | </br>
                    @lang('Next Installment')</th>
                <th>@lang('Status')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loans as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <span class="fw-bold">{{ __($loan->loan_number) }}</span>
                        <span class="d-block text--info">{{ __($loan->plan->name) }}</span>
                    </td>
                    <td>
                        <span class="fw-bold d-block">{{ $loan->user->account_number }}</span>
                        <span class="small">
                            {{ $loan->user->username }}
                        </span>
                    </td>
                    <td>
                        <span>{{ $general->cur_sym . showAmount($loan->amount) }}</span>
                        <span class="d-block text--info">
                            {{ $general->cur_sym . showAmount($loan->payable_amount) }} @lang('Receivable')
                        </span>
                    </td>

                    <td>
                        <span>{{ $general->cur_sym . showAmount($loan->per_installment) }}</span>
                        <span class="d-block text--info">
                            @lang('Per') {{ $loan->installment_interval }} @lang('days')
                        </span>
                    </td>

                    <td>
                        <span>@lang('Total') : {{ $loan->total_installment }}</span>
                        <span class="d-block text--info">@lang('Given') : {{ $loan->given_installment }}</span>
                    </td>

                    <td>
                        <span class="d-block">{{ showDateTime($loan->created_at, 'd M, Y') }}</span>
                        @if ($loan->nextInstallment)
                            <span class="text--info">
                                {{ showDateTime($loan->nextInstallment->installment_date, 'd M, Y') }}</span>
                        @else
                            <span class="text--info">@lang('N\A')</span>
                        @endif
                    </td>

                    <td>
                        @php echo $loan->status_badge; @endphp
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
