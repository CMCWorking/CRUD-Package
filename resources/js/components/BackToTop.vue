<template>
    <b-button class="back-to-top" :variant="variant" @click="goTop">🔝</b-button>
</template>

<script>
export default {
    props: {
        variant: { type: String, default: "light" }
    },
    methods: {
        goTop(event) {
            window.scrollTo(0, 0);
        }
    }
};
</script>

<style>
.back-to-top {
    position: fixed;
    bottom: 3rem;
    right: 1rem;
    font-size: 2rem;
}
</style>
