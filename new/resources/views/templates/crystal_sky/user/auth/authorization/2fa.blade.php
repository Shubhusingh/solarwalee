@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container py-120">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper custom--card">
                <div class="verification-area">
                    <form action="{{ route('user.go2fa.verify') }}" method="POST" class="submit-form">
                        @csrf
                        <p class="mb-3 text-muted">@lang('Take the code from your google authenticator app.')</p>

                        @include($activeTemplate . 'partials.verification_code')
                        <button type="submit" class="btn btn-md btn--base w-100">@lang('Submit')</button>
                    </form>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('user.logout') }}">
                            <span class="icon"><i class="las la-sign-out-alt"></i></span>
                            <span class="text">@lang('Log Out')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
