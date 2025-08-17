@extends('layouts.app')
@section('title', 'Modifier l\'Article')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Modifier : {{ $product->name }}</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oups !</strong> Il y a eu des erreurs avec votre saisie.
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('products._form')
    </form>
@endsection
