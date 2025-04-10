
<style>
    .sidebar a {
        transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        border-radius: 0.375rem; /* Rounded untuk tautan */
    }

    .sidebar a:hover {
        transform: translateX(10px);
        background-color: #e9ecef; /* Warna latar belakang lebih gelap */
        color: #212529; /* Warna teks lebih kontras */
        border-radius: 0.375rem; /* Rounded untuk tautan */
    }

    .sidebar a.active {
        border-left: 4px solid #0ab600; /* Indikator visual untuk tautan aktif */
        font-weight: bold; /* Teks lebih tebal */
        color: #0ab600; /* Warna teks untuk tautan aktif */
        border-radius: 0.375rem; /* Rounded untuk tautan aktif */
    }
</style>

<aside class="sidebar rounded-3" id="sidebar" role="navigation">
    <a href="{{ route('dashboard') }}" class="d-flex align-items-center py-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="{{ request()->routeIs('dashboard') ? 'page' : '' }}">
        <i class="fas fa-home ms-2 me-3" title="{{ __('messages.menu_dashboard') }}"></i>
        <span>{{ __('messages.menu_dashboard') }}</span>
    </a>
    <a href="{{ route('board.index') }}" class="d-flex align-items-center py-2 {{ request()->routeIs('board.index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('board.index') ? 'page' : '' }}">
        <i class="fas fa-clipboard-list ms-2 me-3" title="{{ __('menu_board') }}"></i>
        <span>{{ __('messages.menu_board') }}</span>
    </a>
    <a href="{{ route('personnels.index') }}" class="d-flex align-items-center py-2 {{ request()->is('personnels*') ? 'active' : '' }}" aria-current="{{ request()->is('personnels*') ? 'page' : '' }}">
        <i class="fas fa-id-card ms-2 me-3" title="{{ __('messages.menu_personnels') }}"></i>
        <span>{{ __('messages.menu_personnels') }}</span>
    </a>
    <a href="{{ route('weapons.index') }}" class="d-flex align-items-center py-2 {{ request()->routeIs('weapons.index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('weapons.index') ? 'page' : '' }}">
        <i class="fas fa-gun ms-2 me-3" title="{{ __('messages.menu_weapons') }}"></i>
        <span>{{ __('messages.menu_weapons') }}</span>
    </a>
    <a href="{{ route('admin.index') }}" class="d-flex align-items-center py-2 {{ request()->routeIs('admin.*') ? 'active' : '' }}" aria-current="{{ request()->routeIs('admin.*') ? 'page' : '' }}">
        <i class="fas fa-user-secret ms-2 me-3" title="{{ __('messagesmenu_admin') }}"></i>
        <span>{{ __('messages.menu_admin') }}</span>
    </a>
</aside>
