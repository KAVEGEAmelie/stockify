@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="bi bi-speedometer2 me-2"></i>Tableau de Bord
            <small class="text-muted">- {{ date('d/m/Y') }}</small>
        </h1>
    </div>
</div>

<!-- Statistiques principales -->
<div class="row mb-4">
    <!-- Total Produits -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="fw-bold">{{ number_format($totalProducts) }}</h4>
                        <p class="mb-0">Articles</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box-seam display-6 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary bg-opacity-75">
                <a href="{{ route('products.index') }}" class="text-white text-decoration-none">
                    <small>Voir tous les produits <i class="bi bi-arrow-right"></i></small>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Catégories -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="fw-bold">{{ $totalCategories }}</h4>
                        <p class="mb-0">Catégories</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-tags display-6 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success bg-opacity-75">
                <a href="{{ route('categories.index') }}" class="text-white text-decoration-none">
                    <small>Gérer les catégories <i class="bi bi-arrow-right"></i></small>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Fournisseurs -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="fw-bold">{{ $totalSuppliers }}</h4>
                        <p class="mb-0">Fournisseurs</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-truck display-6 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info bg-opacity-75">
                <a href="{{ route('suppliers.index') }}" class="text-white text-decoration-none">
                    <small>Voir les fournisseurs <i class="bi bi-arrow-right"></i></small>
                </a>
            </div>
        </div>
    </div>

    <!-- Produits en Alerte -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="fw-bold">{{ $lowStockProducts }}</h4>
                        <p class="mb-0">Articles en Alerte</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle display-6 opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-warning bg-opacity-75">
                <a href="{{ route('reports.low-stock') }}" class="text-white text-decoration-none">
                    <small>Voir les alertes <i class="bi bi-arrow-right"></i></small>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques secondaires -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body text-center">
                <h3 class="text-danger">{{ $criticalStockCount }}</h3>
                <p class="mb-0">Produits Épuisés</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <h3 class="text-success">{{ number_format($totalStockValue, 0, ',', ' ') }} CFA</h3>
                <p class="mb-0">Valeur Totale du Stock</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-body text-center">
                <h3 class="text-info">{{ $totalLocations }}</h3>
                <p class="mb-0">Emplacements</p>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Actions Rapides</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($quickActions as $action)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="d-grid">
                            <a href="{{ $action['url'] }}" class="btn btn-outline-{{ $action['color'] }} btn-lg">
                                <i class="{{ $action['icon'] }} me-2"></i>{{ $action['title'] }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Mouvements récents -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Mouvements Récents</h5>
                <a href="{{ route('stock-movements.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body">
                @if($recentMovements->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Article</th>
                                    <th>Type</th>
                                    <th>Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMovements as $movement)
                                <tr>
                                    <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $movement->product->name ?? 'N/A' }}</strong>
                                        <br><small class="text-muted">{{ $movement->product->sku ?? '' }}</small>
                                    </td>
                                    <td>
                                        @if($movement->direction === 'in')
                                            <span class="badge bg-success">Entrée</span>
                                        @else
                                            <span class="badge bg-danger">Sortie</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold {{ $movement->direction === 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $movement->direction === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-clock-history display-4 d-block mb-2"></i>
                        Aucun mouvement récent.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top produits valorisés -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-trophy me-2"></i>Top Produits Valorisés</h5>
            </div>
            <div class="card-body">
                @if($topValuedProducts->count() > 0)
                    @foreach($topValuedProducts as $index => $product)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                            <strong>{{ Str::limit($product->name, 20) }}</strong>
                            <br><small class="text-muted">{{ $product->sku }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">{{ number_format($product->total_value, 0, ',', ' ') }} CFA</div>
                            <small class="text-muted">{{ $product->stock_quantity }} unités</small>
                        </div>
                    </div>
                    @if(!$loop->last)<hr>@endif
                    @endforeach
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-box display-4 d-block mb-2"></i>
                        Aucun produit valorisé.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
