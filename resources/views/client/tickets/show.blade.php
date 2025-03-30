<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ticket') }} #{{ $ticket->id }}: {{ $ticket->title }}
            </h2>
            <span class="px-4 py-1 text-sm rounded-lg 
                @if ($ticket->status == 'open') bg-green-500 text-white 
                @else bg-red-500 text-white @endif">
                {{ ucfirst($ticket->status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Détails du ticket</h3>
                        <p class="text-gray-800 dark:text-gray-200"><strong>Titre : </strong>{{ $ticket->title }}</p>
                        <p class="text-gray-800 dark:text-gray-200"><strong>Description :</strong> {{ $ticket->description }}</p>
                    </div>

                    <div class="messages mt-6 space-y-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Messages</h4>
                        @foreach ($messages as $message)
                            <div class="rounded-lg p-4 shadow-md 
                                @if ($message->user->name == Auth::user()->name) bg-green-100 dark:bg-green-900 
                                @else bg-gray-100 dark:bg-gray-700 @endif">
                                <div class="flex items-center justify-between">
                                    <strong class="text-sm text-gray-800 dark:text-gray-200 capitalize" >{{ $message->user->name }}</strong>
                                    <span class="text-xs text-gray-500">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">{{ $message->message }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if ($ticket->status == 'open')
                        <form method="POST" action="{{ route('tickets.message', $ticket->id) }}" class="mt-6">
                            @csrf
                            <div class="flex items-start gap-4">
                                <textarea name="message" class="flex-grow p-3 border  rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800" rows="3" placeholder="Votre message..."></textarea>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <i class="ri-send-plane-fill mr-2"></i> Envoyer
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
