
@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-12">
                <div class="custom--card">
                    <div class="card-body">
                        <h5 class="text-center">
                            @lang('Your FDR invest information')
                        </h5>

                        <ul class="caption-list-two mt-3">
                            <li>
                                <span class="caption">@lang('Plan')</span>
                                <span class="value">{{ __($fdr->plan->name) }}</span>
                            </li>
                            <li>
                                <span class="caption">@lang('Profit Rate')</span>
                                <span class="value">{{ getAmount($fdr->plan->interest_rate) }}%</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Your Amount')</span>
                                <span class="value">{{ $general->cur_sym . showAmount($fdr->amount) }}</span>
                            </li>

                            <li>
                                <span class="caption">@lang('Profit in Every') {{ $fdr->plan->installment_interval }}
                                    @lang('Days')</span>
                                <span
                                    class="value">{{ $general->cur_sym . showAmount(($fdr->amount * $fdr->plan->interest_rate) / 100) }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-end mt-3 gap-2">
                            <a href="{{ route('user.fdr.download', $fdr->id) }}" type="button"
                                class="btn btn--base btn-sm"><i class="las la-file-download"></i>@lang('Download')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('bottom-menu')
    <li><a href="{{ route('user.fdr.plans') }}">@lang('FDR Plans')</a></li>
    <li><a href="{{ route('user.fdr.list') }}">@lang('My FDR List')</a></li>
@endpush
