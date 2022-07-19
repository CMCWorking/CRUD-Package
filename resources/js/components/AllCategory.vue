<template>
    <div>
        <h2 class="text-center">Category List</h2>
        <section class="categories">
            <vue-paginate-scroll v-if="categories.length" :src="categories" :per-scroll="8">
                <template slot-scope="{ data, currentScroll, lastScroll }">
                    <div style="margin-top:5rem;" class="d-flex justify-content-center py-1 px-2 bg-success rounded-lg text-white fixed-bottom">
                        <div>{{ data.length }} / {{ categories.length }} </div>
                        <div class="ml-1">
                            <strong>Current scoll:</strong>
                            {{ currentScroll }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 mb-2 d-flex" v-for="category in data" :key="category.id">
                            <b-card class="shadow mb-3" :title="category.name">
                                <b-card-text class="flex">{{ category.description }}</b-card-text>

                                <div class="btn-delete">
                                    <router-link :to="{ name: 'edit', params: { id: category.id } }" class="btn btn-primary">Edit</router-link>
                                    <button class="btn btn-outline-danger" @click="showModal(category.id)">Delete</button>
                                </div>
                            </b-card>
                        </div>
                    </div>
                </template>
            </vue-paginate-scroll>
            <b-skeleton-wrapper :loading="loading">
                <template #loading>
                    <div class="row">
                        <div class="col-4 mb-2">
                            <b-card>
                                <b-skeleton width="100%"></b-skeleton>
                                <b-skeleton width="55%"></b-skeleton>
                                <b-skeleton width="55%"></b-skeleton>
                                <b-skeleton width="70%"></b-skeleton>
                                <div class="btn-delete">
                                    <b-skeleton width="35%"></b-skeleton>
                                    <b-skeleton width="35%"></b-skeleton>
                                </div>
                            </b-card>
                        </div>
                    </div>
                </template>
            </b-skeleton-wrapper>
        </section>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            categories: [],
            status: '',
            offset: '',
            limit: '',
            loading: false,
        };
    },
    watch: {
        loading(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.clearLoadingTimeInterval()

                if (newValue) {
                    this.$_loadingTimeInterval = setInterval(() => {
                        this.loadingTime++
                    }, 1000)
                }
            }
        },
        loadingTime(newValue, oldValue) {
            if (newValue !== oldValue) {
                if (newValue === this.maxLoadingTime) {
                    this.loading = false
                }
            }
        }
    },
    methods: {
        getCategories() {
            this.startLoading();
            axios.get("http://api.localhost/categories")
                .then(response => {
                    this.loading = false;
                    this.categories = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showModal(id) {
            this.delete_id = id;
            this.$refs['delete-modal'].show();
        },
        hideModal() {
            this.$refs['delete-modal'].hide();
        },
        deleteCategory(id) {
            console.log(id);
        },
        clearLoadingTimeInterval() {
            clearInterval(this.$_loadingTimeInterval)
            this.$_loadingTimeInterval = null
        },
        startLoading() {
            this.loading = true
            this.loadingTime = 0
        }
    },
    created() {
        this.getCategories();
    }
};
</script>

<style>
.categories {
    padding: 1rem 0;
}

.card {
    border: none;
    border-left: 5px solid #099bc0;
}

.close {
    visibility: hidden;
}

.btn-delete {
    float: right;
}
</style>
