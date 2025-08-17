@extends('layouts.app')

@section('title', 'Gestion d\'Inventaire')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-clipboard-check me-2"></i>Gestion d'Inventaire</h1>
    <div class="btn-group">
        <a href="{{ route('inventory.count') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Décompte Inventaire
        </a>
        <a href="{{ route('inventory.scan') }}" class="btn btn-success">
            <i class="bi bi-upc-scan me-1"></i>Scanner
        </a>
    </div>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ number_format($totalProducts) }}</h4>
                        <p class="mb-0">Total Produits</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box-seam display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $lowStockCount }}</h4>
                        <p class="mb-0">Stock Faible</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-triangle display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $zeroStockCount }}</h4>
                        <p class="mb-0">Stock Zéro</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-x-circle display-6"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ number_format($totalValue, 0, ',', ' ') }} CFA</h4>
                        <p class="mb-0">Valeur Totale</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-euro display-6"></i>
                    </div>
                </div>
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
                    <div class="col-md-4">
                        <div class="d-grid">
                            <a href="{{ route('inventory.count') }}" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-clipboard-check me-2"></i>
                                <div>
                                    <strong>Décompte d'Inventaire</strong>
                                    <br><small>Compter physiquement le stock</small>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <a href="{{ route('inventory.scan') }}" class="btn btn-outline-success btn-lg">
                                <i class="bi bi-upc-scan me-2"></i>
                                <div>
                                    <strong>Scanner Code-Barres</strong>
                                    <br><small>Identification rapide par scan</small>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid">
                            <a href="{{ route('reports.low-stock') }}" class="btn btn-outline-warning btn-lg">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <div>
                                    <strong>Alertes Stock</strong>
                                    <br><small>Voir les produits en alerte</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajustements récents -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Ajustements Récents</h5>
    </div>
    <div class="card-body">
        @if($recentAdjustments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Type</th>
                            <th>Quantité</th>
                            <th>Raison</th>
                            <th>Référence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAdjustments as $adjustment)
                        <tr>
                            <td>{{ $adjustment->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <strong>{{ $adjustment->product->name }}</strong>
                                <br><small class="text-muted">{{ $adjustment->product->sku }}</small>
                            </td>
                            <td>
                                @if($adjustment->direction === 'in')
                                    <span class="badge bg-success">Ajout</span>
                                @else
                                    <span class="badge bg-danger">Retrait</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold {{ $adjustment->direction === 'in' ? 'text-success' : 'text-danger' }}">
                                    {{ $adjustment->direction === 'in' ? '+' : '-' }}{{ $adjustment->quantity }}
                                </span>
                            </td>
                            <td>{{ $adjustment->reason }}</td>
                            <td><code>{{ $adjustment->reference }}</code></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-4">
                <i class="bi bi-clock-history display-4 d-block mb-2"></i>
                Aucun ajustement récent trouvé.
            </div>
        @endif
    </div>
</div>
@endsection
