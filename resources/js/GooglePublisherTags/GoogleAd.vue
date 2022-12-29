<template>
    <div class="w-100 d-flex justify-content-center">
        <div :id="id" class="gpt-ad" :style="{'min-height': `${minHeightSize}px`}"></div>
    </div>
</template>

<script>

export default {
    name: "GoogleAd",
    props: {
        id: {
            default: () => {
                return 'ad-' + Math.random().toString(16).slice(2);
            }
        },
        unit: {
            type: String,
            required: true,
        },
    },
    computed: {
        adUnit() {
            return `/${this.$googlead.id}/${this.unit}`;
        },
        mappings() {
            let mappingData = this.$googlead.mappings[this.unit];
            if (mappingData === undefined) {
                return [];
            }
            let mapping = googletag.sizeMapping();
            mappingData.forEach(function (map) {
                mapping = mapping.addSize(map.window, map.sizes)
            });
            return mapping.build();
        },
        sizes() {
            return this.$googlead.sizes[this.unit];
        },
        minHeightSize() {
            let height = null;
            this.sizes.forEach(function (size) {
                if (height === null || size[1] < height) {
                    height = size[1];
                }
            });
            return height;
        }
    },
    beforeCreate() {
        let units = Object.keys(this.$googlead.sizes);
        if (!units.includes(this.unit)) {
            throw new Error(`Unit ${this.unit} is not defined in the config`);
        }
    },
    created() {
        this.setSlot();
    },
    mounted() {
        googletag.cmd.push(() => {
            googletag.display(this.id)
        });
    },
    beforeUnmount() {
        let slot = window.gptAds[this.id];
        if (slot !== undefined) {
            googletag.cmd.push(() => {
                googletag.destroySlots([slot]);
            });
        }
    },
    methods: {
        setSlot() {
            googletag.cmd.push(() => {
                window.gptAds[this.id] = googletag
                    .defineSlot(
                        this.adUnit,
                        this.sizes,
                        this.id
                    )
                    .addService(googletag.pubads())
                    .defineSizeMapping(this.mappings)
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
            });
        },
    },

}
</script>

<style scoped>

</style>
