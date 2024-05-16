<div class="dashboard-header">
    <div class="row gy-3 gy-lg-4">
        <div class="col-6 d-lg-none d-inline order-1">
            <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
        </div>

        <div class="col-lg-9 col-7 order-lg-2 order-3">
            <div class="dashboard-header__details order-lg-fast order-0">
                <p class="account-no">@lang('Account No') {{ auth()->user()->account_number }}</p>
                <h4 class="dashboard-header__title mb-0">{{ __(@$pageTitle) }}</h4>
            </div>
        </div>

        @if ($general->multi_language)
            @php
                $language = App\Models\Language::all();
            @endphp
            <div class="col-6 col-lg-3 text-end order-lg-3 order-2">
                <select class="select-lang rounded-2 langSel">
                    @foreach ($language as $item)
                        <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @stack('bottom-menu')
    </div>
</div>
