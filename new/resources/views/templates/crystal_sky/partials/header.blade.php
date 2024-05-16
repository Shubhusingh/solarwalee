<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}">
                <img src="{{ siteLogo('dark') }}" alt="@lang('image')" />
            </a>
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    <li class="nav-item d-block d-lg-none">
                        <div class="top-button d-flex flex-wrap justify-content-between align-items-center"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('home') }}" aria-current="page" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @php
                        $pages = App\Models\Page::where('tempname', $activeTemplate)
                            ->where('is_default', 0)
                            ->get();
                    @endphp
                    @foreach ($pages as $k => $data)
                        <li class="nav-item">
                            <a class="nav-link @if ($data->slug == Request::segment(1)) active @endif" aria-current="page" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('contact') }}" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>

                </ul>
                <div class="nav-right">
                    @if ($general->multi_language)
                        @php
                            $language = App\Models\Language::all();
                        @endphp
                        <div class="lang-select">
                            <select class="fs-18 border-0 lang-select langSel">
                                @foreach ($language as $item)
                                    <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="signin-btn">
                        @auth
                            <a href="{{ route('user.home') }}" class="btn btn--base">
                                @lang('Dashboard')
                            </a>
                        @else
                            <a href="{{ route('user.login') }}" class="btn btn--base">
                                <i class="las la-sign-in-alt"></i>
                                @lang('Sign In')
                            </a>
                            <a href="{{ route('user.logout') }}" class="logout-btn v-hidden"></a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
