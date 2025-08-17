@extends('layouts.app')
@section('title', 'Modifier Fournisseur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">
                <i class="bi bi-pencil-square me-2"></i>Modifier le Fournisseur
            </h1>
            <p class="text-muted mb-0">Modification des informations de {{ $supplier->name }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-outline-info">
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

    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Informations principales -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Informations du Fournisseur
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Nom du fournisseur -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="bi bi-building me-1"></i>Nom du Fournisseur *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $supplier->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Personne de contact -->
                            <div class="col-md-6 mb-3">
                                <label for="contact_person" class="form-label fw-bold">
                                    <i class="bi bi-person me-1"></i>Personne de Contact
                                </label>
                                <input type="text" 
                                       class="form-control @error('contact_person') is-invalid @enderror" 
                                       id="contact_person" 
                                       name="contact_person" 
                                       value="{{ old('contact_person', $supplier->contact_person) }}">
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">
                                    <i class="bi bi-envelope me-1"></i>Email
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $supplier->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="bi bi-telephone me-1"></i>Téléphone
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $supplier->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Adresse -->
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">
                                <i class="bi bi-geo-alt me-1"></i>Adresse
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3">{{ old('address', $supplier->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    <i class="bi bi-toggle-on me-1"></i>Fournisseur actif
                                </label>
                                <div class="form-text">
                                    Un fournisseur actif peut être utilisé lors de la création de produits.
                                </div>
                            </div>
                        </div>

                        @if($supplier->products()->count() > 0)
                            <div class="alert alert-info">
                                <h6><i class="bi bi-info-circle me-2"></i>Information</h6>
                                <p class="mb-0">
                                    Ce fournisseur a {{ $supplier->products()->count() }} produit(s) associé(s). 
                                    La désactivation du fournisseur n'affectera pas les produits existants.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Enregistrer les Modifications
                    </button>
                </div>
            </div>

            <!-- Sidebar avec informations -->
            <div class="col-lg-4">
                <!-- Informations actuelles -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Informations Actuelles
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Créé le:</span>
                                <small>{{ $supplier->created_at->format('d/m/Y') }}</small>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Modifié le:</span>
                                <small>{{ $supplier->updated_at->format('d/m/Y') }}</small>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Produits:</span>
                                <span class="badge bg-info">{{ $supplier->products()->count() }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between px-0">
                                <span>Statut:</span>
                                @if($supplier->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-secondary">Inactif</span>
                                @endif
                            </div>
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
                            <a href="{{ route('suppliers.show', $supplier) }}" 
                               class="btn btn-outline-info btn-sm">
                                <i class="bi bi-eye me-2"></i>Voir les Détails
                            </a>
                            <a href="{{ route('products.index', ['supplier' => $supplier->id]) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box me-2"></i>Voir les Produits
                            </a>
                            @if($supplier->email)
                                <a href="mailto:{{ $supplier->email }}" 
                                   class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-envelope me-2"></i>Envoyer Email
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Conseils -->
                <div class="card bg-light">
                    <div class="card-header">
                        <h6 class="mb-0 text-dark">
                            <i class="bi bi-lightbulb me-2"></i>Conseils
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-dark">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i>Attention</h6>
                            <ul class="mb-3">
                                <li>Vérifiez les informations avant de sauvegarder</li>
                                <li>Un fournisseur inactif n'apparaîtra plus dans les listes</li>
                                <li>Les produits existants ne seront pas affectés</li>
                            </ul>

                            <h6><i class="bi bi-star me-2"></i>Bonnes pratiques</h6>
                            <ul class="mb-0">
                                <li>Maintenez les coordonnées à jour</li>
                                <li>Utilisez un email professionnel</li>
                                <li>Renseignez l'adresse complète</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
