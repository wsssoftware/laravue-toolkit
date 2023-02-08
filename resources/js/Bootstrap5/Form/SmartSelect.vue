<template>
    <div v-bind="parentAttributes">
        <select ref="select" :id="id" :required="required" class="d-none" v-model="form[formDataName]" :multiple="multiple">
            <option v-if="placeholder" value>{{ placeholder }}</option>
            <option v-for="option in availableOptions" :value="option.keyField">{{ option.valueField }}</option>
        </select>
        <label v-if="label" class="form-label" :for="id" v-bind="labelAttributes">{{ label }}</label>
        <div ref="dropdown" class="dropdown" :data-bs-toggle="help ? 'tooltip' : null">
            <InputButton
                @onSelectedChange="onSelectedChange"
                :help="help"
                :selected="form[formDataName]"
                :clearable="clearable"
                :errors="errors"
                :placeholder="placeholder"
                :options="availableOptions"
                :aria-label="ariaLabel"/>

            <DropdownMenu
                @requestToggle="toggleDropdown"
                @onClear="clearSelected"
                @onOptionsChange="onOptionsChange"
                @onSelected="addSelected"
                :addable="addable"
                :clearable="isClearable()"
                :searchable="searchable"
                :multiple="multiple"
                :max-height="maxHeight"
                :options="options"
                :selected="form[formDataName]"/>
        </div>
        <InvalidFeedback :errors="errors"/>
    </div>
</template>

<script>
import {Dropdown, Tooltip} from 'bootstrap/dist/js/bootstrap.esm.min';
import DropdownMenu from "./SmartSelect/DropdownMenu.vue";
import InvalidFeedback from "./InvalidFeedback.vue";
import InputButton from "./SmartSelect/InputButton.vue";

export default {
    inheritAttrs: false,
    name: "SmartSelect",
    components: {
        DropdownMenu,
        InputButton,
        InvalidFeedback,
    },
    props: {
        addable: {type: Boolean, default: false},
        clearable: {type: Boolean, default: false},
        placeholder: String,
        help: String,
        form: {type: Object, required: true},
        formDataName: {type: String, required: true},
        label: String,
        labelAttributes: {type: Object, default: {}},
        maxHeight: {type: Number, default: 360},
        multiple: {type: Boolean, default: false},
        options: {type: Array, required: true},
        parentAttributes: {type: Object, default: {class: 'mb-3'}},
        required: Boolean,
        searchable: {type: Boolean, default: false},
    },
    data() {
        return {
            id: 'smart-select-' + Math.random().toString(16).slice(2),
            availableOptions: this.options,
            hasRequiredError: false,
        };
    },
    computed: {
        ariaLabel() {
            if (this.label) {
                return this.label;
            }
            if (this.placeholder) {
                return this.placeholder;
            }
        },
        errors() {
            if (this.form.errors !== undefined && this.form.errors[this.formDataName] !== undefined) {
                return this.form.errors[this.formDataName];
            }
        },
    },
    beforeMount() {
        if (this.form[this.formDataName] === null) {
            this.form[this.formDataName] = '';
        }
    },
    mounted() {
        if (typeof this.help === 'string') {
            this.tooltip = new Tooltip(this.$refs.dropdown);
        }
        this.dropdown = new Dropdown(this.$refs.dropdown);

        this.$refs.select.addEventListener('invalid', this.onInvalidListener);
    },
    beforeUnmount() {
        if (this.tooltip) {
            this.tooltip.dispose();
            this.tooltip = null;
        }
        if (this.dropdown) {
            this.dropdown.dispose();
        }
        this.$refs.select.removeEventListener('invalid', this.onInvalidListener);
    },
    methods: {
        isClearable() {
            if (!this.clearable) {
                return false;
            }
            if (Array.isArray(this.form[this.formDataName])) {
                return this.form[this.formDataName].length > 0;
            }

            return !!this.form[this.formDataName];
        },
        onInvalidListener(event) {
            if (this.$refs.select.validity.valueMissing) {
                this.form.setError(this.formDataName, 'Selecione um item da lista');
                this.hasRequiredError = true;
            }
        },
        onOptionsChange(newOptions) {
            this.availableOptions = newOptions;
        },
        addSelected(value) {
            if (Array.isArray(this.form[this.formDataName]) && !this.form[this.formDataName].includes(value)) {
                this.form[this.formDataName].push(value);
            } else {
                this.form[this.formDataName] = value;
            }
            if (this.hasRequiredError) {
                this.form.clearErrors(this.formDataName);
                this.hasRequiredError = false;
                this.dropdown.hide();
            }
        },
        clearSelected() {
            if (Array.isArray(this.form[this.formDataName])) {
                this.form[this.formDataName] = [];
            } else {
                this.form[this.formDataName] = '';
            }
        },
        onSelectedChange(newSelected) {
            this.toggleDropdown();
            this.form[this.formDataName] = newSelected
        },
        toggleDropdown() {
            this.dropdown.toggle();
        }
    },
}
</script>

<style scoped lang="scss">
.invalid-feedback {
    display: block !important;
    ul {
        color: inherit;
    }
}
</style>
