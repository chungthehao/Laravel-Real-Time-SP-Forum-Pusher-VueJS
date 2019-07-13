<template>
    <div class="mt-3">
        <v-card>
            <v-card-title>
                <div class="headline">{{reply.user}}</div>
                <div class="ml-3 grey--text">{{reply.created_at}}</div>
            </v-card-title>

            <edit-reply v-if="editing"
                        :reply="reply"
                        :questionSlug="questionSlug"></edit-reply>
            <v-card-text v-else
                         v-html="replyBody"></v-card-text>

            <v-card-actions v-if="own && !editing">
                <v-btn icon small @click="editReply">
                    <v-icon color="orange">edit</v-icon>
                </v-btn>
                <v-btn icon small @click="deleteReply">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
    import EditReply from './EditReply';
    export default {
        components: {EditReply},
        props: ['reply', 'questionSlug'],
        data() {
            return {
                editing: false,
                replyContentBeforeCancel: ''
            }
        },
        created() {
            // Listening events...
            this.cancelEditReply();
            this.editReplyDone();
        },
        methods: {
            deleteReply() {
                axios
                    .delete(`/api/questions/${this.questionSlug}/replies/${this.reply.id}`)
                    .then(res => {
                        EventBus.$emit('deleteReply', res.data.id);
                    })
                    .catch(err => console.log(err.response.data));
            },
            editReply() {
                this.replyContentBeforeCancel = this.reply.body;
                this.editing = true;
            },
            cancelEditReply() {
                EventBus.$on('cancelEditReply', (replyId) => {
                    // Thực hiện cancel đúng component fire event này!
                    if (this.reply.id === replyId) {
                        this.reply.body = this.replyContentBeforeCancel;
                        this.editing = false;
                    }
                });
            },
            editReplyDone() {
                EventBus.$on('editReplyDone', (replyId) => {
                    // Thực hiện đóng đúng component fire event này!
                    if (this.reply.id === replyId) {
                        this.editing = false;
                    }
                });
            }
        },
        computed: {
            own(){
                return User.own(this.reply.user_id)
            },
            replyBody() {
                return md.parse(this.reply.body);
            }
        }
    }
</script>

<style>

</style>