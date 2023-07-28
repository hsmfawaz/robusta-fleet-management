<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            <span>{{ $model ? "Edit" : "Create" }}  {{ $title }}</span>
            <div>
                <button form="model-form" class="btn btn-sm btn-primary ">{{ __('Save Data') }}</button>
                <a href="{{ route($route.".index") }}" class="btn btn-sm btn-secondary ">{{ __('Back') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <form id="model-form" action="{{ $model ? route($route.'.update',$model) : route($route.'.store') }}"
                      method="post">
                    @csrf
                    @method($model ? 'PUT' :"POST")
                    {{ $slot }}
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
