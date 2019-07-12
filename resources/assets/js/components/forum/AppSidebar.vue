<template>
    <v-card>
        <v-toolbar color="cyan" dark dense class="mt-2">
            <v-toolbar-title>Categories</v-toolbar-title>
        </v-toolbar>

        <v-list>
            <v-list-tile v-for="(category, index) in categories"
                         :key="index">
                <v-list-tile-content>
                    <v-list-tile-title>{{category.name}}</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                categories: []
            };
        },
        created() {
            axios.get('/api/categories')
                .then(res => this.categories = res.data)
                .catch(err => console.log(err.response.data));
        }
    }
</script>

<style></style>