@extends('layouts.app')
@section('title', 'Détails du Mouvement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">
                <i class="bi bi-info-circle me-2"></i>Détails du Mouvement
            </h1>
            <p class="text-muted mb-0">Informations détaillées sur ce mouvement de stock</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('stock-movements.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-list me-2"></i>Historique
            </a>
            <a href="{{ route('stock-movements.edit', $stockMovement) }}" class="btn btn-outline-warning">
                <i class="bi bi-pencil me-2"></i>Modifier
            </a>
            <a href="{{ route('products.show', $stockMovement->product) }}" class="btn btn-outline-primary">
                <i class="bi bi-box me-2"></i>Voir l'Article
            </a>
            <form method="POST" action="{{ route('stock-movements.destroy', $stockMovement) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ?')">
                    <i class="bi bi-trash me-2"></i>Supprimer
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-data me-2"></i>Informations du Mouvement
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Date et Heure:</td>
                                    <td>{{ $stockMovement->movement_date->format('d/m/Y à H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Type de Mouvement:</td>
                                    <td>
                                        @if($stockMovement->type === 'in')
                                            <span class="badge bg-success fs-6">
                                                <i class="bi bi-arrow-down me-1"></i>Entrée de Stock
                                            </span>
                                        @else
                                            <span class="badge bg-danger fs-6">
                                                <i class="bi bi-arrow-up me-1"></i>Sortie de Stock
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Quantité:</td>
                                    <td>
                                        <span class="fs-4 fw-bold {{ $stockMovement->type === 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $stockMovement->type === 'in' ? '+' : '-' }}{{ $stockMovement->quantity }} unités
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Référence:</td>
                                    <td>{{ $stockMovement->reference ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Stock Avant:</td>
                                    <td><span class="badge bg-secondary fs-6">{{ $stockMovement->previous_stock }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Stock Après:</td>
                                    <td><span class="badge bg-info fs-6">{{ $stockMovement->new_stock }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Utilisateur:</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person text-white"></i>
                                            </div>
                                            {{ $stockMovement->user->name ?? 'Système' }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Créé le:</td>
                                    <td>{{ $stockMovement->created_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($stockMovement->notes)
                        <div class="alert alert-info">
                            <h6><i class="bi bi-sticky me-2"></i>Notes:</h6>
                            <p class="mb-0">{{ $stockMovement->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Graphique de l'évolution -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>Impact sur le Stock
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h5 class="text-muted mb-1">Stock Initial</h5>
                                <span class="fs-2 fw-bold text-secondary">{{ $stockMovement->previous_stock }}</span>
                                <p class="text-muted mb-0">unités</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h5 class="text-{{ $stockMovement->type === 'in' ? 'success' : 'danger' }} mb-1">
                                    {{ $stockMovement->type === 'in' ? 'Ajout' : 'Retrait' }}
                                </h5>
                                <span class="fs-2 fw-bold text-{{ $stockMovement->type === 'in' ? 'success' : 'danger' }}">
                                    {{ $stockMovement->type === 'in' ? '+' : '-' }}{{ $stockMovement->quantity }}
                                </span>
                                <p class="text-muted mb-0">unités</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <h5 class="text-primary mb-1">Stock Final</h5>
                            <span class="fs-2 fw-bold text-primary">{{ $stockMovement->new_stock }}</span>
                            <p class="text-muted mb-0">unités</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar avec informations du produit -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-box me-2"></i>Article Concerné
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-lg bg-primary bg-opacity-10 rounded mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-box fs-1 text-primary"></i>
                        </div>
                        <h5 class="text-primary">{{ $stockMovement->product->name }}</h5>
                        <p class="text-muted mb-0">SKU: {{ $stockMovement->product->sku }}</p>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Stock Actuel:</span>
                            <strong class="text-primary">{{ $stockMovement->product->stock_quantity }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Seuil Minimum:</span>
                            <strong class="text-warning">{{ $stockMovement->product->min_stock_level }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Catégorie:</span>
                            <strong>{{ $stockMovement->product->category->name ?? 'N/A' }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Prix:</span>
                            <strong class="text-success">{{ number_format($stockMovement->product->price, 0, ',', ' ') }} CFA</strong>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('products.show', $stockMovement->product) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye me-2"></i>Voir l'Article
                        </a>
                        <a href="{{ route('products.edit', $stockMovement->product) }}" class="btn btn-outline-warning">
                            <i class="bi bi-pencil me-2"></i>Modifier l'Article
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('stock-movements.create', ['product_id' => $stockMovement->product->id, 'type' => 'in']) }}" 
                           class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle me-2"></i>Nouvelle Entrée
                        </a>
                        <a href="{{ route('stock-movements.create', ['product_id' => $stockMovement->product->id, 'type' => 'out']) }}" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-dash-circle me-2"></i>Nouvelle Sortie
                        </a>
                        <a href="{{ route('stock-movements.export', $stockMovement->product) }}" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-download me-2"></i>Exporter Historique
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg { width: 80px; height: 80px; }
.avatar-xs { width: 24px; height: 24px; font-size: 0.75rem; }
</style>
@endsection
