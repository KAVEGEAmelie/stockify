<nav class="sidebar d-flex flex-column flex-shrink-0">
    <!-- En-tête fixe -->
    <div class="sidebar-header-fixed p-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('dashboard') }}" class="sidebar-brand d-flex align-items-center text-white text-decoration-none">
                <i class="bi bi-box-seam-fill me-2" style="font-size: 1.5rem;"></i>
                <span class="fs-4">Stockify</span>
            </a>
            <button class="btn btn-outline-light btn-sm d-md-none" type="button" id="sidebar-toggle">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <hr class="my-3">
    </div>

    <!-- Contenu défilable -->
    <div class="sidebar-content flex-grow-1 px-3">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="page">
                    <i class="bi bi-grid-1x2-fill me-2"></i> Tableau de Bord
                </a>
            </li>

            <li class="sidebar-header mt-3">Gestion du Stock</li>
            <li>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="bi bi-box me-2"></i> Articles
                </a>
            </li>
            <li>
                <a href="{{ route('stock-movements.index') }}" class="nav-link {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history me-2"></i> Mouvements
                </a>
            </li>
            <li>
                <a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check me-2"></i> Inventaire
                </a>
            </li>

            <li class="sidebar-header mt-3">Organisation</li>
            <li>
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags me-2"></i> Catégories
                </a>
            </li>
            <li>
                <a href="{{ route('locations.index') }}" class="nav-link {{ request()->routeIs('locations.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill me-2"></i> Emplacements
                </a>
            </li>
            <li>
                <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <i class="bi bi-truck me-2"></i> Fournisseurs
                </a>
            </li>
            <li>
                <a href="{{ route('tags.index') }}" class="nav-link {{ request()->routeIs('tags.*') ? 'active' : '' }}">
                    <i class="bi bi-bookmark-fill me-2"></i> Tags
                </a>
            </li>

            <li class="sidebar-header mt-3">Configuration</li>
            <li>
                <a href="{{ route('custom-fields.index') }}" class="nav-link {{ request()->routeIs('custom-fields.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders me-2"></i> Champs Personnalisés
                </a>
            </li>

            <li class="sidebar-header mt-3">Analyse</li>
            <li>
                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill me-2"></i> Rapports
                </a>
            </li>

            <!-- Espacement pour éviter que le dernier élément soit caché -->
            <li style="height: 40px;"></li>
        </ul>
    </div>

    <!-- Pied de page fixe -->
    <div class="sidebar-footer-fixed p-3">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://via.placeholder.com/32" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>Utilisateur</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i> Profil</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-sliders me-2"></i> Paramètres</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></li>
            </ul>
        </div>
    </div>
</nav>
