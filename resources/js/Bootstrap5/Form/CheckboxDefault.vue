<template>
    <div class="form-check" v-bind="parentAttributes">
        <input
            v-bind="$attrs"
            ref="input"
            :class="['form-check-input', {'is-invalid': errors}]"
            :id="id"
            :required="required"
            type="checkbox"
            v-model="form[formDataName]">
        <label
            ref="label"
            v-if="hasSlot"
            class="form-check-label"
            :for="id">
            <slot/>
        </label>
        <InvalidFeedback :errors="errors"/>
    </div>
</template>

<script>
import InvalidFeedback from "./InvalidFeedback.vue";

export default {
    inheritAttrs: false,
    name: "CheckboxDefault",
    components: {
        InvalidFeedback,
    },
    props: {
        form: {
            type: Object,
            required: true,
        },
        formDataName: {
            type: String,
            required: true,
        },
        parentAttributes: {
            type: Object,
            default: {class: 'mb-3'},
        },
        required: Boolean,
    },
    data() {
        return {
            id: 'input-' + Math.random().toString(16).slice(2),
        };
    },
    computed: {
        hasSlot() {
            return !!this.$slots.default;
        },
        errors() {
            if (this.form.errors !== undefined && this.form.errors[this.formDataName] !== undefined) {
                return this.form.errors[this.formDataName];
            }
            return null;
        },
    },
}
</script>

<style scoped>

</style>
