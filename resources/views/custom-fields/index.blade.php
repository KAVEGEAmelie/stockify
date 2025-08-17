@extends('layouts.app')

@section('title', 'Champs Personnalisés')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-sliders me-2"></i>Champs Personnalisés</h1>
    <a href="{{ route('custom-fields.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nouveau Champ
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ordre</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Requis</th>
                        <th>Utilisations</th>
                        <th>Statut</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customFields as $field)
                    <tr>
                        <td>
                            <span class="badge bg-secondary">{{ $field->order }}</span>
                        </td>
                        <td>
                            <strong>{{ $field->name }}</strong>
                            @if($field->type === 'select' && $field->options)
                                <br><small class="text-muted">Options: {{ implode(', ', array_slice($field->options, 0, 3)) }}{{ count($field->options) > 3 ? '...' : '' }}</small>
                            @endif
                        </td>
                        <td>
                            @switch($field->type)
                                @case('text')
                                    <span class="badge bg-primary">Texte</span>
                                    @break
                                @case('number')
                                    <span class="badge bg-success">Nombre</span>
                                    @break
                                @case('date')
                                    <span class="badge bg-info">Date</span>
                                    @break
                                @case('textarea')
                                    <span class="badge bg-warning">Texte Long</span>
                                    @break
                                @case('select')
                                    <span class="badge bg-secondary">Sélection</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @if($field->is_required)
                                <span class="badge bg-danger">Obligatoire</span>
                            @else
                                <span class="badge bg-light text-dark">Optionnel</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ $field->values->count() }} produits
                            </span>
                        </td>
                        <td>
                            @if($field->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-danger">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('custom-fields.show', $field) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('custom-fields.edit', $field) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('custom-fields.destroy', $field) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce champ personnalisé ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-sliders display-4 d-block mb-2"></i>
                            Aucun champ personnalisé trouvé.
                            <br>
                            <a href="{{ route('custom-fields.create') }}" class="btn btn-primary mt-2">
                                Créer le premier champ personnalisé
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customFields->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $customFields->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Info Box -->
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info">
            <h6><i class="bi bi-info-circle me-2"></i>À propos des champs personnalisés</h6>
            <p class="mb-0">
                Les champs personnalisés vous permettent d'ajouter des informations spécifiques à vos produits selon vos besoins métier. 
                Exemples : Taille, Couleur, Auteur, Date d'expiration, etc.
            </p>
        </div>
    </div>
</div>
@endsection
