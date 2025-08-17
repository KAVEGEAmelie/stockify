@extends('layouts.app')
@section('title', 'Fournisseurs')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">
                <i class="bi bi-truck me-2"></i>Fournisseurs
            </h1>
            <p class="text-muted mb-0">Gestion des fournisseurs et partenaires commerciaux</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('suppliers.export') }}" class="btn btn-outline-success">
                <i class="bi bi-download me-2"></i>Exporter
            </a>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Nouveau Fournisseur
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary bg-opacity-10 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md bg-primary bg-opacity-25 rounded me-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-truck fs-4 text-primary"></i>
                        </div>
                        <div>
                            <h3 class="text-primary mb-0">{{ $suppliers->total() }}</h3>
                            <p class="text-muted mb-0">Total Fournisseurs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success bg-opacity-10 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md bg-success bg-opacity-25 rounded me-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle fs-4 text-success"></i>
                        </div>
                        <div>
                            <h3 class="text-success mb-0">{{ $suppliers->where('is_active', true)->count() }}</h3>
                            <p class="text-muted mb-0">Actifs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info bg-opacity-10 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md bg-info bg-opacity-25 rounded me-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-box fs-4 text-info"></i>
                        </div>
                        <div>
                            <h3 class="text-info mb-0">{{ $suppliers->sum('products_count') }}</h3>
                            <p class="text-muted mb-0">Produits Fournis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning bg-opacity-10 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-md bg-warning bg-opacity-25 rounded me-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-x-circle fs-4 text-warning"></i>
                        </div>
                        <div>
                            <h3 class="text-warning mb-0">{{ $suppliers->where('is_active', false)->count() }}</h3>
                            <p class="text-muted mb-0">Inactifs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('suppliers.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Rechercher</label>
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nom, email, contact...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select class="form-select" name="status">
                        <option value="">Tous</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Actifs</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactifs</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Produits</label>
                    <select class="form-select" name="products">
                        <option value="">Tous</option>
                        <option value="with" {{ request('products') == 'with' ? 'selected' : '' }}>Avec produits</option>
                        <option value="without" {{ request('products') == 'without' ? 'selected' : '' }}>Sans produits</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i>
                    </button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des fournisseurs -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-list me-2"></i>Liste des Fournisseurs
            </h5>
            <span class="badge bg-primary">{{ $suppliers->total() }} fournisseurs</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Fournisseur</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Produits</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary bg-opacity-25 rounded me-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-truck text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $supplier->name }}</h6>
                                            <small class="text-muted">Créé le {{ $supplier->created_at->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($supplier->contact_person)
                                        <div>
                                            <span class="fw-medium">{{ $supplier->contact_person }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Non renseigné</span>
                                    @endif
                                </td>
                                <td>
                                    @if($supplier->email)
                                        <a href="mailto:{{ $supplier->email }}" class="text-decoration-none">
                                            {{ $supplier->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">Non renseigné</span>
                                    @endif
                                </td>
                                <td>
                                    @if($supplier->phone)
                                        <a href="tel:{{ $supplier->phone }}" class="text-decoration-none">
                                            {{ $supplier->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">Non renseigné</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $supplier->products_count }} produits</span>
                                </td>
                                <td>
                                    @if($supplier->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Actif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle me-1"></i>Inactif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('suppliers.show', $supplier) }}" 
                                           class="btn btn-outline-success btn-sm" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('suppliers.edit', $supplier) }}" 
                                           class="btn btn-outline-warning btn-sm" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')">
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
                                        <i class="bi bi-truck fs-1 d-block mb-3"></i>
                                        <h5>Aucun fournisseur trouvé</h5>
                                        <p>Commencez par ajouter un nouveau fournisseur.</p>
                                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus me-2"></i>Ajouter un Fournisseur
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($suppliers->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-center">
                    {{ $suppliers->links('vendor.pagination.dark-theme') }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.avatar-sm { width: 35px; height: 35px; }
.avatar-md { width: 50px; height: 50px; }
</style>
@endsection
