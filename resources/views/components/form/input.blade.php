@props(['name','label','col'=>6])
<div class="mb-4 col-md-{{ $col ?? 6 }}">
    <x-label>{{ $label }}</x-label>
    <input name="{{ $name }}" {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 w-full rounded-md shadow-sm']) !!} {{ $attributes }}>
    <x-input-error :for="$name"/>
</div>