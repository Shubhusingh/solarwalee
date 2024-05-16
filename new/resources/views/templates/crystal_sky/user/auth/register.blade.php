@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $policyPages = getContent('policy_pages.element', orderById: true);
        $signupBg = getContent('signup_bg.content', true);
    @endphp

    <section class="account">
        <div class="account__left flex-align bg-img" data-background-image="{{ asset($activeTemplateTrue . 'images/thumbs/account-bg.png') }}">
            <div class="account__thumb">
                <img src="{{ getImage('assets/images/frontend/signup_bg/' . @$signupBg->data_values->image, '1920x1280') }}" alt="@lang('image')">
            </div>
        </div>
        <div class="d-flex flex-wrap account__right flex-align">
            <div class="account__form">
                <div class="account-form pt-0 pb-0">
                    <a class="site-logo" href="{{ route('home') }}"><img src="{{ siteLogo('dark') }}" alt="@lang('logo')"></a>
                    <div class="section-heading style-left">
                        <h6 class="section-heading__subtitle">{{ __(@$signupBg->data_values->heading) }}</h6>
                        <h3 class="section-heading__title">
                            {{ __(@$signupBg->data_values->subheading) }}
                        </h3>
                    </div>
                    <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                        @csrf
                        <div class="row">
                            @if (session()->get('reference') != null && $general->modules->referral_system)
                                <div class="form-group">
                                    <label for="referenceBy" class="form--label">@lang('Referred by')</label>
                                    <input type="text" name="referBy" id="referenceBy" class="form--control" value="{{ session()->get('reference') }}" readonly>
                                </div>
                            @endif
                            <div class="col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label for="f-name" class="form--label">@lang('Username')</label>
                                    <input type="text" class="form--control checkUser" name="username" value="{{ old('username') }}" id="f-name">
                                    <small class="text--danger usernameExist"></small>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label for="email" class="form--label">@lang('Email Address')</label>
                                    <input type="email" name="email" class="form--control checkUser" id="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label for="country" class="form--label">@lang('Country')</label>
                                    @php
                                        $countryCode = @getIpInfo()['code'];
                                    @endphp
                                    <select name="country" class="form--control">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}" @selected($countryCode == $key)>
                                                {{ __($country->country) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label for="phone" class="form--label">@lang('Mobile')</label>
                                    <div class="input-group custom-input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="phone" class="form-control form--control checkUser" required>
                                    </div>
                                    <small class="text--danger mobileExist"></small>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                </div>
                            </div>

                            <div class="col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label for="yourPassword" class="form--label">@lang('Password')</label>
                                    <input name="password" id="yourPassword" type="password" class="form--control @if ($general->secure_password) secure-password @endif" required>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label for="confirmPassword" class="form--label">@lang('Confirm password')</label>
                                    <input name="password_confirmation" id="confirmPassword" type="password" class="form--control" required>
                                </div>
                            </div>

                            <x-captcha />

                            @if ($general->agree)
                                <div class="col-12">
                                    <div class="form-group d-flex">
                                        <div class="form--check">
                                            <input class="form-check-input" type="checkbox" name="agree" @checked(old('agree')) id="remember">
                                        </div>
                                        <div class="terms px-2">
                                            <label class="form-check-label" for="remember">@lang('I agree with')</label>
                                            @foreach ($policyPages as $policy)
                                                <a class="text--base footer-menu__link" href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" target="_blank">{{ __($policy->data_values->title) }}</a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="have-account text-center">
                                    <p class="have-account__text">@lang('Already Have An Account?')
                                        <a href="{{ route('user.login') }}" class="have-account__link text--base">@lang('Login')</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            $(document).ready(function() {
                $('select[name=country]').change();
            });

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('.checkUser').on('focusout', function(e) {

                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    };
                }

                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }

                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }

                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`This ${response.type} is already exist`);
                    } else {
                        $(`.${response.type}Exist`).empty();
                    }
                });
            });


            $('select[name=country]').change();

        })(jQuery);
    </script>
@endpush
