<template>
  <div class="form-toggle-button">
    <input
        type="checkbox"
        class="btn-check"
        :id="id"
        autocomplete="off"
        v-model="form[formDataName]">
    <label ref="label" :title="title" :class="['btn', btnSizeClass, theme]" :for="id">
      <FaIcon :icon="icon" />
      {{ label }}
    </label>
  </div>
</template>

<script>
import {Tooltip} from 'bootstrap/dist/js/bootstrap.esm.min';
import {FaIcon} from "laravue-toolkit";

export default {
  name: "ToggleButton",
  components: {
    FaIcon,
  },
  props: {
    btnSize: {
      type: String,
      default: 'sm',
      validator: (value) => {
        return ['xs', 'sm', 'md', 'lg'].includes(value);
      }
    },
    disabledLabel: {
      type: String,
      required: true,
    },
    disabledTheme: {
      type: String,
      default: 'secondary',
    },
    disabledIcon: {
      type: String,
      default: 'circle-xmark',
    },
    enabledLabel: {
      type: String,
      required: true,
    },
    enabledTheme: {
      type: String,
      default: 'primary',
    },
    enabledIcon: {
      type: String,
      default: 'circle-check',
    },
    form: {
      type: Object,
      required: true,
    },
    formDataName: {
      type: String,
      required: true,
    },
    showIcon: {
      type: Boolean,
      default: true,
    },
    title: String,
  },
  data() {
    return {
      id: 'input-' + Math.random().toString(16).slice(2),
    };
  },
  computed: {
    btnSizeClass() {
      return `btn-${this.btnSize}`;
    },
    icon() {
      return this.form[this.formDataName] ? this.enabledIcon : this.disabledIcon;
    },
    label() {
      return this.form[this.formDataName] ? this.enabledLabel : this.disabledLabel;
    },
    theme() {
      return this.form[this.formDataName] ? `btn-${this.enabledTheme}` : `btn-${this.disabledTheme}`;
    },
  },
  mounted() {
    if (this.title) {
      this.tooltip = new Tooltip(this.$refs.label, {placement: 'left'});
    }
  },
  unmounted() {
    if (this.tooltip) {
      this.tooltip.dispose();
      this.tooltip = null;
    }
  }
}
</script>

<style lang="scss" scoped>
</style>