@extends('layouts.app')

@section('title', 'Tags')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-bookmark-fill me-2"></i>Tags</h1>
    <a href="{{ route('tags.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nouveau Tag
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tag</th>
                        <th>Description</th>
                        <th>Produits Associés</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                    <tr>
                        <td>
                            <span class="badge" style="background-color: {{ $tag->color }}; color: white; font-size: 14px;">
                                {{ $tag->name }}
                            </span>
                        </td>
                        <td>
                            @if($tag->description)
                                {{ Str::limit($tag->description, 100) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $tag->products_count }} produits
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('tags.show', $tag) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('tags.destroy', $tag) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="bi bi-bookmark display-4 d-block mb-2"></i>
                            Aucun tag trouvé.
                            <br>
                            <a href="{{ route('tags.create') }}" class="btn btn-primary mt-2">
                                Créer le premier tag
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tags->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $tags->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
