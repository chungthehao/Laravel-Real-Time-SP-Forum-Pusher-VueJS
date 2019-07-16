<template>
    <div>
        <reply v-for="(reply, index) in replies"
               :key="index"
               :reply="reply"
               :questionSlug="questionSlug"></reply>
    </div>
</template>

<script>
    import Reply from './Reply';
    export default {
        components: { Reply },
        props: ['replies', 'questionSlug'],
        created() {
            // Listening events...
            this.listenNoti();
        },
        methods: {
            listenNoti() {
                // - Muốn đoạn code private này chạy tốt, phải cho pusher laravel biết
                // cách để authenticate (qua JWT). Config trong file bootstrap.js
                Echo.private('App.User.' + User.id())
                    .notification((notification) => {
                        EventBus.$emit('addNewReply', notification.reply);
                        window.scrollTo(0, 0);
                    });
            }
        }
    }
</script>

<style>

</style>