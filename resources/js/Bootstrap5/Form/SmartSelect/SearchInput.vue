<template>
    <input
        autofocus
        v-if="searchable"
        type="search"
        v-model="search"
        class="form-control"
        v-on:keydown.enter="create"
        placeholder="Buscar">
</template>

<script>

import {toRaw} from "vue";

export default {
    name: "SearchInput",
    props: {
        addable: {type: Boolean, required: true},
        options: {type: Array, required: true},
        searchable: {type: Boolean, required: true},
    },
    emits: ['onOptionsChange', 'newOptionCreated', 'hasSearch'],
    data() {
        return {
            search: '',
            createdOptions: [],
            mustCreate: false,
        };
    },
    methods: {
        norm(string) {
            return string.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
        },
        doSearch() {
            if (this.mustCreate && !!this.search) {
                let equalCreatedOptions = this.createdOptions.filter(option => {
                    return this.norm(option.valueField) === this.norm(this.search)
                });
                let equalOptions = this.options.filter(option => {
                    return this.norm(option.valueField) === this.norm(this.search)
                });
                if (equalCreatedOptions.length === 0 && equalOptions.length === 0) {
                    let newOption = {
                        keyField: this.search,
                        valueField: this.search,
                    };
                    this.createdOptions.push(newOption);
                    this.$emit('newOptionCreated', newOption);
                }
                this.mustCreate = false;
            }
            let searchValue = this.search.toLowerCase().trim();
            let puttedKeys = [];
            let newOptions = [
                ...this.createdOptions.map(option => toRaw(option)),
                ...this.options
            ].filter(option => {
                if (puttedKeys.includes(option.keyField)) {
                    return false;
                }
                puttedKeys.push(option.keyField);
                return true;
            });
            let newFilteredOptions = [];

            newOptions.forEach(option => {
                if (option.valueField.toLowerCase().includes(searchValue)) {
                    newFilteredOptions.push(option);
                }
            });
            this.$emit('onOptionsChange', newFilteredOptions, newOptions);
        },
        clearInput() {
            this.search = '';
        },
        create(event) {
            if (this.addable) {
                this.mustCreate = true;
                this.doSearch();
            }
            event.preventDefault();
        }
    },
    watch: {
        search(value) {
            this.$emit('hasSearch', !!value);
            this.doSearch();
        },
    },
}
</script>

<style scoped>

</style>
