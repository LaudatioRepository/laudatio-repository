<template>
    <dl>
        <dt>{{item.label}}</dt>
        <dd>{{item.language}}</dd>
    </dl>
</template>
<script>
    export default {
        props: ['item'],
    }
</script>