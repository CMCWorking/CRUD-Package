<template>
    <div class="fluid-container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Home</router-link>
                    <router-link :to="{ name: 'create' }" class="nav-item nav-link">Add new Category</router-link>
                </div>
            </div>
        </nav>

        <router-view class="mx-2"></router-view>

        <back-to-top></back-to-top>
    </div>
</template>

<script>
import BackToTop from "./components/BackToTop";

export default {
    components: {
        BackToTop
    }
}
</script>

<style>
html {
    scroll-behavior: smooth;
}

#app {
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
}
</style>
