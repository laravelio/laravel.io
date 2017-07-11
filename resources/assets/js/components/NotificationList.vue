<template>
    <div class="panel panel-default">
        <div class="panel-heading">Notifications <button class="btn btn-xs btn-danger pull-right">Mark all as read</button></div>
        <div class="panel-body">
            <div class="notifications-container">
                <notification-card :data="notification" v-for="notification in notifications"></notification-card>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notifications: [
                    {
                        to: '#',
                        type: 'info',
                        icon: 'fa fa-heart-o',
                        content: '<a href="#">Laravel.io</a> now has notifications!',
                        created_at: '2017-07-11 02:07:52',
                    },
                    {
                        to: '#',
                        type: 'danger',
                        icon: 'fa fa-ban',
                        content: 'Your post has been deleted, pay attention to our rules.',
                        created_at: '2017-07-10 23:31:49',
                    },
                    {
                        to: '#',
                        icon: 'fa fa-reply',
                        image: 'https://s3.amazonaws.com/uifaces/faces/twitter/adellecharles/128.jpg',
                        content: '<a href="#">Lorena</a> replied you in a post!',
                        created_at: '2017-07-10 09:01:32',
                    },
                    {
                        to: '#',
                        type: 'read',
                        icon: 'fa fa-tag',
                        image: 'https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg',
                        content: '<a href="#">Mark</a> tagged you in a post!',
                        created_at: '2017-07-10 09:01:32',
                    },
                ],
            }
        }
    }
</script>

