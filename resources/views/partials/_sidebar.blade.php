<nav class="sidebar d-flex flex-column flex-shrink-0 p-3">
    <a href="{{ route('dashboard') }}" class="sidebar-brand d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-box-seam-fill me-2" style="font-size: 1.5rem;"></i>
        <span class="fs-4">Stockify</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
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
            <a href="#" class="nav-link"><i class="bi bi-clock-history me-2"></i> Mouvements</a>
        </li>
        <li>
            <a href="#" class="nav-link"><i class="bi bi-clipboard-check me-2"></i> Inventaire</a>
        </li>

        <li class="sidebar-header mt-3">Organisation</li>
        <li>
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags me-2"></i> Catégories
            </a>
        </li>
        <li>
            <a href="#" class="nav-link"><i class="bi bi-geo-alt-fill me-2"></i> Emplacements</a>
        </li>
        <li>
            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <i class="bi bi-truck me-2"></i> Fournisseurs
            </a>
        </li>

        <li class="sidebar-header mt-3">Analyse</li>
        <li>
            <a href="#" class="nav-link"><i class="bi bi-file-earmark-bar-graph-fill me-2"></i> Rapports</a>
        </li>
    </ul>
</nav>
