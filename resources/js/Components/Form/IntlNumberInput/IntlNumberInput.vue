<template>
    <input
        ref="inputRef"
        type="text"
    />
</template>

<script>
/**
 * @see https://dm4t2.github.io/vue-currency-input/guide.html#usage
 */

import { watch } from 'vue'
import { useNumberInput } from './useNumberInput';

export default {
    name: "IntlNumberInput",
    props: {
        modelValue: Number,
        options: {
            type: Object,
            default: {'locale': 'en-US'},
        },
    },
    setup(props) {
        const { inputRef, setOptions, setValue } = useNumberInput(props.options)

        watch(
            () => props.modelValue, // Vue 2: props.value
            (value) => {
                setValue(value)
            }
        )

        watch(
            () => props.options,
            (options) => {
                setOptions(options)
            }
        )

        return { inputRef }
    },
}
</script>

<style scoped>

</style>
