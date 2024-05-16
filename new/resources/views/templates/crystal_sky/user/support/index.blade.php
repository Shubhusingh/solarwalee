@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="full-table">
        <table class="table table--responsive--md">
            <thead>
                <tr>
                    <th>@lang('S.N.')</th>
                    <th>@lang('Subject')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Priority')</th>
                    <th>@lang('Last Reply')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($supports as $support)
                    <tr>
                        <td>{{ $loop->index + $supports->firstItem() }}</td>

                        <td>
                            <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a>
                        </td>

                        <td>@php echo $support->statusBadge; @endphp</td>

                        <td>
                            @if ($support->priority == Status::PRIORITY_LOW)
                                <span class="badge badge--dark">@lang('Low')</span>
                            @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                <span class="badge badge--warning">@lang('Medium')</span>
                            @elseif($support->priority == Status::PRIORITY_HIGH)
                                <span class="badge badge--danger">@lang('High')</span>
                            @endif
                        </td>

                        <td>{{ diffForHumans($support->last_reply) }}</td>

                        <td>
                            <a class="btn btn-outline--base btn--sm" href="{{ route('ticket.view', $support->ticket) }}">
                                <i class="la la-desktop"></i> @lang('View')
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
    @if ($supports->hasPages())
        <div class="mt-4">
            {{ paginateLinks($supports) }}
        </div>
    @endif
@endsection

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('ticket.index') }}" class="btn btn--base active">@lang('My Tickets')</a>
            <a href="{{ route('ticket.open') }}" class="btn btn-outline--base">@lang('Open New Ticket')</a>
        </div>
    </div>
@endpush
