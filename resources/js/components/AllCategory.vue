<template>
    <div>
        <h2 class="text-center">Category List</h2>

        <b-input-group class="mt-3 mb-3" size="sm">
            <b-form-input v-model="keyword" placeholder="Search" type="text"></b-form-input>
        </b-input-group>

        <b-table id="my-table" :fields="fields" :items="categories" :keyword="keyword" label-sort-asc="" label-sort-desc="" :per-page="perPage" :current-page="currentPage">
            <template #cell(action)="data">
                <router-link :to="{ name: 'edit', params: { id: data.item.id } }" class="btn btn-primary w-100">Edit</router-link>
                <button class="btn btn-danger w-100" @click="showModal(data.item.id)">Delete</button>
            </template>
        </b-table>

        <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>

        <b-modal ref="my-modal" title="Delete this category" id="bv-modal-example" hide-footer>
            <template #modal-title>
                Are you sure to delete this Category?. <br>
                This action can not undone
            </template>
            <b-button class="mt-2" variant="btn-primary" block @click="hideModal">Close</b-button>
            <b-button class="mt-2" variant="outline-danger" block @click="deleteCategory(delete_id)">Confirm Delete</b-button>
        </b-modal>
    </div>
</template>

<script>
import { thisExpression } from '@babel/types';

export default {
    data() {
        return {
            perPage: 10,
            currentPage: 1,
            keyword: "",
            dataArray: this.getCategories(),
            fields: [
                { key: "name", label: "Name", sortable: true },
                { key: "description", label: "Description", sortable: false },
                { key: "action", label: "", sortable: false }
            ]
        };
    },
    methods: {
        getCategories() {
            axios.get("http://api.localhost/categories")
                .then(response => {
                    this.dataArray = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteCategory(id) {
            // console.log(id);
            axios.delete("http://api.localhost/categories/" + id)
                .then(response => {
                    let i = this.dataArray.map(data => data.id).indexOf(id);
                    this.dataArray.splice(i, 1);
                    this.hideModal();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showModal(id) {
            this.delete_id = id;
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
        }
    },
    computed: {
        categories() {
            return this.keyword
                ? this.dataArray.filter(
                    (item) =>
                        item.name.includes(this.keyword) ||
                        item.description.includes(this.keyword)
                )
                : this.dataArray;
        },
        rows() {
            return this.dataArray.length
        }
    }
}
</script>
