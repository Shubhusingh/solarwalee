@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Submitted By')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Last Reply')</th>
                                    @can('admin.ticket.view')
                                        <th>@lang('Action')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td>
                                            @can('admin.ticket.view')
                                                <a href="{{ route('admin.ticket.view', $item->id) }}" class="fw-bold"> [@lang('Ticket')#{{ $item->ticket }}] {{ strLimit($item->subject, 30) }} </a>
                                            @else
                                                [@lang('Ticket')#{{ $item->ticket }}] {{ strLimit($item->subject, 30) }}
                                            @endcan
                                        </td>

                                        <td>
                                            @if ($item->user_id)
                                                @can('admin.users.detail')
                                                    <a href="{{ route('admin.users.detail', $item->user_id) }}"> {{ @$item->user->fullname }}</a>
                                                @else
                                                    {{ @$item->user->fullname }}
                                                @endcan
                                            @else
                                                <p class="fw-bold"> {{ $item->name }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @php echo $item->statusBadge; @endphp
                                        </td>
                                        <td>

                                            @if ($item->priority == Status::PRIORITY_LOW)
                                                <span class="badge badge--dark">@lang('Low')</span>
                                            @elseif($item->priority == Status::PRIORITY_MEDIUM)
                                                <span class="badge  badge--warning">@lang('Medium')</span>
                                            @elseif($item->priority == Status::PRIORITY_HIGH)
                                                <span class="badge badge--danger">@lang('High')</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ diffForHumans($item->last_reply) }}
                                        </td>

                                        @can('admin.ticket.view')
                                            <td>
                                                <a href="{{ route('admin.ticket.view', $item->id) }}" class="btn btn-sm btn-outline--primary ms-1">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($items->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($items) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection
