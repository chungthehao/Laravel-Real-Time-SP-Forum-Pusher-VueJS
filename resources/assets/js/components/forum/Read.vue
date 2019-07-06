<template>
    <div v-if="question">
        <edit-question
                v-if="editing"
                :question="question"></edit-question>

        <show-question
                v-else
                :question="question"></show-question>
    </div>
</template>

<script>
import ShowQuestion from './ShowQuestion';
import EditQuestion from './EditQuestion';
export default {
    components: {
        ShowQuestion,
        EditQuestion
    },
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

        this.getQuestion();
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
        }
    }
}
</script>

<style>

</style>