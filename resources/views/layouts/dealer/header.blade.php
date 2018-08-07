<nav class="navbar custom-header" role="navigation" aria-label="main navigation" id="navigation"  style="z-index: 9999;">
    <div class="navbar-brand">
        <button class="button toggle-button mobile-drawer-trigger" id="toggle-drawer-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div id="navMenu" class="navbar-menu" style="border-bottom: solid 1px #ccc;">
        <div class="navbar-start">
            <a class="navbar-item {{ $menuName=='courses' ? 'is-active' : null }}" href="{{ route('group.portal') }}">
                <i class="fas fa-cogs"></i>&nbsp;Courses
            </a>
            <a class="navbar-item {{ $menuName=='students' ? 'is-active' : null }}" href="{{ route('group.students') }}">
                <i class="fas fa-user"></i>&nbsp;Students
            </a>
            <a class="navbar-item {{ $menuName=='orders' ? 'is-active' : null }}" href="{{ route('group.orders') }}">
                <i class="far fa-list-alt"></i>&nbsp;Orders
            </a>
            <a class="navbar-item {{ $menuName=='payments' ? 'is-active' : null }}" href="{{ route('group.payments') }}">
                <i class="fas fa-money-bill-alt"></i>&nbsp;Payments
            </a>
        </div>
        <div class="navbar-end">
            <a class="navbar-item has-text-link" href="{{ url('/') }}" target="_blank">
                <i class="fa fa-arrow-right"></i>&nbsp;SIIT Preview
            </a>
        </div>
    </div>
</nav>