@extends('layouts.app')
@section('title', 'Nouveau Fournisseur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 text-primary mb-1">
                <i class="bi bi-plus-circle me-2"></i>Nouveau Fournisseur
            </h1>
            <p class="text-muted mb-0">Ajouter un nouveau fournisseur au système</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour à la Liste
        </a>
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

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        
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
                                       value="{{ old('name') }}" 
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
                                       value="{{ old('contact_person') }}">
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
                                       value="{{ old('email') }}">
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
                                       value="{{ old('phone') }}">
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
                                      rows="3">{{ old('address') }}</textarea>
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
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    <i class="bi bi-toggle-on me-1"></i>Fournisseur actif
                                </label>
                                <div class="form-text">
                                    Un fournisseur actif peut être utilisé lors de la création de produits.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-2"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Créer le Fournisseur
                    </button>
                </div>
            </div>

            <!-- Sidebar avec aide -->
            <div class="col-lg-4">
                <div class="card bg-light">
                    <div class="card-header">
                        <h6 class="mb-0 text-dark">
                            <i class="bi bi-lightbulb me-2"></i>Conseils
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-dark">
                            <h6><i class="bi bi-info-circle me-2"></i>Informations importantes</h6>
                            <ul class="mb-3">
                                <li>Le nom du fournisseur est obligatoire</li>
                                <li>L'email doit être valide s'il est renseigné</li>
                                <li>Seuls les fournisseurs actifs apparaîtront dans les listes de sélection</li>
                            </ul>

                            <h6><i class="bi bi-star me-2"></i>Bonnes pratiques</h6>
                            <ul class="mb-0">
                                <li>Renseignez au minimum un moyen de contact</li>
                                <li>Vérifiez l'orthographe du nom du fournisseur</li>
                                <li>L'adresse complète facilite la gestion logistique</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Aperçu -->
                <div class="card mt-3 bg-primary bg-opacity-10 border-primary">
                    <div class="card-header border-primary">
                        <h6 class="mb-0 text-primary">
                            <i class="bi bi-eye me-2"></i>Aperçu
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="avatar-lg bg-primary bg-opacity-25 rounded mx-auto mb-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-truck fs-1 text-primary"></i>
                            </div>
                            <h6 class="text-primary" id="preview-name">Nom du Fournisseur</h6>
                            <p class="text-muted mb-2" id="preview-contact">Personne de Contact</p>
                            <small class="text-muted" id="preview-email">email@example.com</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.avatar-lg { width: 80px; height: 80px; }
</style>

<script>
// Aperçu en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const contactInput = document.getElementById('contact_person');
    const emailInput = document.getElementById('email');
    
    const previewName = document.getElementById('preview-name');
    const previewContact = document.getElementById('preview-contact');
    const previewEmail = document.getElementById('preview-email');
    
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nom du Fournisseur';
    });
    
    contactInput.addEventListener('input', function() {
        previewContact.textContent = this.value || 'Personne de Contact';
    });
    
    emailInput.addEventListener('input', function() {
        previewEmail.textContent = this.value || 'email@example.com';
    });
});
</script>
@endsection
