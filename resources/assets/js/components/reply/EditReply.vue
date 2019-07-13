<template>
    <div>
        <markdown-editor v-model="reply.body"></markdown-editor>

        <v-card-actions>
            <v-btn icon small @click="update">
                <v-icon color="green">save</v-icon>
            </v-btn>
            <v-btn icon small @click="cancel">
                <v-icon color="black">cancel</v-icon>
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
    export default {
        props: ['reply', 'questionSlug'],
        data() {
            return {
                //editedReply: this.reply.body
            };
        },
        methods: {
            update() {
                axios
                    .put(`/api/questions/${this.questionSlug}/replies/${this.reply.id}`, {
                        body: this.reply.body
                    })
                    .then(res => {
                        console.log(res.data);
                        this.editDone();
                    })
                    .catch(err => console.log(err.response.data));
            },
            cancel() {
                EventBus.$emit('cancelEditReply', this.reply.id);
            },
            editDone() {
                EventBus.$emit('editReplyDone', this.reply.id);
            }
        }
    }
</script>

<style></style>