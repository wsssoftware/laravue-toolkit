<template>

    <table class="table table-bordered table-striped table-hover mb-0">
        <thead>
        <tr>
            <th class="bg-primary text-light" v-for="column in payload.columns" :key="column.name">
                <template v-if="column.orderable">
                    <a class="d-flex w-100 justify-content-between" @click="sort(column.name)" href="javascript:void(0);">
                        <span>{{ column.label }}</span>
                        <span v-if="column.current_sort === 'asc'"><FaIcon icon="arrow-down-a-z"/></span>
                        <span v-else-if="column.current_sort === 'desc'"><FaIcon icon="arrow-down-z-a"/></span>
                        <span v-else><FaIcon icon="arrow-up-arrow-down"/></span>
                    </a>
                </template>
                <span v-else>{{ column.label }}</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="payload.data === undefined">
            <td class="text-center py-3 fw-bold" :colspan="Object.keys(payload.columns).length">
                <FaIcon animation="spin" fixed-width type="solid" icon="refresh" /> {{ payload.trans.loading_data }}
            </td>
        </tr>
        <tr v-else-if="payload.data.rows.length === 0">
            <td class="text-center py-3 fw-bold" :colspan="Object.keys(payload.columns).length">
                {{ payload.trans.not_found }}
            </td>
        </tr>
        <tr v-else v-for="row in payload.data.rows" :key="row.primary_key">
            <td v-for="column in payload.columns" :key="column.name">
                {{ this.cast(row[column.name], column, row) }}
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import FaIcon from "../FontAwesomeIcon.vue";
import Formatter from "../../Formatter";

export default {
    name: "TableStructure",
    components: {
        FaIcon,
    },
    props: {
        payload: {
            type: [Array, Object],
            required: true
        },
        customCasts: {
            type: Object,
            required: true,
        }
    },
    emits: ['sorted'],
    methods: {
        sort(column) {
            let columnData = this.payload.columns[column];
            let nextSort;
            if (columnData.current_sort === null) {
                nextSort = 'asc';
            } else if (columnData.current_sort === 'asc') {
                nextSort = 'desc';
            } else {
                nextSort = null;
            }
            this.$emit('sorted', column, nextSort);
        },
        cast(value, column, row) {
            if (typeof this.customCasts[column.name] === 'function') {
                return this.customCasts[column.name](value, row);
            }
            if (column.cast === 'datetime') {
                return Formatter.datetime(value);
            }
            if (column.cast === 'date') {
                return Formatter.date(value);
            }
            if (column.cast === 'integer' || column.cast === 'int') {
                return Formatter.integer(value);
            }
            if (column.cast === 'float') {
                return Formatter.float(value);
            }
            return value;
        }
    }
}
</script>

<style lang="scss" scoped>
    table {
        thead {
            th {
                a {
                    color: #fff;
                    text-decoration: none;
                }
            }
        }
    }
</style>
