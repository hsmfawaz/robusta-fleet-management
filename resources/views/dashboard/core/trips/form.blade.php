<x-form :model="$model ?? null" route="core.trips" :title="__('Trip')">
    <div class="row">
        <x-form.select :options="$buses" name="bus_id" label="Bus" :value="$model?->bus_id ?? null" required/>
    </div>
    <h3 class="font-bold mt-4 text-xl">Stations</h3>
    <p class="italic mb-2 text-gray-400">
        Note: The first station is the start station and the last station is the final
        destination,<br> You can <span class="text-gray-700">drag and drop</span> to order them correctly
    </p>
    <hr>
    @if($errors->has('stations'))
        <div class="alert alert-danger">
            {{  $errors->first('stations') }}
        </div>
    @endif
    <div class="mt-4 bg-gray-100 rounded shadow p-2 flex items-center space-x-4">
        <x-form.select :options="$stations" name="station_selector" label="Station"/>
        <div>
            <button type="button" id="add-new-station" class="btn btn-primary text-white btn-sm"
                    style="background-color: var(--bs-btn-bg) !important;">Add Station
            </button>
        </div>
    </div>

    <div id="vue-app"></div>

    @push('modals')
        <script>
            window.vueData = {
                old_stations: @json($oldStations),
            }
        </script>
        @vite('resources/js/stations_form/index.js')
    @endpush
</x-form>