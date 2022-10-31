<template>
    <div class="ss-tag">
        {{ option.valueField }}
        <a @click="$emit('onRemove', option)" href="javascript:void(0);">
            <svg class="ss-tag-remove" width="14" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"></path>
            </svg>
        </a>

    </div>
</template>

<script>
export default {
    name: "Tag",
    props: {
        option: {type: Object, required: true}
    },
    emits: ['onRemove'],
}
</script>

<style lang="scss" scoped>
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/mixins";
.ss-tag {
    background-color: $secondary;
    color: $light;
    padding-left: add(.5rem, 14px);
    padding-right: .5rem;
    border-radius: $border-radius;
    height: calc(#{$form-select-line-height} * #{$font-size-base});
    line-height: calc((#{$form-select-line-height} * #{$font-size-base}) - 1px);
    position: relative;


    .ss-tag-remove {
        position: absolute;
        left: .25rem;
        top: 50%;
        margin-top: -7px;
        color: rgba($light, .35);
        @include transition(color .15s ease-in-out);
        &:hover {
            color: $light;
        }
    }

}


</style>
