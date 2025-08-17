@extends('layouts.app')

@section('title', 'Créer un Tag')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-bookmark-fill me-2"></i>Créer un Tag</h1>
    <a href="{{ route('tags.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tags.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du Tag <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Couleur <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror" 
                                   id="color" name="color" value="{{ old('color', '#007bff') }}" required>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                   id="color-text" value="{{ old('color', '#007bff') }}" readonly>
                        </div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Aperçu du Tag</label>
                        <div>
                            <span id="tag-preview" class="badge" style="background-color: {{ old('color', '#007bff') }}; color: white; font-size: 16px;">
                                {{ old('name', 'Nom du tag') }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Créer le Tag
                        </button>
                        <a href="{{ route('tags.index') }}" class="btn btn-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations</h5>
            </div>
            <div class="card-body">
                <h6>À quoi servent les tags ?</h6>
                <p class="small text-muted">
                    Les tags permettent de catégoriser vos produits selon plusieurs critères transversaux :
                </p>
                <ul class="small">
                    <li>État : Nouveau, Occasion, Défectueux</li>
                    <li>Urgence : Urgent, Normal</li>
                    <li>Saisonnalité : Été, Hiver</li>
                    <li>Promotion : Soldé, Promo</li>
                    <li>Qualité : Premium, Standard</li>
                </ul>
                
                <h6 class="mt-3">Conseils :</h6>
                <ul class="small">
                    <li>Utilisez des couleurs cohérentes</li>
                    <li>Gardez les noms courts et clairs</li>
                    <li>Un produit peut avoir plusieurs tags</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('color-text');
    const nameInput = document.getElementById('name');
    const tagPreview = document.getElementById('tag-preview');

    function updatePreview() {
        const color = colorInput.value;
        const name = nameInput.value || 'Nom du tag';
        
        colorText.value = color;
        tagPreview.style.backgroundColor = color;
        tagPreview.textContent = name;
    }

    colorInput.addEventListener('input', updatePreview);
    nameInput.addEventListener('input', updatePreview);
});
</script>
@endsection
