@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="header-nav">
        <x-search-form placeholder="Trx" dateSearch='yes' btn="btn--base" />
        @if (request()->date || request()->search)
            <a class="btn btn-outline--info" href="{{ request()->fullUrlWithQuery(['download' => 'pdf']) }}"><i class="la la-download"></i> @lang('Download PDF')</a>
        @endif
    </div>

    <div class="full-table">
        <table class="table table--responsive--md">
            <thead>
                <tr>
                    <th>@lang('TRX')</th>
                    <th>@lang('Account')</th>
                    <th>@lang('Bank')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Charge')</th>
                    <th>@lang('Paid Amount')</th>
                    <th>@lang('Status')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transfers as $transfer)
                    <tr>
                        <td>
                            <div>
                                <span class="text--dark fw-bold">{{ $transfer->trx }}</span>
                                <br>
                                <small>{{ showDateTime($transfer->created_at, 'd M, Y h:i A') }}</small>
                            </div>
                        </td>

                        <td>
                            <div>
                                @if ($transfer->beneficiary)
                                    <span class="text--base fw-bold">{{ $transfer->beneficiary->short_name }}</span>
                                    <br>
                                    {{ @$transfer->beneficiary->account_number }}
                                @else
                                    <span class="text--base fw-bold">{{ $transfer->wireTransferAccountName() }}</span>
                                    <br>
                                    {{ $transfer->wireTransferAccountNumber() }}
                                @endif
                            </div>
                        </td>

                        <td>
                            <div>
                                @if ($transfer->beneficiary)
                                    {{ $transfer->beneficiary->beneficiaryOf->name ?? $general->site_name }}
                                @else
                                    <span class="text--warning fw-bold">@lang('Wire Transfer')</span>
                                    <br>
                                    <button class="badge badge--info wire-transfer" data-id="{{ $transfer->id }}" type="button"> <i class="la la-eye"></i> @lang('Recipient Info')</button>
                                @endif
                            </div>
                        </td>

                        <td>{{ $general->cur_sym . showAmount($transfer->amount) }}</td>

                        <td>{{ $general->cur_sym . showAmount($transfer->charge) }}</td>

                        <td>{{ $general->cur_sym . showAmount($transfer->final_amount) }}</td>

                        <td>
                            @if ($transfer->status == 1)
                                <span class="badge badge--success">@lang('Completed')</span>
                            @elseif($transfer->status == 0)
                                <span class="badge badge--warning">@lang('Pending')</span>
                            @elseif($transfer->status == 2)
                                <span class="badge badge--danger">@lang('Rejected')</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%">@lang($emptyMessage)</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($transfers->hasPages())
        <div class="mt-4">
            {{ paginateLinks($transfers) }}
        </div>
    @endif
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.wire-transfer').on('click', function(e) {
                let id = $(this).data('id');
                let modal = $('#detailsModal');
                modal.find('.loading').removeClass('d-none');
                let action = `{{ route('user.transfer.wire.details', ':id') }}`;

                $.ajax({
                    url: action.replace(':id', id),
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (response.success) {
                            modal.find('.loading').addClass('d-none');
                            modal.find('.modal-body').html(response.html);
                            modal.modal('show');
                        } else {
                            notify('error', response.message || `@lang('Something went the wrong')`)
                        }
                    },
                    error: function(e) {
                        notify(`@lang('Something went the wrong')`)
                    }
                });

            });
        })(jQuery);
    </script>
@endpush
<x-transfer-breadcrumb-menu />

@push('modal')
    <div class="modal fade custom--modal" id="detailsModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Wire Transfer Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-ajax-loader />
                </div>
            </div>
        </div>
    </div>
@endpush
