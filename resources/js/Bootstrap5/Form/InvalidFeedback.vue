<template>
    <div v-if="hasErrors" class="invalid-feedback">
        <template v-if="typeof errors === 'string'">{{ errors }}</template>
        <ul class="mb-0 ps-4" v-else>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "InvalidFeedback",
    props: {
        errors: Array|String
    },
    computed: {
        hasErrors() {
            if (Array.isArray(this.errors)) {
                return this.errors.length > 0;
            }
            return !!this.errors;
        }
    }
}
</script>

<style scoped>

</style>
