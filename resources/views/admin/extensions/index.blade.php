<x-app-layout>
<h1>Liste des Extensions</h1>
    <table border="1" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Nom de l'Extension</th>
                <th>Auteur</th>
                <th>Version</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($extensions as $key => $meta)
            <tr>
                <td>{{ $meta['name'] }}</td>
                <td>{{ $meta['author'] }}</td>
                <td>{{ $meta['version'] }}</td>
                <td>{{ $meta['description'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>