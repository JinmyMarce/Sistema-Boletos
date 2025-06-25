<x-main-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-4">Editar Evento</h2>
            
            <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título del Evento</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="4" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $event->description) }}</textarea>
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Ubicación</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="event_date" class="block text-sm font-medium text-gray-700">Fecha y Hora del Evento</label>
                    <input type="datetime-local" name="event_date" id="event_date" 
                        value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Precio (S/.)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" step="0.01" min="0" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700">Capacidad (opcional)</label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}" min="1"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Evento (dejar en blanco para mantener la actual)</label>
                    @if ($event->image_path)
                        <div class="mt-2">
                            <img src="{{ Storage::url($event->image_path) }}" alt="Imagen actual" class="h-32 w-auto">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('events.show', $event) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Actualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-main-layout> 