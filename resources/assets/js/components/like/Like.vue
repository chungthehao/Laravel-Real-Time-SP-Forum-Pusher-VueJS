<template>
    <div>
        <v-btn icon @click="likeReply">
            <v-icon :color="color">favorite</v-icon> {{count}}
        </v-btn>
    </div>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                likedAlready: this.reply.liked_already,
                count: this.reply.like_count
            };
        },
        created() {
            Echo.channel('like-channel')
                .listen('LikeEvent', e => {
                    // - Nếu reply này là cái reply mà chỗ khác like (đc push tới mình)
                    // - Mỗi Reply đều có Like component này nên mình phải biết đc là component nào!
                    if (Number(e.replyId) === this.reply.id) {
                        Number(e.type) === 1 ? this.count++ : this.count--;
                    }
                });
        },
        methods: {
            likeReply() {
                if (User.loggedIn()) {
                    this.likedAlready ? this.decr() : this.incr();
                    this.likedAlready = !this.likedAlready;
                }
            },
            decr() {
                axios
                    .delete(`/api/like/${this.reply.id}`)
                    .then(res => {
                        console.log(res.data);
                        this.count--;
                    })
                    .catch(err => console.log(err.response.data));
            },
            incr() {
                axios
                    .post(`/api/like/${this.reply.id}`)
                    .then(res => {
                        console.log(res.data);
                        this.count++;
                    })
                    .catch(err => console.log(err.response.data));
            }
        },
        computed: {
            color() {
                return this.likedAlready ? 'red' : 'red lighten-4';
            }
        }
    }
</script>