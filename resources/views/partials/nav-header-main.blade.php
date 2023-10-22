<nav class="navbar navbar-expand-lg">
    <div class="container">
        <div class="col-md-2">
            <h2>CRUD Cartelera</h2>
        </div>
        <div class="col-md-8 col-search d-flex justify-content-end">
            @include('partials.search')
        </div>
        <div class="col-md-2 text-end">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item message">
                        <a class="nav-link" aria-current="page" href="#">
                            Bienvenid@</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false"><i class="fas fa-user"></i></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar
                                    sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
