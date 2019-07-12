<template>
    <v-container>
        <v-form @submit.prevent="submit">
            <v-text-field
                label="Category Name"
                v-model="form.name"
                required></v-text-field>

            <v-btn
                type="submit"
                color="teal"
                v-if="!editSlug">Create</v-btn>
            <v-btn
                type="submit"
                color="orange"
                v-else>Update</v-btn>
        </v-form>

        <v-card>
            <v-toolbar color="cyan" dark dense>
                <v-toolbar-title>Categories</v-toolbar-title>
            </v-toolbar>

            <v-list>
                <div v-for="(category, index) in categories"
                     :key="index">
                    <v-list-tile>
                        <v-list-tile-action>
                            <v-btn icon small @click="edit(index)">
                                <v-icon color="orange">edit</v-icon>
                            </v-btn>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{category.name}}
                            </v-list-tile-title>
                        </v-list-tile-content>

                        <v-list-tile-action>
                            <v-btn icon small @click="destroy(category.slug, index)">
                                <v-icon color="red">delete</v-icon>
                            </v-btn>
                        </v-list-tile-action>
                    </v-list-tile>

                    <v-divider></v-divider>
                </div>
            </v-list>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: null
                },
                categories: [],
                editSlug: null
            };
        },
        created() {
            if ( ! User.admin()) this.$router.push('/forum');
            axios.get('/api/categories')
                .then(res => this.categories = res.data)
                .catch(err => console.log(err.response.data));
        },
        methods: {
            submit() {
                this.editSlug ? this.update() : this.create();
            },
            create() {
                axios.post('/api/categories', this.form)
                    .then(res => {
                        this.categories.unshift(res.data);
                        this.form.name = '';
                    })
                    .catch(err => console.log(err.response.data));
            },
            update() {
                axios.patch(`/api/categories/${this.editSlug}`, this.form)
                    .then(res => {
                        this.categories.unshift(res.data);
                        this.form.name = '';
                    })
                    .catch(err => console.log(err.response.data));
            },
            destroy(slug, index) {
                axios.delete(`/api/categories/${slug}`)
                    .then(res => this.categories.splice(index, 1))
                    .catch(err => console.log(err.response.data));
            },
            edit(index) {
                this.form.name = this.categories[index].name;
                this.editSlug = this.categories[index].slug;
                this.categories.splice(index, 1);
            }
        }
    }
</script>

<style></style>