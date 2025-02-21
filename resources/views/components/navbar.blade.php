<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://www.stas-rg.com">
                <img src="{{ asset('assets/img/landingpages/stas.png') }}" alt="STAS-RG Logo" width="100" class="rounded-circle">
            </a>

            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown me-4">
                    <a class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownLanguage" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/indonesia.png" alt="Bendera Indonesia" width="20" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownLanguage">
                        <li><a class="dropdown-item" href="#"><span class="flag-icon flag-icon-id"></span> Bahasa Indonesia</a></li>
                        <li><a class="dropdown-item" href="#"><span class="flag-icon flag-icon-us"></span> English</a></li>
                    </ul>
                </div>
                <div class="dropdown me-4">
                    <a class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2" style="font-size: 32px;"></i>
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">Need Help</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Sign out</a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
