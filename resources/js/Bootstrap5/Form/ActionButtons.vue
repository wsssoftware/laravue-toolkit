<template>
    <ButtonGroup aria-label="Botões de ações do formulário">
        <Button
            fa-icon="floppy-disk"
            :processing="form.processing"
            type="submit">
            {{ submitMessage }}
        </Button>
        <Button
            :disabled="form.processing"
            fa-icon="trash"
            theme="warning"
            type="reset"
            v-if="resetButton">
            Limpar Formulário
        </Button>
        <Button
            @click="onCancel"
            :disabled="form.processing"
            fa-icon="times"
            theme="secondary"
            type="button"
            v-if="cancelButton || cancelConfirm">
            Cancelar
        </Button>
    </ButtonGroup>
</template>

<script>
import ButtonGroup from "../ButtonGroup.vue";
import Button from "../BButton.vue";
import {router} from '@inertiajs/vue3'

export default {
    name: "ActionButtons",
    components: {
        ButtonGroup,
        Button,
    },
    props: {
        form: {
            type: Object,
            required: true,
        },
        submitMessage: {
            type: String,
            default: 'Salvar',
        },
        resetButton: Boolean,
        cancelButton: String,
        cancelConfirm: [String, Boolean],
    },
    methods: {
        onCancel() {
            if (this.cancelConfirm !== false && this.cancelConfirm !== undefined) {
                let message = (typeof this.cancelConfirm === "string" && this.cancelConfirm.length === 0) ||
                this.cancelConfirm === true ?
                    'Você perderá todos os dados não salvos e esta ação não poderá ser desfeita.' :
                    this.cancelConfirm;
                this.$swal({
                    title: 'Você tem certeza?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, cancelar',
                    cancelButtonText: 'Não, vou ficar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.visit(this.cancelButton);
                    }
                })
            } else {
                router.visit(this.cancelButton);
            }

        },
    }
}
</script>

<style scoped>

</style>
