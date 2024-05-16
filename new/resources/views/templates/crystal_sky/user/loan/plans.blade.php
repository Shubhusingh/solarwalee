@extends($activeTemplate . 'layouts.master')
@section('content')
    @include($activeTemplate . 'partials.loan_plans')
@endsection

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('user.loan.plans') }}" class="btn btn--base active">@lang('Loan Plans')</a>
            <a href="{{ route('user.loan.list') }}" class="btn btn-outline--base">@lang('My Loan List')</a>
        </div>
    </div>
@endpush
