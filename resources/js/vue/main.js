import { createApp } from "vue";

import Oruga from '@oruga-ui/oruga-next'
import VueCookies from 'vue3-cookies'
// import '@oruga-ui/theme-oruga/dist/oruga.min.css'
import '../../css/vue.css'
// import '@oruga-ui/theme-oruga/dist/oruga-full.min.css'
// import "@oruga-ui/theme-oruga/dist/scss/oruga.scss";
// import "@oruga-ui/theme-oruga/dist/scss/theme.scss";
// import '@oruga-ui/theme-oruga/dist/theme.css';
// import '@oruga-ui/theme-oruga/dist/oruga.css';
// import 'theme-oruga/dist/theme.css';
import '/node_modules/@oruga-ui/theme-oruga/dist/theme.css';
import '@mdi/font/css/materialdesignicons.min.css'

import { OButton, OInput, OField, OTable, OModal, OTableColumn, OPagination } from '@oruga-ui/oruga-next';

import axios from "axios";

import App from "./App.vue"

import router from './router'

const app = createApp(App)
app.use(Oruga,).use(router).use(VueCookies)

app.component('o-button', OButton);
app.component('o-input', OInput);
app.component('o-field', OField);
app.component('o-table', OTable);
app.component('o-modal', OModal);
app.component('o-table-column', OTableColumn);
app.component('o-pagination', OPagination);

app.config.globalProperties.$axios = axios
window.axios = axios

app.mount("#app")