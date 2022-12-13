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
        <div class="col-12 col-sm-6 col-md-5 col-lg-5 col-xl-4 align-self-end">
            <div class="input-group mb-2">
                <template v-if="filters.length > 0">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <FontAwesomeIcon icon="filter"/> {{ payload.trans.filters }}
                    </button>
                    <ul class="dropdown-menu">
                        <li v-for="filterItem in filters">
                            <button
                                :class="[
                                    'dropdown-item',
                                    {'active': filterItem.key === filter},
                                ]"
                                @click="setFilter(filterItem.key)"
                                role="button">
                                {{ filterItem.label }}
                            </button>
                        </li>
                    </ul>
                </template>
                <input ref="searchInput" type="search" @keyup="onSearchKeyUp" v-model="search" class="form-control" :id="'search-input-'+id"
                       :placeholder="payload.trans.header.search_placeholder">
            </div>
        </div>
    </div>
    <div class="table-responsive mb-2">
        <TableStructure ref="tableStructure" :custom-components="customComponents" :custom-casts="customCasts" :payload="payload" @sorted="setSort"/>
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
import FontAwesomeIcon from "../FontAwesomeIcon.vue";

export default {
    name: "Table",
    components: {
        FontAwesomeIcon,
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
                .replace(':from', Intl.NumberFormat().format(pageInfo.from))
                .replace(':to', Intl.NumberFormat().format(pageInfo.to))
                .replace(':entries', Intl.NumberFormat().format(pageInfo.filtered_total))
                .concat(filtered);
        }
    },
    data() {
        return {
            filters: this.payload.options.filters,
            filter: this.payload.options.filter,
            sort: this.payload.options.sort,
            search: this.payload.options.search,
            search_focus: this.payload.options.search_focus,
            default_page_size: this.payload.options.default_page_size,
            page_size: this.payload.options.current_page_size,
            page: this.payload.options.page,
        }
    },
    updated() {
        if (this.payload.data === undefined) {
            this.updateTable();
        }
    },
    mounted() {
        if (this.payload.data === undefined) {
            this.updateTable();
        }
        if (this.search_focus) {
            this.$refs.searchInput.focus();
            this.search_focus = null;
        }
    },
    methods: {
        updateTable() {
            this.$refs.tableStructure.setLoading();
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
            if (this.filter !== 'none') {
                data.filter = this.filter;
            }
            if (this.search !== null && this.search !== '') {
                data.search = this.search;
            }
            if (this.search_focus === true) {
                data.search_focus = this.search_focus;
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
        },
        setFilter(filterKey) {
            this.filter = filterKey;
            this.page = 1;
            this.updateTable();
        },
        onSearchKeyUp() {
            this.search_focus = true;
            this.page = 1;
            this.updateTable();
        }
    },
    watch: {
        page_size() {
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
