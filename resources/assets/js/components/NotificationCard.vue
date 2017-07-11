<template>
    <div :class="['notification', notification.type]">
        <div class="icon">
            <i :class="notification.icon"></i>
        </div>
        <div class="profile-image" v-if="notification.image">
            <img :src="notification.image">
        </div>
        <div class="content">
            <div v-html="notification.content"></div>
            <small v-text="dateFromNow"></small>
        </div>
        <div class="icon-group">
            <i class="fa fa-check"></i>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                required: true,
            },
        },

        data() {
            return {
                notification: this.data,
            }
        },

        computed: {
            dateFromNow() {
                return moment(this.notification.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
            }
        }
    }
</script>
