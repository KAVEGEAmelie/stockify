<div class="row">
    <!-- Colonne Principale -->
    <div class="col-lg-8">
        <div class="card mb-4 border-primary border-opacity-25">
            <div class="card-header bg-primary bg-opacity-10">
                <h5 class="mb-0 text-primary">
                    <i class="bi bi-info-circle me-2"></i>Informations Générales
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label required">
                        <i class="bi bi-tag me-1 text-primary"></i>Nom de l'article
                    </label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $product->name) }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="sku" class="form-label required">
                        <i class="bi bi-upc-scan me-1 text-info"></i>Référence / SKU
                    </label>
                    <input type="text" 
                           class="form-control @error('sku') is-invalid @enderror" 
                           id="sku" 
                           name="sku" 
                           value="{{ old('sku', $product->sku) }}" 
                           required>
                    @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="bi bi-text-paragraph me-1 text-secondary"></i>Description
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="5" 
                              placeholder="Décrivez votre produit...">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="card border-info border-opacity-25">
            <div class="card-header bg-info bg-opacity-10">
                <h5 class="mb-0 text-info">
                    <i class="bi bi-gear me-2"></i>Détails Additionnels
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="brand" class="form-label">
                            <i class="bi bi-award me-1 text-warning"></i>Marque
                        </label>
                        <input type="text" 
                               class="form-control @error('brand') is-invalid @enderror" 
                               id="brand" 
                               name="brand" 
                               value="{{ old('brand', $product->brand) }}"
                               placeholder="Ex: Samsung, Apple...">
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="expiry_date" class="form-label">
                            <i class="bi bi-calendar-event me-1 text-danger"></i>Date d'expiration
                        </label>
                        <input type="date" 
                               class="form-control @error('expiry_date') is-invalid @enderror" 
                               id="expiry_date" 
                               name="expiry_date" 
                               value="{{ old('expiry_date', $product->expiry_date?->format('Y-m-d')) }}">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Colonne Latérale -->
    <div class="col-lg-4">
        <div class="card mb-4 border-success border-opacity-25">
            <div class="card-header bg-success bg-opacity-10">
                <h5 class="mb-0 text-success">
                    <i class="bi bi-currency-euro me-2"></i>Tarification
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="price" class="form-label required">
                        <i class="bi bi-tag-fill me-1 text-success"></i>Prix de Vente (CFA)
                    </label>
                    <div class="input-group">
                        <input type="number" 
                               step="1" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $product->price) }}" 
                               required>
                        <span class="input-group-text">CFA</span>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-0">
                    <label for="cost_price" class="form-label">
                        <i class="bi bi-receipt me-1 text-warning"></i>Coût d'Achat (CFA)
                    </label>
                    <div class="input-group">
                        <input type="number" 
                               step="1" 
                               class="form-control @error('cost_price') is-invalid @enderror" 
                               id="cost_price" 
                               name="cost_price" 
                               value="{{ old('cost_price', $product->cost_price) }}">
                        <span class="input-group-text">CFA</span>
                        @error('cost_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-warning border-opacity-25">
            <div class="card-header bg-warning bg-opacity-10">
                <h5 class="mb-0 text-warning">
                    <i class="bi bi-boxes me-2"></i>Gestion du Stock
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="stock_quantity" class="form-label required">
                        <i class="bi bi-stack me-1 text-info"></i>Quantité en Stock
                    </label>
                    <input type="number" 
                           class="form-control @error('stock_quantity') is-invalid @enderror" 
                           id="stock_quantity" 
                           name="stock_quantity" 
                           value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" 
                           required>
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-0">
                    <label for="min_stock_level" class="form-label required">
                        <i class="bi bi-exclamation-triangle me-1 text-danger"></i>Seuil d'Alerte
                    </label>
                    <input type="number" 
                           class="form-control @error('min_stock_level') is-invalid @enderror" 
                           id="min_stock_level" 
                           name="min_stock_level" 
                           value="{{ old('min_stock_level', $product->min_stock_level ?? 5) }}" 
                           required>
                    <small class="form-text">Quantité minimale avant alerte</small>
                    @error('min_stock_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4 border-secondary border-opacity-25">
            <div class="card-header bg-secondary bg-opacity-10">
                <h5 class="mb-0 text-secondary">
                    <i class="bi bi-diagram-3 me-2"></i>Organisation
                </h5>
            </div>
            <div class="card-body">
                 <div class="mb-3">
                    <label for="category_id" class="form-label required">
                        <i class="bi bi-tags me-1 text-primary"></i>Catégorie
                    </label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" 
                            name="category_id" 
                            required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                    @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">
                        <i class="bi bi-truck me-1 text-info"></i>Fournisseur
                    </label>
                    <select class="form-select @error('supplier_id') is-invalid @enderror" 
                            id="supplier_id" 
                            name="supplier_id">
                        <option value="">Aucun fournisseur</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" 
                                    @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-0">
                    <label for="tags" class="form-label">
                        <i class="bi bi-bookmark me-1 text-warning"></i>Tags
                    </label>
                    <select class="form-select @error('tags') is-invalid @enderror" 
                            id="tags" 
                            name="tags[]" 
                            multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" 
                                    @selected(in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray())))>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text">Maintenez Ctrl/Cmd pour en sélectionner plusieurs.</small>
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card border-danger border-opacity-25">
            <div class="card-header bg-danger bg-opacity-10">
                <h5 class="mb-0 text-danger">
                    <i class="bi bi-toggle-on me-2"></i>Statut
                </h5>
            </div>
            <div class="card-body">
                <div class="form-check form-switch">
                    <input class="form-check-input @error('is_active') is-invalid @enderror" 
                           type="checkbox" 
                           role="switch" 
                           id="is_active" 
                           name="is_active" 
                           value="1" 
                           @checked(old('is_active', $product->is_active ?? true))>
                    <label class="form-check-label fw-bold" for="is_active">
                        Article Actif
                    </label>
                    <small class="form-text d-block">
                        Les articles inactifs n'apparaissent pas dans les ventes
                    </small>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 p-3 bg-light rounded">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted">
            <i class="bi bi-info-circle me-1"></i>
            Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-x-lg me-1"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-lg me-1"></i>
                {{ $product->exists ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
        </div>
    </div>
</div>

<style>
.required::after {
    content: " *";
    color: #dc3545;
}

.border-opacity-25 {
    border-opacity: 0.25 !important;
}

.bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}
</style>
