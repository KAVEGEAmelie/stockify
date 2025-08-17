@extends('layouts.app')
@section('title', 'Historique des Mouvements')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">
                <i class="bi bi-clock-history me-2"></i>Historique des Mouvements
            </h1>
            <p class="text-muted mb-0">Suivi de tous les mouvements de stock</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-box me-2"></i>Voir les Articles
            </a>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-plus-circle me-2"></i>Nouveau Mouvement
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Type de mouvement</h6></li>
                    <li><a class="dropdown-item" href="#" onclick="showProductSelector('in')">
                        <i class="bi bi-arrow-down-circle text-success me-2"></i>Entrée de Stock
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="showProductSelector('out')">
                        <i class="bi bi-arrow-up-circle text-danger me-2"></i>Sortie de Stock
                    </a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <select class="form-select" id="filterType">
                        <option value="">Tous les types</option>
                        <option value="in">Entrées uniquement</option>
                        <option value="out">Sorties uniquement</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filterDate" placeholder="Date">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="filterProduct" placeholder="Rechercher un article...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-success border-opacity-25">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-success mb-1">{{ $stats['entriesCount'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">Entrées</p>
                        </div>
                        <i class="bi bi-arrow-down-circle fs-1 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger border-opacity-25">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-danger mb-1">{{ $stats['exitsCount'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">Sorties</p>
                        </div>
                        <i class="bi bi-arrow-up-circle fs-1 text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info border-opacity-25">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-info mb-1">{{ $stats['totalQuantity'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">Unités déplacées</p>
                        </div>
                        <i class="bi bi-boxes fs-1 text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning border-opacity-25">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-warning mb-1">{{ $stats['todayMovements'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">Aujourd'hui</p>
                        </div>
                        <i class="bi bi-calendar-day fs-1 text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-list-ul me-2 text-primary"></i>Tous les Mouvements
            </h5>
            <span class="badge bg-primary">{{ $movements->total() ?? count($movements) }} mouvements</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                                        <table class="table table-hover table-responsive-lg">
                            <thead class="table-dark">
                                <tr>
                                    <th style="color: var(--text-primary); font-weight: 600;">Date & Heure</th>
                                    <th style="color: var(--text-primary); font-weight: 600;">Article</th>
                                    <th style="color: var(--text-primary); font-weight: 600;">Type</th>
                                    <th style="color: var(--text-primary); font-weight: 600;">Quantité</th>
                                    <th style="color: var(--text-primary); font-weight: 600;">Stock Avant</th>
                                    <th style="color: var(--text-primary); font-weight: 600;">Stock Après</th>
                                    <th style="color: var(--text-primary); font-weight: 600;">Utilisateur</th>
                                    <th style="color: var(--text-primary); font-weight: 600;">Actions</th>
                                </tr>
                            </thead>
                    <tbody>
                        @forelse ($movements as $movement)
                            <tr class="align-middle">
                                <td>
                                    <div>
                                        <strong>{{ $movement->movement_date->format('d/m/Y') }}</strong>
                                        <br><small class="text-muted">{{ $movement->movement_date->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded me-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-primary">{{ $movement->product->name ?? 'N/A' }}</h6>
                                            <small class="text-muted">SKU: {{ $movement->product->sku ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($movement->type === 'in')
                                        <span class="badge bg-success">
                                            <i class="bi bi-arrow-down me-1"></i>Entrée
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-arrow-up me-1"></i>Sortie
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold fs-5 {{ $movement->type === 'in' ? 'text-success' : 'text-danger' }}">
                                        {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $movement->previous_stock }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $movement->new_stock }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                        <span>{{ $movement->user->name ?? 'Système' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($movement->notes)
                                        <button class="btn btn-outline-info btn-sm" 
                                                data-bs-toggle="tooltip" 
                                                title="{{ $movement->notes }}">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('stock-movements.show', $movement) }}" 
                                       class="btn btn-outline-success btn-sm"
                                       title="Voir les détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('products.show', $movement->product) }}" 
                                       class="btn btn-outline-primary btn-sm"
                                       title="Voir l'article">
                                        <i class="bi bi-box"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-clock-history display-1 d-block mb-3"></i>
                                        <h5>Aucun mouvement trouvé</h5>
                                        <p>Les mouvements de stock apparaîtront ici.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($movements->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    {{ $movements->links('vendor.pagination.dark-theme') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal pour sélectionner un produit -->
<div class="modal fade" id="productSelectorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-search me-2"></i>Sélectionner un Article
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="productSearch" placeholder="Rechercher par nom ou SKU...">
                </div>
                <div id="productsList" class="list-group">
                    <!-- Les produits seront chargés ici -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm { width: 40px; height: 40px; }
.avatar-xs { width: 24px; height: 24px; font-size: 0.75rem; }
.border-opacity-25 { border-opacity: 0.25 !important; }
</style>

<script>
let selectedMovementType = '';

function showProductSelector(type) {
    selectedMovementType = type;
    const modal = new bootstrap.Modal(document.getElementById('productSelectorModal'));
    loadProducts();
    modal.show();
}

function loadProducts() {
    // Simuler le chargement des produits
    const productsList = document.getElementById('productsList');
    productsList.innerHTML = '<div class="text-center p-3"><div class="spinner-border" role="status"></div></div>';
    
    // En production, ceci ferait un appel AJAX pour charger les produits
    fetch('/api/products/search')
        .then(response => response.json())
        .then(products => {
            displayProducts(products);
        })
        .catch(() => {
            productsList.innerHTML = '<div class="text-center text-muted p-3">Erreur lors du chargement</div>';
        });
}

function displayProducts(products) {
    const productsList = document.getElementById('productsList');
    if (products.length === 0) {
        productsList.innerHTML = '<div class="text-center text-muted p-3">Aucun produit trouvé</div>';
        return;
    }
    
    productsList.innerHTML = products.map(product => `
        <a href="/stock-movements/create?product_id=${product.id}&type=${selectedMovementType}" 
           class="list-group-item list-group-item-action">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">${product.name}</h6>
                    <small class="text-muted">SKU: ${product.sku} | Stock: ${product.stock_quantity}</small>
                </div>
                <span class="badge ${product.stock_quantity > 0 ? 'bg-success' : 'bg-danger'}">
                    ${product.stock_quantity}
                </span>
            </div>
        </a>
    `).join('');
}

function resetFilters() {
    document.getElementById('filterType').value = '';
    document.getElementById('filterDate').value = '';
    document.getElementById('filterProduct').value = '';
}

// Initialiser les tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
