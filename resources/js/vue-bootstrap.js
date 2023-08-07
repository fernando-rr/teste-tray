import { createApp } from "vue";
import DashboardComponent from "./components/DashboardComponent.vue";
import VendasListComponent from "./components/Vendas/VendasListComponent.vue";
import VendedoresListComponent from "./components/Vendedores/VendedoresListComponent.vue";
import ModelSaveComponent from "./components/ModelSaveComponent.vue";
import Paginate from "vuejs-paginate-next";
import VueDayjs from 'vue3-dayjs-plugin';

import "bootstrap/dist/css/bootstrap.css";

const app = createApp({
                components: {
                    'dashboard':       DashboardComponent,
                    'vendas-list':     VendasListComponent,
                    'vendedores-list': VendedoresListComponent,
                    'model-save':      ModelSaveComponent,
                }
            })
            .use(Paginate)
            .use(VueDayjs)
            .mount("#app");
