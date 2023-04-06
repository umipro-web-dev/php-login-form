<template>
    <header>
    <nav class="navbar navbar-light" style="background-color: #ddd">
    <h2 class="title text-left"><router-link to="/" class="navbar-brand text-left">login form</router-link></h2>
    <span>
    <router-link to="/login" class="navbar-text px-3 text-decoration-none">ログイン</router-link>
    <router-link to="/newUser" class="navbar-text px-3 text-decoration-none">新規登録</router-link>
    </span>
    </nav>
    </header>
    <main>
        <RouterView />
    </main>

    <footer>

    </footer>
</template>

<script setup lang="ts">

</script>

<style scoped lang="scss">


main {
    height: 90%;
    display: block;
    margin: 0;
}

.title  {
    margin-left: 1.5%;
    
    
    a {
        text-decoration: none;
    }

    a:hover {

        color: #b5b5b5;

     }
}

</style>