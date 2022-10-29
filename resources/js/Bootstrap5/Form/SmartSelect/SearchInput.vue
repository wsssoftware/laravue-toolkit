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

export default {
    name: "SearchInput",
    props: {
        addable: {type: Boolean, required: true},
        options: {type: Array, required: true},
        searchable: {type: Boolean, required: true},
    },
    emits: ['onOptionsChange'],
    data() {
        return {
            search: '',
            createdOptions: [],
            mustCreate: false,
        };
    },
    methods: {
        doSearch() {
            if (this.mustCreate && !!this.search) {
                let option = this.createdOptions.filter(option => option.valueField === this.search);
                if (option.length === 0) {
                    this.createdOptions.push({
                        keyField: this.search,
                        valueField: this.search,
                    });
                }
                this.mustCreate = false;
            }
            let searchValue = this.search.toLowerCase().trim();
            let newOptions = this.createdOptions.concat(Array.from(this.options));
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
        create() {
            if (this.addable) {
                this.mustCreate = true;
                this.doSearch();
            }
        }
    },
    watch: {
        search() {
            this.doSearch();
        },
    },
}
</script>

<style scoped>

</style>
