<template>
    <v-card>
        <v-container fluid>
            <v-card-title>
                <div>
                    <div class="headline">
                        {{ question.title }}
                    </div>
                    <span class="grey--text">{{ question.user }} - {{ question.created_at }}</span>
                </div>
                <v-spacer></v-spacer>
                <v-btn color="teal" dark>{{ question.reply_count }} replies</v-btn>
            </v-card-title>

            <v-card-text v-html="body"></v-card-text>

            <v-card-actions v-if="own">
                <v-btn icon small @click="edit">
                    <v-icon color="orange">edit</v-icon>
                </v-btn>
                <v-btn icon small @click="destroy">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-card-actions>
        </v-container>
    </v-card>
</template>

<script>
export default {
    props: ['question'],
    data() {
        return {
            own: User.own(this.question.user_id)
        };
    },
    methods: {
        destroy() {
            axios.delete(`/api/questions/${this.question.slug}`)
                .then(res => this.$router.push('/forum'))
                .catch(err => console.log(err.response.data));
        },
        edit() {
            // Emit event ngược lên để truyền thông tin là ngta muốn edit
            EventBus.$emit('editingQuestion');
        }
    },
    computed: {
        body() {
            return md.parse(this.question.body);
        }
    }
}
</script>

<style>

</style>