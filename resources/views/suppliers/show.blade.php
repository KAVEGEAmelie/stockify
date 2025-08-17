@extends('layouts.app')
@section('title', 'Détails Fournisseur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">
                <i class="bi bi-truck me-2"></i>{{ $supplier->name }}
            </h1>
            <p class="text-muted mb-0">Détails et statistiques du fournisseur</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-outline-warning">
                <i class="bi bi-pencil me-2"></i>Modifier
            </a>
            <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')">
                    <i class="bi bi-trash me-2"></i>Supprimer
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informations du fournisseur -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Informations du Fournisseur
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Nom:</td>
                                    <td>{{ $supplier->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Contact:</td>
                                    <td>{{ $supplier->contact_person ?? 'Non renseigné' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>
                                        @if($supplier->email)
                                            <a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a>
                                        @else
                                            Non renseigné
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Téléphone:</td>
                                    <td>
                                        @if($supplier->phone)
                                            <a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a>
                                        @else
                                            Non renseigné
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Statut:</td>
                                    <td>
                                        @if($supplier->is_active)
                                            <span class="badge bg-success fs-6">
                                                <i class="bi bi-check-circle me-1"></i>Actif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary fs-6">
                                                <i class="bi bi-x-circle me-1"></i>Inactif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Créé le:</td>
                                    <td>{{ $supplier->created_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Modifié le:</td>
                                    <td>{{ $supplier->updated_at->format('d/m/Y à H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($supplier->address)
                        <div class="mt-3">
                            <h6><i class="bi bi-geo-alt me-2"></i>Adresse:</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $supplier->address }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Produits du fournisseur -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-box me-2"></i>Produits du Fournisseur
                    </h5>
                    <span class="badge bg-primary">{{ $stats['total_products'] }} produits</span>
                </div>
                <div class="card-body p-0">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Catégorie</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary bg-opacity-25 rounded me-3 d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-box text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($product->category)
                                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                                @else
                                                    <span class="text-muted">Non catégorisé</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    {{ number_format($product->price, 0, ',', ' ') }} CFA
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->stock_quantity > $product->min_stock_level ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($product->is_active)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.show', $product) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($products->hasPages())
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-center">
                                    {{ $products->links('vendor.pagination.dark-theme') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-box fs-1 d-block mb-3"></i>
                                <h5>Aucun produit</h5>
                                <p>Ce fournisseur n'a pas encore de produits associés.</p>
                                <a href="{{ route('products.create', ['supplier_id' => $supplier->id]) }}" class="btn btn-primary">
                                    <i class="bi bi-plus me-2"></i>Ajouter un Produit
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar avec statistiques -->
        <div class="col-lg-4">
            <!-- Statistiques -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>Statistiques
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary mb-1">{{ $stats['total_products'] }}</h4>
                            <small class="text-muted">Total Produits</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $stats['active_products'] }}</h4>
                            <small class="text-muted">Produits Actifs</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h5 class="text-warning mb-1">{{ number_format($stats['total_stock_value'], 0, ',', ' ') }} CFA</h5>
                        <small class="text-muted">Valeur Total du Stock</small>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning me-2"></i>Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.create', ['supplier_id' => $supplier->id]) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-plus me-2"></i>Nouveau Produit
                        </a>
                        <a href="{{ route('suppliers.export') }}?supplier={{ $supplier->id }}" 
                           class="btn btn-outline-success btn-sm">
                            <i class="bi bi-download me-2"></i>Exporter Données
                        </a>
                        @if($supplier->email)
                            <a href="mailto:{{ $supplier->email }}" 
                               class="btn btn-outline-info btn-sm">
                                <i class="bi bi-envelope me-2"></i>Envoyer Email
                            </a>
                        @endif
                        @if($supplier->phone)
                            <a href="tel:{{ $supplier->phone }}" 
                               class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-telephone me-2"></i>Appeler
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Mouvements récents -->
            @if($stats['recent_movements']->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>Mouvements Récents
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($stats['recent_movements']->take(5) as $movement)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <small class="text-muted">{{ $movement->movement_date->diffForHumans() }}</small>
                                            <div class="fw-medium">{{ $movement->product->name }}</div>
                                        </div>
                                        <span class="badge {{ $movement->type === 'in' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-sm { width: 35px; height: 35px; }
</style>
@endsection
