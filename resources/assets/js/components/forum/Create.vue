<template>
    <v-container>
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
            error: {}
        };
    },
    created() {
        axios.get('/api/categories')
            .then(res => this.categories = res.data);
    },
    methods: {
        create() {
            axios.post('/api/questions', this.form)
                .then(res => this.$router.push(res.data.path))
                .catch(error => this.error = error.response.data.error);
        }
    }
}
</script>

<style>

</style>