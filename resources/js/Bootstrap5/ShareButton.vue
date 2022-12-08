<template>
    <ShareLink
        :class="['btn', 'share-button', 'share-button-' + network, {'auto-hide': hideStringOnSmallScreen}]"
        :network="network"
        :url="url"
        :title="title"
        :description="description"
        :quote="quote"
        :hashtags="hashtags"
        :twitterUser="twitterUser"
        :media="media">
        <div class="share-icon d-flex justify-content-center align-items-center" :class="[{'d-none d-md-flex': hideStringOnSmallScreen}]">
            <FaIcon :icon="icon" :type="iconType" fixed-width/>
        </div>
        <span :class="[{'d-none d-md-inline-block': hideStringOnSmallScreen}]">{{ name }}</span>

        <FaIcon v-if="hideStringOnSmallScreen" :class="[{'d-inline-block d-md-none': hideStringOnSmallScreen}]" :icon="icon" :type="iconType" fixed-width/>
    </ShareLink>
</template>

<script>

import ShareLink from '../Components/ShareLink.vue';
import AvailableNetworks, {info} from "../Components/networks";
import {FaIcon} from "../index";

export default {
    name: "ShareButton",
    components: {
        ShareLink,
        FaIcon,
    },
    props: {
        hideStringOnSmallScreen: {
            type: Boolean,
            default: true
        },
        network: {
            type: String,
            required: true,
            validate: (value) => {
                return Object.keys(AvailableNetworks).includes(value)
            }
        },
        url: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        description: String,
        quote: String,
        hashtags: Array,
        twitterUser: String,
        media: String,
    },
    data() {
        return {
            baseColor: '#5437e0'
        }
    },
    computed: {
        name() {
            return info[this.network].name;
        },
        icon() {
            return info[this.network].icon;
        },
        iconType() {
            return info[this.network].iconType === 'commom' ? 'solid' : 'brands';
        },
        colors() {
            return info[this.network].colors;
        },
        color() {
            return this.colors.color;
        },
        background() {
            return this.colors.background;
        },
        border() {
            return this.colors.background;
        },
        hoverColor() {
            return this.colors.hoverColor;
        },
        hoverBackground() {
            return this.colors.hoverBackground
        },
        hoverBorder() {
            return this.colors.hoverBorder;
        },
        activeColor() {
            return this.colors.activeColor;
        },
        activeBackground() {
            return this.colors.activeBackground
        },
        activeBorder() {
            return this.colors.activeBorder;
        },
        disabledColor() {
            return this.colors.disabledColor;
        },
        disabledBackground() {
            return this.colors.disabledBackground
        },
        disabledBorder() {
            return this.colors.disabledBorder;
        },
        borderShadowRgb() {
            return this.colors.borderShadowRgb;
        },
    }
}
</script>

<style lang="scss" scoped>
@import "bootstrap/scss/vendor/rfs";
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";
@import "bootstrap/scss/mixins/breakpoints";


.share-button {
    --#{$prefix}btn-color: v-bind(color);
    --#{$prefix}btn-bg: v-bind(background);
    --#{$prefix}btn-border-color: v-bind(border);
    --#{$prefix}btn-hover-color: v-bind(hoverColor);
    --#{$prefix}btn-hover-bg: v-bind(hoverBackground);
    --#{$prefix}btn-hover-border-color: v-bind(hoverBorder);
    --#{$prefix}btn-focus-shadow-rgb: v-bind(borderShadowRgb);
    --#{$prefix}btn-active-color: v-bind(activeColor);
    --#{$prefix}btn-active-bg: v-bind(activeBackground);
    --#{$prefix}btn-active-border-color: v-bind(activeBorder);
    --#{$prefix}btn-active-shadow: #{$btn-active-box-shadow};
    --#{$prefix}btn-disabled-color: v-bind(disabledColor);
    --#{$prefix}btn-disabled-bg: v-bind(disabledBackground);
    --#{$prefix}btn-disabled-border-color: v-bind(disabledBorder);
    position: relative;
    word-wrap: break-word;
    padding-left: calc(var(--#{$prefix}btn-padding-x) * 3);

    &.span {
        word-wrap: break-word;
    }

    @include media-breakpoint-down(md) {
        &.auto-hide {
            padding-left: var(--#{$prefix}btn-padding-x);
        }
    }


    .share-icon {
        position: absolute;
        margin-top: -$btn-border-width;
        margin-bottom: -$btn-border-width;
        margin-left: -$btn-border-width;
        width: calc(var(--#{$prefix}btn-padding-x) * 2.5);
        @include font-size(calc(var(--#{$prefix}btn-font-size) * 1.4));
        line-height: var(--#{$prefix}btn-line-height);
        color: v-bind(background);
        top: 0;
        left: 0;
        bottom: 0;
        text-align: center;
        border-top-left-radius: var(--#{$prefix}btn-border-radius);
        border-bottom-left-radius: var(--#{$prefix}btn-border-radius);
        background: rgba(0,0,0 ,0.3);
    }

    &.share-button-buffer {
        .share-icon {
            background: rgba(255,255,255 ,0.3);
        }
    }
}


.btn-group .share-button:not(:first-child) {
    .share-icon {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
}
</style>
