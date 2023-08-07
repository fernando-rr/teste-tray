<template>
    <div class="d-flex flex-column gap-4">
        <div class="d-flex justify-content-between">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ model?.id ? 'Editar' : 'Adicionar' }} {{title}}</h2>
            <button type="button" class="btn btn-outline-danger" @click="deleteItem()" v-if="model?.id">Deletar</button>
        </div>

        <form v-if="show" class="form w-100 d-flex flex-column gap-3" @submit.prevent="save">
            <slot></slot>

            <div class="d-flex gap-3 justify-content-end">
                <button type="button" class="btn btn-outline-secondary" @click="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</template>

<script>
import BaseRestService from "../services/BaseRestService";
import useVuelidate from '@vuelidate/core'

export default {
    props: {
        title: String,
        service: {
            type: BaseRestService,
            required: true,
        },
        model: {
            type: Object,
            required: true,
        },
        show: Boolean,
        validations: {
            required: true,
        },
    },
    setup (props, { emit }) {
        const v$ = useVuelidate(props.validations, props.model)
        return { v$ }
    },
    methods: {
        /**
         * Cria um novo registro ou atualiza se já possuir ID
         * @returns {Promise<void>}
         */
        async save() {
            this.v$.$validate();

            if (!this.v$.$error) {
                if (this.service && this.model) {
                    let save = await this.model.id ? this.service.put(this.model) : this.service.post(this.model);

                    save.then(res => {
                        this.closeModal();
                        alert('Salvo com sucesso!');
                    }).catch(error => {
                        alert('Houve um problema ao tentar salvar');
                    })
                }
            } else
                this.$emit('validation-error', this.v$);
        },

        /**
         * Desabilita o componente
         */
        closeModal() {
            this.$emit('update:show', false);
        },

        deleteItem() {
            if(this.model && this.model.id && confirm('Deseja realmente excluir? ~um confirm bonito aqui~'))
            {
                this.service.delete(this.model.id)
                    .then(res => {
                        alert('Deletado com sucesso!');
                        this.closeModal();
                    })
                    .catch(err => {
                        alert('Não foi possível deletar');
                    });
            }
        }
    },

    validations() {
        return this.validationErrors
    },
}
</script>
