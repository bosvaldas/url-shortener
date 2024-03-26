<template>
    <div>
        <h1 class="text-center mt-5">URL Input Form</h1>
        <form @submit.prevent="submitForm">
            <div class="row">
                <div v-for="(input, index) in inputs" :key="index" class="col-md-6">
                    <div class="input-group mt-3">
                        <input type="url" class="form-control" v-model="input.url" placeholder="Enter URL">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger" type="button" @click="removeInput(index)" :disabled="removeUrlDisabled">
                                Remove
                            </button>
                        </div>
                    </div>
                    <ul v-if="input.errors" class="m-0 text-danger">
                        <li v-for="error in input.errors" class="">{{ error }}</li>
                    </ul>
                </div>
            </div>

            <div class="mt-3">
                <button class="btn btn-primary" type="button" @click="addInput">
                    Add URL
                </button>
                <button class="btn btn-success d-block mt-3" type="submit">
                    Submit
                </button>
            </div>
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
            inputs: [
                { url: 'http://testsafebrowsing.appspot.com/apiv4/ANY_PLATFORM/SOCIAL_ENGINEERING/URL/' }, // Fake unsafe url
            ],
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
        async submitForm() {
            const urls = this.inputs.map(i => ({url: i.url}))

            try {
                const response = await axios.post('/api/url-mappings', {urls});
                this.removeErrors();
                this.results = response.data.mappings;
            } catch (e) {
                if (e.response && e.response.data) {
                    this.setErrors(e.response.data.errors);
                } else {
                    console.error(e);
                }
            }
        },
        removeErrors() {
            for (const input of this.inputs) {
                input.errors = [];
            }
        },
        setErrors(errors) {
            for (const [key, violations] of Object.entries(errors)) {
                const index = Number(key.match(/\d+/)[0]);
                this.inputs[index].errors = violations;
            }
        }
    }
};
</script>
