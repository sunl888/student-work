<template>
  <div class="taskDetail">
    <div class="current">
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <h2 style="line-height: 36px;color: #444;">{{'任务名称：' + tableData.name}}</h2>
        </div>
        <div class="text item">
          <div>发布日期：<span>{{ tableData.createDate }}</span></div>
          <div>工作类型：<span>{{ tableData.province }}</span></div>
          <div> 对口科室：<span>{{ tableData.city }}</span></div>
          <div> 负责人：<span>{{ tableData.address }}</span></div>
          <div>截止日期：<span>{{ tableData.zip }}</span></div>
          <div>附件情况：<span>{{ tableData.addFile }}</span></div>
          <p class="content"><span>{{ tableData.item}}</span></p>
        </div>
    <div class="taskWatch">
      <template>
        <el-table
          border
          stripe
          height="300"
          :data="xueyuan"
          style="width: 100%">
          <el-table-column
            sortable
            prop="section"
            label="学院"
            min-width="200">
          </el-table-column>
          <el-table-column
            prop="time"
            sortable
            label="完成时间"
            min-width="130">
          </el-table-column>
          <el-table-column
            prop="status"
            sortable
            label="任务状态">
          </el-table-column>
          <el-table-column
            label="操作"
            width="130">
            <template scope="scope" class="operaBtn">
              <i size="small" title="审核" @click="jump('taskScore')" class="el-icon-check"></i>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </div>
      </el-card>
    </div>
  </div>

</template>
<script>
export default{
  methods: {
    jump (address) {
      this.$router.push({name: address})
    }
  },
  data () {
    return {
      tableData: {
        createDate: '2017-06-21',
        name: '暑期留校注意事项',
        province: '常规工作',
        city: '学生管理',
        address: '学院负责人',
        zip: '2017-07-06',
        addFile: '有',
        item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
      },
      xueyuan: [{
        section: '计算机学院',
        time: '2016-05-02',
        status: '已完成'
      }, {
        section: '化学与材料工程学院',
        time: '无',
        status: '未完成'
      }, {
        section: '电子工程学院',
        time: '无',
        status: '未完成'
      }, {
        section: '经济与管理学院',
        time: '2016-05-02',
        status: '已完成'
      }, {
        section: '美术与设计学院',
        time: '无',
        status: '未完成'
      }, {
        section: '文化创意与传播学院',
        time: '2016-05-02',
        status: '已完成'
      }, {
        section: '音乐与舞蹈学院',
        time: '2016-05-02',
        status: '已完成'
      }, {
        section: '金融学院',
        time: '2016-05-02',
        status: '已完成'
      }]
    }
  }
}
</script>
<style scoped>
.box-card{
  margin-top:20px;
  padding-bottom:50px;
}
.current p{
  margin-top:10px;
  text-align:left;
}
.taskDetail{
  height:100%;
  width: 100%;
}
.clearfix:before,
.clearfix:after {
  display: table;
  content: "";
}
.clearfix:after {
  clear: both
}
.text{
  font-size: 14px;
}
.operaBtn i{
  cursor:pointer;
}
.text>div{
  display:inline;
  color:#888;
  margin-right:25px;
}
.text>p.content{
  color:#888;
  padding: 15px 30px;
  line-height: 2;
  font-size: 16px;
  text-indent: 2em;
}
.text>div span,.text>p span{
  color:#333;
}
.el-card__header{
  padding:5px;
}
.taskWatch{
  text-align:center;
  margin-top:20px;
}
</style>
