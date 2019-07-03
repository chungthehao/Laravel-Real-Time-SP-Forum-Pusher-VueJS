<template>
    <div>
        <toolbar></toolbar>

        <!-- route outlet -->
        <!-- component matched by the route will render here -->
        <router-view></router-view>

        <app-footer></app-footer>
    </div>
</template>

<script>
import toolbar from './Toolbar';
import AppFooter from './Footer';
import Login from './login/Login';
export default {
    components: {
        toolbar,
        AppFooter,
        Login
    }
}
</script>

<style scoped>

</style>