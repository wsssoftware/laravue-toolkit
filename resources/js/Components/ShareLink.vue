<template>
    <a :href="shareUrl"><slot/></a>
</template>

<script>
export default {
    name: "ShareLink",
    props: {
        url: {
            type: String,
            required: true
        },
        title: String,
        via: {
            type: String,
            required: true,
            validator(value) {
                return ['facebook', 'twitter', 'email', 'whatsapp', 'telegram', 'linkedin', 'pinterest'].includes(value)
            },
        }
    },
    computed: {
        shareUrl() {
            let message = this.title ? `${this.title} ${this.url}` : this.url
            switch (this.via) {
                case 'facebook':
                    return `https://www.facebook.com/sharer/sharer.php?u=${this.url}`
                case 'twitter':
                    return `https://www.twitter.com/share?url=${this.url}`
                case 'email':
                    return `mailto:?body=${this.url}`
                case 'whatsapp':
                    return `https://wa.me/?text=${message}`
                case 'telegram':
                    return `https://telegram.me/share/url?url=${this.url}`
                case 'linkedin':
                    return `https://www.linkedin.com/shareArticle?url=${this.url}`
                case 'pinterest':
                    return `https://pinterest.com/pin/create/button/?url=${this.url}`
            }
        }
    }
}
</script>

<style scoped>

</style>
