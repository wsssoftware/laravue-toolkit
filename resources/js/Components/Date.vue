<template>
  <time :datetime="timestamp">
    {{ formatted }}
  </time>
</template>

<script>

export default {
  name: "Datetime",
  props: {
    date: {
      required: true,
      type: String,
    },
  },
  computed: {
    timestamp() {
      return new Date(this.date).toISOString().slice(0, 10);
    },
    formatted() {
      return new Date(this.date).toLocaleDateString('pt-BR', {
        year: 'numeric',
        month: "short",
        day: "numeric"
      });
    },
  }
}
</script>

<style scoped>

</style>
