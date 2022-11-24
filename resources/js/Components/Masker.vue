<template>
<span>{{ masked }}</span>
</template>

<script>

import StringMasker from '../Utils/Masker/StringMasker'

export default {
    name: "Masker",
    props: {
        value: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
            validator(value) {
                return Object.keys(StringMasker).includes(value)
            }
        },
    },
    computed: {
        masked() {
            return StringMasker[this.type](this.value)
        }
    },
}
</script>

<style scoped>

</style>
