<nav id="menu" class="menu slideout-menu slideout-menu-left">
    <section class="menu-section">
        <h3 class="menu-section-title">Content</h3>
        <ul class="menu-section-list">
            <li>
                <a class="{{ $menuName=='pages' ? 'is-active' : null }}" href="{{ url('/backend/pages/index') }}">
                    <i class="fas fa-paperclip"></i>&nbsp{{ trans('admin.menu.pages') }}
                </a>
            </li>
            <li><a class="{{ $menuName=='blog' ? 'is-active' : null }}" href="{{ url('/backend/blog/index') }}">
                    <i class="fab fa-blogger"></i>&nbsp{{ trans('admin.menu.blog') }}
                </a>
            </li>
            <li>
                <a class="{{ $menuName=='news' ? 'is-active' : null }}" href="{{ url('/backend/news/index') }}">
                    <i class="far fa-newspaper"></i>{{ trans('admin.menu.news') }}
                </a>
            </li>
            <li>
                <a class="{{ $menuName=='events' ? 'is-active' : null }}" href="{{ url('/backend/events/index') }}">
                    <i class="fas fa-calendar-alt"></i>Events
                </a>
            </li>
        </ul>
    </section>

    <section class="menu-section">
        <h3 class="menu-section-title">Widgets</h3>
        <ul class="menu-section-list">
            <li><a class="{{ $menuName=='blocks' ? 'is-active' : null }}" href="{{ url('/backend/widgets/blocks') }}"><i class="fas fa-columns"></i>Blocks</a></li>
            <li><a class="{{ $menuName=='sliders' ? 'is-active' : null }}" href="{{ url('/backend/widgets/sliders') }}"><i class="fab fa-slideshare"></i>Sliders</a></li>
            <li><a class="{{ $menuName=='galleries' ? 'is-active' : null }}" href="{{ url('/backend/widgets/galleries') }}"><i class="fas fa-film"></i>Galleries</a></li>
            <li><a class="{{ $menuName=='leads' ? 'is-active' : null }}" href="{{ url('/backend/leads') }}"><i class="fab fa-wpforms"></i>Leads</a></li>
        </ul>
    </section>

    <section class="menu-section">
        <h3 class="menu-section-title">Extensions</h3>
        <ul class="menu-section-list">
            @if(env('activate_wechat', false))
                <li>
                    <a class="{{ $menuName=='blocks' ? 'is-active' : null }}" href="{{ url('/backend/widgets/blocks') }}">
                        <i class="fab fa-weixin"></i>WeChat 微信公众号
                    </a>
                </li>
            @endif
            @if(env('support_multiple_groups', false))
                <li>
                    <a class="{{ $menuName=='groups' ? 'is-active' : null }}" href="{{ url('/backend/groups') }}">
                        <i class="fas fa-shopping-basket"></i>合作经销商管理
                    </a>
                </li>
            @endif
            @if(env('activate_shipment_manager', false))
                <li>
                    <a class="{{ $menuName=='shipment' ? 'is-active' : null }}" href="{{ url('/backend/shipment') }}">
                        <i class="fas fa-truck"></i>运费管理
                    </a>
                </li>
            @endif
        </ul>
    </section>

    <section class="menu-section">
        <h3 class="menu-section-title">Users</h3>
        <ul class="menu-section-list">
            @if(env('activate_ecommerce', false))
            <li>
                <a class="{{ $menuName=='customers' ? 'is-active' : null }}" href="{{ url('/backend/customers') }}">
                    <i class="fa fa-user"></i>Students Account
                </a>
            </li>
            <li>
                <a class="{{ $menuName=='users' ? 'is-active' : null }}" href="{{ url('/backend/system-users') }}">
                    <i class="far fa-address-card"></i>System Accounts
                </a>
            </li>
            @endif
            <li>
                <a class="{{ $menuName=='staff' ? 'is-active' : null }}" href="{{ url('/backend/staff/index') }}">
                    <i class="fas fa-user-circle"></i>&nbsp;Staff Manager
                </a>
            </li>
            <li>
                <a class="{{ $menuName=='update-password' ? 'is-active' : null }}" href="{{ url('/backend/update-password') }}">
                    <i class="fa fa-key"></i>Update My Password
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out-alt"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            <li>
                <a href="{{ url('/show-user-guide') }}" target="_blank">
                    <i class="fa fa-book"></i>User Guide
                </a>
            </li>
        </ul>
    </section>
</nav>