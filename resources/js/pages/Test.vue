<template>
    <a href="#" @click.prevent="logout">Logout</a>
</template>

<script>
import axios from 'axios';

export default {
    name: 'test',
    methods: {
        logout() {
            axios.post('/logout')
                .then((responce) => {
                    console.log('%clogout', 'padding: 5px; background: DarkKhaki; color: Yellow;', responce);
                    window.localStorage.removeItem('auth');
                    this.$router.push({ name: 'welcome.login' });
                })
        }
    }
}

</script>