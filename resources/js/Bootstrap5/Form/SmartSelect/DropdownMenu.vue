<template>
    <div class="dropdown-menu" style="">
        <div class="d-flex flex-column">
            <SearchInput
                ref="searchInput"
                :addable="addable"
                :options="options"
                :searchable="searchable"
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
        }
    },
    emits: ['onSelected', 'onOptionsChange', 'onClear'],
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
            this.$emit('onSelected', option.keyField);
        },
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
