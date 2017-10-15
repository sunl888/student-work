<template>
  <div class="work_type">
      <PreseSemesterPanel title="学期学年设置" getUrl="semesters" url="semester"></PreseSemesterPanel>
  </div>
</template>

<script>
import PreseSemesterPanel from '../../components/PresetSemesterPanel.vue'
export default {
  components: {
    PreseSemesterPanel
  }
}
</script>

<style lang="css">
.work_type{
}
</style>
