<template>
    <v-container>
        <v-alert v-if="errors"
                 :value="true"
                 type="error">
            <div v-if="errors.title">{{errors.title[0]}}</div>
            <div v-if="errors.category_id">{{errors.category_id[0]}}</div>
            <div v-if="errors.body">{{errors.body[0]}}</div>
        </v-alert>

        <v-form @submit.prevent="create">
            <v-text-field
                    v-model="form.title"
                    label="Title"
                    type="text"
                    required
            ></v-text-field>

            <v-select
                    :items="categories"
                    v-model="form.category_id"
                    item-text="name"
                    item-value="id"
                    label="Category"
                    autocomplete
            ></v-select>

            <markdown-editor v-model="form.body"></markdown-editor>

            <v-btn
                    color="green"
                    type="submit"
                    :disabled="disabled"
            >Ask</v-btn>
        </v-form>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            categories: [],
            form: { title: null, category_id: null, body: null },
            errors: null
        };
    },
    created() {
        axios.get('/api/categories')
            .then(res => {
                this.categories = res.data;
            });
    },
    computed: {
        disabled() {
            //return false;
            return ! (this.form.title && this.form.category_id && this.form.body);
        }
    },
    methods: {
        create() {
            axios.post('/api/questions', this.form)
                .then(res => {
                    this.$router.push(res.data.path);
                    this.errors = null;
                })
                .catch(errors => this.errors = errors.response.data.errors);
        }
    }
}
</script>

<style>

</style>