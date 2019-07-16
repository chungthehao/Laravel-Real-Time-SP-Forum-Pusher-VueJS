<template>
    <div class="mt-4">
        <markdown-editor v-model="body"></markdown-editor>

        <v-btn color="green" dark @click="submit">
            Reply
        </v-btn>
    </div>
</template>

<script>
    export default {
        props: ['question'],
        data() {
            return {
                body: null
            };
        },
        methods: {
            submit() {
                axios
                    .post(`/api/questions/${this.question.slug}/replies`, {
                        body: this.body
                    })
                    .then(res => {
                        this.body = '';
                        EventBus.$emit('addNewReply', res.data);
                        window.scrollTo(0, 0);
                    })
                    .catch(err => console.log(err.response.data));
            }
        }
    }
</script>

<style>

</style>