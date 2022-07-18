<template>
    <div>
        <h3 class="text-center">Edit Category</h3>

        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateCategory">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" v-model="category.name">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" v-model="category.description" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            category: {}
        }
    },
    created() {
        this.getCategory();
    },
    methods: {
        getCategory() {
            axios.get('http://api.localhost/categories/' + this.$route.params.id)
                .then(response => {
                    this.category = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateCategory() {
            axios.put('http://api.localhost/categories/' + this.$route.params.id, this.category)
                .then(response => {
                    this.$router.push('/');
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => this.loading = false);
        }
    }
}
</script>
