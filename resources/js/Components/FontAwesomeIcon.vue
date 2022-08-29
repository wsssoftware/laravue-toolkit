<template>
  <i
      :class="[
          {'fa-fw': this.fixedWidth},
          `fa-${this.type}`,
          `fa-${this.icon}`,
          getAnimationClass,
          getSizeClass,
          getRotateClass,
      ]">

  </i>
</template>

<script>
export default {
  name: "FontAwesomeIcon",
  props: {
    animation: {
      type: String,
      default: undefined,
      validator(value) {
        return ['beat', 'fade', 'beat-fade', 'bounce', 'flip', 'shake', 'spin'].includes(value)
      },
    },
    fixedWidth: {
      type: Boolean,
      default: false
    },
    icon: String,
    rotate: {
      type: Number,
      default: 0,
      validator(value) {
        return [0, 90, 180, 270].includes(value)
      },
    },
    size: {
      type: String,
      default: undefined,
      validator(value) {
        return ['1x', '2x', '3x', '4x', '5x', '6x', '7x', '8x', '9x', '10x'].includes(value)
      },
    },
    type: {
      type: String,
      default: 'regular'
    },
  },
  computed: {
    getAnimationClass() {
      if (this.animation === undefined) {
        return null;
      }
      return `fa-${this.animation}`;
    },
    getSizeClass() {
      if (this.size === undefined) {
        return null;
      }
      return `fa-${this.size}`;
    },
    getRotateClass() {
      switch (this.rotate) {
        case 90:
          return 'fa-rotate-90';
        case 180:
          return 'fa-rotate-180';
        case 270:
          return 'fa-rotate-270';
        default:
          return null;
      }
    },
  },
}
</script>

<style scoped>

</style>
