<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publicado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __('¡Bienvenido!') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2">{{ __('Mis Eventos') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('Gestiona tus eventos creados') }}</p>
                            <a href="{{ route('events.my-events') }}" class="mt-3 inline-block text-blue-600 hover:text-blue-800">
                                {{ __('Ver mis eventos →') }}
                            </a>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2">{{ __('Crear Nuevo Evento') }}</h4>
                            <p class="text-sm text-gray-600">{{ __('Comienza a crear un nuevo evento') }}</p>
                            <a href="{{ route('events.create') }}" class="mt-3 inline-block text-blue-600 hover:text-blue-800">
                                {{ __('Crear evento →') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
