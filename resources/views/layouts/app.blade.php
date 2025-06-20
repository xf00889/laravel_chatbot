<nav class="navbar navbar-expand-lg navbar-light bg-light">
    ...
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            ...
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
        </ul>
    </div>
</nav> 