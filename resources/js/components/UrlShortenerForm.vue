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
    </div>
</template>

<script>
export default {
    data() {
        return {
            inputs: [{ url: '' }]
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
        }
    }
};
</script>
