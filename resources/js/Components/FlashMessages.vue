<template>

</template>

<script>
import {useToast} from "vue-toastification";
import "vue-toastification/dist/index.css";
import {router, usePage} from '@inertiajs/vue3'

export default {
  name: "FlashMessages",
  data() {
    return {
      flash_timeout: null,
      toast: useToast(),
      printed: [],
    }
  },
  mounted() {
    router.on('finish', () => {
        this.flash_timeout = setTimeout(this.flash, 500);
    })
    this.flash_timeout = setTimeout(this.flash, 500);
  },
  unmounted() {
    clearTimeout(this.flash_timeout);
  },
  methods: {
    flash() {
      let messages = usePage().props.flash_messages;
      messages.forEach(message => {
        if (this.printed.includes(message.id)) {
          return;
        }
        this.toast(message.message, message);
        this.printed.push(message.id);
      });
    },
  }
}
</script>

<style scoped>

</style>
