<template>
    <div class="departments">
        <PresetGradePanel title="缺勤原因设置" getUrl="appraises/lates" url="appraise/lates"></PresetGradePanel>
    </div>
</template>
<script>
    import PresetGradePanel from '../../components/PresetGradePanel.vue'
    export default {
        components: {
            PresetGradePanel
        }
    }
</script>
<style scoped>
</style>