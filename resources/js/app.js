import './bootstrap';
import '../css/app.css';
import '../css/vue-multiselect.css';
import '../css/custom.css';
import '../css/dataTables.tailwindcss.min.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas);
import { fab } from '@fortawesome/free-brands-svg-icons';
library.add(fab);
import { far } from '@fortawesome/free-regular-svg-icons';
library.add(far);
import { dom } from "@fortawesome/fontawesome-svg-core";
dom.watch();
import { createPinia } from 'pinia'
import VueGoogleMaps from '@fawmi/vue-google-maps'
import VueApexCharts from "vue3-apexcharts";
const pinia = createPinia()

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(VueApexCharts)
            .use(VueGoogleMaps, {
                load: {
                    key: import.meta.env.VITE_API_GOOGLE_MAP,
                    libraries: "places"
                    // language: 'de',
                },
                autobindAllEvents: true,
                })
            .component("font-awesome-icon", FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#5156be',
         // The delay after which the progress bar will appear, in milliseconds...
    delay: 250,


    // Whether to include the default NProgress styles...
    includeCSS: true,

    // Whether the NProgress spinner will be shown...
    showSpinner: true,
    },
});
