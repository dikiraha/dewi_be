<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('website.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <span style="color: var(--bs-primary)">
                    <?xml version="1.0" encoding="utf-8"?>
                    <svg viewBox="0 0 159.41 159.41" xmlns="http://www.w3.org/2000/svg" xmlns:bx="https://boxy-svg.com">
                        <defs>
                            <radialGradient gradientUnits="userSpaceOnUse" cx="86.024" cy="65.421" r="45.997"
                                id="gradient-0"
                                gradientTransform="matrix(1.174419, 0, 0, 1.174419, -12.599426, -10.357308)">
                                <stop offset="0" style="stop-color: rgb(56.471% 33.333% 99.216%)" />
                                <stop offset="1" style="stop-color: rgb(32.907% 12.624% 76.34%)" />
                            </radialGradient>
                            <style bx:fonts="Agbalumo">
                                @import url('{{ asset('fonts/agbalumo/fonts.css') }}');
                            </style>
                        </defs>
                        <text
                            style="fill: url('#gradient-0'); font-family: Agbalumo; font-size: 143.7px; font-style: italic; white-space: pre;"
                            x="34.409" y="132.453"
                            transform="matrix(1, 0, 0, 1, 7.105427357601002e-15, 7.105427357601002e-15)">D</text>
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">DEWI</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ Route::is('website.home') ? 'active' : '' }}">
            <a href="{{ route('website.home') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div data-i18n="Basic">Dashboard</div>
            </a>
        </li>
        <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li>
        <!-- Apps -->
        <!-- Pages -->
        {{-- Purchase Requisition --}}
        @php
            $folderRoutes = ['website.folder.list', 'website.folder.create', 'website.folder.edit'];
            $subfolderRoutes = ['website.subfolder.list', 'website.subfolder.create', 'website.subfolder.edit'];
        @endphp
        <li
            class="menu-item {{ in_array(Route::currentRouteName(), $folderRoutes) || in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-file-sign"></i>
                <div data-i18n="Purchase Requisition">Purchase Requisition</div>
                &nbsp&nbsp<span class="badge bg-danger rounded-pill" id="ticket_count">1</span>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ in_array(Route::currentRouteName(), $folderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Create PR">Create PR</div>
                    </a>
                </li>
                <li class="menu-item {{ in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="List PR">List PR</div>
                    </a>
                </li>
                <li class="menu-item {{ in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="PR Approval">PR Approval</div>
                        &nbsp&nbsp<span class="badge bg-danger rounded-pill" id="ticket_count">1</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- RFQ Management --}}
        <li class="menu-item {{ Route::is('website.user.lista') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-file-document-edit-outline"></i>
                <div data-i18n="RFQ Management">RFQ Management</div>
            </a>
        </li>
        {{-- Quotation --}}
        <li
            class="menu-item {{ in_array(Route::currentRouteName(), $folderRoutes) || in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-file-document-outline"></i>
                <div data-i18n="Quotation">Quotation</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ in_array(Route::currentRouteName(), $folderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Vendor Quotations">Vendor Quotations</div>
                    </a>
                </li>
                <li class="menu-item {{ in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Compare Quotations">Compare Quotations</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Purchase Orders --}}
        <li class="menu-item {{ Route::is('website.user.lista') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-cart"></i>
                <div data-i18n="Purchase Orders">Purchase Orders</div>
            </a>
        </li>
        {{-- Goods Receipt --}}
        <li class="menu-item {{ Route::is('website.user.lista') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-receipt-text"></i>
                <div data-i18n="Goods Receipt">Goods Receipt</div>
            </a>
        </li>
        {{-- Report --}}
        <li
            class="menu-item {{ in_array(Route::currentRouteName(), $folderRoutes) || in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-speedometer"></i>
                <div data-i18n="Reports">Reports</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ in_array(Route::currentRouteName(), $folderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="PR History">PR History</div>
                    </a>
                </li>
                <li class="menu-item {{ in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="PO History">PO History</div>
                    </a>
                </li>
                <li class="menu-item {{ in_array(Route::currentRouteName(), $subfolderRoutes) ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Vendor Performance">Vendor Performance</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Master -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text">Master</span></li>
        @php
            $departmentRoutes = ['website.department.list', 'website.department.create', 'website.department.edit'];
        @endphp
        <li class="menu-item {{ in_array(Route::currentRouteName(), $departmentRoutes) ? 'active' : '' }}">
            <a href="{{ route('website.department.list') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-office-building"></i>
                <div data-i18n="Departments">Departments</div>
            </a>
        </li>

        @php
            $roleRoutes = ['website.role.list', 'website.role.create', 'website.role.edit'];
        @endphp
        <li class="menu-item {{ in_array(Route::currentRouteName(), $roleRoutes) ? 'active' : '' }}">
            <a href="{{ route('website.role.list') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-account-cog"></i>
                <div data-i18n="Roles">Roles</div>
            </a>
        </li>

        <li class="menu-item {{ Route::is('website.setting.list') ? 'active' : '' }}">
            <a href="{{ route('website.setting.list') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-cog"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
        </li>

        @php
            $userRoutes = ['website.user.list', 'website.user.create', 'website.user.edit'];
        @endphp
        <li class="menu-item {{ in_array(Route::currentRouteName(), $userRoutes) ? 'active' : '' }}">
            <a href="{{ route('website.user.list') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-account-multiple"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>

        @php
            $vendorRoutes = ['website.vendor.list', 'website.vendor.create', 'website.vendor.edit'];
        @endphp
        <li class="menu-item {{ in_array(Route::currentRouteName(), $vendorRoutes) ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-town-hall"></i>
                <div data-i18n="Vendors">Vendors</div>
            </a>
        </li>
    </ul>
</aside>
