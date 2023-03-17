import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp, Link, Head} from '@inertiajs/vue3';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import '@sweetalert2/theme-dark/dark.css';
import "v3-infinite-loading/lib/style.css";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        let page = pages[`./Pages/${name}.vue`]
        if (page.default.layout === undefined) {
            page.default.layout = AuthenticatedLayout
        }
        return page;
    },
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el);
    },
    title: title => title ? `${title} - ${appName}` : appName,
    progress: {
        color: '#4B5563',
        showSpinner: true,
    },
});

