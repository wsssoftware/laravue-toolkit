<template>
    <div v-bind="parentAttributes">
        <label v-if="label" class="form-label" :for="id">{{ label }}</label>
        <div :class="['input-group', {'is-invalid': errors}]">
            <slot name="before"/>
            <input
                v-bind="$attrs"
                :aria-label="ariaLabel"
                :autofocus="autofocus"
                :class="['form-control', {'is-invalid': errors}]"
                :data-bs-toggle="help ? 'tooltip' : null"
                :id="id"
                :required="required"
                :readonly="readonly"
                ref="input"
                :title="help"
                :type="type"
                @input="form[formDataName] = $event.target.files[0]"/>
            <slot name="after"/>
        </div>
        <InvalidFeedback :errors="errors"/>
    </div>
</template>

<script>
import {Tooltip} from 'bootstrap/dist/js/bootstrap.esm.min';
import InvalidFeedback from "./InvalidFeedback.vue";

export default {
    inheritAttrs: false,
    name: "FileDefault",
    components: {
        InvalidFeedback,
    },
    props: {
        autofocus: Boolean,
        help: String,
        form: {
            type: Object,
            required: true,
        },
        formDataName: {
            type: String,
            required: true,
        },
        label: String,
        parentAttributes: {
            type: Object,
            default: {class: 'mb-3'},
        },
        required: Boolean,
        readonly: Boolean,
        type: {
            type: String,
            default: 'file',
        },
    },
    computed: {
        ariaLabel() {
            if (this.label) {
                return this.label;
            }
            return null;
        },
        errors() {
            if (this.form.errors !== undefined && this.form.errors[this.formDataName] !== undefined) {
                return this.form.errors[this.formDataName];
            }
            return null;
        },
    },
    data() {
        return {
            tooltip: null,
            id: 'input-' + Math.random().toString(16).slice(2),
        };
    },
    mounted() {
        if (this.$refs.input.hasAttribute('autofocus') && this.$refs.input !== document.activeElement) {
            this.$refs.input.focus();
        }
        if (typeof this.help === 'string') {
            this.$nextTick(() => {
                this.tooltip = new Tooltip(this.$refs.input);
            });
        }
    },
    beforeUnmount() {
        if (this.tooltip) {
            this.tooltip.dispose();
        }
    },
}
</script>

<style scoped lang="scss">
.invalid-feedback {
    ul {
        color: inherit;
    }
}
</style>
