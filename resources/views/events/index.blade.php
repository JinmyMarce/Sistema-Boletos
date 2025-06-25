<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros de categoría -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4">{{ __('Filtrar por categoría') }}</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('events.index') }}" 
                       class="inline-flex items-center px-4 py-2 rounded-md {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('Todos') }}
                    </a>
                    @foreach($categories as $value => $label)
                        <a href="{{ route('events.index', ['category' => $value]) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-md {{ request('category') == $value ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if($events->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <p class="mb-4">{{ __('No hay eventos disponibles en esta categoría.') }}</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            @if($event->image_path)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-6">
                                <div class="mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $categories[$event->category] }}
                                    </span>
                                </div>
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
                                    <p class="text-sm text-gray-500">
                                        {{ __('Por') }} {{ $event->user->name }}
                                    </p>
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