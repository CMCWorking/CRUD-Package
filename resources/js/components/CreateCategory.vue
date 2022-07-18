<template>
    <div>
        <h3 class="text-center">Create Category</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCategory">
                    <div class="form-group">
                        <label for="name">name</label>
                        <input type="text" name="name" id="name" class="form-control" v-model="category.name">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" v-model="category.description" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-primary">Create</button>
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
    methods: {
        addCategory() {
            axios.post('http://api.localhost/categories', this.category)
                .then(response => {
                    this.category = {};
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
