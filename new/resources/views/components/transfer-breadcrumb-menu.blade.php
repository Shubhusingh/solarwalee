@push('bottom-menu')
    <div class="col-12 order-lg-3 order-4">
        <div class="d-flex nav-buttons flex-align gap-md-3 gap-2">
            @if (@$general->modules->own_bank || @$general->modules->other_bank || $general->modules->wire_transfer)
                @if ($general->modules->own_bank)
                    <a class="@if (request()->routeIs('user.beneficiary.*')) btn btn--base active @else btn btn-outline--base @endif" href="{{ route('user.beneficiary.own') }}">@lang('Beneficiaries')</a>
                @elseif ($general->modules->other_bank)
                    <a class="@if (request()->routeIs('user.beneficiary.*')) btn btn--base active @else btn btn-outline--base @endif" href="{{ route('user.beneficiary.other') }}">@lang('Beneficiaries')</a>
                @endif
                @if (@$general->modules->own_bank)
                    <a href="{{ route('user.transfer.own.bank.beneficiaries') }}" class="@if (request()->routeIs('user.transfer.own.bank.beneficiaries')) btn btn--base active @else btn btn-outline--base @endif">
                        @lang('Within') @lang($general->site_name)</a>
                @endif
                @if (@$general->modules->other_bank)
                    <a href="{{ route('user.transfer.other.bank.beneficiaries') }}" class="@if (request()->routeIs('user.transfer.other.bank.beneficiaries')) btn btn--base active @else btn btn-outline--base @endif">
                        @lang('Other Bank')
                    </a>
                @endif
                @if (@$general->modules->wire_transfer)
                    <a href="{{ route('user.transfer.wire.index') }}" class="@if (request()->routeIs('user.transfer.wire.index')) btn btn--base active @else btn btn-outline--base @endif">
                        @lang('Wire Transfer')
                    </a>
                @endif
                <a href="{{ route('user.transfer.history') }}" class="@if (request()->routeIs('user.transfer.history')) btn btn--base active @else btn btn-outline--base @endif">
                    @lang('History')
                </a>
            @endif
        </div>
    </div>
@endpush
