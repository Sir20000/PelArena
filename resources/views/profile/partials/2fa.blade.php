<section class="space-y-6">
<header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('2Af') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Manage your 2af.') }}
        </p>
        <img class="my-4" src="{{ 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&bgcolor=FFFFFF&color=87CEEB&data=' .$qrCodeUrl }}" alt="QR Code">
        <form action="{{ route('2fa.enable') }}" method="POST">
        @csrf
        <input type="hidden" name="secret" value="{{ $secret }}">
        <x-primary-button type="submit" class="btn btn-primary">Enable</x-primary-button>
        <form action="{{ route('2fa.disable') }}" method="POST">
        @csrf
        <x-danger-button type="submit" class="btn btn-primary">Disable</x-danger-button>
    </form>
    

</section >
