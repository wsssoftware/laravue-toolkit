<template>
    <div class="row justify-content-between">
        <div class="col-12 col-sm-3 col-md-2 col-lg-2">
            <div class="mb-2">
                <label :for="'page-size-input-'+id" class="form-label">
                    {{ payload.trans.header.page_size_label }}
                </label>
                <select class="form-select" v-model="page_size" :id="'page-size-input-'+id">
                    <option v-for="(isDefault, index) in payload.options.page_size_options">
                        {{ index }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
            <div class="mb-2">
                <label :for="'search-input-'+id" class="form-label">{{ payload.trans.header.search_label }}</label>
                <input ref="searchInput" type="search" v-model="search" class="form-control" :id="'search-input-'+id"
                       :placeholder="payload.trans.header.search_placeholder">
            </div>
        </div>
    </div>
    <div class="table-responsive mb-2">
        <TableStructure :custom-components="customComponents" :custom-casts="customCasts" :payload="payload" @sorted="setSort"/>
    </div>
    <template v-if="payload.data !== undefined">
        <div class="w-100 text-center">
            <p class="mb-2 d-block d-md-none">{{ info }}</p>
        </div>
        <div class="d-flex justify-content-center justify-content-md-between">
            <p class="align-self-center d-none d-md-block">{{ info }}</p>
            <Paginator :payload="payload" @page-change="setPage"/>
        </div>
    </template>

</template>

<script>
import TableStructure from "./TableStructure.vue";
import Paginator from "./Paginator.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Table",
    components: {
        TableStructure,
        Paginator
    },
    props: {
        payload: {
            type: [Object, Array],
            required: true
        },
        dataKey: {
            type: String,
            required: true
        },
        customCasts: {
            type: Object,
            default: {}
        },
        customComponents: {
            type: Object,
            default: {}
        },
    },

    computed: {
        id() {
            return 'table-' + this.dataKey;
        },
        info() {
            let pageInfo = this.payload.data.info;
            let string = this.payload.trans.footer.info;

            let filtered = '';
            if (pageInfo.total !== pageInfo.filtered_total) {
                filtered = ' (' + this.payload.trans.footer.info_filtered + ')';
                filtered = filtered.replace(':total', pageInfo.total);
            }

            return string
                .replace(':from', pageInfo.from)
                .replace(':to', pageInfo.to)
                .replace(':entries', pageInfo.filtered_total)
                .concat(filtered);
        }
    },
    data() {
        return {
            sort: this.payload.options.sort,
            search: this.payload.options.search,
            was_a_search: this.payload.options.was_a_search,
            default_page_size: this.payload.options.default_page_size,
            page_size: this.payload.options.current_page_size,
            page: this.payload.options.page,
        }
    },
    mounted() {
        if (this.payload.data === undefined) {
            this.updateTable();
        }
        if (this.was_a_search) {
            this.$refs.searchInput.focus();
        }
    },
    methods: {
        updateTable() {
            let params = route().params;
            delete params[this.id];
            Inertia.get(
                route(route().current(), params),
                this.getData(),
                {
                    only: [
                        this.dataKey + '.options',
                        this.dataKey + '.trans',
                        this.dataKey + '.columns',
                        this.dataKey + '.data',
                    ],
                });
        },
        getData() {
            let data = {};
            if (this.page !== 1) {
                data.page = this.page;
            }
            if (Number(this.page_size) !== (Number(this.default_page_size))) {
                data.page_size = this.page_size;
            }
            if (this.sort !== null) {
                data.sort = this.sort;
            }
            if (this.search !== null && this.search !== '') {
                data.search = this.search;
            }
            let tableData = {};
            tableData[this.id] = data;
            return tableData;
        },
        setPage(page) {
            this.page = page;
        },
        setSort(column, direction) {
            if (direction === null) {
                this.sort = null;
            } else {
                this.sort = {
                    column, direction
                };
            }
            this.page = 1;
            this.updateTable();
        }
    },
    watch: {
        page_size() {
            this.page = 1;
            this.updateTable();
        },
        search() {
            this.page = 1;
            this.updateTable();
        },
        page() {
            this.updateTable();
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
