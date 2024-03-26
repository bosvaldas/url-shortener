<template>
    <div>
        <h1 class="text-center mt-5">URL Input Form</h1>
        <form @submit.prevent="submitForm">
            <div class="row">
                <div v-for="(input, index) in inputs" :key="index" class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="url" class="form-control" v-model="input.url" placeholder="Enter URL">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="button" @click="removeInput(index)" :disabled="removeUrlDisabled">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary" type="button" @click="addInput">
                Add URL
            </button>
            <button class="btn btn-success d-block mt-3" type="submit">
                Submit
            </button>
        </form>

        <div v-if="results" class="mt-5">
            <h3>Results</h3>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>Long URL</th>
                        <th>Short URL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="result in results" :key="result.id">
                        <td>{{ result.longUrl }}</td>
                        <td>{{ result.shortUrl }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            inputs: [{ url: '' }],
            results: null,
        };
    },
    computed: {
        removeUrlDisabled() {
            return this.inputs.length === 1;
        }
    },
    methods: {
        addInput() {
            this.inputs.push({url: ''});
        },
        removeInput(index) {
            if (this.removeUrlDisabled) {
                return;
            }

            this.inputs.splice(index, 1);
        },
        submitForm() {
            console.log(this.inputs);

            this.results = this.inputs.map((u) => {
                return {longUrl: u.url, shortUrl: '...'};
            })
        }
    }
};
</script>
