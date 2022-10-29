<template>
  <div
      :class="[
          {'btn-group': !vertical},
          {'btn-group-vertical': vertical},
          `btn-group-${size}`
      ]"
      role="group"
      :aria-label="ariaLabel">
    <slot/>
  </div>
</template>

<script>

export default {
  name: "ButtonGroup",
  props: {
    size: {
      type: String,
      validator(value) {
        return ['sm', 'md', 'lg'].includes(value)
      },
      default: 'md',
    },
    vertical: {
      type: Boolean,
      default: false
    },
    ariaLabel: String,
  },
}
</script>

<style scoped>

</style>
