@props(['name','label','col'=>6,'options'=>[],'value'=>null])
<div class="col-md-{{ $col ?? 6 }}">
    <x-label>{{ $label }}</x-label>
    <select name="{{ $name }}" {!! $attributes->merge(['class' => 'select2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 w-full rounded-md shadow-sm']) !!} {{ $attributes }}>
        <option value=""></option>
        @foreach($options as $key=> $option)
            <option value="{{ $key }}" @selected($key === $value)>{{ $option }}</option>
        @endforeach
    </select>
    <x-input-error :for="$name"/>

    @once
        @push('header')
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
                  integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
                  crossorigin="anonymous" referrerpolicy="no-referrer"/>
        @endpush
        @push('modals')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
                    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
                    crossorigin="anonymous" referrerpolicy="no-referrer" type="module"></script>
            <script type="module">
                $(document).ready(function () {
                    $(".select2").select2({
                        allowClear: true,
                        placeholder: "Select an option",
                    });
                });
            </script>
        @endpush
    @endonce
</div>