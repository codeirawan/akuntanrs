<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            <a href="{{ url('/') }}">
                <img alt="Logo" src="{{ asset('images/logo/brand.svg') }}" width="155px" height="60px" />
            </a>
        </div>
        <div class="kt-aside__brand-tools">
            <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left"
                id="kt_aside_toggler"><span></span></button>
        </div>
    </div>

    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu" data-ktmenu-vertical="1" data-ktmenu-scroll="1"
            data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav">
                <li class="kt-menu__item @if (Request::is('/dashboard')) kt-menu__item--here @endif"
                    aria-haspopup="true">
                    <a href="{{ route('dashboard') }}" class="kt-menu__link">
                        <i class="kt-menu__link-icon flaticon2-graphic"></i>
                        <span class="kt-menu__link-text">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                @permission(['view-transaction'])
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text">{{ __('Transaction Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                    {{-- <li class="kt-menu__item @if (Request::is('patient*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('patient.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-hospital-user"></i>
                            <span class="kt-menu__link-text">{{ __('Patient') }}</span>
                        </a>
                    </li>
                    <li class="kt-menu__item @if (Request::is('receipt*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('receipt.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-receipt"></i>
                            <span class="kt-menu__link-text">{{ __('Receipt') }}</span>
                        </a>
                    </li>
                    <li class="kt-menu__item @if (Request::is('payment*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('payment.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-file-invoice"></i>
                            <span class="kt-menu__link-text">{{ __('Payment') }}</span>
                        </a>
                    </li> --}}
                    <li class="kt-menu__item @if (Request::is('cash*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('cash.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-cash-register"></i>
                            <span class="kt-menu__link-text">{{ __('Cash & Bank') }}</span>
                        </a>
                    </li>
                    <li class="kt-menu__item @if (Request::is('journal*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('journal.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-ticket"></i>
                            <span class="kt-menu__link-text">{{ __('Journal Voucher') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission(['view-report'])
                    <li class="kt-menu__section">
                        <h4 class="kt-menu__section-text">{{ __('Report Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>

                    <li class="kt-menu__item @if (Request::is('general-ledger*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('general-ledger.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-book"></i>
                            <span class="kt-menu__link-text">{{ __('General Ledger') }}</span>
                        </a>
                    </li>

                    <li class="kt-menu__item @if (Request::is('income-statement*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('income-statement.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-sack-dollar"></i>
                            <span class="kt-menu__link-text">{{ __('Income Statement') }}</span>
                        </a>
                    </li>

                    <li class="kt-menu__item @if (Request::is('balance-sheet*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('balance-sheet.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-scale-balanced"></i>
                            <span class="kt-menu__link-text">{{ __('Balance Sheet') }}</span>
                        </a>
                    </li>

                    <li class="kt-menu__item @if (Request::is('trial-balance*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('trial-balance.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-scale-unbalanced"></i>
                            <span class="kt-menu__link-text">{{ __('Trial Balance') }}</span>
                        </a>
                    </li>

                    <li class="kt-menu__item @if (Request::is('cash-flow*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('cash-flow.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa-solid fa-money-bill-trend-up"></i>
                            <span class="kt-menu__link-text">{{ __('Cash Flow') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission(['view-user', 'view-role'])
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text">{{ __('User Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                @endpermission
                @permission('view-user')
                    <li class="kt-menu__item @if (Request::is('user*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('user.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon flaticon2-user"></i>
                            <span class="kt-menu__link-text">{{ __('User') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('view-role')
                    <li class="kt-menu__item @if (Request::is('role*')) kt-menu__item--here @endif"
                        aria-haspopup="true">
                        <a href="{{ route('role.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon flaticon2-user-1"></i>
                            <span class="kt-menu__link-text">{{ __('Role') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission(['view-master'])
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text">{{ __('Account Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                    <li class="kt-menu__item kt-menu__item--submenu @if (Request::is('master*')) kt-menu__item--open kt-menu__item--here @endif"
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                            <i class="kt-menu__link-icon flaticon2-layers-1"></i>
                            <span class="kt-menu__link-text">{{ __('Master Data') }}</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="kt-menu__submenu">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                                    <span class="kt-menu__link">
                                        <span class="kt-menu__link-text">{{ __('Master Data') }}</span>
                                    </span>
                                </li>
                                <li class="kt-menu__item @if (Request::is('master*')) kt-menu__item--here @endif"
                                    aria-haspopup="true">
                                    {{-- <a href="{{ route('master.company.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Company') }}</span>
                                    </a>
                                    <a href="{{ route('master.fiscal-year.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Fiscal Years') }}</span>
                                    </a> --}}
                                    {{-- <a href="{{ route('master.unit.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Units') }}</span>
                                    </a> --}}
                                    <a href="{{ route('master.account.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Accounts') }}</span>
                                    </a>
                                    {{-- <a href="{{ route('master.specialty.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Specialties') }}</span>
                                    </a>
                                    <a href="{{ route('master.doctor.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Doctors') }}</span>
                                    </a>
                                    <a href="{{ route('master.service.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Services') }}</span>
                                    </a>
                                    <a href="{{ route('master.supplier.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Suppliers') }}</span>
                                    </a>
                                    <a href="{{ route('master.item.index') }}" class="kt-menu__link">
                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                        <span class="kt-menu__link-text">{{ __('Items') }}</span>
                                    </a> --}}
                                </li>
                            </ul>
                        </div>
                    </li>
                @endpermission
            </ul>
        </div>
    </div>
</div>
