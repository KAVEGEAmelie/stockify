@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Tableau de Bord</h1>
    </div>
</div>

<div class="row mb-4">
    <!-- Total Produits -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h4>{{ $totalProducts }}</h4>
                <p class="mb-0">Articles</p>
            </div>
        </div>
    </div>

    <!-- Total Catégories -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h4>{{ $totalCategories }}</h4>
                <p class="mb-0">Catégories</p>
            </div>
        </div>
    </div>

    <!-- Total Fournisseurs -->
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h4>{{ $totalSuppliers }}</h4>
                <p class="mb-0">Fournisseurs</p>
            </div>
        </div>
    </div>

    <!-- Produits en Stock Faible -->
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h4>{{ $lowStockProducts }}</h4>
                <p class="mb-0">Articles en Alerte</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Mouvements Récents</h5>
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
                                    <td>{{ $movement->product->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($movement->type === 'in')
                                            <span class="badge bg-success">Entrée</span>
                                        @else
                                            <span class="badge bg-danger">Sortie</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Aucun mouvement récent.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
