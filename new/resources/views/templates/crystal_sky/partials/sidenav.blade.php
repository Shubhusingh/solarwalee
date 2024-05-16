<div class="sidebar-menu flex-between">
    <div class="sidebar-menu__inner">
        <span class="sidebar-menu__close d-lg-none d-block flex-between"><i class="fas fa-times"></i></span>
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="sidebar-logo__link"><img src="{{ siteLogo('dark') }}" alt="@lang('image')" /></a>
        </div>
        <ul class="sidebar-menu-list">
            <li class="menu-title pt-0">@lang('MENU')</li>

            <li class="sidebar-menu-list__item {{ menuActive('user.home') }}">
                <a href="{{ route('user.home') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-landmark"></i></span>
                    <span class="text">@lang('Dashboard')</span>
                </a>
            </li>

            @if ($general->modules->deposit)
                <li class="sidebar-menu-list__item {{ menuActive('user.deposit.*') }}">
                    <a href="{{ route('user.deposit.history') }}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="las la-wallet"></i></span>
                        <span class="text">@lang('Deposit')</span>
                    </a>
                </li>
            @endif

            @if ($general->modules->withdraw)
                <li class="sidebar-menu-list__item {{ menuActive('user.withdraw*') }}">
                    <a href="{{ route('user.withdraw.history') }}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="las la-money-bill"></i></span>
                        <span class="text">@lang('Withdraw')</span>
                    </a>
                </li>
            @endif

            @if ($general->modules->fdr)
                <li class="sidebar-menu-list__item {{ menuActive('user.fdr.*') }}">
                    <a href="{{ route('user.fdr.plans') }}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="las la-file-invoice-dollar"></i></span>
                        <span class="text">@lang('FDR')</span>
                    </a>
                </li>
            @endif

            @if ($general->modules->dps)
                <li class="sidebar-menu-list__item {{ menuActive('user.dps.*') }}">
                    <a href="{{ route('user.dps.plans') }}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="las la-piggy-bank"></i></span>
                        <span class="text">@lang('DPS')</span>
                    </a>
                </li>
            @endif

            @if ($general->modules->loan)
                <li class="sidebar-menu-list__item {{ menuActive('user.loan.*') }}">
                    <a href="{{ route('user.loan.plans') }}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="las la-hand-holding-usd"></i></span>
                        <span class="text">@lang('Loan')</span>
                    </a>
                </li>
            @endif

            @if ($general->modules->own_bank || $general->modules->other_bank || $general->modules->wire_transfer)
                <li class="sidebar-menu-list__item {{ menuActive(['user.transfer*', 'user.beneficiary.*']) }}">
                    @if ($general->modules->own_bank)
                        <a href="{{ route('user.beneficiary.own') }}" class="sidebar-menu-list__link">
                            <span class="icon"><i class="las la-exchange-alt"></i></span>
                            <span class="text">@lang('Transfer')</span>
                        </a>
                    @elseif($general->modules->other_bank)
                        <a href="{{ route('user.beneficiary.other') }}" class="sidebar-menu-list__link">
                            <span class="icon"><i class="las la-exchange-alt"></i></span>
                            <span class="text">@lang('Transfer')</span>
                        </a>
                    @else
                        <a href="{{ route('user.transfer.wire.index') }}" class="sidebar-menu-list__link">
                            <span class="icon"><i class="las la-exchange-alt"></i></span>
                            <span class="text">@lang('Transfer')</span>
                        </a>
                    @endif
                </li>
            @endif

            <li class="sidebar-menu-list__item {{ menuActive('user.transaction.history') }}">
                <a href="{{ route('user.transaction.history') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-sync"></i></span>
                    <span class="text">@lang('Transactions')</span>
                </a>
            </li>

            @if ($general->modules->referral_system)
                <li class="sidebar-menu-list__item {{ menuActive('user.referral.users') }}">
                    <a href="{{ route('user.referral.users') }}" class="sidebar-menu-list__link">
                        <span class="icon"><i class="las la-user-friends"></i></span>
                        <span class="text">@lang('Referral')</span>
                    </a>
                </li>
            @endif

            <li class="sidebar-menu-list__item {{ menuActive('ticket.*') }}">
                <a href="{{ route('ticket.index') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-ticket-alt"></i></span>
                    <span class="text">@lang('Support Ticket')</span>
                </a>
            </li>

            <li class="sidebar-menu-list__item {{ menuActive(['user.profile.setting', 'user.change.password', 'user.twofactor']) }}">
                <a href="{{ route('user.profile.setting') }}" class="sidebar-menu-list__link">
                    <span class="icon"><i class="las la-cog"></i></span>
                    <span class="text">@lang('Setting')</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="user-logout">
        <div class="sidebar-menu-list__item w-100">
            <a href="{{ route('user.logout') }}" class="sidebar-menu-list__link logout logout-btn">
                <span class="icon"><i class="las la-sign-out-alt"></i></span>
                <span class="text">@lang('Log Out')</span>
            </a>
        </div>
    </div>
</div>
