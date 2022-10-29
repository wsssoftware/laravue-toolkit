<template>
    <button
        v-if="clearable"
        type="button"
        class="btn ss-clear"
        @click="$emit('onClear')"
        title="Limpar seleção">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" fill="none">
            <path d="M13 1L0.999999 13" stroke-width="2" stroke="currentColor"></path>
            <path d="M1 1L13 13" stroke-width="2" stroke="currentColor"></path>
        </svg>
    </button>
</template>

<script>
export default {
    name: "ClearButton",
    props: {
        clearable: {type: Boolean, required: true},
    },
    emits: ['onClear'],
}
</script>

<style lang="scss" scoped>
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/mixins";

$clear-icon-width: .625rem;
.ss-clear {
    position: absolute;
    padding: 0;
    border: 0;
    box-shadow: none;
    top: 0;
    bottom: 0;
    right: $form-select-indicator-padding;
    display: flex;
    align-items: center;
    color: $text-muted;
    cursor: pointer;

    &:hover {
        color: inherit;
    }

    svg {
        width: $clear-icon-width;
        height: $clear-icon-width;
    }
}
</style>
