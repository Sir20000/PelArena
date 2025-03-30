<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket') }} #{{ $ticket->id }}:  {{ $ticket->title }}<br>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container space-y-6">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-lg"><strong>Description :</strong> {{ $ticket->description }}</p>
                            <div class="p-2 @if ($ticket->status == 'open') bg-green-500 @else bg-red-500 @endif text-white rounded-lg max-w-xs text-center">
                                <strong>Statut :</strong> {{ ucfirst($ticket->status) }}
                            </div>
                        </div>

                        <div class="messages space-y-4 bg-gray-700 p-4 rounded-lg">
                            @foreach ($messages as $message)
                                <div class="message @if ($message->user->name == Auth::user()->name) bg-green-500 @else bg-gray-400 @endif rounded-lg p-4 max-w-3xl">
                                    <strong>{{ $message->user->name }}</strong>
                                    <span class="text-sm text-gray-600">({{ $message->created_at->format('d/m/Y H:i') }})</span>
                                    <p class="mt-2">{{ $message->message }}</p>
                                </div>
                            @endforeach
                        </div>
                        @if(auth()->user() && auth()->user()->hasAccess('admin.tickets.message'))

                        @if ($ticket->status == 'open')
                            <form method="POST" action="{{ route('admin.tickets.message', $ticket->id) }}" class="flex items-start mt-4">
                                @csrf
                                <textarea name="message" class="flex-grow form-control rounded-lg border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 p-3 mr-4 resize-none" rows="1" placeholder="Votre message..."></textarea>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md min-w-[50px]">
                                    <i class="ri-send-plane-fill mr-2"></i>Envoyer
                                </button>
                            </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
