@extends('admin.pdf.layouts.master')

@section('main-content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('S.N.')</th>
                <th>@lang('User')</th>
                <th>@lang('TRX')</th>
                <th>@lang('Transacted')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Post Balance')</th>
                <th>@lang('Details')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $trx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="d-block">{{ $trx->user->fullname }}</span>
                    </td>

                    <td>
                        <strong>{{ $trx->trx }}</strong>
                    </td>

                    <td>
                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                    </td>

                    <td>
                        <span class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }} {{ $general->cur_text }}
                        </span>
                    </td>

                    <td>
                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                    </td>

                    <td>{{ __($trx->details) }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
