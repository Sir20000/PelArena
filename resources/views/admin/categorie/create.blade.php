<div class="container">
    <h1>{{ isset($category) ? 'Modifier la Categorie' : 'Ajouter une Categorie' }}</h1>
    
    <form action="{{route('admin.categorie.store') }}" method="POST">
    @csrf
        @if(isset($category))
            @method('POST')
        @endif
        <div class="form-group">
            <label for="ram">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" >
        </div>
        <div class="form-group">
            <label for="cpu">Description</label>
            <input type="text" name="description" class="form-control" value="{{ old('description', $category->description ?? '') }}">
        </div>
        <div class="form-group">
            <label for="storage">Image</label>
            <input type="text" name="image" class="form-control" value="{{ old('image', $category->image ?? '') }}">
        </div>
        <div class="form-group">
            <label for="db">Egg id</label>
            <input type="number" name="egg_id" class="form-control" value="{{ old('db', $category->egg_id ?? '') }}" >
        </div>
        <div class="form-group">
            <label for="backups">Nest id</label>
            <input type="number" name="nests" class="form-control" value="{{ old('backups', $category->nests ?? '') }}" >
        </div>
        
        <div class="form-group">
            <label for="maxram">maxram</label>
            <input type="number" name="maxram" class="form-control" value="{{ old('maxram', $category->maxram ?? '') }}" min="0" step="0.01">
        </div> <div class="form-group">
            <label for="maxcpu">maxcpu</label>
            <input type="number" name="maxcpu" class="form-control" value="{{ old('maxcpu', $category->maxcpu ?? '') }}" min="0" step="0.01">
        </div> <div class="form-group">
            <label for="maxstorage">maxstorage</label>
            <input type="number" name="maxstorage" class="form-control" value="{{ old('maxstorage', $category->maxstorage ?? '') }}" min="0" step="0.01">
        </div> <div class="form-group">
            <label for="maxdb">maxdb</label>
            <input type="number" name="maxdb" class="form-control" value="{{ old('maxdb', $category->maxdb ?? '') }}" min="0" step="0.01">
        </div> <div class="form-group">
            <label for="maxbackups">maxbackups</label>
            <input type="number" name="maxbackups" class="form-control" value="{{ old('maxbackups', $category->maxbackups ?? '') }}" min="0" step="0.01">
        </div> <div class="form-group">
            <label for="maxallocations">maxallocations</label>
            <input type="number" name="maxallocations" class="form-control" value="{{ old('maxallocations', $category->maxallocations ?? '') }}" min="0" step="0.01">
        </div>
        <div class="form-group">
            <label for="maxbyuser">maxbyuser</label>
            <input type="number" name="maxbyuser" class="form-control" value="{{ old('maxbyuser', $category->maxbyuser ?? '') }}" min="0" step="1">
        </div>
        <div class="form-group">
            <label for="stock">stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $category->stock ?? '') }}" min="-1" step="1">
        </div>
        <div class="form-group">
            <label for="ram">RAM (Go)</label>
            <input type="number" name="ram" class="form-control" value="{{ old('ram', $prix->ram ?? '') }}" min="0"       step="0.01"            >
        </div>
        <div class="form-group">
            <label for="cpu">CPU (vCores)</label>
            <input type="number" name="cpu" class="form-control" value="{{ old('cpu', $prix->cpu ?? '') }}" min="0" step="0.01">
        </div>
        <div class="form-group">
            <label for="storage">Stockage (Go)</label>
            <input type="number" name="storage" class="form-control" value="{{ old('storage', $prix->storage ?? '') }}" min="0" step="0.01">
        </div>
        <div class="form-group">
            <label for="db">DB</label>
            <input type="number" name="db" class="form-control" value="{{ old('db', $prix->db ?? '') }}" min="0" step="0.01">
        </div>
        <div class="form-group">
            <label for="backups">Backups</label>
            <input type="number" name="backups" class="form-control" value="{{ old('backups', $prix->backups ?? '') }}" min="0" step="0.01">
        </div>
        <div class="form-group">
            <label for="allocations">Allocations</label>
            <input type="number" name="allocations" class="form-control" value="{{ old('allocations', $prix->allocations ?? '') }}"min=0 step="0.01">
        </div>
        
        <button type="submit" class="btn btn-success">{{ isset($category) ? 'Modifier' : 'Ajouter' }}</button>
    </form>
</div>

