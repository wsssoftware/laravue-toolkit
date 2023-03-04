<template>
    <img
        ref="img"
        v-bind="$attrs"
        :class="[
            {'with-aspect-ratio': aspectRatio !== undefined},
        ]"
        :src="this.defaultImage"
        :data-src="this.finalSrc">
</template>

<script>

import LazyLoad from "vanilla-lazyload";
import defaultImage from "../../img/lazy-empty.webp";
import errorImage from "../../img/lazy-error.webp";
import Color from "../Utils/Colors/Color";
import {mergeProps} from "vue";

export default {
    inheritAttrs: false,
    name: "LazyImage",
    props: {
        adaptiveAspectRatio: {
            type: Boolean,
            default: false
        },
        aspectRatio: {
            type: [String, Array],
        },
        aspectRatioBackground: {
            type: String,
            default: '#ced4da'
        },
        aspectRatioAnimated: {
            type: Boolean,
            default: true
        },
        defaultImage: {
            type: String,
            default: defaultImage
        },
        emptySrc: String,
        errorImage: {
            type: String,
            default: errorImage
        },
        src: String,
    },
    emits: ['applied', 'cancel', 'enter', 'error', 'exit', 'finish', 'loaded', 'loading'],
    data() {
        return {
            finalSrc: null,
            lazyOptions: {
                callback_applied: el => this.$emit('applied', el),
                callback_cancel: el => this.$emit('cancel', el),
                callback_enter: el => this.$emit('enter', el),
                callback_error: this.onLoadError,
                callback_exit: el => this.$emit('exit', el),
                callback_finish: el => this.$emit('finish', el),
                callback_loaded: this.onLoaded,
                callback_loading: el => this.$emit('loading', el),
                class_applied: 'lazy-applied',
                class_entered: 'lazy-entered',
                class_error: 'lazy-error',
                class_exited: 'lazy-exited',
                class_loaded: 'lazy-loaded',
                class_loading: 'lazy-loading',
            },
            props: {},
            fAspectRatio: undefined,
            objectFit: 'contain',
        }
    },
    computed: {
        aspectRatioBackgroundFormatted() {
            let bg = this.aspectRatioBackground;
            let bg2 = new Color(bg).lighten(0.03).hex();
            return `linear-gradient(90deg, ${bg}, ${bg2} 10%, ${bg} 33%)`;
        },
    },
    beforeMount() {
        this.beforeLazyStartSetup();
    },
    beforeUpdate() {
        this.beforeLazyStartSetup();
    },
    mounted() {
        this.lazyImageStart();
    },
    updated() {
        let el = this.lazyImageStart();
        if (el) {
            LazyLoad.load(el, this.lazyOptions);
        }
    },
    methods: {
        beforeLazyStartSetup() {
            if (this.aspectRatio !== undefined) {
                this.fAspectRatio = Array.isArray(this.aspectRatio)
                    ? this.aspectRatio.join('/')
                    : this.aspectRatio;
            }
            if (this.src) {
                this.finalSrc = this.src;
            } else if (this.emptySrc) {
                if (!this.adaptiveAspectRatio) {
                    this.objectFit = 'cover';
                }
                this.finalSrc = this.emptySrc;
            } else {
                this.finalSrc = this.errorImage;
            }
        },
        lazyImageStart() {
            if (this.lazyLoad) {
                this.lazyLoad.destroy();
            }
            this.$refs.img.classList.remove('lazy-applied');
            this.$refs.img.classList.remove('lazy-entered');
            this.$refs.img.classList.remove('lazy-error');
            this.$refs.img.classList.remove('lazy-exited');
            this.$refs.img.classList.remove('lazy-loaded');
            if (this.aspectRatioAnimated) {
                this.$refs.img.classList.add('animated');
            }
            this.lazyLoad = new LazyLoad(this.lazyOptions, [this.$refs.img]);
            return this.$refs.img;
        },
        onLoaded(el) {
            this.$emit('loaded', el);
            if (this.adaptiveAspectRatio) {
                this.setAspectRatioFromElement(el);
            }
            el.classList.remove('animated');
        },
        onLoadError(el) {
            this.$emit('loaded', el);
            el.setAttribute("src", this.errorImage);
            el.classList.remove('animated');
            if (this.adaptiveAspectRatio) {
                this.setAspectRatioFromElement(el);
            } else {
                this.objectFit = 'cover';
            }
        },
        setAspectRatioFromElement(el) {
            this.fAspectRatio = `${el.naturalWidth}/${el.naturalHeight}`;
        }
    },
}
</script>

<style lang="scss" scoped>
img {
    transition: 500ms ease-in-out;
}

.with-aspect-ratio {
    background: v-bind(aspectRatioBackgroundFormatted);
    aspect-ratio: v-bind(fAspectRatio);
    width: 100%;
    object-fit: v-bind(objectFit);
    background-size: 200% 100%;

    &.lazy-loading.animated {
        animation: lazy-shine 2s infinite linear forwards;
    }
}

@keyframes lazy-shine {
    to {
        background-position-x: -200%;
    }
}
</style>
