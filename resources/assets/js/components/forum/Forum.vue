<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs8>
                <question
                    v-for="(question, index) in questions"
                    :key="index"
                    :question="question"></question>
            </v-flex>
            Sidebar
        </v-layout>
    </v-container>
</template>

<script>
import question from './Question';
export default {
    components: {
        question
    },
    data() {
        return {
            questions: {}
        }
    },
    created() {
        axios.get('/api/questions')
            .then(res => this.questions = res.data.data)
            .catch(error => console.log(error.response.data));
    }
}
</script>

<style>

</style>