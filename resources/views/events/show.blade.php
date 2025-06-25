<x-main-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    @if ($event->image_path)
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-96 object-cover rounded-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-500">Sin imagen</span>
                        </div>
                    @endif
                </div>
                
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
                        <p class="mt-2 text-sm text-gray-500">Organizado por {{ $event->user->name }}</p>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-900">Detalles del Evento</h3>
                        <dl class="mt-2 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha y Hora</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $event->event_date->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ubicación</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $event->location }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Precio</dt>
                                <dd class="mt-1 text-lg font-bold text-indigo-600">S/. {{ number_format($event->price, 2) }}</dd>
                            </div>
                            @if($event->capacity)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Capacidad</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $event->capacity }} personas</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-medium text-gray-900">Descripción</h3>
                        <div class="mt-2 text-sm text-gray-500 space-y-4">
                            {{ $event->description }}
                        </div>
                    </div>

                    @can('update', $event)
                        <div class="border-t border-gray-200 pt-4 flex space-x-4">
                            <a href="{{ route('events.edit', $event) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Editar Evento
                            </a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este evento?')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    Eliminar Evento
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-main-layout> 