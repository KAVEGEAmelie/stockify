@extends('layouts.app')
@section('title', 'Modifier le Mouvement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">
                <i class="bi bi-pencil-square me-2"></i>Modifier le Mouvement
            </h1>
            <p class="text-muted mb-0">Modification des informations du mouvement de stock</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('stock-movements.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('stock-movements.show', $stockMovement) }}" class="btn btn-outline-info">
                <i class="bi bi-eye me-2"></i>Voir
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h5><i class="bi bi-exclamation-triangle me-2"></i>Erreurs de validation</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stock-movements.update', $stockMovement) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Formulaire principal -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-form-check me-2"></i>Informations du Mouvement
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Type de mouvement (non modifiable) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Type de Mouvement</label>
                                <div class="form-control-plaintext">
                                    @if($stockMovement->type === 'in')
                                        <span class="badge bg-success fs-6">
                                            <i class="bi bi-arrow-down me-1"></i>Entrée de Stock
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6">
                                            <i class="bi bi-arrow-up me-1"></i>Sortie de Stock
                                        </span>
                                    @endif
                                    <input type="hidden" name="type" value="{{ $stockMovement->type }}">
                                </div>
                            </div>

                            <!-- Produit (non modifiable) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Article</label>
                                <div class="form-control-plaintext">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-primary rounded me-2 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-box text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $stockMovement->product->name }}</div>
                                            <small class="text-muted">SKU: {{ $stockMovement->product->sku }}</small>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $stockMovement->product_id }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Date du mouvement -->
                            <div class="col-md-6 mb-3">
                                <label for="movement_date" class="form-label fw-bold">
                                    <i class="bi bi-calendar me-1"></i>Date et Heure
                                </label>
                                <input type="datetime-local" 
                                       class="form-control @error('movement_date') is-invalid @enderror" 
                                       id="movement_date" 
                                       name="movement_date" 
                                       value="{{ old('movement_date', $stockMovement->movement_date->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('movement_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Quantité -->
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label fw-bold">
                                    <i class="bi bi-123 me-1"></i>Quantité
                                </label>
                                <input type="number" 
                                       class="form-control @error('quantity') is-invalid @enderror" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="{{ old('quantity', $stockMovement->quantity) }}" 
                                       min="1" 
                                       required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Quantité actuelle: {{ $stockMovement->quantity }} unités
                                </div>
                            </div>
                        </div>

                        <!-- Référence -->
                        <div class="mb-3">
                            <label for="reference" class="form-label fw-bold">
                                <i class="bi bi-tag me-1"></i>Référence
                            </label>
                            <input type="text" 
                                   class="form-control @error('reference') is-invalid @enderror" 
                                   id="reference" 
                                   name="reference" 
                                   value="{{ old('reference', $stockMovement->reference) }}" 
                                   placeholder="Référence du document (facture, bon de livraison, etc.)">
                            @error('reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-bold">
                                <i class="bi bi-sticky me-1"></i>Notes
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="4" 
                                      placeholder="Notes complémentaires sur ce mouvement">{{ old('notes', $stockMovement->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alertes importantes -->
                        <div class="alert alert-warning">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i>Attention</h6>
                            <p class="mb-0">
                                La modification de ce mouvement recalculera automatiquement les stocks. 
                                Assurez-vous que les nouvelles valeurs sont correctes.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <a href="{{ route('stock-movements.show', $stockMovement) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-2"></i>Annuler
                        </a>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Enregistrer les Modifications
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar avec informations complémentaires -->
            <div class="col-lg-4">
                <!-- État actuel du stock -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>État Actuel du Stock
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Stock Actuel:</span>
                                <strong class="text-primary">{{ $stockMovement->product->stock_quantity }}</strong>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Seuil Minimum:</span>
                                <strong class="text-warning">{{ $stockMovement->product->min_stock_level }}</strong>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Valeur Stock:</span>
                                <strong class="text-success">
                                    {{ number_format($stockMovement->product->stock_quantity * $stockMovement->product->price, 0, ',', ' ') }} CFA
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations sur le mouvement original -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>Mouvement Original
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Créé le:</span>
                                <small>{{ $stockMovement->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Créé par:</span>
                                <small>{{ $stockMovement->user->name ?? 'Système' }}</small>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Stock Avant:</span>
                                <small class="badge bg-secondary">{{ $stockMovement->previous_stock }}</small>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Stock Après:</span>
                                <small class="badge bg-info">{{ $stockMovement->new_stock }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-lightning me-2"></i>Actions Rapides
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.show', $stockMovement->product) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box me-2"></i>Voir l'Article
                            </a>
                            <a href="{{ route('stock-movements.create', ['product_id' => $stockMovement->product->id]) }}" 
                               class="btn btn-outline-success btn-sm">
                                <i class="bi bi-plus me-2"></i>Nouveau Mouvement
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.avatar-xs { width: 24px; height: 24px; font-size: 0.75rem; }
</style>
@endsection
