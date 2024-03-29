<template>
    <div class="dropdown-menu" style="">
        <div class="d-flex flex-column">
            <SearchInput
                :disabled="options.length === 0 && addable === false"
                ref="searchInput"
                :addable="addable"
                :options="options"
                :searchable="searchable"
                @hasSearch="(value) => hasSearch = value"
                @newOptionCreated="onOptionClick"
                @onOptionsChange="onOptionsChange"/>

            <div :style="{overflow: 'auto', 'max-height': `${maxHeight}px`}">
                <button
                    v-for="option in availableFilteredOptions"
                    :key="option.keyField"
                    :class="['dropdown-item', {'active': isActive(option)}]"
                    @click="onOptionClick(option)"
                    type="button">
                    {{ option.valueField }}
                </button>
            </div>

            <div v-if="options.length === 0 && availableFilteredOptions.length === 0 && !hasSearch" class="ss-no-results">
                Nenhuma opção disponível
            </div>
            <div v-if="options.length === 0 && availableFilteredOptions.length === 0 && hasSearch && addable" class="ss-no-results">
                Pressione <b>enter</b> para criar um novo
            </div>
            <div v-if="availableFilteredOptions.length === 0 && options.length > 0" class="ss-no-results">
                <template v-if="addable">
                    Pressione <b>enter</b> para criar um novo
                </template>
                <template v-else>
                    Nenhum resultado encontrado
                </template>
            </div>
        </div>
    </div>
    <ClearButton
        @onClear="$emit('onClear')"
        :clearable="clearable"/>
</template>

<script>
import ClearButton from "./ClearButton.vue";
import SearchInput from "./SearchInput.vue";

export default {
    name: "DropdownMenu",
    components: {
        ClearButton,
        SearchInput,
    },
    props: {
        addable: {type: Boolean, required: true},
        clearable: {type: Boolean, required: true},
        maxHeight: {type: Number, required: true},
        multiple: {type: Boolean, required: true},
        options: {type: Array, required: true},
        searchable: {type: Boolean, required: true},
        selected: Array|String,
    },
    data() {
        return {
            availableFilteredOptions: this.options,
            hasSearch: false,
        }
    },
    emits: ['onSelected', 'onOptionsChange', 'onClear', 'requestToggle'],
    methods: {
        isActive(option) {
            if (Array.isArray(this.selected)) {
                return this.selected.includes(option.keyField);
            }
            return this.selected === option.keyField;
        },
        onOptionsChange(newFilteredOptions, newOptions) {
            this.availableFilteredOptions = newFilteredOptions;
            this.$emit('onOptionsChange', newOptions);
        },
        onOptionClick(option) {
            this.$refs.searchInput.clearInput();
            if (this.multiple && this.isActive(option)) {
                this.$emit('requestToggle');
                return;
            }
            this.$emit('onSelected', option.keyField);
        },
        requestSearchFocus() {
            this.$refs.searchInput.$el.focus();
        }
    }
}
</script>

<style lang="scss" scoped>
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/mixins";

.dropdown-menu {
    padding: calc($form-select-padding-x / 2);
    width: 100%;

    > .flex-column {
        gap: calc($form-select-padding-x / 2);
    }
}

.form-select-sm + .dropdown-menu {
    padding: calc($form-select-padding-x-sm / 2);
    @include font-size($form-select-font-size-sm);
}

.form-select-lg + .dropdown-menu {
    padding: calc($form-select-padding-x-lg / 2);
    @include font-size($form-select-font-size-lg);
}

// No results
.ss-no-results {
    padding: $dropdown-item-padding-y calc($form-select-padding-x / 2);
}

.form-select-sm + .dropdown-menu .ss-no-results {
    padding: subtract($dropdown-item-padding-y, 1px) calc($form-select-padding-x-sm / 2);
}

.form-select-lg + .dropdown-menu .ss-no-results {
    padding: $dropdown-item-padding-y calc($form-select-padding-x-lg / 2);
}
</style>
