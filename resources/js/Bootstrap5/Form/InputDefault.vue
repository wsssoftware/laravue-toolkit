<template>
    <div v-bind="parentAttributes">
        <label v-if="label" class="form-label" :for="id">{{ label }}</label>
        <input
            v-bind="$attrs"
            :aria-label="ariaLabel"
            :autocomplete="autocomplete"
            :autofocus="autofocus"
            :class="['form-control', {'is-invalid': errors}]"
            :data-bs-toggle="help ? 'tooltip' : null"
            :id="id"
            :placeholder="placeholder"
            :required="required"
            :readonly="readonly"
            ref="input"
            :title="help"
            :type="type"
            v-model="form[formDataName]"/>
        <InvalidFeedback :errors="errors"/>
    </div>
</template>

<script>
import {Tooltip} from 'bootstrap/dist/js/bootstrap.esm.min';
import MaskInput from "../../Utils/MaskInput";
import InvalidFeedback from "./InvalidFeedback.vue";

export default {
    inheritAttrs: false,
    name: "InputDefault",
    components: {
        InvalidFeedback,
    },
    props: {
        autocomplete: String,
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
        mask: {
            type: String,
            validator(value) {
                return Object.keys(MaskInput).includes(value)
            },
        },
        parentAttributes: {
            type: Object,
            default: {class: 'mb-3'},
        },
        placeholder: String,
        required: Boolean,
        readonly: Boolean,
        type: {
            type: String,
            default: 'text',
        },
    },
    computed: {
        ariaLabel() {
            if (this.label) {
                return this.label;
            }
            if (this.placeholder) {
                return this.placeholder;
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
            imask: null,
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
        if (this.mask) {
            this.imask = MaskInput[this.mask](this.$refs.input);
        }
    },
    unmounted() {
        if (this.tooltip) {
            this.tooltip.dispose();
        }
        if (this.imask) {
            this.imask.destroy();
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
