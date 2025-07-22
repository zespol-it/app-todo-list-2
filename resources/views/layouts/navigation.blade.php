<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success" href="{{ route('dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zm-1 1H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
                <path d="M10.97 5.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L5.324 9.384a.75.75 0 1 1 1.06-1.06l1.094 1.093 3.492-4.438z"/>
            </svg>
            To-Do App
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('tasks.*') ? ' active' : '' }}" href="{{ route('tasks.index') }}">Zadania</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('shared-tasks.index') ? ' active' : '' }}" href="{{ route('shared-tasks.index') }}">Udostępnione</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Wyloguj</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Zaloguj się</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Zarejestruj się</a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
