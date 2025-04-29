<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit new : {{ $new->title }}

            </h2>
            </x-slot>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-6 xl:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-500  text-white px-4 py-2 rounded-xl mt-2">
                            <i class="ri-information-line"></i> {{ session('success') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded-xl mt-2">
                            <i class="ri-information-line"></i> {{ session('error') }}
                        </div>
                        @endif
                       


    <form action="{{ route('admin.news.update',$new->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" required value="{{$new->title}}">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="editor" required >{{$new->description}}</textarea>
        </div>
        <div>
            <label for="image">Image</label>
            <input type="file" name="image" id="image">
        </div>
        <button type="submit">update</button>
    </form>
                        </div>
                        </div>
                        </div>
      
</x-app-layout>
