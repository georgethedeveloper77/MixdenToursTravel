<template>
    <div class="block-panel">
        <div class="block-title">
            {{item.name}}
            <div class="title-right">
                <span @click="deleteBlock" class="btn btn-light block-delete show-hover"><i
                    class="icon ion-ios-trash"></i></span>
                <span @click="openEdit" class="btn btn-light block-edit"><i class="icon ion-ios-build"></i></span>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                i18n: template_i18n
            }
        },
        props: {
            item: {},
            block: {},
            index: 0
        },
        methods: {
            openEdit() {
                editBlockScreen.openEdit(this.item, this.block);

            },
            deleteBlock() {
                let c = confirm(this.i18n.delete_confirm);

                if (!c) return;

                this.$emit('delete', this.index);
            }
        }
    }
</script>
