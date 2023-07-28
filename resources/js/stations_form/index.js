import {createApp} from 'vue'

import StationsForm from './StationsForm.vue'
import VueSortable from "vue3-sortablejs";

createApp(StationsForm)
    .use(VueSortable)
    .mount('#vue-app')