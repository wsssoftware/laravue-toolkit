<template>
    <div :class="divClass" role="alert">
        <button v-if="dismissable" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4 v-if="title" class="alert-heading">
            <i v-if="faIcon" :class="faIcon + ' ' + faType"></i>
            {{ title }}
        </h4>
        <i v-if="faIcon && title === false" :class="faIcon + ' ' + faType"></i> <slot/>
        <hr v-if="footer">
        <p v-if="footer" class="mb-0">{{ footer }}</p>
    </div>
</template>

<script>
export default {
    name: "Alert",
    props: {
        dismissable: {
            type: Boolean,
            default: false,
        },
        faIcon: [String, Boolean],
        faType: String,
        title: [String, Boolean],
        footer: [String, Boolean],
        type: {
            type: String,
            default: "primary",
        }
    },
    computed: {
        divClass() {
            let dismiss = '';
            if (this.dismissable) {
                dismiss = ' alert-dismissible fade show';
            }
            let type = this.type.includes('alert-') ? this.type : 'alert-' + this.type;
            return 'alert ' + type + dismiss;
        }
    }
}
</script>

<style scoped>
</style>
