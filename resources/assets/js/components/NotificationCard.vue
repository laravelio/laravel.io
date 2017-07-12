<template>
    <li :class="['notification',  notification.read_at ? 'read' : notification.type]">
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
        <div class="icon-group" v-if="typeof notification.read_at !== 'undefined' && ! notification.read_at">
            <i class="fa fa-check" @click.stop="markAsRead"></i>
        </div>
    </li>
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
                format: 'YYYY-MM-DD HH:mm:ss',
            }
        },

        computed: {
            dateFromNow() {
                return moment(this.notification.created_at, this.format).fromNow();
            }
        },

        methods: {
            markAsRead() {
                this.notification.read_at = moment().format(this.format);
            }
        }
    }
</script>
