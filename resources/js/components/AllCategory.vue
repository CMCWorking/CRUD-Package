<template>
    <div>
        <h2 class="text-center">Category List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Detail</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="category in categories" key="category.id">
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                    <td>{{ category.description }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <router-link :to="{name: 'edit', params: {id: category.id}}" class="btn btn-primary">Edit</router-link>
                            <router-link :to="{name: 'delete', params: {id: category.id}}" class="btn btn-danger" @click="deleteCategory(category.id)">Delete</router-link>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: []
            }
        },
        created() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                axios.get('/api/categories')
                    .then(response => {
                        this.categories = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            deleteCategory(id) {
                axios.delete('/api/categories/' + id)
                    .then(response => {
                        let i = this.categories.map(data => data.id).indexOf(id);
                        this.categories.splice(i, 1);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>
