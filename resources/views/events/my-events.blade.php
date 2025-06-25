<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Eventos Publicados') }}
            </h2>
            <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Crear Nuevo Evento') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($events->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <p class="mb-4">{{ __('Aún no has publicado ningún evento.') }}</p>
                        <a href="{{ route('events.create') }}" class="text-indigo-600 hover:text-indigo-800">
                            {{ __('¡Comienza creando tu primer evento!') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            @if($event->image_path)
                                <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-600 mb-2">{{ Str::limit($event->description, 100) }}</p>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="text-sm font-semibold text-indigo-600">
                                        S/. {{ number_format($event->price, 2) }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-800">
                                        {{ __('Ver detalles') }}
                                    </a>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('events.edit', $event) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('¿Estás seguro de que deseas eliminar este evento?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 