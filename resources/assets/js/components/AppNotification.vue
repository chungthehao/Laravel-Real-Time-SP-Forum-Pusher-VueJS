<template>
    <div class="text-xs-center">
        <v-menu offset-y>
            <v-btn icon slot="activator">
                <v-icon :color="color">add_alert</v-icon> {{unreadCount}}
            </v-btn>
            <v-list>
                <v-list-tile v-for="(item, index) in unread"
                             :key="item.id">
                    <router-link :to="`/${item.path}`">
                        <v-list-tile-title @click="onRead(item)">{{ item.question }}</v-list-tile-title>
                    </router-link>
                </v-list-tile>

                <v-divider></v-divider>

                <v-list-tile v-for="(item, index) in read"
                             :key="item.id">
                    <v-list-tile-title>{{ item.question }}</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                read: {},
                unread: {},
                unreadCount: 0
            };
        },
        created() {
            if (User.loggedIn()) {
                this.getNotifications();
                this.realTimeNotification();
            }
        },
        methods: {
            getNotifications() {
                axios
                    .post(`/api/notifications`)
                    .then(res => {
                        this.read = res.data.read,
                        this.unread = res.data.unread,
                        this.unreadCount = res.data.unread.length
                    })
                    .catch(err => console.log(err.response.data));
            },
            onRead(notification) {
                axios
                    .post(`/api/mark-as-read`, { id: notification.id })
                    .then(res => {
                        this.unread.splice(notification, 1);
                        this.read.push(notification);
                        this.unreadCount--;
                    });
            },
            realTimeNotification() {
                Echo.private('App.User.' + User.id())
                    .notification(({reply, replyBy, questionTitle, questionPath}) => {
                        this.unread.unshift({
                            id: reply.id,
                            replyBy,
                            question: questionTitle,
                            path: questionPath
                        });
                        this.unreadCount++;
                    });
            }
        },
        computed: {
            color() {
                return this.unreadCount ? 'red' : 'primary';
            }
        }
    }
</script>

<style></style>