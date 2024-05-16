@extends($activeTemplate . 'layouts.master')
@push('style')
    <style>
        @media (max-width: 532px) {
            a.btn.h-45.btn--base {
                font-size: 12px;
            }
        }
    </style>
@endpush
@section('content')
    <div class="header-nav">
        <x-search-form placeholder="TRX No." btn="btn--base" />
        <a class="btn btn--base" href="{{ route('user.withdraw') }}">
            <i class="las la-wallet"></i> @lang('Withdraw Money')
        </a>
    </div>

    <div class="full-table">
        <table class="table table--responsive--md">
            <thead>
                <tr>
                    <th>@lang('S.N.')</th>
                    <th>@lang('Gateway') | @lang('TRX No.')</th>
                    <th>@lang('Initiated')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Conversion')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdraws as $withdraw)
                    <tr>
                        <td>{{ $loop->index + $withdraws->firstItem() }}</td>
                        <td>
                            <div>
                                @if ($withdraw->branch)
                                    <span class="fw-bold">
                                        <span class="text--primary"
                                            title="@lang('Branch Name')">{{ __(@$withdraw->branch->name) }}</span>
                                    </span>
                                @else
                                    <span class="fw-bold"><span class="text--primary" title="@lang('Method Name')">
                                            {{ __(@$withdraw->method->name) }}</span></span>
                                @endif
                                <br>
                                <small>{{ $withdraw->trx }}</small>
                            </div>
                        </td>

                        <td>
                            <div>
                                <em>{{ showDateTime($withdraw->created_at) }} </em>
                                <br> {{ diffForHumans($withdraw->created_at) }}
                            </div>
                        </td>

                        <td>
                            <div>
                                {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount) }} - <span class="text--danger"
                                    title="@lang('charge')">{{ showAmount($withdraw->charge) }} </span>
                                <br>
                                <strong title="@lang('Amount after charge')">
                                    {{ showAmount($withdraw->amount - $withdraw->charge) }}
                                    {{ __($general->cur_text) }}
                                </strong>
                            </div>

                        </td>

                        <td>
                            <div>
                                1 {{ __($general->cur_text) }} = {{ showAmount($withdraw->rate) }}
                                {{ __($withdraw->currency) }}
                                <br>
                                <strong>{{ showAmount($withdraw->final_amount) }}
                                    {{ __($withdraw->currency) }}</strong>
                            </div>
                        </td>

                        <td>
                            <div>
                                @php echo $withdraw->statusBadge @endphp
                            </div>
                        </td>

                        <td>
                            <button class="btn btn-outline--base btn--sm detailBtn"
                                data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                @if ($withdraw->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                <i class="la la-desktop"></i> @lang('Details')
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($withdraws->hasPages())
        <div class="mt-4">
            {{ $withdraws->links() }}
        </div>
    @endif
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data');
                var html = ``;

                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }
                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('modal')
    <div class="modal fade custom--modal" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush userData">

                    </ul>
                    <div class="feedback"></div>
                </div>

            </div>
        </div>
    </div>
@endpush
