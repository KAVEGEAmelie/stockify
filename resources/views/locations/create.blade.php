@extends('layouts.app')

@section('title', 'Créer un Emplacement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-geo-alt-fill me-2"></i>Créer un Emplacement</h1>
    <a href="{{ route('locations.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('locations.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Sélectionner un type</option>
                            <option value="warehouse" {{ old('type') == 'warehouse' ? 'selected' : '' }}>Entrepôt</option>
                            <option value="room" {{ old('type') == 'room' ? 'selected' : '' }}>Salle</option>
                            <option value="shelf" {{ old('type') == 'shelf' ? 'selected' : '' }}>Étagère</option>
                            <option value="box" {{ old('type') == 'box' ? 'selected' : '' }}>Boîte</option>
                            <option value="zone" {{ old('type') == 'zone' ? 'selected' : '' }}>Zone</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Emplacement Parent</label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                            <option value="">Aucun (Emplacement racine)</option>
                            @foreach($parentLocations as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }} ({{ ucfirst($parent->type) }})
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Sélectionnez un emplacement parent pour créer une hiérarchie (ex: Entrepôt > Étagère > Boîte)
                        </div>
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
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Emplacement actif
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Créer l'Emplacement
                        </button>
                        <a href="{{ route('locations.index') }}" class="btn btn-secondary">
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
                <h6>Types d'emplacements :</h6>
                <ul class="list-unstyled">
                    <li><strong>Entrepôt :</strong> Emplacement principal</li>
                    <li><strong>Salle :</strong> Division dans un entrepôt</li>
                    <li><strong>Zone :</strong> Secteur spécifique</li>
                    <li><strong>Étagère :</strong> Rangement vertical</li>
                    <li><strong>Boîte :</strong> Conteneur spécifique</li>
                </ul>
                
                <hr>
                
                <h6>Hiérarchie :</h6>
                <p class="small text-muted">
                    Vous pouvez créer une hiérarchie d'emplacements pour une organisation optimale. 
                    Par exemple : Entrepôt A > Étagère 3 > Boîte B
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
