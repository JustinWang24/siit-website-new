<nav id="menu" class="menu slideout-menu slideout-menu-left">
    <section class="menu-section">
        <h3 class="menu-section-title">Users</h3>
        <ul class="menu-section-list">
            <li>
                <a class="{{ $menuName=='update-password' ? 'is-active' : null }}" href="{{ url('/backend/update-password') }}">
                    <i class="fa fa-key"></i>Update My Password
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out-alt"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('group.logout') }}" method="POST" style="display: none;">
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