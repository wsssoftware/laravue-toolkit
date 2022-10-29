<template>
  <div class="progress">
    <div
        v-if="!showPercent"
        class="progress-bar"
        role="progressbar"
        :style="style"
        :aria-valuenow="percentCurrent"
        :aria-valuemin="0"
        :aria-valuemax="100"></div>
    <div
        v-if="showPercent"
        class="progress-bar"
        role="progressbar"
        :style="style"
        :aria-valuenow="percentCurrent"
        :aria-valuemin="0"
        :aria-valuemax="100">
      {{ Intl.NumberFormat('pt-BR', {maximumFractionDigits: 2}).format(percentCurrent) }}%
    </div>
  </div>
</template>

<script>
export default {
  name: "Progress",
  props: {
    showPercent: {
      type: Boolean,
      default: false,
    },
    current: {
      type: [String, Number],
      default: "0",
    },
    min: {
      type: [String, Number],
      default: "0",
    },
    max: {
      type: [String, Number],
      default: "100",
    },
  },
  computed: {
    style() {
      return 'width: ' + this.percentCurrent + '%';
    },
    percentCurrent() {
      let percent = (this.current / (this.max - this.min)) * 100;
      return percent > 100 ? 100 : percent;
    },
  }
}
</script>

<style scoped>

</style>