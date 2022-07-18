<template>
    <div>
        <h2 class="text-center">Category List</h2>

        <b-input-group class="mt-3 mb-3" size="sm">
            <b-form-input v-model="keyword" placeholder="Search" type="text"></b-form-input>
        </b-input-group>

        <b-table :fields="fields" :items="items" :keyword="keyword"></b-table>
    </div>
</template>

<script>
export default {
    data() {
        return {
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
        }
    },
    computed: {
        items() {
            return this.keyword
                ? this.dataArray.filter(
                    (item) =>
                        item.name.includes(this.keyword) ||
                        item.description.includes(this.keyword)
                )
                : this.dataArray;
        }
    }
}
</script>
