<template>
  <div class="work_type">
      <PreseDataPanel title="对口科室设置" getUrl="departments" url="department"></PreseDataPanel>
  </div>
</template>

<script>
import PreseDataPanel from '../../components/PresetDataPanel.vue'
export default {
  components: {
    PreseDataPanel
  }
}
</script>

<style lang="css">
.work_type{
}
</style>
