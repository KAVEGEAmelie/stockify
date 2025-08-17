@extends('layouts.app')

@section('title', 'Rapports et Analyses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-file-earmark-bar-graph me-2"></i>Rapports et Analyses</h1>
</div>

<div class="row">
    <!-- Rapport de Valorisation -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-currency-euro display-4 text-success"></i>
                </div>
                <h5 class="card-title">Valorisation du Stock</h5>
                <p class="card-text text-muted">
                    Analyse de la valeur totale de votre stock par catégorie et identification des produits les plus valorisés.
                </p>
                <a href="{{ route('reports.stock-valuation') }}" class="btn btn-success">
                    <i class="bi bi-eye me-1"></i>Voir le Rapport
                </a>
            </div>
        </div>
    </div>

    <!-- Rapport de Rotation -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-arrow-repeat display-4 text-primary"></i>
                </div>
                <h5 class="card-title">Rotation des Stocks</h5>
                <p class="card-text text-muted">
                    Identifiez les produits les plus actifs et ceux qui stagnent dans votre inventaire.
                </p>
                <a href="{{ route('reports.stock-rotation') }}" class="btn btn-primary">
                    <i class="bi bi-eye me-1"></i>Voir le Rapport
                </a>
            </div>
        </div>
    </div>

    <!-- Rapport Stock Faible -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle display-4 text-warning"></i>
                </div>
                <h5 class="card-title">Alertes de Stock</h5>
                <p class="card-text text-muted">
                    Liste des produits en stock faible ou épuisés nécessitant un réapprovisionnement.
                </p>
                <a href="{{ route('reports.low-stock') }}" class="btn btn-warning">
                    <i class="bi bi-eye me-1"></i>Voir le Rapport
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Outils d'Export -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-download me-2"></i>Outils d'Export</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Export des Données</h6>
                        <p class="text-muted">Exportez vos données de stock dans différents formats pour analyse externe.</p>
                        <div class="btn-group mb-3">
                            <a href="{{ route('products.export') }}" class="btn btn-outline-primary">
                                <i class="bi bi-file-earmark-spreadsheet me-1"></i>Export Produits (CSV)
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Rapports Personnalisés</h6>
                        <p class="text-muted">Générez des rapports personnalisés selon vos critères spécifiques.</p>
                        <button class="btn btn-outline-info" onclick="alert('Fonctionnalité à venir')">
                            <i class="bi bi-gear me-1"></i>Rapport Personnalisé
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistiques Rapides -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Aperçu Rapide</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-primary">{{ \App\Models\Product::count() }}</h4>
                            <small class="text-muted">Produits Total</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success">{{ \App\Models\Category::count() }}</h4>
                            <small class="text-muted">Catégories</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info">{{ \App\Models\Supplier::count() }}</h4>
                            <small class="text-muted">Fournisseurs</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning">{{ \App\Models\Product::lowStock()->count() }}</h4>
                            <small class="text-muted">En Alerte</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
