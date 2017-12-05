<template>
    <div>
        <span style="margin-right:3px">{{count}}</span><i class="fa" :class="classes" @click="toggle"></i>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                count:0,
                isLiked: false
            }
        },
        computed:{
            classes(){
                return this.isLiked ? 'fa-thumbs-down text-danger' : 'fa-thumbs-up text-success';
            }
        },
        methods:{
            toggle(){
                return this.isLiked ? this.dislike() : this.like();
            },
            like(){
                //axios call
                console.log('like');
                this.count++;
                this.isLiked = true;
            },
            dislike(){
                //axios call
                console.log('dislike');
                this.count--;
                this.isLiked = false;
            }
        }
    }
</script>