<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="d-block b-brand w-100">
                <img src="{{ asset('assets/images/logo_infi.png') }}" alt="" class="logo logo-lg w-100" />
                <img src="{{ asset('assets/images/logo_infi.png') }}" alt="" class="logo logo-sm w-100" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>
                <li class="nxl-item nxl-hasmenu {{ $sidebar == 'dashboard' ? 'active nxl-trigger' : '' }} ">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-gauge"></i></span>
                        <span class="nxl-mtext">Bảng điều khiển</span><span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu {{ $sidebar == 'dashboard' ? '' : 'style="display: none;"' }}">
                        <li class="nxl-item {{ $sidebar == 'dashboard' ? 'active' : '' }}"><a class="nxl-link" href="{{ route('admin.dashboard') }}">Home</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu {{ $sidebar != 'dashboard' ? 'active nxl-trigger' : '' }}">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-layer-group"></i></span>
                        <span class="nxl-mtext">Danh mục</span><span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu" {{ $sidebar != 'dashboard' ? '' : 'style="display: none;"' }} >
                        @can('typecar_list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('type-cars') }}">Hãng xe</a></li>
                        @endcan
                        @can('car_list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('cars') }}">Xe</a></li>
                        @endcan
                        @can('licenseplate_list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('license-plates') }}">Biển số</a></li>
                        @endcan
                        @can('user_list')
                        <li class="nxl-item"><a class="nxl-link" href="{{ route('admin-users') }}">Người dùng</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
