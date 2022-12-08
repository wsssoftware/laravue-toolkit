<template>
    <ShareLink
        class="btn share-button"
        :network="network"
        :url="url"
        :title="title"
        :description="description"
        :quote="quote"
        :hashtags="hashtags"
        :twitterUser="twitterUser"
        :media="media">
        <div class="share-icon">
            <FaIcon :icon="icon" :type="iconType"/>
        </div>
        {{ name }}
    </ShareLink>
</template>

<script>

import ShareLink from '../Components/ShareLink.vue';
import AvailableNetworks, {info} from "../Components/networks";
import {LightenDarkenColor} from "../Utils";
import {FaIcon} from "../index";
import chroma from "chroma-js";

export default {
    name: "ShareButton",
    components: {
        ShareLink,
        FaIcon,
    },
    props: {
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
            LightenDarkenColor('')
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
@import "bootstrap/scss/functions";
@import "bootstrap/scss/variables";

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

    .share-icon {
        float: left;
    }
}
</style>
