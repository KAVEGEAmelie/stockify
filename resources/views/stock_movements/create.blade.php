@extends('layouts.app')

@php
    $pageTitle = $type === 'in' ? 'Nouvelle Entrée' : 'Nouvelle Sortie';
    $pageColor = $type === 'in' ? 'success' : 'danger';
    $pageIcon = $type === 'in' ? 'bi-arrow-down-circle' : 'bi-arrow-up-circle';
@endphp

@section('title', $pageTitle . ' pour ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-{{ $pageColor }} mb-1">
                <i class="bi {{ $pageIcon }} me-2"></i>{{ $pageTitle }}
            </h1>
            <p class="text-muted mb-0">Enregistrer un mouvement de stock</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('stock-movements.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-list me-2"></i>Historique
            </a>
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i>Retour à l'Article
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                    <strong>Erreurs détectées !</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informations produit -->
        <div class="col-lg-4 mb-4">
            <div class="card border-{{ $pageColor }} border-opacity-25">
                <div class="card-header bg-{{ $pageColor }} bg-opacity-10">
                    <h5 class="mb-0 text-{{ $pageColor }}">
                        <i class="bi bi-box me-2"></i>Article Sélectionné
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-lg bg-{{ $pageColor }} bg-opacity-10 rounded mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-box fs-1 text-{{ $pageColor }}"></i>
                        </div>
                        <h5 class="text-primary">{{ $product->name }}</h5>
                        <p class="text-muted mb-0">SKU: {{ $product->sku }}</p>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-{{ $product->stock_quantity > $product->min_stock_level ? 'success' : 'warning' }} mb-1">
                                    {{ $product->stock_quantity }}
                                </h4>
                                <small class="text-muted">Stock Actuel</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-danger mb-1">{{ $product->min_stock_level }}</h4>
                            <small class="text-muted">Seuil Minimum</small>
                        </div>
                    </div>

                    @if($product->stock_quantity <= $product->min_stock_level)
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Stock faible !</strong> Cet article est en dessous du seuil d'alerte.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historique récent -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Mouvements Récents
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $recentMovements = $product->stockMovements()->latest()->take(5)->get();
                    @endphp
                    @forelse($recentMovements as $movement)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-{{ $movement->type === 'in' ? 'success' : 'danger' }} me-2">
                                    {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                </span>
                                <small class="text-muted">{{ $movement->movement_date->format('d/m H:i') }}</small>
                            </div>
                            <small class="text-muted">{{ $movement->user->name ?? 'Système' }}</small>
                        </div>
                    @empty
                        <div class="text-center text-muted">
                            <i class="bi bi-clock"></i>
                            <p class="mb-0 mt-2">Aucun mouvement récent</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Formulaire de mouvement -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi {{ $pageIcon }} me-2 text-{{ $pageColor }}"></i>
                        Formulaire de {{ $pageTitle }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('stock-movements.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="quantity" class="form-label required">
                                    <i class="bi bi-hash me-1 text-{{ $pageColor }}"></i>
                                    Quantité {{ $type === 'in' ? 'à ajouter' : 'à retirer' }}
                                </label>
                                <div class="input-group input-group-lg">
                                    @if($type === 'in')
                                        <span class="input-group-text bg-success text-white">
                                            <i class="bi bi-plus-lg"></i>
                                        </span>
                                    @else
                                        <span class="input-group-text bg-danger text-white">
                                            <i class="bi bi-dash-lg"></i>
                                        </span>
                                    @endif
                                    <input type="number" 
                                           class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="{{ old('quantity') }}" 
                                           required 
                                           min="1"
                                           @if($type === 'out') max="{{ $product->stock_quantity }}" @endif
                                           autofocus
                                           onchange="updatePreview()">
                                    <span class="input-group-text">unités</span>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if($type === 'out')
                                    <small class="form-text text-muted">
                                        Maximum disponible: {{ $product->stock_quantity }} unités
                                    </small>
                                @endif
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="movement_date" class="form-label required">
                                    <i class="bi bi-calendar-event me-1 text-info"></i>
                                    Date et Heure du Mouvement
                                </label>
                                <input type="datetime-local" 
                                       class="form-control form-control-lg @error('movement_date') is-invalid @enderror" 
                                       id="movement_date" 
                                       name="movement_date" 
                                       value="{{ old('movement_date', now()->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('movement_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">
                                <i class="bi bi-sticky me-1 text-warning"></i>
                                Notes / Référence (Optionnel)
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="4"
                                      placeholder="Ajoutez des détails sur ce mouvement (facture, commande, ajustement, etc.)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Aperçu du changement -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="bi bi-eye me-2"></i>Aperçu du Changement
                                </h6>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="border-end">
                                            <h5 class="text-muted mb-1">Stock Actuel</h5>
                                            <span class="fs-4 fw-bold">{{ $product->stock_quantity }}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border-end">
                                            <h5 class="text-{{ $pageColor }} mb-1">{{ $type === 'in' ? 'Ajout' : 'Retrait' }}</h5>
                                            <span class="fs-4 fw-bold text-{{ $pageColor }}" id="quantityPreview">
                                                {{ $type === 'in' ? '+' : '-' }}0
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="text-primary mb-1">Nouveau Stock</h5>
                                        <span class="fs-4 fw-bold text-primary" id="newStockPreview">{{ $product->stock_quantity }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires
                            </div>
                            <div>
                                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary me-2">
                                    <i class="bi bi-x-lg me-1"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-{{ $pageColor }} btn-lg px-4">
                                    <i class="bi bi-check-lg me-1"></i>
                                    Enregistrer {{ $type === 'in' ? 'l\'Entrée' : 'la Sortie' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg { width: 80px; height: 80px; }
.required::after { content: " *"; color: #dc3545; }
.border-opacity-25 { border-opacity: 0.25 !important; }
.bg-opacity-10 { background-color: rgba(var(--bs-success-rgb), 0.1) !important; }
</style>

<script>
function updatePreview() {
    const quantityInput = document.getElementById('quantity');
    const quantity = parseInt(quantityInput.value) || 0;
    const currentStock = {{ $product->stock_quantity }};
    const type = '{{ $type }}';
    
    // Mettre à jour l'aperçu de la quantité
    document.getElementById('quantityPreview').textContent = 
        (type === 'in' ? '+' : '-') + quantity;
    
    // Calculer et afficher le nouveau stock
    const newStock = type === 'in' ? currentStock + quantity : currentStock - quantity;
    document.getElementById('newStockPreview').textContent = newStock;
    
    // Validation visuelle
    const newStockElement = document.getElementById('newStockPreview');
    if (newStock < 0) {
        newStockElement.className = 'fs-4 fw-bold text-danger';
        quantityInput.setCustomValidity('Stock insuffisant');
    } else if (newStock <= {{ $product->min_stock_level }}) {
        newStockElement.className = 'fs-4 fw-bold text-warning';
        quantityInput.setCustomValidity('');
    } else {
        newStockElement.className = 'fs-4 fw-bold text-success';
        quantityInput.setCustomValidity('');
    }
}

// Validation Bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
@endsection
