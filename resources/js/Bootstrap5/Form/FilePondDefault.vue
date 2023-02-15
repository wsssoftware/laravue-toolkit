<template>
    <div v-bind="parentAttributes" :class="[{'is-invalid': errors}]">
        <label v-if="label" class="form-label" :for="id">{{ label }}</label>
        <input
            type="file"
            v-bind="$attrs"
            :id="id"
            ref="input"/>
    </div>
    <InvalidFeedback :errors="errors"/>
</template>

<script>

import * as FilePond from "filepond";
import 'filepond/dist/filepond.min.css';
import pt_BR from 'filepond/locale/pt-br';
import InvalidFeedback from "./InvalidFeedback.vue";

export default {
    inheritAttrs: false,
    name: "FilePondDefault",
    components: {
        InvalidFeedback,
    },
    props: {
        form: {
            type: Object,
            required: true,
        },
        formDataName: {
            type: String,
            required: true,
        },
        label: String,
        lang: {
            type: Object,
            default: pt_BR,
        },
        load: String,
        options: {
            type: Object,
            default: {
                storeAsFile: true,
            },
        },
        parentAttributes: {
            type: Object,
            default: {},
        },
        plugins: {
            type: Object,
            default: [],
        },
    },
    data() {
        return {
            id: 'input-filepond-' + Math.random().toString(16).slice(2),
        }
    },
    emits: ['remove'],
    computed: {
        finalOptions() {
            let options = {};
            if (
                this.load !== undefined &&
                this.form[this.formDataName] !== undefined &&
                this.form[this.formDataName] !== null &&
                this.form[this.formDataName] !== ''
            ) {
                options.server = {
                    load: this.load,
                    remove: this.remove,
                }
                options.files = this.getFiles(this.form[this.formDataName]);
            }
            return {
                ...options,
                ...this.options,
                ...this.lang,
            };
        },
        errors() {
            if (this.form.errors !== undefined && this.form.errors[this.formDataName] !== undefined) {
                return this.form.errors[this.formDataName];
            }
            return null;
        },
    },
    mounted() {
        this.createFilePond();
    },
    beforeUnmount() {
        this.destroyFilePond();
    },
    methods: {
        createFilePond() {
            if (this.pond) {
                this.pond.setOptions(this.finalOptions);
                return;
            }
            Object.keys(this.plugins).forEach((plugin) => {
                FilePond.registerPlugin(this.plugins[plugin]);
            });

            this.pond = FilePond.create(this.$refs.input, this.finalOptions);
            document.getElementById(this.id).addEventListener('FilePond:addfile', this.updateFiles);
            document.getElementById(this.id).addEventListener('FilePond:removefile', this.updateFiles);
        },
        destroyFilePond() {
            if (this.pond) {
               document.getElementById(this.id).removeEventListener('FilePond:addfile', this.updateFiles);
               document.getElementById(this.id).removeEventListener('FilePond:removefile', this.updateFiles);
                this.pond.destroy();
            }
        },
        getFiles(files) {
            let data;
            if (Array.isArray(files)) {
                data = [];
                files.forEach((file) => {
                    data.push({
                        source: file,
                        options: {type: 'local'}
                    });
                });
            } else {
                data = [{
                    source: files,
                    options: {type: 'local'}
                }];
            }
            return data;
        },
        getPond() {
            return this.pond;
        },
        remove(source, load, error) {
            this.$emit('remove', source, load, error);
        },
        updateFiles() {
            let files = this.pond.getFiles().filter((file) => {
                return file.origin === 1;
            });
            if (this.finalOptions?.allowMultiple ?? false) {
                this.form[this.formDataName] = [];
                files.forEach((file) => {
                    this.form[this.formDataName].push(file.file);
                });
            } else {
                this.form[this.formDataName] = files[0]?.file ?? null;
            }

        }
    },
}
</script>

<style scoped lang="scss">

.invalid-feedback {
    margin-top: -1em;
    margin-bottom: 1em;
}

</style>
