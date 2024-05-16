@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4 justify-content-center ">
        <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-4 col-sm-6">
            <div class="section-bg">
                <span class="text-center d-block proifle-image-preview">
                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, null, true) }}" alt="@lang('image')" class="man-thumb">
                </span>
                <ul class="user-info-card">
                    <li class="user-info-card__list flex-align">
                        <p class="user-info-card__name">@lang('Account No.')</p>
                        <p class="user-info-card__value fs-16 ms-auto">{{ $user->account_number }}</p>
                    </li>
                    @if ($user->branch)
                        <li class="user-info-card__list flex-align">
                            <p class="user-info-card__name">@lang('Branch')</p>
                            <p class="user-info-card__value fs-16 ms-auto">{{ @$user->branch->name }}</p>
                        </li>
                    @endif
                    <li class="user-info-card__list flex-align">
                        <p class="user-info-card__name">@lang('Username')</p>
                        <p class="user-info-card__value fs-16 ms-auto">{{ $user->username }}</p>
                    </li>
                    <li class="user-info-card__list flex-align">
                        <p class="user-info-card__name">@lang('Email')</p>
                        <p class="user-info-card__value fs-16 ms-auto">{{ $user->email }}</p>
                    </li>
                    <li class="user-info-card__list flex-align">
                        <p class="user-info-card__name">@lang('Mobile')</p>
                        <p class="user-info-card__value fs-16 ms-auto">{{ $user->mobile }}</p>
                    </li>
                    <li class="user-info-card__list flex-align">
                        <p class="user-info-card__name">@lang('Country')</p>
                        <p class="user-info-card__value fs-16 ms-auto">{{ $user->address->country }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xxl-9 col-xl-8 col-lg-7 col-md-8 col-sm-6">
            <form class="section-bg" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gx-4">
                    <div class="col-xl-6 col-lg-12 col-md-6 col-xsm-6">
                        <div class="form-group">
                            <label class="form-label">@lang('First Name')</label>
                            <input type="text" class="form--control" name="firstname" value="{{ $user->firstname }}" required>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6 col-xsm-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Last Name')</label>
                            <input type="text" class="form--control" name="lastname" value="{{ $user->lastname }}" required>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6 col-xsm-6">
                        <div class="form-group">
                            <label class="form-label">@lang('State')</label>
                            <input type="text" class="form--control" name="state" value="{{ $user->address->state }}">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6 col-xsm-6">
                        <div class="form-group">
                            <label class="form-label">@lang('City')</label>
                            <input type="text" class="form--control" name="city" value="{{ $user->address->city }}">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6 col-xsm-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Zip Code')</label>
                            <input type="text" class="form--control" name="zip" value="{{ $user->address->zip }}">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-6 col-xsm-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Address')</label>
                            <input type="text" class="form--control" name="address" value="{{ $user->address->address }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="file" class="form--control" id="imageUpload" name="image" type='file' accept=".png, .jpg, .jpeg">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $("#imageUpload").on('change', function() {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('.proifle-image-preview img').attr('src', e.target.result)
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush

@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            <a href="{{ route('user.profile.setting') }}" class="btn btn--base active">@lang('Profile Setting')</a>
            <a href="{{ route('user.change.password') }}" class="btn btn-outline--base">@lang('Change Password')</a>
            <a href="{{ route('user.twofactor') }}" class="btn btn-outline--base">@lang('2FA Security')</a>
        </div>
    </div>
@endpush
