<template>
    <div>
        <h2 class="text-center">Category List</h2>

        <section class="categories">
            <div class="row">
                <div class="col-4 mb-4 d-flex" v-if="categories.length" v-for="category in categories" :key="category.id">
                    <b-card class="shadow w-100 h-100" header-tag="header" footer-tag="footer">
                        <template #header>
                            <h5 class="mb-0">{{ category.name }}</h5>
                        </template>

                        <b-card-text>
                            {{ category.description }} <br>
                            {{ category.description }} <br>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus, in! Laboriosam nesciunt et sint quaerat quam aliquid labore necessitatibus, quia praesentium aut corporis atque quibusdam facilis quisquam rerum! Doloribus, ut? <br>
                            <br> <strong>ID: </strong>{{ category.id }}
                        </b-card-text>

                        <template #footer>
                            <router-link :to="{ name: 'edit', params: { id: category.id } }" class="btn btn-primary">Edit</router-link>

                            <button class="btn btn-outline-danger btn-delete" @click="showModal(category.id)">Delete</button>
                        </template>
                    </b-card>
                </div>

                <div class="col-12 mb-4 text-center" v-if="maximumRecord == true">
                    <b-card class="shadow w-100 h-100">
                        <b-card-text>
                            You have come to the end of categories
                        </b-card-text>
                    </b-card>
                </div>
            </div>

            <b-skeleton-wrapper :loading="loading">
                <template #loading>
                    <div class="row">
                        <div class="col-4 mb-2" v-for="index in 3">
                            <b-card>
                                <b-skeleton width="100%"></b-skeleton>

                                <b-skeleton width="55%"></b-skeleton>
                                <b-skeleton width="55%"></b-skeleton>
                                <b-skeleton width="70%"></b-skeleton>

                                <b-skeleton width="20%"></b-skeleton>
                                <b-skeleton width="20%"></b-skeleton>
                            </b-card>
                        </div>
                    </div>
                </template>
            </b-skeleton-wrapper>
        </section>
    </div>
</template>

<script>
import DataService from '../services/DataService.js';
const service = new DataService('categories');

export default {
    data() {
        return {
            categories: [],
            status: '',
            offset: '',
            limit: '',
            loading: false,
            total: 0,
            maximumRecord: false
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
        }
    },
    methods: {
        getInitialData() {
            this.startLoading()
            service.getAll().then(response => {
                this.loading = false
                this.categories = response.data.data
                this.status = response.status
                this.offset = response.data.offset
                this.limit = response.data.limit
                this.total = response.data.total
            })
        },
        scroll() {
            window.onscroll = () => {
                let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight === document.documentElement.offsetHeight

                if (bottomOfWindow) {
                    if (this.offset < this.total) {
                        this.startLoading()
                        service.getAll(this.offset, this.limit).then(response => {
                            this.loading = false
                            const append = response.data.data.slice(
                                this.categories.length,
                                this.categories.length + this.limit
                            )
                            this.categories = this.categories.concat(response.data.data)
                            this.categories = [...new Set(this.categories)]
                            this.status = response.status
                            this.offset = response.data.offset
                            this.limit = response.data.limit
                            this.total = response.data.total
                        }).catch(error => {
                            this.loading = false
                            console.log(error)
                        });
                    } else {
                        this.maximumRecord = true
                    }
                }
            }
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
    beforeMount() {
        this.getInitialData();
    },
    mounted() {
        this.scroll();
    }
};
</script>

<style>
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
