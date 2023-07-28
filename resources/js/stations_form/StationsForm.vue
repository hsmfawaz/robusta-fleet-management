<template>
    <div class="my-4 bg-gray-100 p-4 rounded">
        <div v-sortable @end="onOrderChange" :key="list.length">
            <div v-for="(i,idx) in list" :key="i.id"
                 class="bg-white cursor-move p-2 mb-2 items-center flex justify-between flex-wrap">
                <input type="hidden" :name="`stations[${idx}][id]`" :value="i.id">
                <input type="hidden" :name="`stations[${idx}][label]`" :value="i.label">
                <input type="hidden" :name="`stations[${idx}][station_order]`" :value="idx">
                <h2>
                    <span class="text-sm bg-blue-800 text-white rounded px-2 py-1" v-if="idx === 0">Starting</span>
                    <span class="text-sm bg-indigo-800 text-white rounded px-2 py-1"
                          v-if="idx === list.length - 1 && list.length > 1">Ending</span>
                    {{ i.label }}
                </h2>

                <div class="flex flex-wrap space-x-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" :value="idx" name="current_station"
                               :checked="selected === idx"
                               @change="selected = idx"
                               :id="`flexCheckDefault${idx}`">
                        <label class="form-check-label" :for="`flexCheckDefault${idx}`">
                            Current
                        </label>
                    </div>
                    <button @click="removeStation(idx)" type="button"
                            class="rounded px-2 py-1 text-sm bg-red-500 text-white btn-sm">Delete
                    </button>
                </div>
            </div>
        </div>
        <div v-if="list.length === 0" class="text-lg italic text-gray-600">You didnt add any stations yet</div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";

const list = ref([]);
const selected = ref(0);

onMounted(() => {
    list.value = window.vueData.old_stations;
    selected.value = list.value.findIndex(i => i.current_station)
    document.getElementById('add-new-station').addEventListener('click', handleNewStation);
})

function removeStation(idx) {
    $('[name="station_selector"]').find(`option[value="${list.value[idx].id}"]`).removeAttr('disabled');
    list.value.splice(idx, 1);
    $('[name="station_selector"]').trigger('change');
}

function handleNewStation() {
    const selected = $('[name="station_selector"]').select2('data');
    if (selected[0].id === '') {
        //todo alert must select
        return;
    }

    const exist = list.value.find(i => i.id === selected[0].id);
    if (exist) {
        //todo alert already exist
        return;
    }

    list.value.push({
        id: selected[0].id,
        label: selected[0].text
    })

    $(selected[0].element).attr('disabled', 'disabled')
    $('[name="station_selector"]').val(null).trigger('change');
}

function onOrderChange(event) {
    // Remove item from old index
    let item = list.value.splice(event.oldIndex, 1)[0];

    // Insert it at new index
    list.value.splice(event.newIndex, 0, item);
}
</script>