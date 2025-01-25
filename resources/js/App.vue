<template>
    <nav>
        <h2>Навигация по сайту</h2>
        <ul class="menu-items">
            <li><router-link to="/welcome">WELCOME</router-link></li>
            <li><router-link :to="{ name: 'welcome.login' }">Login</router-link></li>
            <li><router-link :to="{ name: 'welcome.register' }">Register</router-link></li>
            <li><router-link :to="{ name: 'welcome.personal' }">Some Personal page</router-link></li>
            <li><router-link :to="{ name: 'welcome.test' }">Test page</router-link></li>
        </ul>
    </nav>
    <router-view></router-view>
</template>

<script lang="ts">
export default {
    name: 'App'
}

</script>