@extends('layouts.app')

@section('title', 'Emplacements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-geo-alt-fill me-2"></i>Emplacements</h1>
    <a href="{{ route('locations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nouvel Emplacement
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
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Emplacement Parent</th>
                        <th>Produits</th>
                        <th>Statut</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $location)
                    <tr>
                        <td>
                            <strong>{{ $location->name }}</strong>
                            @if($location->description)
                                <br><small class="text-muted">{{ Str::limit($location->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ ucfirst($location->type) }}
                            </span>
                        </td>
                        <td>
                            @if($location->parent)
                                <span class="text-muted">{{ $location->parent->name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $location->products->count() }} produits
                            </span>
                        </td>
                        <td>
                            @if($location->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-danger">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('locations.show', $location) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('locations.destroy', $location) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emplacement ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-geo-alt display-4 d-block mb-2"></i>
                            Aucun emplacement trouvé.
                            <br>
                            <a href="{{ route('locations.create') }}" class="btn btn-primary mt-2">
                                Créer le premier emplacement
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($locations->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $locations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
