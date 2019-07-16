<template>
    <v-toolbar color="indigo lighten-1" dark>
        <!--<v-toolbar-side-icon></v-toolbar-side-icon>-->
        <v-toolbar-title>
            <router-link class="white--text" to="/">Henry Chung</router-link>
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <app-notification v-if="loggedIn"></app-notification>
        <div class="hidden-sm-and-down">
            <router-link class="white--text" v-for="(item, index) in items"
                         :key="index"
                         :to="item.to"
                         v-if="item.show">
                <v-btn flat>{{item.title}}</v-btn>
            </router-link>
        </div>
    </v-toolbar>
</template>

<script>
    import AppNotification from './AppNotification';
    export default {
        components: { AppNotification },
        data() {
            return {
                loggedIn: User.loggedIn(),
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