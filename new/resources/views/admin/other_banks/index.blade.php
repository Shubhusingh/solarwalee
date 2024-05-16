@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Bank')</th>
                                    <th>@lang('Transfer Limit')</th>
                                    <th>@lang('Transfer Charge')</th>
                                    <th>@lang('Status')</th>
                                    @if (can('admin.bank.edit') || can('admin.bank.change.status'))
                                        <th>@lang('Action')</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banks as  $bank)
                                    <tr>
                                        <td>{{ $loop->index + $banks->firstItem() }}</td>

                                        <td>
                                            <span class="text--primary fw-bold">{{ __($bank->name) }}</span>
                                            <br>
                                            <span>@lang('Processing Time'): {{ $bank->processing_time }}</span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">@lang('Min'):</span>
                                            {{ $general->cur_sym . showAmount($bank->minimum_limit) }}
                                            <br>
                                            <span class="fw-bold">@lang('Max'):</span>
                                            {{ $general->cur_sym . showAmount($bank->maximum_limit) }}
                                        </td>

                                        <td>
                                            <span class="fw-bold">@lang('Fixed'):</span> {{ $general->cur_sym . showAmount($bank->fixed_charge) }}
                                            <br>
                                            <span class="fw-bold">@lang('Percent'):</span> {{ getAmount($bank->percent_charge) }}%
                                        </td>

                                        <td>@php echo $bank->statusBadge;@endphp</td>
                                        @if (can('admin.bank.edit') || can('admin.bank.change.status'))
                                            <td>
                                                <div class="button--group">
                                                    @can('admin.bank.edit')
                                                        <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.bank.edit', $bank->id) }}">
                                                            <i class="la la-pencil"></i> @lang('Edit')
                                                        </a>
                                                    @endcan

                                                    @can('admin.bank.change.status')
                                                        @if (!$bank->status)
                                                            <button class="btn btn-sm btn-outline--success confirmationBtn" data-question="@lang('Are you sure to enable this bank?')" data-action="{{ route('admin.bank.change.status', $bank->id) }}"><i class="la la-eye"></i> @lang('Enable')</button>
                                                        @else
                                                            <button class="btn btn-sm btn-outline--danger confirmationBtn" data-question="@lang('Are you sure to disable this bank?')" data-action="{{ route('admin.bank.change.status', $bank->id) }}"> <i class="la la-eye-slash"></i> @lang('Disable')</button>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($banks->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($banks) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @can('admin.bank.change.status')
        <x-confirmation-modal />
    @endcan
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Bank Name" />
    @can('admin.bank.create')
        <a class="btn btn-outline--primary" href="{{ route('admin.bank.create') }}">
            <i class="las la-plus"></i>@lang('Add New')
        </a>
    @endcan
@endpush
