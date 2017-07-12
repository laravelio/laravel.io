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
        data() {
            return {
                noNotifications: {
                    to: '#',
                    type: 'info',
                    icon: 'fa fa-square-o',
                    content: 'No new notifications were found!',
                    created_at: moment().format(),
                },
                notifications: [
                    {
                        to: '#',
                        type: 'info',
                        icon: 'fa fa-heart-o',
                        content: '<a href="#">Laravel.io</a> now has notifications!',
                        created_at: '2017-07-11 02:07:52',
                        read_at: null,
                    },
                    {
                        to: '#',
                        type: 'danger',
                        icon: 'fa fa-ban',
                        content: 'Your post has been deleted, pay attention to our rules.',
                        created_at: '2017-07-10 23:31:49',
                        read_at: '2017-07-10 23:33:49',
                    },
                    {
                        to: '#',
                        icon: 'fa fa-reply',
                        image: 'https://s3.amazonaws.com/uifaces/faces/twitter/adellecharles/128.jpg',
                        content: '<a href="#">Lorena</a> replied you in a post!',
                        created_at: '2017-07-10 09:01:32',
                        read_at: null,
                    },
                    {
                        to: '#',
                        icon: 'fa fa-tag',
                        image: 'https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg',
                        content: '<a href="#">Mark</a> tagged you in a post!',
                        created_at: '2017-07-10 09:01:32',
                        read_at: null,
                    },
                    {
                        to: '#',
                        type: 'danger',
                        icon: 'fa fa-ban',
                        content: 'Your post has been deleted, pay attention to our rules.',
                        created_at: '2017-07-10 23:31:49',
                        read_at: '2017-07-10 23:33:49',
                    },
                    {
                        to: '#',
                        icon: 'fa fa-reply',
                        image: 'https://s3.amazonaws.com/uifaces/faces/twitter/adellecharles/128.jpg',
                        content: '<a href="#">Lorena</a> replied you in a post!',
                        created_at: '2017-07-10 09:01:32',
                        read_at: null,
                    },
                    {
                        to: '#',
                        icon: 'fa fa-tag',
                        image: 'https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg',
                        content: '<a href="#">Mark</a> tagged you in a post!',
                        created_at: '2017-07-10 09:01:32',
                        read_at: null,
                    },
                ],
            }
        },

        mounted() {
            Bus.$on('MarkAllAsRead', () => {
                console.log('marked');
            })
        }
    }
</script>

