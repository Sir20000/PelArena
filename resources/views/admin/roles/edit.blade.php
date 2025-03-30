<div class="container">
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        @php
            $displayedCores = []; // Tableau pour suivre les noyaux déjà affichés
        @endphp

        @foreach ($routes as $route)
            @php
                $nameParts = explode('.', $route->getName());
                if (isset($nameParts[3])) {
                    $action = $nameParts[3];
                    $core = $nameParts[2] . ' ' . $nameParts[1];
                } else {
                    $action = $nameParts[2];  // Par défaut, si le segment n'existe pas
                    $core = $nameParts[1] ;
                }
            @endphp

            <!-- Afficher le H1 une seule fois pour chaque noyau -->
            @if (!in_array($core, $displayedCores))
                <h1>{{ $core }}</h1>
                @php
                    $displayedCores[] = $core; // Ajouter le noyau à la liste des noyaux affichés
                @endphp
            @endif

            <!-- Afficher les cases à cocher pour les actions -->
            <div class="form-check">
                <input type="checkbox" name="permissions[]" value="{{ $route->getName() }}" class="form-check-input">
                <label class="form-check-label">
                    {{ strtoupper($action) }}
                </label>
            </div>
        @endforeach
        @if(auth()->user() && auth()->user()->hasAccess('admin.roles.store'))

        <button type="submit" class="btn btn-success mt-3">Créer</button>
        @endif
    </form>
</div>
