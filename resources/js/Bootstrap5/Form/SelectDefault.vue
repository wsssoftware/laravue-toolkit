<template>
    <div v-bind="parentAttributes">
        <label v-if="label" class="form-label" :for="id" v-bind="labelAttributes">{{ label }}</label>
        <div class="input-group">
            <slot name="before"/>
            <select
                v-bind="$attrs"
                :aria-label="ariaLabel"
                :autofocus="autofocus"
                :class="['form-select', {'is-invalid': errors}]"
                :data-bs-toggle="help ? 'tooltip' : null"
                :id="id"
                :required="required"
                ref="input"
                :title="help"
                v-model="form[formDataName]">
                <option v-if="empty" value>{{ empty }}</option>
                <option v-for="option in options" :value="option.keyField">{{ option.valueField }}</option>
            </select>
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
    name: "SelectDefault",
    components: {
        InvalidFeedback,
    },
    props: {
        autofocus: Boolean,
        empty: String,
        help: String,
        form: {type: Object, required: true},
        formDataName: {type: String, required: true},
        label: String,
        labelAttributes: {type: Object, default: {}},
        options: {type: Object, required: true},
        parentAttributes: {type: Object, default: {class: 'mb-3'}},
        required: Boolean,
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
            id: 'input-' + Math.random().toString(16).slice(2),
        };
    },
    mounted() {
        if (this.form[this.formDataName] === null) {
            this.form[this.formDataName] = '';
        }
        if (this.$refs.input.hasAttribute('autofocus') && this.$refs.input !== document.activeElement) {
            this.$refs.input.focus();
        }
        if (typeof this.help === 'string') {
            this.$nextTick(() => {
                this.tooltip = new Tooltip(this.$refs.input);
            });
        }
    },
    unmounted() {
        if (this.tooltip) {
            this.tooltip.dispose();
            this.tooltip = null;
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
