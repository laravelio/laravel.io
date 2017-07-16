<template>
    <div class="notifications-container">
        <div class="header">
            <h4>Notifications</h4>
        </div>
        <ul>
            <notification-card :data="notification" v-for="notification in notificationsIterable" v-if="hasNotifications"></notification-card>
            <notification-card :data="noNotifications" v-if="! hasNotifications"></notification-card>
        </ul>
        <div class="footer">
            <a href="/notifications" class="btn btn-xs btn-primary">View all</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['notifications'],

        data() {
            return {
                noNotifications: {
                    data: {
                        url: '#',
                        type: 'info',
                        icon: 'fa fa-square-o',
                        content: 'No new notifications were found!',
                    },
                    created_at: moment().format(),
                },
            }
        },

        computed: {
            notificationsIterable() {
                return this.notifications.data || this.notifications;
            },

            hasNotifications() {
                let { data, length } = this.notifications;

                return !! (data ? data.length : length);
            }
        },

        mounted() {
            Bus.$once('markAllAsRead', () => {
                this.markAllAsRead();
            });
        },

        methods: {
            markAllAsRead() {
                axios.put('/notifications/markall').then(() => {
                    this.notificationsIterable.forEach((notification) => {
                        notification.read_at = moment().format();
                    });
                });
            }
        }
    }
</script>

