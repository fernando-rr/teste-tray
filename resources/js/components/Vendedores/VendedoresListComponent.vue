<template>
    <div class="p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none focus:outline focus:2 focus:red-500 w-100">
        <div v-if="saveComponentOpened">
            <model-save :model="vendedorSave" :show="saveComponentOpened" @update:show="getVendedores()" title="Vendedor"
                        :service="vendedoresService" @validation-error="validateFormErrors($event)" :validations="validations">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nome</span>
                        </div>

                        <input type="text" class="form-control" :class="{'is-invalid': validationErrors?.nome?.$error}" placeholder="Digite seu nome" name="nome" v-model="vendedorSave.nome" />
                        <div class="invalid-feedback" v-if="validationErrors?.nome?.$error">Nome inválido</div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">E-mail</span>
                        </div>

                        <input type="text" class="form-control" :class="{'is-invalid': validationErrors?.email?.$error}" placeholder="Digite seu e-mail" name="email" v-model="vendedorSave.email" />
                        <div class="invalid-feedback" v-if="validationErrors?.email?.$error">E-mail inválido</div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Comissão (%)</span>
                        </div>

                        <input type="text" class="form-control" :class="{'is-invalid': validationErrors?.comissao?.$error}" placeholder="Digite o valor da comissão" name="comissao" v-model="vendedorSave.comissao" />
                        <div class="invalid-feedback" v-if="validationErrors?.comissao?.$error">Comissão inválida</div>
                    </div>
                </div>
            </model-save>
        </div>
        <div v-else>
            <div class="d-flex justify-content-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Vendedores</h2>

                <button type="button" class="btn btn-primary" @click="novoVendedor()">Adicionar</button>
            </div>

            <div class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed d-flex">
                <table class="table w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Comissão</th>
                        </tr>
                    </thead>
                    <tbody v-if="vendedoresPage">
                        <tr class="cursor-pointer" @click="editar(vendedor)" v-for="vendedor in vendedoresPage.data">
                            <td>{{vendedor.id}}</td>
                            <td>{{vendedor.nome}}</td>
                            <td>{{vendedor.email}}</td>
                            <td>{{vendedor.comissao}}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <paginate
                v-model="vendedoresPage.current_page"
                v-if="vendedoresPage"
                :page-count="vendedoresPage.last_page"
                :page-range="3"
                :margin-pages="2"
                :click-handler="getVendedores"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'"
            >
            </paginate>
        </div>
    </div>
</template>

<script>
import VendedoresService from '../../services/VendedoresService';
import Paginate from 'vuejs-paginate-next';
import VendedorModel from "../../models/VendedorModel";
import {minValue, required, minLength, maxLength, email} from "@vuelidate/validators";
import ModelSaveComponent from "../ModelSaveComponent.vue";
import VendaModel from "../../models/VendaModel";

export default {
    data() {
        return {
            vendedoresPage: null,
            saveComponentOpened: false,
            vendedorSave: new VendedorModel(),
            vendedoresService: new VendedoresService(),
            validationErrors: null,
            validations: {
                nome: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(255),
                },
                email: {
                    required,
                    email
                },
                comissao: {
                    required,
                    minValue: minValue(1)
                }
            },
        }
    },
    components: {
        paginate: Paginate,
        'model-save': ModelSaveComponent,
    },
    methods: {
        validateFormErrors(e) {
            this.validationErrors = e;
        },

        novoVendedor() {
            // Limpa da memória
            delete this.vendedorSave;

            // Limpa os erros do form
            this.validationErrors = null;

            // Cria uma nova instância
            this.vendedorSave = new VendedorModel();

            // Mostra o componente
            this.saveComponentOpened = true;
        },

        editar(vendedor)
        {
            this.vendedorSave        = vendedor;
            this.saveComponentOpened = true;
        },

        /**
         * Busca os vendedores na API
         * @returns {Promise<void>}
         */
        getVendedores(currentPage = 0) {
            // Para garantir que o componente de edição esteja sempre fechado
            this.saveComponentOpened = false;

            return this.vendedoresService.getPage({
                per_page: 5,
                page: currentPage,
            })
            .then(response => {
                this.vendedoresPage = response;
            })
            .catch(error => {
                console.log('There was an error:', error.response)
            })
        }
    },
    created() {
        this.getVendedores();
    }
}
</script>
