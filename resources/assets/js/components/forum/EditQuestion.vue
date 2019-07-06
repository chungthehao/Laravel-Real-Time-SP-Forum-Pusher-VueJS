<template>
    <v-container>
        <v-card>
            <v-form @submit.prevent="saveQuestion">
                <v-text-field
                        v-model="form.title"
                        label="Title"
                        type="text"
                        required
                ></v-text-field>

                <markdown-editor v-model="form.body"></markdown-editor>

                <v-card-actions>
                    <v-btn icon small @click="cancelEditQuestion">
                        <v-icon>cancel</v-icon>
                    </v-btn>
                    <v-btn icon small type="submit">
                        <v-icon color="green">save</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                form: {}
            };
        },
        methods: {
            cancelEditQuestion() {
                EventBus.$emit('cancelEditQuestion');
            },
            saveQuestion() {
                axios.put(`/api/questions/${this.question.slug}`, this.form)
                    .then(res => this.cancelEditQuestion())
                    .catch(err => console.log(err.response.data));
            }
        },
        mounted() {
            this.form = this.question;
        }
    }
</script>

<style>

</style>