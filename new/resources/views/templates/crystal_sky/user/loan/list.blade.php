@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="header-nav">
        <x-search-form placeholder="Loan No.| Plan" dateSearch='yes' btn="btn--base" />
        @if (request()->date || request()->search)
            <a class="btn btn-outline--info" href="{{ request()->fullUrlWithQuery(['download' => 'pdf']) }}"><i class="la la-download"></i> @lang('Download PDF')</a>
        @endif
    </div>

    <div class="full-table">
        <table class="table table--responsive--md">
            <thead>
                <tr>
                    <th>@lang('S.N.')</th>
                    <th>@lang('Loan No. | Plan')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Installment Amount')</th>
                    <th>@lang('Installment')</th>
                    <th>@lang('Next Installment')</th>
                    <th>@lang('Paid')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr>
                        <td>{{ __($loop->index + $loans->firstItem()) }}</td>

                        <td>
                            <div>
                                <span>{{ __($loan->loan_number) }}</span>
                                <br>
                                <small class="text--base">{{ __($loan->plan->name) }}</small>
                            </div>
                        </td>

                        <td>
                            <div>
                                <span>{{ $general->cur_sym . showAmount($loan->amount) }}</span>
                                <br>
                                <small class="text--base">
                                    {{ $general->cur_sym . showAmount($loan->payable_amount) }} @lang('Need to pay')
                                </small>
                            </div>
                        </td>

                        <td>
                            <div>
                                <span>{{ $general->cur_sym . showAmount($loan->per_installment) }}</span>
                                <br>
                                <small class="text--base">
                                    @lang('In Every') {{ __($loan->installment_interval) }} @lang('Days')
                                </small>
                            </div>
                        </td>

                        <td>
                            <div>
                                <span> @lang('Total') : {{ __($loan->total_installment) }}</span>
                                <br>
                                <small class="text--base">
                                    @lang('Given') : {{ __($loan->given_installment) }}
                                </small>
                            </div>
                        </td>
                        <td>
                            @if ($loan->nextInstallment)
                                {{ showDateTime($loan->nextInstallment->installment_date, 'd M, Y') }}
                            @endif
                        </td>

                        <td>
                            <div>
                                <span>{{ $general->cur_sym . showAmount($loan->paid_amount) }}</span>
                                <br>
                                <span class="text--warning">
                                    @php $remainingAmount = $loan->payableAmount - $loan->paid_amount;  @endphp
                                    <small> {{ $general->cur_sym . showAmount($remainingAmount) }} @lang('Remaining')</small>
                                </span>
                            </div>
                        </td>

                        <td>
                            <div>
                                @php echo $loan->statusBadge; @endphp
                                @if ($loan->status == 3)
                                    <span class="admin-feedback" data-feedback="{{ __($loan->admin_feedback) }}">
                                        <i class="la la-info-circle"></i>
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td>
                            <a class="btn btn-outline--base btn--sm @disabled(!$loan->nextInstallment)" href="{{ route('user.loan.instalment.logs', $loan->loan_number) }}">
                                <i class="las la-wallet"></i> @lang('Installments')
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($loans->hasPages())
        <div class="mt-4">
            {{ paginateLinks($loans) }}
        </div>
    @endif
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.admin-feedback').on('click', function() {
                var modal = $('#adminFeedback');
                modal.find('.modal-body').text($(this).data('feedback'));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('user.loan.plans') }}" class="btn btn-outline--base">@lang('Loan Plans')</a>
            <a href="{{ route('user.loan.list') }}" class="btn btn--base active">@lang('My Loan List')</a>
        </div>
    </div>
@endpush

@push('modal')
    <!-- Modal -->
    <div class="modal fade" id="adminFeedback">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reason of Rejection')!</h5>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn--dark" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('style')
    <style>
        .btn[type=submit] {
            height: unset !important;
        }

        .btn {
            padding: 12px 1.875rem;
        }
    </style>
@endpush
