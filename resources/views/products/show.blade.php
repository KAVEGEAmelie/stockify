@extends('layouts.app')
@section('title', $product->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0">{{ $product->name }}</h1>
            <small class="text-muted">{{ $product->sku }}</small>
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning"><i class="bi bi-pencil-fill me-2"></i>Modifier</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Description</h5></div>
                <div class="card-body">
                    <p>{{ $product->description ?? 'Aucune description fournie.' }}</p>
                </div>
            </div>
            <div class="card">
    <div class="card-header"><h5 class="mb-0">5 Derniers Mouvements</h5></div>
    <div class="card-body p-0">
        @if($product->stockMovements->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th class="text-center">Quantité</th>
                            <th class="text-center">Stock Résultant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->stockMovements->take(5) as $movement)
                            <tr>
                                <td>{{ $movement->movement_date->format('d/m/Y') }}</td>
                                <td>@if($movement->type === 'in')<span class="badge bg-success">Entrée</span>@else<span class="badge bg-danger">Sortie</span>@endif</td>
                                <td class="text-center fw-bold {{ $movement->type === 'in' ? 'text-success' : 'text-danger' }}">
                                    {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                </td>
                                <td class="text-center">{{ $movement->new_stock }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted p-4">
                <i class="bi bi-clock-history fs-1"></i>
                <p class="mt-2 mb-0">Aucun mouvement enregistré pour cet article.</p>
            </div>
        @endif
    </div>
</div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Actions sur le Stock</h5></div>
        <div class="card-body text-center">
            <div class="d-grid gap-2">
                <a href="{{ route('stock-movements.create', ['product_id' => $product->id, 'type' => 'in']) }}" class="btn btn-success btn-lg">
                    <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Entrée
                </a>
                <a href="{{ route('stock-movements.create', ['product_id' => $product->id, 'type' => 'out']) }}" class="btn btn-danger btn-lg">
                    <i class="bi bi-dash-circle-fill me-2"></i>Nouvelle Sortie
                </a>
            </div>
        </div>
    </div>
            <div class="card mb-4">
                 <div class="card-header"><h5 class="mb-0">Informations Clés</h5></div>
                 <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span>Statut</span> @if($product->is_active)<span class="badge bg-success">Actif</span>@else<span class="badge bg-secondary">Inactif</span>@endif</li>
                    <li class="list-group-item d-flex justify-content-between"><span>Stock Actuel</span> <strong>{{ $product->stock_quantity }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Seuil d'Alerte</span> <strong>{{ $product->min_stock_level }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Valeur du Stock</span> <strong>{{ number_format($product->stockValue, 0, ',', ' ') }} CFA</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Marque</span> <strong>{{ $product->brand ?? 'N/A' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Date Expiration</span> <strong>{{ $product->expiry_date?->format('d/m/Y') ?? 'N/A' }}</strong></li>
                 </ul>
            </div>
             <div class="card">
                <div class="card-header"><h5 class="mb-0">Organisation</h5></div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between"><span>Catégorie</span> <strong>{{ $product->category->name ?? 'N/A' }}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Fournisseur</span> <strong>{{ $product->supplier->name ?? 'N/A' }}</strong></li>
                </ul>
                <div class="card-body">
                    <h6>Tags</h6>
                    @forelse ($product->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->name }}</span>
                    @empty
                        <small class="text-muted">Aucun tag associé.</small>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
