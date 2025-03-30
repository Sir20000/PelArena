<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }}</title>
</head>
<body>

    <h1>{{ $news->title }}</h1>
    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" width="500">
    <p>{{ $news->description }}</p>

</body>
</html>
