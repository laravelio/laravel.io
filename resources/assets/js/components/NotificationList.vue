<template>
    <div class="notifications-container">
        <div class="header">
            <h4>Notifications</h4>
        </div>
        <ul>
            <notification-card :data="notification" v-for="notification in notifications" v-if="notifications.length != 0"></notification-card>
            <notification-card :data="noNotifications" v-if="notifications.length == 0"></notification-card>
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

        mounted() {
            Bus.$on('MarkAllAsRead', () => {
                console.log('marked');
            })
        }
    }
</script>

