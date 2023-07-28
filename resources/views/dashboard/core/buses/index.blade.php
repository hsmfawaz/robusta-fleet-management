<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            <span>{{ __('Buses') }}</span>
            <a href="{{ route('core.buses.create') }}" class="btn btn-sm btn-primary ">{{ __('New Bus') }}</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-datatable :datatable="$dataTable"/>
            </div>
        </div>
    </div>

</x-app-layout>
