<template>
    <div v-if="question">
        <edit-question
                v-if="editing"
                :question="question"></edit-question>

        <show-question
                v-else
                :question="question"></show-question>

        <v-container>
            <replies
                :replies="question.replies"
                :questionSlug="question.slug"></replies>

            <new-reply
                v-if="isLoggedIn"
                :question="question"></new-reply>
            <div v-else class="my-4">
                <router-link to="/login">Please login to reply.</router-link>
            </div>
        </v-container>
    </div>
</template>

<script>
import ShowQuestion from './ShowQuestion';
import EditQuestion from './EditQuestion';
import Replies from '../reply/Replies';
import NewReply from '../reply/NewReply';
export default {
    components: {ShowQuestion, EditQuestion, Replies, NewReply},
    data() {
        return {
            question: null,
            editing: false
        };
    },
    created() {
        // Listening events
        this.editQuestion(); // Đký để chực chờ làm khi có event 'editingQuestion' fire
        this.cancelEditQuestion();
        this.onAddNewReply();
        this.onDeleteReply();
        // Real time from others
        this.realTimeDeleteReplyFromOthers();

        this.getQuestion();
    },
    computed: {
        isLoggedIn() {
            return User.loggedIn();
        }
    },
    methods: {
        editQuestion() {
            EventBus.$on('editingQuestion', () => {
                this.editing = true;
            });
        },
        getQuestion() {
            axios.get(`/api/questions/${this.$route.params.slug}`)
                .then(res => this.question = res.data.data)
                .catch(error => console.log(error.response.data));
        },
        cancelEditQuestion() {
            EventBus.$on('cancelEditQuestion', () => {
                this.editing = false;
            });
        },
        onAddNewReply() {
            EventBus.$on('addNewReply', (newReply) => {
                this.question.replies.unshift(newReply);
                this.question.reply_count++;
            });
        },
        onDeleteReply() {
            EventBus.$on('deleteReply', (replyId) => {
                this.question.replies = this.question.replies.filter(reply => reply.id !== replyId);
                this.question.reply_count--;
            });
        },
        realTimeDeleteReplyFromOthers() {
            Echo.channel('delete-reply-channel')
                .listen('DeleteReplyEvent', e => {
                    this.question.replies = this.question.replies.filter(reply => reply.id !== Number(e.replyId));
                    this.question.reply_count--;
                });
        }
    },
}
</script>

<style>

</style>