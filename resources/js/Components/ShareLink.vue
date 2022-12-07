<template>
<a href="javascript:void(0)" @click="trigger" role="link">
    <slot/>
</a>
</template>

<script>
import AvailableNetworks from './networks'

const jsWindow = typeof window !== 'undefined' ? window : null;
let popupWindow = undefined;

export default {
    name: "ShareLink",
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
        popup: {
            type: Object,
            default: () => ({
                width: 626,
                height: 436
            })
        }
    },
    data () {
        return {
            popupTop: 0,
            popupLeft: 0,
        }
    },
    computed: {
        /**
         * Create the url for sharing.
         */
        shareLink () {
            return AvailableNetworks[this.network](
                this.url,
                this.title,
                this.description,
                this.quote,
                this.encodedHashtags,
                this.twitterUser,
                this.media
            )
        },
        encodedHashtags () {
            if (!this.hashtags) {
                return undefined;
            }
            if (this.network === 'facebook' && this.hashtags.length > 1) {
                return '%23' + this.hashtags[0]
            }
            return this.hashtags
        }
    },
    methods: {
        resizePopup () {
            const width = jsWindow.innerWidth || (document.documentElement.clientWidth || jsWindow.screenX)
            const height = jsWindow.innerHeight || (document.documentElement.clientHeight || jsWindow.screenY)
            const systemZoom = width / jsWindow.screen.availWidth
            this.popupLeft = (width - this.popup.width) / 2 / systemZoom + (jsWindow.screenLeft !== undefined ? jsWindow.screenLeft : jsWindow.screenX)
            this.popupTop = (height - this.popup.height) / 2 / systemZoom + (jsWindow.screenTop !== undefined ? jsWindow.screenTop : jsWindow.screenY)
        },
        share () {
            this.resizePopup()
            popupWindow = jsWindow.open(
                this.shareLink,
                'sharer-' + this.network,
                ',height=' + this.popup.height +
                ',width=' + this.popup.width +
                ',left=' + this.popupLeft +
                ',top=' + this.popupTop +
                ',screenX=' + this.popupLeft +
                ',screenY=' + this.popupTop
            )
            if (!popupWindow) return
            popupWindow.focus()
        },
        touch () {
            window.open(this.shareLink, '_blank')
        },
        trigger() {
            if (this.shareLink.substring(0, 4) === 'http') {
                this.share();
            } else {
                this.touch();
            }
        }
    }
}
</script>

<style scoped>

</style>
