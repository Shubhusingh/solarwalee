@extends($activeTemplate . 'layouts.master')
@section('content')
    @include($activeTemplate . 'partials.fdr_plans')
@endsection

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('user.fdr.plans') }}" class="btn btn--base active">@lang('FDR Plans')</a>
            <a href="{{ route('user.fdr.list') }}" class="btn btn-outline--base">@lang('My FDR List')</a>
        </div>
    </div>
@endpush
