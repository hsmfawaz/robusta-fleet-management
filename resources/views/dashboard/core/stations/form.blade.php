<x-form :model="$model ?? null" route="core.stations" :title="__('Station')">
    <div class="row">
        <x-form.input name="name" label="Name" :value="$model?->name" required/>
    </div>
</x-form>