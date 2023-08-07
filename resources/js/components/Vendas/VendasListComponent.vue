<template>
    <div class="p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none focus:outline focus:2 focus:red-500 w-100">
        <div v-if="saveComponentOpened">
            <model-save :model="vendaSave" :show="saveComponentOpened" @update:show="getVendas()" title="Venda"
                        :service="vendasService" @validation-error="validateFormErrors($event)" :validations="validations">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Vendedor</label>
                    </div>
                    <select class="form-select" id="inputGroupSelect01" :class="{'is-invalid': validationErrors?.id_vendedor?.$error}" v-model="vendaSave.id_vendedor">
                        <option selected>Choose...</option>
                        <option v-for="vendedor in vendedores" :value="vendedor.id">{{ vendedor.nome }}</option>
                    </select>
                    <div class="invalid-feedback" v-if="validationErrors?.id_vendedor?.$error">Vendedor é obrigatório</div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                        </div>
                        <input type="number" class="form-control" :class="{'is-invalid': validationErrors?.valor?.$error}" placeholder="Valor" name="valor" v-model="vendaSave.valor" />
                        <div class="invalid-feedback" v-if="validationErrors?.valor?.$error">Valor inválido</div>
                    </div>
                </div>
            </model-save>
        </div>
        <div v-else>
            <div class="d-flex flex-column gap-4">
                <div class="d-flex justify-content-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Vendas</h2>

                    <button type="button" class="btn btn-primary" @click="novaVenda()">Adicionar</button>
                </div>

                <div class="input-group">
                    <input type="text" @keyup.enter="getVendas()" v-model="query.q_id_email" class="form-control" placeholder="ID / E-mail do vendedor" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" v-on:click="getVendas()" type="button" id="button-addon2">Pesquisar</button>
                    </div>
                </div>

                <div class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed d-flex">
                    <table class="table w-100">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Comissão</th>
                            <th>Valor</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody v-if="vendasPage">
                        <tr class="cursor-pointer" @click="editar(venda)" v-for="venda in vendasPage.data">
                            <td>{{venda.id}}</td>
                            <td>{{venda.vendedor.nome}}</td>
                            <td>{{venda.vendedor.email}}</td>
                            <td>R${{calcularValorComissao(venda)}}</td>
                            <td>R${{venda.valor}}</td>
                            <td>{{$date(venda.created_at).format('DD/MM/YYYY')}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <paginate
                    v-model="vendasPage.current_page"
                    v-if="vendasPage"
                    :page-count="vendasPage.last_page"
                    :page-range="3"
                    :margin-pages="2"
                    :click-handler="getVendas"
                    :prev-text="'Prev'"
                    :next-text="'Next'"
                    :container-class="'pagination'"
                    :page-class="'page-item'"
                >
                </paginate>
            </div>
        </div>
    </div>
</template>

<script>
import VendasService from '../../services/VendasService';
import VendedoresService from '../../services/VendedoresService';
import Paginate from 'vuejs-paginate-next';
import ModelSaveComponent from "../ModelSaveComponent.vue";
import VendaModel from "../../models/VendaModel";
import VendedorModel from "../../models/VendedorModel";
import {email, minValue, required} from "@vuelidate/validators";

export default {
    data() {
        return {
            saveComponentOpened: false,
            vendasPage: null,
            vendedores: null,
            query: {
                q_id_email: ''
            },
            vendaSave: new VendaModel(),
            vendasService: new VendasService(),
            validations: {
                id_vendedor: {
                    required
                },
                valor: {
                    required,
                    minValue: minValue(1)
                },
            },
            validationErrors: null,
        }
    },
    components: {
        paginate: Paginate,
        'model-save': ModelSaveComponent,
    },
    methods: {
        openModal(modalKey) {
            this.isModalOpen[modalKey] = true;
        },

        validateFormErrors(e) {
            this.validationErrors = e;
        },

        editar(venda)
        {
            this.vendaSave           = venda;
            this.saveComponentOpened = true;
        },

        novaVenda() {
            // Limpa da memória
            delete this.vendaSave;

            // Limpa os erros do form
            this.validationErrors = null;

            // Cria uma nova instância
            this.vendaSave = new VendaModel();

            // Mostra o componente
            this.saveComponentOpened = true;
        },

        /**
         * Busca os vendedores na API
         * Usar paginação para não sobrecarregar
         * @returns {Promise<void>}
         */
        getVendedores() {
            let service = new VendedoresService();

            return service.getPage({
                per_page: 15,
            })
            .then(response => {
                if(response) {
                    this.vendedores = response.data;
                }
            })
            .catch(error => {
                console.log('There was an error:', error.response)
            })
        },

        /**
         * Busca as vendas na API
         * @returns {Promise<void>}
         */
        getVendas(currentPage = 0) {
            // Para garantir que o componente de edição esteja sempre fechado
            this.saveComponentOpened = false;

            return this.vendasService.getPage(Object.assign({
                per_page: 5,
                page: currentPage,
            }, this.query))
            .then(response => {
                this.vendasPage = response;
            })
            .catch(error => {
                console.log('There was an error:', error.response)
            })
        },

        /**
         * Calcula o valor da comissão em reais
         * @param venda
         * @returns {number}
         */
        calcularValorComissao(venda) {
            return ((venda.valor * venda.comissao) / 100).toFixed(2);
        }
    },
    created() {
        this.getVendas();
        this.getVendedores();
    }
}
</script>
