import './bootstrap';
import { createApp } from 'vue';


import Formstepsmaster from './components/FormStepsMaster.vue'
import Formstepsexcellence from './components/FormStepsExcellence.vue'
import Formstepsbachelier from './components/FormStepsBachelier.vue'
import Formstepsbacacceouvert from './components/FormStepsBacAcceOuvert.vue'
import Formquick from './components/FormQuick.vue'
import Formfilierechoisen from './components/FormFiliereChoisen.vue'
import ErrorPopup  from './components/ErrorPopup.vue'
const app = createApp({
    components: {
        Formstepsmaster,
        Formstepsexcellence,
        Formstepsbachelier,
        Formstepsbacacceouvert,
        Formquick,
        Formfilierechoisen,
        ErrorPopup
    },
});

app.mount('#app');
