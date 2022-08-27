<template>
    <div class="table-responsive">
        <TableStructure
            :columns="payload.columns"
            :rows="payload.rows"/>
    </div>
</template>

<script>
import TableStructure from "./TableStructure.vue";
export default {
  name: "Table",
  components: {TableStructure},
  props: {
    payload: {
      type: Object,
      required: true
    },
  }
}
</script>

<style scoped>

</style>