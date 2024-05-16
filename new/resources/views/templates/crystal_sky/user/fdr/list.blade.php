@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="header-nav">
        <x-search-form placeholder="FDR No.| Plan" dateSearch='yes' btn="btn--base" />
        @if (request()->date || request()->search)
            <a class="btn btn-outline--info" href="{{ request()->fullUrlWithQuery(['download' => 'pdf']) }}"><i class="la la-download"></i> @lang('Download PDF')</a>
        @endif
    </div>

    <div class="full-table">
        <table class="table table--responsive--md">
            <thead>
                <tr>
                    <th>@lang('S.N.')</th>
                    <th>@lang('FDR No.') | @lang('Plan')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Profit')</th>
                    <th>@lang('Next Installment')</th>
                    <th>@lang('Lock In Period')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allFdr as $fdr)
                    <tr>
                        <td>{{ $loop->index + $allFdr->firstItem() }}</td>

                        <td>
                            <div>
                                <strong>{{ $fdr->fdr_number }}</strong>
                                <small class="d-block text--base">{{ __($fdr->plan->name) }}</small>
                            </div>
                        </td>

                        <td>
                            <div>
                                <strong>{{ $general->cur_sym . showAmount($fdr->amount) }}</strong>
                                <small class="d-block text--base">
                                    @lang('With') {{ getAmount($fdr->interest_rate) }}%
                                    @lang('Profit Rate')
                                </small>
                            </div>
                        </td>

                        <td>
                            <div>
                                {{ $general->cur_sym . showAmount($fdr->per_installment) }}
                                <small class="text--base d-block">@lang('Per')
                                    {{ $fdr->installment_interval }} @lang('Days')</small>
                            </div>
                        </td>

                        <td>
                            <div>
                                @if ($fdr->status != 2)
                                    {{ showDateTime($fdr->next_installment_date, 'd M, Y') }}
                                @else
                                    @lang('N/A')
                                @endif
                            </div>
                        </td>

                        <td>
                            <div>
                                {{ showDateTime($fdr->locked_date->endOfDay(), 'd M, Y h:i A') }}
                                <small class="d-block text--base">{{ diffForHumans($fdr->locked_date, 'd M, Y') }}</small>
                            </div>
                        </td>

                        <td>
                            <div>
                                @php echo $fdr->statusBadge; @endphp
                            </div>
                        </td>

                        <td>
                            <div class="btn--group">
                                <button type="button" data-id="{{ $fdr->id }}" class="btn btn-outline--base btn--sm closeBtn" @disabled(($fdr->locked_date->endOfDay() >= now() && $fdr->status == 1) || $fdr->status == 2)>
                                    <i class="fa fa-stop-circle"></i> @lang('Close')
                                </button>

                                <a href="{{ route('user.fdr.instalment.logs', $fdr->fdr_number) }}" class="btn btn-outline--primary btn--sm">
                                    <i class="las la-wallet"></i> @lang('Installments')
                                </a>
                            </div>
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
    @if ($allFdr->hasPages())
        <div class="mt-4">
            {{ paginateLinks($allFdr) }}
        </div>
    @endif
@endsection

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('user.fdr.plans') }}" class="btn btn-outline--base">@lang('FDR Plans')</a>
            <a href="{{ route('user.fdr.list') }}" class="btn btn--base active">@lang('My FDR List')</a>
        </div>
    </div>
@endpush

@push('modal')
    <div class="modal fade" id="closeFdr" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Close FDR')</h5>
                    <button type="button" class="bg-transparent" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="user_token" required>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" class="transferId" required>
                        </div>
                        <div class="content">
                            <p>@lang('Are you sure to close this FDR?')</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn--danger text-white" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-md btn--base text-white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.closeBtn').on('click', function() {
                let modal = $('#closeFdr');
                let form = modal.find('form')[0];
                form.action = `{{ route('user.fdr.close', '') }}/${$(this).data('id')}`
                modal.modal('show');
            });

        })(jQuery);
    </script>
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
