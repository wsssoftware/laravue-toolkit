<template>
    <div :class="getClass"
         role="alert">
        <h4 v-if="$slots.header" class="alert-heading">
            <slot name="header"/>
        </h4>
        <slot/>


        <button v-if="dismissible" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</template>

<script>
export default {
    name: "Alert",
    props: {
        type: {
            type: String,
            default: 'primary'
        },
        dismissible: {
            type: Boolean,
            default: false
        },
    },
    mounted() {

    },
    computed: {
        getClass() {
            let type = this.type;
            if (!type.includes('alert-')) {
                type = 'alert-' + type;
            }
            return [
                'alert',
                type,
                {'alert-dismissible': this.dismissible},
                {fade: this.dismissible},
                {show: this.dismissible},
            ];
        }
    }
}
</script>

<style scoped>

</style>
