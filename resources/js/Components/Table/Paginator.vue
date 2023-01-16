<template>
    <nav class="align-self-center">
        <ul class="pagination">
            <li :class="['page-item',{disabled: this.page === 1}]">
                <button class="page-link" @click="goToPage(1)" role="button">
                    <span class="d-none d-md-block">
                        <FaIcon icon="chevrons-left"/>
                        {{ payload.trans.paginator.first }}
                    </span>
                    <span class="d-block d-md-none"><FaIcon icon="chevrons-left"/></span>
                </button>
            </li>
            <li :class="['page-item',{disabled: this.page === 1}]">
                <button class="page-link" @click="goToPage(this.page - 1)" role="button">
                    <span class="d-none d-md-block">
                        <FaIcon icon="chevron-left"/>
                        {{ payload.trans.paginator.previous }}
                    </span>
                    <span class="d-block d-md-none"><FaIcon icon="chevron-left"/></span>
                </button>
            </li>

            <li class="page-item" v-for="page in previousItems()">
                <button class="page-link" @click="goToPage(page)" role="button">{{ page }}</button>
            </li>

            <li class="page-item active">
                <span class="page-link">{{ Intl.NumberFormat().format(this.page) }}</span>
            </li>

            <li class="page-item" v-for="page in nextItems()">
                <button class="page-link" @click="goToPage(page)" role="button">{{ page }}</button>
            </li>

            <li :class="['page-item',{disabled: this.page === this.last_page}]">
                <button class="page-link" @click="goToPage(this.page + 1)" role="button">
                    <span class="d-none d-md-block">
                        {{ payload.trans.paginator.next }}
                        <FaIcon icon="chevron-right"/>
                    </span>
                    <span class="d-block d-md-none"><FaIcon icon="chevron-right"/></span>
                </button>
            </li>
            <li :class="['page-item',{disabled: this.page === this.last_page}]">
                <button class="page-link" @click="goToPage(this.last_page)" role="button">
                    <span class="d-none d-md-block">
                        {{ payload.trans.paginator.last }}
                        <FaIcon icon="chevrons-right"/>
                    </span>
                    <span class="d-block d-md-none"><FaIcon icon="chevrons-right"/></span>
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
import FaIcon from "../FontAwesomeIcon.vue";

export default {
    name: "Paginator",
    components: {
        FaIcon
    },
    props: {
        payload: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            page: this.payload.options.page,
            last_page: this.payload.data.info.last_page,
        }
    },
    emits: ['page-change'],
    methods: {
        previousItems() {
            let items = [];
            for (let i = this.page - 3; i < this.page; i++) {
                if (i > 0) {
                    items.push(i);
                }
            }
            return items;
        },
        nextItems() {
            let items = [];
            for (let i = this.page + 1; i <= this.page + 3; i++) {
                if (i <= this.last_page) {
                    items.push(i);
                }
            }
            return items;
        },
        goToPage(page) {
            this.$emit('page-change', page);
        }
    }
}
</script>

<style scoped>

</style>
