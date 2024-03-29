<template>
    <div v-bind="parentAttributes">
        <label v-if="label" class="form-label" :for="id">{{ label }}</label>
        <textarea
            v-bind="$attrs"
            :maxlength="maxLength"
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
            v-model="form[formDataName]"/>
        <div v-if="maxLength" class="form-text">
            <span :class="['float-end', 'fw-bold', {'glow': leghtGreaterOrEqualThan(maxLength * .9)}, getLeghtTextClass()]">
                 {{ Intl.NumberFormat().format(form[formDataName]?.length ?? 0) }}
                /
                {{ Intl.NumberFormat().format(maxLength) }}
            </span>
        </div>

        <InvalidFeedback :errors="errors"/>
    </div>
</template>

<script>
import {Tooltip} from 'bootstrap/dist/js/bootstrap.esm.min';
import InvalidFeedback from "./InvalidFeedback.vue";

export default {
    inheritAttrs: false,
    name: "TextareaDefault",
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
        maxLength: {
            type: Number,
            validator(value) {
                return value > 0
            },
        },
        parentAttributes: {
            type: Object,
            default: {class: 'mb-3'},
        },
        placeholder: String,
        required: Boolean,
        readonly: Boolean,
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
    methods: {
        getLeghtTextClass() {
            if (this.maxLength !== undefined) {
                if (this.leghtGreaterOrEqualThan(this.maxLength)) {
                    return 'text-danger';
                }
                if (this.leghtGreaterOrEqualThan(this.maxLength * 0.9)) {
                    return 'text-warning';
                }
            }
            return null;
        },
        leghtGreaterOrEqualThan(value) {
            return (this.form[this.formDataName]?.length ?? 0) >= value;
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
.glow {
    animation: glow 1s ease infinite alternate;
}

@keyframes glow {
    from {
        opacity: 1.5;
    }
    to {
        opacity: 0.6;
    }
}
</style>
