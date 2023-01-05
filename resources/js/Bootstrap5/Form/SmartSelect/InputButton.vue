<template>
    <button
        type="button"
        v-bind="$attrs"
        :aria-label="ariaLabel"
        :class="['form-select', {'is-invalid': errors}, {clearable: clearable}]"
        data-bs-toggle="dropdown"
        :title="help">
        <template v-if="Array.isArray(selected) && selected.length > 0">
            <Tag v-for="option in getOptions()" :option="option" :key="option.keyField" @onRemove="removeTag"/>
        </template>
        <template v-else-if="!Array.isArray(selected) && !!selected">
            {{ getValue() }}
        </template>
        <span v-else class="ss-placeholder" v-html="placeholder"></span>
    </button>
</template>

<script>
import Tag from "./Tag.vue";

export default {
    name: "InputButton",
    components: {
        Tag,
    },
    props: {
        ariaLabel: String,
        help: String,
        placeholder: {type: String, default: '&nbsp;'},
        selected: String|Array,
        options: Array,
        clearable: {type: Boolean, required: true},
        errors: Array|String,
    },
    emits: ['onSelectedChange'],
    methods: {
        getValue() {
            let labels = [];
            if (Array.isArray(this.selected)) {
                this.options.forEach(option => {
                    if (this.selected.includes(option.keyField)) {
                        labels.push(option.valueField);
                    }
                });
                return labels;
            }
            let option = this.options.find(option => option.keyField === this.selected);
            return option.valueField;
        },
        getOptions() {
            let options = [];
            this.options.forEach(option => {
                if (this.selected.includes(option.keyField)) {
                    options.push(option);
                }
            });
            return options;
        },
        removeTag(option) {
            this.$emit('onSelectedChange', this.selected.filter(selected => selected !== option.keyField));
        }
    }
}
</script>

<style lang="scss" scoped>
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/mixins";

$clear-icon-width: .625rem;

button.form-select {
    padding-left: $form-select-padding-x;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .25rem;
    text-align: left;

    .ss-placeholder {
        color: $input-placeholder-color;
    }

    &.show {
        border-color: $form-select-focus-border-color;
        outline: 0;
        @if $enable-shadows {
            @include box-shadow($form-select-box-shadow, $form-select-focus-box-shadow);
        } @else {
            box-shadow: $form-select-focus-box-shadow;
        }
    }

    &.clearable {
        padding-right: add($form-select-indicator-padding + (calc($form-select-padding-x / 2)), $clear-icon-width);
    }

    &.form-select-sm {
        padding-left: $form-select-padding-x-sm;

        &.clearable {
            padding-right: add($form-select-indicator-padding + (calc($form-select-padding-x-sm / 2)), $clear-icon-width);
        }
    }

    &.form-select-lg {
        padding-left: $form-select-padding-x-lg;

        &.clearable {
            padding-right: add($form-select-indicator-padding + (calc($form-select-padding-x-lg / 2)), $clear-icon-width);
        }
    }
    &.form-select-sm .multiselect-tag {
        height: auto;
        line-height: inherit;
    }
    &.form-select-lg .multiselect-tag {
        height: calc(#{$form-select-line-height} * #{$font-size-lg});
        line-height: calc(#{$form-select-line-height} * #{$font-size-lg});
    }
}
</style>
