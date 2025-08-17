<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container-fluid">
        <button class="btn text-light" type="button" id="sidebar-toggle">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="ms-3 d-none d-md-block">
            <form class="d-flex">
                <div class="input-group">
                    <input class="form-control bg-dark text-light border-secondary" type="search" placeholder="Rechercher..." aria-label="Search">
                </div>
            </form>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown me-2">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-circle-fill me-1"></i> Ajouter
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('products.create') }}">Nouvel Article</a></li>
                    <li><a class="dropdown-item" href="#">Nouvelle Entrée</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
