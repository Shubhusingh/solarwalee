@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-12">
                <div class="custom--card">
                    <div class="card-body">
                        <h5 class="text-center">
                            @lang('Your Loan information')
                        </h5>
                        <ul class="caption-list-two mt-3">
                            <li>
                                <span class="caption">@lang('Loan No.')</span>
                                <span class="value">{{ $loan->loan_number }}</span>
                            </li>
                            <li>
                                <span class="caption">@lang('loan Name')</span>
                                <span class="value">{{ $loan->plan->name }}</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Loan Amount')</span>
                                <span class="value">{{ $general->cur_sym . showAmount($loan->amount) }}</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Total Installment')</span>
                                <span class="value">{{ $loan->plan->total_installment }}</span>
                            </li>

                            @php $per_intallment = $loan->amount * $loan->plan->per_installment / 100; @endphp

                            <li>
                                <span class="caption">@lang('Per Installment')</span>
                                <span class="value">{{ $general->cur_sym . showAmount($per_intallment) }}</span>
                            </li>

                            <li class="fw-bold text--danger">
                                <span class="caption">@lang('You Will Pay')</span>
                                <span
                                    class="value">{{ $general->cur_sym . showAmount($per_intallment * $loan->plan->total_installment) }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-end mt-3 gap-2">
                            <a href="{{ route('user.loan.download', $loan->id) }}" type="button"
                                class="btn btn--base btn-sm"><i class="las la-file-download"></i>@lang('Download')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('bottom-menu')
    <li><a href="{{ route('user.loan.plans') }}">@lang('Loan Plans')</a></li>
    <li><a href="{{ route('user.loan.list') }}">@lang('My Loan List')</a></li>
@endpush
