<template>
  <button :type="type" class="btn btn-primary w-100"><slot/></button>
</template>

<script>
export default {
  name: "ButtonBlock",
  props: {
    type: {
      type: String,
      default: 'submit',
    },
  }
}
</script>

<style scoped>

</style>