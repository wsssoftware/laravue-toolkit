<template>
    <div v-bind="parentAttributes">
        <label v-if="label" class="form-label" :for="id">{{ label }}</label>
        <div :class="['input-group', {'is-invalid': errors}]">
            <slot name="before"/>
            <IntlNumberInput
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
                type="text"
                inputmode="numeric"
                :options="numberOptions"
                v-model="form[formDataName]"/>
            <slot name="after"/>
        </div>
        <InvalidFeedback :errors="errors"/>
    </div>
</template>

<script>
import {Tooltip} from 'bootstrap/dist/js/bootstrap.esm.min';
import InvalidFeedback from "./InvalidFeedback.vue";
import IntlNumberInput from '../../Components/Form/IntlNumberInput/IntlNumberInput.vue';
import NumberPresets from '../../Components/Form/IntlNumberInput/NumberPresets'

export default {
    name: "NumberDefault",
    inheritAttrs: false,
    components: {
        InvalidFeedback,
        IntlNumberInput,
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
        parentAttributes: {
            type: Object,
            default: {class: 'mb-3'},
        },
        placeholder: String,
        required: Boolean,
        readonly: Boolean,
        locale: {
            type: String,
            default: 'pt-BR',
        },
        options: {
            type: [Object, String],
            default: {},
            validator: function (value) {
                return typeof value === 'object' || Object.keys(NumberPresets).includes(value);
            }
        }
    },
    computed: {
        numberOptions() {
            return typeof this.options === 'object' ? this.options : NumberPresets[this.options]();
        },
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
            id: 'input-' + Math.random().toString(16).slice(2),
        };
    },
    mounted() {
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
