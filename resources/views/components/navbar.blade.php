<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://www.stas-rg.com">
                <img src="{{ asset('assets/img/landingpages/stas.png') }}" alt="STAS-RG Logo" width="100" class="rounded-circle">
            </a>

            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown me-4">
                    <a class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownLanguage" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/img/bendera/' . (app()->getLocale() == 'id' ? 'indonesia bendera bulat.png' : 'inggris bendera bulat.png')) }}" alt="{{ app()->getLocale() == 'id' ? 'Bahasa Indonesia' : 'English' }}" width="30" class="rounded-circle transition-transform" style="transition: transform 0.3s ease;">
                        <span class="ms-2 fw-bold">{{ app()->getLocale() == 'id' ? 'Bahasa Indonesia' : 'English' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownLanguage" style="min-width: 200px;">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url()->current() }}?lang=id">
                                <img src="{{ asset('assets/img/bendera/indonesia bendera bulat.png') }}" alt="Bahasa Indonesia" width="25" class="rounded-circle me-2 transition-transform" style="transition: transform 0.3s ease;">
                                <span class="transition-transform" style="transition: transform 0.3s ease;">Bahasa Indonesia</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url()->current() }}?lang=en">
                                <img src="{{ asset('assets/img/bendera/inggris bendera bulat.png') }}" alt="English" width="25" class="rounded-circle me-2 transition-transform" style="transition: transform 0.3s ease;">
                                <span class="transition-transform" style="transition: transform 0.3s ease;">English</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <style>
                    /* Dropdown item hover effects */
                    .dropdown-item:hover img {
                        transform: scale(1.2); /* Membesarkan ikon bendera saat hover */
                    }

                    .dropdown-item:hover span {
                        transform: translateX(5px); /* Geser teks sedikit ke kanan saat hover */
                    }

                    /* Dropdown menu styling */
                    .dropdown-menu {
                        border-radius: 10px; /* Membuat sudut dropdown lebih melengkung */
                        padding: 10px; /* Memberikan ruang di dalam dropdown */
                        min-width: 200px; /* Memperlebar dropdown */
                    }

                    .dropdown-item {
                        padding: 10px 15px; /* Memberikan ruang lebih besar untuk item dropdown */
                        border-radius: 5px; /* Membuat sudut item dropdown lebih melengkung */
                        transition: background-color 0.3s ease, transform 0.3s ease; /* Transisi untuk hover */
                    }

                    .dropdown-item:hover {
                        background-color: #f8f9fa; /* Warna latar belakang saat hover */
                        transform: scale(1.05); /* Sedikit memperbesar item saat hover */
                    }

                    /* Transition for the main dropdown toggle */
                    #dropdownLanguage img {
                        transition: transform 0.3s ease;
                    }

                    #dropdownLanguage:hover img {
                        transform: rotate(10deg); /* Sedikit memutar ikon bendera saat hover */
                    }
                </style>

                <div class="dropdown me-4">
                    <a class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2" style="font-size: 32px;"></i>
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="{{ route('needhelp') }}">Need Help</a></li>
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
