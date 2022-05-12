<template>
    <draggable :group="{ name: 'g1' }" :list="items" class="dragArea" tag="ul">
        <li :key="el.name" v-for="item in items">
            <slot :item="item"></slot>
            <nested-draggable :items="item.children"/>
        </li>
    </draggable>
</template>
<script>
    import draggable from "vuedraggable";

    export default {
        props: {
            items: {
                required: true,
                type: Array
            }
        },
        components: {
            draggable
        },
        name: "nested-draggable"
    };
</script>
<style scoped>
    .dragArea {
        min-height: 50px;
        outline: 1px dashed;
    }
</style>
