<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('admin.dashboard') }}" class="sidebar__main-logo">
                <h3 style="color:#fff">Solar Software</h3>
            </a>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">

                @can('admin.dashboard')
                    <li class="sidebar-menu-item {{ menuActive('admin.dashboard') }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="menu-icon las la-home"></i>
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </li>
                @endcan

                @can(['admin.staff.index', 'admin.roles.index', 'admin.permissions.index'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive(['admin.staff*', 'admin.roles.*'], 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-users"></i>
                            <span class="menu-title">@lang('Manage Staff')</span>
                        </a>
                        <div
                            class="sidebar-submenu {{ menuActive(['admin.staff*', 'admin.roles.*', 'admin.permissions*'], 2) }}">
                            <ul>
                                @can('admin.staff.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.staff*') }}">
                                        <a class="nav-link" href="{{ route('admin.staff.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All Staff')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.roles.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.roles*') }}">
                                        <a class="nav-link" href="{{ route('admin.roles.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Roles')</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan

                @can(['admin.users*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.users*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-users"></i>
                            <span class="menu-title">@lang('Manage Customer')</span>

                            @if (
                                $bannedUsersCount > 0 ||
                                    $emailUnverifiedUsersCount > 0 ||
                                    $mobileUnverifiedUsersCount > 0 ||
                                    $kycUnverifiedUsersCount > 0 ||
                                    $kycPendingUsersCount > 0)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.users*', 2) }}">
                            <ul>
                                @can('admin.users.active')
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.active') }}">
                                        <a class="nav-link" href="{{ route('admin.users.active') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Active Users')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.users.banned')
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.banned') }}">
                                        <a class="nav-link" href="{{ route('admin.users.banned') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Banned Users')</span>
                                            @if ($bannedUsersCount)
                                                <span class="menu-badge pill bg--danger ms-auto">{{ $bannedUsersCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                             
                              
                              

                               


                              
                                @can('admin.users.all')
                                    <li class="sidebar-menu-item {{ menuActive('admin.users.all') }}">
                                        <a class="nav-link" href="{{ route('admin.users.all') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All Users')</span>
                                        </a>
                                    </li>
                                @endcan

                               
                            </ul>
                        </div>
                    </li>
                @endcan


       
{{-- 
                @can(['admin.loan*'])
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="{{ menuActive('admin.loan*', 3) }}" href="javascript:void(0)">
                        <i class="menu-icon las la-hand-holding-usd"></i>
                        <span class="menu-title">Lead Management</span>
                        @if ($pendingLoanCount || $dueLoanCount)
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>

                    <div class="sidebar-submenu ">
                        <ul>
                       
                            
                      
                            @can('admin.loan.pending')
                                <li class="sidebar-menu-item {{ menuActive('admin.loan.pending') }}">
                                    <a class="nav-link" href="{{ route('admin.loan.pending') }}">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">No Answer Leads</span>
                                        @if ($pendingLoanCount)
                                            <span
                                                class="menu-badge pill bg--danger ms-auto">{{ $pendingLoanCount }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan

                            @can('admin.loan.running')
                                <li class="sidebar-menu-item {{ menuActive('admin.loan.running') }}">
                                    <a class="nav-link" href="{{ route('admin.loan.running') }}">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">Fresh Leads</span>
                                    </a>
                                </li>
                            @endcan

                            @can('admin.loan.due')
                                <li class="sidebar-menu-item {{ menuActive('admin.loan.due') }}">
                                    <a class="nav-link" href="{{ route('admin.loan.due') }}">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">Interested Leads</span>
                                        @if ($dueLoanCount)
                                            <span class="menu-badge pill bg--danger ms-auto">{{ $dueLoanCount }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endcan

                            @can('admin.loan.paid')
                                <li class="sidebar-menu-item {{ menuActive('admin.loan.paid') }}">
                                    <a class="nav-link" href="{{ route('admin.loan.paid') }}">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">Less Salary</span>
                                    </a>
                                </li>
                            @endcan


                            @can('admin.loan.rejected')
                                <li class="sidebar-menu-item {{ menuActive('admin.loan.rejected') }}">
                                    <a class="nav-link" href="{{ route('admin.loan.rejected') }}">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">Not Eligible</span>
                                    </a>
                                </li>
                            @endcan

                            @can('admin.loan.rejected')
                            <li class="sidebar-menu-item {{ menuActive('admin.loan.rejected') }}">
                                <a class="nav-link" href="{{ route('admin.loan.rejected') }}">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">Docs Received</span>
                                </a>
                            </li>
                        @endcan


                        @can('admin.loan.rejected')
                        <li class="sidebar-menu-item {{ menuActive('admin.loan.rejected') }}">
                            <a class="nav-link" href="{{ route('admin.loan.rejected') }}">
                                <i class="menu-icon las la-dot-circle"></i>
                                <span class="menu-title">Incomplete Docs</span>
                            </a>
                        </li>
                    @endcan

                    @can('admin.loan.rejected')
                    <li class="sidebar-menu-item {{ menuActive('admin.loan.rejected') }}">
                        <a class="nav-link" href="{{ route('admin.loan.rejected') }}">
                            <i class="menu-icon las la-dot-circle"></i>
                            <span class="menu-title">PayDay Pending Loan</span>
                        </a>
                    </li>
                @endcan
                         

                        </ul>
                    </div>
                </li>
            @endcan --}}
                @can(['admin.loan*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.loan*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-hand-holding-usd"></i>
                            <span class="menu-title">Lead Management</span>
                            @if ($pendingLoanCount || $dueLoanCount)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>

                        <div class="sidebar-submenu {{ menuActive('admin.loan*', 2) }}">
                            <ul>
                                @can('admin.loan.index')
                                <li class="sidebar-menu-item {{ menuActive('admin.loan.index') }}">
                                    <a class="nav-link" href="{{ route('admin.loan.index') }}">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">All Lead</span>
                                    </a>
                                </li>
                            @endcan
                                @can('admin.loan.pending')
                                    <li class="sidebar-menu-item {{ menuActive('admin.loan.pending') }}">
                                        <a class="nav-link" href="{{ route('admin.loan.pending') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">Super Hot Lead</span>
                                            @if ($pendingLoanCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $pendingLoanCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.loan.running')
                                    <li class="sidebar-menu-item {{ menuActive('admin.loan.running') }}">
                                        <a class="nav-link" href="{{ route('admin.loan.running') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">Hot lead</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.loan.due')
                                    <li class="sidebar-menu-item {{ menuActive('admin.loan.due') }}">
                                        <a class="nav-link" href="{{ route('admin.loan.due') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">Won Lead </span>
                                            @if ($dueLoanCount)
                                                <span class="menu-badge pill bg--danger ms-auto">{{ $dueLoanCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.loan.paid')
                                    <li class="sidebar-menu-item {{ menuActive('admin.loan.paid') }}">
                                        <a class="nav-link" href="{{ route('admin.loan.paid') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">Cold Lead</span>
                                        </a>
                                    </li>
                                @endcan


                                @can('admin.loan.noteligible')
                                    <li class="sidebar-menu-item {{ menuActive('admin.loan.noteligible') }}">
                                        <a class="nav-link" href="{{ route('admin.loan.noteligible') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">Dead Lead</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.loan.rejected')
                                <li class="sidebar-menu-item {{ menuActive('admin.loan.rejected') }}">
                                    <a class="nav-link" href="{{ route('admin.loan.rejected') }}">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">Lost Dead</span>
                                    </a>
                                </li>
                            @endcan
                            @can('admin.loan.paid')
                            <li class="sidebar-menu-item {{ menuActive('admin.loan.paid') }}">
                                <a class="nav-link" href="{{ route('admin.loan.paid') }}">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">Booking Lead</span>
                                </a>
                            </li>
                        @endcan

                        @can('admin.loan.paid')
                        <li class="sidebar-menu-item {{ menuActive('admin.loan.paid') }}">
                            <a class="nav-link" href="{{ route('admin.loan.paid') }}">
                                <i class="menu-icon las la-dot-circle"></i>
                                <span class="menu-title">Follow Lead</span>
                            </a>
                        </li>
                    @endcan
                               

                            </ul>
                        </div>
                    </li>
                @endcan

              
              

                @can(['admin.withdraw*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.withdraw*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon la la-hand-holding-usd"></i>
                            <span class="menu-title">@lang('Proposal') </span>
                            @if (0 < $pendingWithdrawCount)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.withdraw*', 2) }}">
                            <ul>

                                @can('admin.withdraw.method.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.withdraw.method.*') }}">
                                        <a class="nav-link" href="{{ route('admin.withdraw.method.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('New proposal')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.withdraw.pending')
                                    <li class="sidebar-menu-item {{ menuActive('admin.withdraw.pending') }}">
                                        <a class="nav-link" href="{{ route('admin.withdraw.pending') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Manage proposal')</span>

                                            @if ($pendingWithdrawCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $pendingWithdrawCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                              
                               

                             
                            </ul>
                        </div>
                    </li>
                @endcan

                {{-- @can(['admin.transfers*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.transfer*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-random"></i>
                            <span class="menu-title">@lang('Money Transfers') </span>
                            @if ($pendingTransferCount)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.transfer*', 2) }}">
                            <ul>
                                @can('admin.transfers.pending')
                                    <li class="sidebar-menu-item {{ menuActive('admin.transfers.pending') }}">
                                        <a class="nav-link" href="{{ route('admin.transfers.pending') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Pending Transfers')</span>
                                            @if ($pendingTransferCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $pendingTransferCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.transfers.rejected')
                                    <li class="sidebar-menu-item {{ menuActive('admin.transfers.rejected') }}">
                                        <a class="nav-link" href="{{ route('admin.transfers.rejected') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Rejected Transfers')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.transfers.own')
                                    <li class="sidebar-menu-item {{ menuActive('admin.transfers.own') }}">
                                        <a class="nav-link" href="{{ route('admin.transfers.own') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Own Bank Transfers')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.transfers.other')
                                    <li class="sidebar-menu-item {{ menuActive('admin.transfers.other') }}">
                                        <a class="nav-link" href="{{ route('admin.transfers.other') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Other Bank Transfers')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.transfers.wire')
                                    <li class="sidebar-menu-item {{ menuActive('admin.transfers.wire') }}">
                                        <a class="nav-link" href="{{ route('admin.transfers.wire') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Wire Transfers')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.transfers.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.transfers.index') }}">
                                        <a class="nav-link" href="{{ route('admin.transfers.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All Transfers')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan --}}

             

                {{-- @can(['admin.wire.transfer*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.wire.transfer*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-comments-dollar"></i>
                            <span class="menu-title">@lang('Wire Transfer') </span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.wire.transfer*', 2) }}">
                            <ul>
                                @can('admin.wire.transfer.setting')
                                    <li class="sidebar-menu-item {{ menuActive('admin.wire.transfer.setting') }}">
                                        <a class="nav-link" href="{{ route('admin.wire.transfer.setting') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Setting')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.wire.transfer.form')
                                    <li class="sidebar-menu-item {{ menuActive('admin.wire.transfer.form') }}">
                                        <a class="nav-link" href="{{ route('admin.wire.transfer.form') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Form')</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan --}}

                {{-- @can(['admin.branch*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.branch*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-project-diagram"></i>
                            <span class="menu-title">@lang('Manage Branches') </span>
                        </a>

                        <div class="sidebar-submenu {{ menuActive('admin.branch*', 2) }}">
                            <ul>
                                @can('admin.branch.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.branch.index') }}">
                                        <a class="nav-link" href="{{ route('admin.branch.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All Branches')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.branch.staff.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.branch.staff.*') }}">
                                        <a class="nav-link" href="{{ route('admin.branch.staff.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Branch Staff')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan --}}

             

                {{-- @can(['admin.fdr*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.fdr*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-money-bill"></i>
                            <span class="menu-title">@lang('FDR') </span>
                            @if ($dueFdrCount)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>

                        <div class="sidebar-submenu {{ menuActive('admin.fdr*', 2) }}">
                            <ul>

                                @can('admin.fdr.running')
                                    <li class="sidebar-menu-item {{ menuActive(['admin.fdr.running']) }}">
                                        <a class="nav-link" href="{{ route('admin.fdr.running') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Running FDR')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.fdr.due')
                                    <li class="sidebar-menu-item {{ menuActive('admin.fdr.due') }}">
                                        <a class="nav-link" href="{{ route('admin.fdr.due') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Due FDR')</span>

                                            @if ($dueFdrCount)
                                                <span class="menu-badge pill bg--danger ms-auto">{{ $dueFdrCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.fdr.closed')
                                    <li class="sidebar-menu-item {{ menuActive(['admin.fdr.closed']) }}">
                                        <a class="nav-link" href="{{ route('admin.fdr.closed') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Closed FDR')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.fdr.index')
                                    <li class="sidebar-menu-item {{ menuActive(['admin.fdr.index']) }}">
                                        <a class="nav-link" href="{{ route('admin.fdr.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All FDR')</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan

                @can(['admin.dps*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.dps*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-box"></i>
                            <span class="menu-title">@lang('DPS') </span>
                            @if ($dueDpsCount)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.dps*', 2) }}">
                            <ul>
                                @can('admin.dps.running')
                                    <li class="sidebar-menu-item {{ menuActive('admin.dps.running') }}">
                                        <a class="nav-link" href="{{ route('admin.dps.running') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Running DPS')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.dps.due')
                                    <li class="sidebar-menu-item {{ menuActive('admin.dps.due') }}">
                                        <a class="nav-link" href="{{ route('admin.dps.due') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Due DPS')</span>
                                            @if ($dueDpsCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ __($dueDpsCount) }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.dps.matured')
                                    <li class="sidebar-menu-item {{ menuActive(['admin.dps.matured']) }}">
                                        <a class="nav-link" href="{{ route('admin.dps.matured') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Matured DPS')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.dps.closed')
                                    <li class="sidebar-menu-item {{ menuActive(['admin.dps.closed']) }}">
                                        <a class="nav-link" href="{{ route('admin.dps.closed') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Closed DPS')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.dps.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.dps.index') }}">
                                        <a class="nav-link" href="{{ route('admin.dps.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All DPS')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan --}}



                {{-- @can(['admin.gateway*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.gateway*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-credit-card"></i>
                            <span class="menu-title">@lang('Payment Gateways')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.gateway*', 2) }}">
                            <ul>
                                @can('admin.gateway.automatic.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.gateway.automatic.*') }}">
                                        <a class="nav-link" href="{{ route('admin.gateway.automatic.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Automatic Gateways')</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('admin.gateway.manual.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.gateway.manual.*') }}">
                                        <a class="nav-link" href="{{ route('admin.gateway.manual.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Manual Gateways')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan --}}

                @can(['admin.ticket*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.ticket*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon la la-ticket"></i>
                            <span class="menu-title">@lang('Support Ticket') </span>
                            @if (0 < $pendingTicketCount)
                                <span class="menu-badge pill bg--danger ms-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.ticket*', 2) }}">
                            <ul>
                                @can('admin.ticket.pending')
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.pending') }}">
                                        <a class="nav-link" href="{{ route('admin.ticket.pending') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Pending Ticket')</span>
                                            @if ($pendingTicketCount)
                                                <span
                                                    class="menu-badge pill bg--danger ms-auto">{{ $pendingTicketCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.ticket.closed')
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.closed') }}">
                                        <a class="nav-link" href="{{ route('admin.ticket.closed') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Closed Ticket')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.ticket.answered')
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.answered') }}">
                                        <a class="nav-link" href="{{ route('admin.ticket.answered') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Answered Ticket')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.ticket.index')
                                    <li class="sidebar-menu-item {{ menuActive('admin.ticket.index') }}">
                                        <a class="nav-link" href="{{ route('admin.ticket.index') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('All Ticket')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can(['admin.report*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.report*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon la la-list"></i>
                            <span class="menu-title">@lang('Report') </span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.report*', 2) }}">
                            <ul>
                                @can('admin.report.transaction')
                                    <li
                                        class="sidebar-menu-item {{ menuActive(['admin.report.transaction', 'admin.report.transaction.search']) }}">
                                        <a class="nav-link" href="{{ route('admin.report.transaction') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">DISBURSAL</span>
                                        </a>
                                    </li>
                                @endcan

                                {{-- @can('admin.report.login.history')
                                    <li
                                        class="sidebar-menu-item {{ menuActive(['admin.report.login.history', 'admin.report.login.ipHistory']) }}">
                                        <a class="nav-link" href="{{ route('admin.report.login.history') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Login History')</span>
                                        </a>
                                    </li>
                                @endcan --}}

                             

                            </ul>
                        </div>
                    </li>
                @endcan


                @if (can([
                        'admin.setting.index',
                        'admin.cron.index',
                        'admin.setting.logo.icon',
                        'admin.setting.system.configuration',
                        'admin.kyc.setting',
                        'admin.referral.setting',
                        'admin.extensions.index',
                        'admin.language.manage',
                        'admin.seo',
                        'admin.setting.notification',
                    ]))
                    <li class="sidebar__menu-header">@lang('Settings')</li>
                @endif

                @can('admin.setting.index')
                    <li class="sidebar-menu-item {{ menuActive('admin.setting.index') }}">
                        <a class="nav-link" href="{{ route('admin.setting.index') }}">
                            <i class="menu-icon las la-life-ring"></i>
                            <span class="menu-title">@lang('General Setting')</span>
                        </a>
                    </li>
                @endcan

              

                @can('admin.setting.logo.icon')
                    <li class="sidebar-menu-item {{ menuActive('admin.setting.logo.icon') }}">
                        <a class="nav-link" href="{{ route('admin.setting.logo.icon') }}">
                            <i class="menu-icon las la-images"></i>
                            <span class="menu-title">@lang('Logo & Favicon')</span>
                        </a>
                    </li>
                @endcan

                
               

             

{{-- 
                @can('admin.extensions.index')
                    <li class="sidebar-menu-item {{ menuActive('admin.extensions.index') }}">
                        <a class="nav-link" href="{{ route('admin.extensions.index') }}">
                            <i class="menu-icon las la-cogs"></i>
                            <span class="menu-title">@lang('Extensions')</span>
                        </a>
                    </li>
                @endcan --}}


              

                {{-- @can(['admin.setting.notification*'])
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.setting.notification*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon las la-bell"></i>
                            <span class="menu-title">@lang('Notification Setting')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.setting.notification*', 2) }}">
                            <ul>
                                @can('admin.setting.notification.global')
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.global') }}">
                                        <a class="nav-link" href="{{ route('admin.setting.notification.global') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Global Template')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.setting.notification.email')
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.email') }}">
                                        <a class="nav-link" href="{{ route('admin.setting.notification.email') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Email Setting')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.setting.notification.sms')
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.sms') }}">
                                        <a class="nav-link" href="{{ route('admin.setting.notification.sms') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('SMS Setting')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.setting.notification.push')
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.push') }}">
                                        <a class="nav-link" href="{{ route('admin.setting.notification.push') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Push Notification')</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin.setting.notification.templates')
                                    <li class="sidebar-menu-item {{ menuActive('admin.setting.notification.templates') }}">
                                        <a class="nav-link" href="{{ route('admin.setting.notification.templates') }}">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">@lang('Notification Templates')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan --}}

                {{-- @if (can(['admin.frontend.templates', 'admin.frontend.manage.pages', 'admin.frontend.sections']))
                    <li class="sidebar__menu-header">@lang('Frontend Manager')</li>
                @endif
                @can('admin.frontend.templates')
                    <li class="sidebar-menu-item {{ menuActive('admin.frontend.templates') }}">
                        <a class="nav-link" href="{{ route('admin.frontend.templates') }}">
                            <i class="menu-icon la la-puzzle-piece"></i>
                            <span class="menu-title">@lang('Manage Templates')</span>
                        </a>
                    </li>
                @endcan

                @can('admin.frontend.manage.pages')
                    <li class="sidebar-menu-item {{ menuActive('admin.frontend.manage.*') }}">
                        <a class="nav-link" href="{{ route('admin.frontend.manage.pages') }}">
                            <i class="menu-icon la la-list"></i>
                            <span class="menu-title">@lang('Manage Pages')</span>
                        </a>
                    </li>
                @endcan

                @can('admin.frontend.sections')
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a class="{{ menuActive('admin.frontend.sections*', 3) }}" href="javascript:void(0)">
                            <i class="menu-icon la la-html5"></i>
                            <span class="menu-title">@lang('Manage Section')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.frontend.sections*', 2) }}">
                            <ul>
                                @php
                                    $lastSegment = collect(request()->segments())->last();
                                @endphp
                                @foreach (getPageSections(true) as $k => $secs)
                                    @if ($secs['builder'])
                                        <li class="sidebar-menu-item @if ($lastSegment == $k) active @endif">
                                            <a class="nav-link" href="{{ route('admin.frontend.sections', $k) }}">
                                                <i class="menu-icon las la-dot-circle"></i>
                                                <span class="menu-title">{{ __($secs['name']) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endcan --}}


            

            </ul>
           
        </div>
    </div>
</div>
<!-- sidebar end -->

@push('script')
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
@endpush
