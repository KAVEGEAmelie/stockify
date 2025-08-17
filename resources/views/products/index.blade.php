@extends('layouts.app')
@section('title', 'Liste des Articles')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">Gestion des Articles</h1>
            <p class="text-muted mb-0">Gérez votre inventaire de produits</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle-fill me-2"></i>Ajouter un Article
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filtres et recherche -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Rechercher un article..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-funnel me-1"></i>Filtrer
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-download me-1"></i>Exporter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-box me-2 text-primary"></i>Tous les Articles
            </h5>
            <span class="badge bg-primary">{{ $products->total() ?? count($products) }} articles</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th class="border-0">Article</th>
                            <th class="border-0">Catégorie</th>
                            <th class="border-0 text-end">Prix de Vente</th>
                            <th class="border-0 text-center">Stock</th>
                            <th class="border-0 text-center">Statut</th>
                            <th class="border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="align-middle">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $product->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded me-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-primary">{{ $product->name }}</h6>
                                            <small class="text-muted">SKU: {{ $product->sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $product->category->name ?? 'N/A' }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-success">{{ number_format($product->price, 0, ',', ' ') }} CFA</span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold {{ $product->isLowStock() ? 'text-warning' : 'text-primary' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if (!$product->is_active)
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-pause-circle me-1"></i>Inactif
                                        </span>
                                    @elseif ($product->isLowStock())
                                        <span class="badge bg-warning">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Alerte
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>En Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="btn btn-outline-info" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="btn btn-outline-warning" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox display-1 d-block mb-3"></i>
                                        <h5>Aucun article trouvé</h5>
                                        <p>Commencez par ajouter votre premier article.</p>
                                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Ajouter un Article
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($products->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}
</style>
@endsection
