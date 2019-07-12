<template>
    <v-toolbar>
        <!--<v-toolbar-side-icon></v-toolbar-side-icon>-->
        <v-toolbar-title>Henry Chung</v-toolbar-title>
        <v-spacer></v-spacer>
        <div class="hidden-sm-and-down">
            <router-link v-for="(item, index) in items"
                         :key="index"
                         :to="item.to"
                         v-if="item.show">
                <v-btn flat>{{item.title}}</v-btn>
            </router-link>
        </div>
    </v-toolbar>
</template>

<script>
    export default {
        data() {
            return {
                items: [
                    { title: 'Forum', to: '/forum', show: true },
                    { title: 'Ask Question', to: '/ask', show: User.loggedIn() },
                    { title: 'Category', to: '/categories', show: User.loggedIn() && User.admin() },
                    { title: 'Login', to: '/login', show: !User.loggedIn() },
                    { title: 'Logout', to: '/logout', show: User.loggedIn() },
                ]
            };
        },
        created() {
            EventBus.$on('logout', () => {
                User.logout();
            });
        }
    }
</script>

<style>

</style>