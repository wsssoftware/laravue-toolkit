<template>
  <component
      ref="btn"
      :is="getTag"
      :aria-label="ariaLabel"
      :class="[
          'btn',
          `btn-${size}`,
          getThemeClass,
          {disabled: getDisabled},
          {active: active}
      ]"
      :role="getRole"
      :type="getType"
      :data-bs-toogle="help"
      :title="help">
    <FaIcon :icon="faIcon" :animation="getFaAnimation" fixed-width :type="faType" v-if="faIcon" />
    <slot/>
  </component>
</template>

<script>
import {Tooltip} from 'bootstrap/dist/js/bootstrap.esm.min';
import {FaIcon} from "laravue-toolkit";

const buttonTypes = ['button', 'submit', 'reset'];

export default {
  name: "BButton",
  components: {
    FaIcon
  },
  props: {
    active: {
      type: Boolean,
      default: false
    },
    ariaLabel: String,
    disabled: {
      type: Boolean,
      default: false
    },
    faIcon: String,
    faType: {
      type: String,
      default: 'solid'
    },
    help: String,
    outline: {
      type: Boolean,
      default: false
    },
    processing: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      validator(value) {
        return ['sm', 'md', 'lg'].includes(value)
      },
      default: 'md',
    },
    tag: {
      type: String,
      validator(value) {
        return ['a', 'button'].includes(value)
      },
    },
    theme: {
      type: String,
      default: 'primary',
    },
    type: {
      type: String,
      validator(value) {
        return buttonTypes.includes(value)
      },
    },
  },
  data() {
    return {
      getType: this.type,
      tooltip: null,
    };
  },
  computed: {
    getTag() {
      if (this.tag) {
        if (this.tag === 'button' && this.type === undefined) {
          this.getType = 'button';
        }
        return this.tag;
      }
      if (buttonTypes.includes(this.type)) {
        return 'button';
      }
      return 'a';
    },
    getRole() {
      if (this.getTag === 'button') {
        return null;
      }
      return 'button';
    },
    getThemeClass() {
      if (this.outline) {
        return `btn-outline-${this.theme}`;
      }
      return `btn-${this.theme}`;
    },
    getFaAnimation() {
      if (this.processing) {
        return 'flip';
      }
      return null;
    },
    getDisabled() {
      return this.disabled || this.processing;
    }
  },
  mounted() {
    if (typeof this.help === 'string') {
      this.$nextTick(() => {
        this.tooltip = new Tooltip(this.$refs.btn);
      });
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

<style scoped>

</style>
