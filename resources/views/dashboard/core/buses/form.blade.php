<x-form :model="$model ?? null" route="core.buses" :title="__('Bus')">
    <div class="row">
        <x-form.input name="plate_number" label="Plate Number" :value="$model?->plate_number" required/>
    </div>
</x-form>