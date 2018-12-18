<nav class="navbar custom-header" role="navigation" aria-label="main navigation" id="navigation"  style="z-index: 9999;">
    <div class="navbar-brand">
        <button class="button toggle-button mobile-drawer-trigger" id="toggle-drawer-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div id="navMenu" class="navbar-menu" style="border-bottom: solid 1px #ccc;">
        <div class="navbar-start">
            <a class="navbar-item {{ $menuName=='config' ? 'is-active' : null }}" href="{{ url('/home') }}">
                <i class="fas fa-cogs"></i>&nbsp;{{ trans('admin.menu.setting') }}
            </a>
            <a class="navbar-item {{ $menuName=='menus' ? 'is-active' : null }}" href="{{ url('/backend/menus/index') }}">
                <i class="fas fa-compass"></i>&nbsp;{{ trans('admin.menu.menus') }}
            </a>
            @if(env('activate_ecommerce',false))
                <a class="navbar-item {{ $menuName=='categories' ? 'is-active' : null }}" href="{{ url('/backend/categories') }}">
                    <i class="fab fa-bitbucket"></i>&nbsp;{{ trans('admin.menu.categories') }}
                </a>
                <a class="navbar-item {{ $menuName=='brands' ? 'is-active' : null }}" href="{{ url('/backend/brands') }}">
                    <i class="fas fa-building"></i>&nbsp;{{ trans('admin.menu.brands') }}
                </a>
                <a class="navbar-item {{ $menuName=='catalog' ? 'is-active' : null }}" href="{{ url('/backend/products') }}">
                    <i class="fab fa-product-hunt"></i>&nbsp;{{ trans('admin.menu.products') }}
                </a>
                <a class="navbar-item {{ $menuName=='attribute_sets' ? 'is-active' : null }}" href="{{ url('/backend/attribute-sets') }}">
                    <i class="fas fa-book"></i>&nbsp;{{ trans('admin.menu.attribute_sets') }}
                </a>
                <a class="navbar-item {{ $menuName=='intakes' ? 'is-active' : null }}" href="{{ url('/backend/intakes/index') }}">
                    <i class="fas fa-bullhorn"></i>&nbsp;{{ trans('admin.menu.intakes') }}
                </a>
                <a class="navbar-item {{ $menuName=='orders' ? 'is-active' : null }}" href="{{ url('/backend/orders') }}">
                    <i class="fas fa-chart-line"></i>&nbsp;{{ trans('admin.menu.orders') }}
                </a>
                <a class="navbar-item {{ $menuName=='voucher' ? 'is-active' : null }}" href="{{ route('admin.voucher.mgr') }}">
                    <i class="fas fa-ticket-alt"></i>&nbsp;{{ trans('admin.menu.voucher') }}
                </a>
            @endif
        </div>
        <div class="navbar-end">
            <a class="navbar-item has-text-link" href="{{ url('/') }}" target="_blank">
                <i class="fa fa-arrow-right"></i>&nbsp;Website Preview
            </a>
        </div>
    </div>
</nav>