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
import InvalidFeedback from "./InvalidFeedback.vue";
import DateComparator from "./DateComparator";
import {addInertiaFormEvent} from "./index";

export default {
    inheritAttrs: false,
    name: "TimeDefault",
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
        parentAttributes: {
            type: Object,
            default: {class: 'mb-3'},
        },
        placeholder: String,
        required: Boolean,
        readonly: Boolean,
        type: {
            type: String,
            default: 'time',
        },
        comparisonFieldLabel: String,
        gt: String,
        gte: String,
        lt: String,
        lte: String,
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
    created() {
        this.form[this.formDataName] = this.formatDate(this.form[this.formDataName]);
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
        addInertiaFormEvent(this.form);
        document.addEventListener('inertia-submit', this.validate);
    },
    beforeUnmount() {
        if (this.tooltip) {
            this.tooltip.dispose();
        }
        document.removeEventListener('inertia-submit', this.validate);
    },
    methods: {
        formatDate(date) {
            if (!date) {
                return '';
            }
            date = new Date(date);
            let hour = String('' + (date.getHours())).padStart(2, '0');
            let minute = String('' + (date.getMinutes())).padStart(2, '0');
            return `${hour}:${minute}`;
        },
        validate(event) {
            DateComparator.validate(this, event);
        }
    }
}
</script>

<style scoped lang="scss">
.invalid-feedback {
    ul {
        color: inherit;
    }
}
</style>
