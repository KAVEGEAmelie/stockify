@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tableau de Bord</h1>
        <div class="text-muted">
            <i class="bi bi-calendar3 me-1"></i>
            {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Articles</h6>
                            <h2 class="mb-0">{{ $totalProducts ?? 0 }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-box fs-1 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 mb-1">En Stock</h6>
                            <h2 class="mb-0">{{ $totalInStock ?? 0 }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-check-circle fs-1 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 mb-1">Stock Faible</h6>
                            <h2 class="mb-0">{{ $lowStockCount ?? 0 }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-exclamation-triangle fs-1 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 mb-1">Catégories</h6>
                            <h2 class="mb-0">{{ $totalCategories ?? 0 }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-tags fs-1 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et informations -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Mouvements de Stock Récents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Article</th>
                                    <th>Type</th>
                                    <th>Quantité</th>
                                    <th>Motif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMovements ?? [] as $movement)
                                <tr>
                                    <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $movement->product->name }}</td>
                                    <td>
                                        @if($movement->type === 'in')
                                            <span class="badge bg-success">Entrée</span>
                                        @else
                                            <span class="badge bg-danger">Sortie</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->quantity }}</td>
                                    <td>{{ $movement->reason }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Aucun mouvement récent</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Alertes Stock</h5>
                </div>
                <div class="card-body">
                    @forelse($lowStockProducts ?? [] as $product)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="bi bi-exclamation-circle text-warning fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $product->name }}</h6>
                            <small class="text-muted">Stock: {{ $product->quantity }} (Min: {{ $product->minimum_stock }})</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted">
                        <i class="bi bi-check-circle text-success fs-1 mb-3"></i>
                        <p>Aucune alerte de stock</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Nouvel Article
                        </a>
                        <a href="{{ route('stock-movements.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-up-right-circle me-2"></i>Mouvement de Stock
                        </a>
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-clipboard-check me-2"></i>Inventaire
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
