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
        props: ['replies', 'questionSlug']

    }
</script>

<style>

</style>