<x-app-layout>
<h1>Configurer l'extension : {{ ucfirst($extension) }}</h1>

<form method="POST" action="{{ route('admin.extensions.config.save', $extension) }}">
    @csrf

    @foreach($fields as $field)
        <div>
            <label>{{ $field['label'] }}</label>
            <input
                type="{{ $field['type'] }}"
                name="{{ $field['key'] }}"
                value="{{ old($field['key'], $values[$field['key']] ?? '') }}"
            >
        </div>
    @endforeach

    <button type="submit">Enregistrer</button>
</form></x-app-layout>