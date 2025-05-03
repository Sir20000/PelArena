@vite(['resources/js/app.js'])

@vite(['resources/css/app.css'])
<meta name="description" content="{{settings('seo')}}">

<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-2xl font-semibold text-center mb-4">Privacy Policy</h2>
    <div class="text-lg text-gray-700">
        <p>
        {!! nl2br(e($privacy)) !!}

</p>
</div>
</div>
