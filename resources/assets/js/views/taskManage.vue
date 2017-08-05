<template>
  <div class="taskManage item">
    <JHeader></JHeader>
    <navMenu></navMenu>
    <div class="item_man el-col-21">
      <div class="table" v-if="this.tableData.length">
        <el-table
          max-height="720px"
          @row-click="jump('TaskDetail')"
          :default-sort = "{prop: 'date', order: 'descending'}"
          :data="tableData"
          border
          stripe
          style="width: 100%">
          <el-table-column
            prop="date"
            sortable
            label="发布日期">
          </el-table-column>
          <el-table-column
            prop="name"
            sortable
            label="任务名称"
            min-width="180"
          >
          </el-table-column>
          <el-table-column
            prop="province"
            label="工作类型"
            sortable
          >
          </el-table-column>
          <el-table-column
            prop="city"
            label="对口科室"
            sortable
          >
          </el-table-column>
          <el-table-column
            prop="address"
            sortable
            label="责任人"
            min-width="100"
          >
          </el-table-column>
          <el-table-column
            prop="zip"
            label="截止时间"
            sortable
          ></el-table-column>
          <el-table-column
            prop="zip"
            label="完成时间"
            sortable
          >
          </el-table-column>
          <el-table-column
            prop="addFile"
            label="附件情况"
            sortable
          >
          </el-table-column>
          <!--<el-table-column-->
          <!--prop="addFile"-->
          <!--label="附件情况"-->
          <!--sortable-->
          <!--&gt;-->
          <!--</el-table-column>-->
          <el-table-column
            label="操作"
            width="130">
            <template scope="scope" class="operaBtn">
              <i  size="small" title="编辑" class="el-icon-edit" @click="jump('AddTask')"></i>
              <i  size="small" title="删除" @click="remove($index)" class="el-icon-delete"></i>
              <i size="small" title="审核" class="el-icon-check"></i>
            </template>
          </el-table-column>
        </el-table>
        <page></page>
      </div>
      <div class="ifNone" v-else>
        <p>
          当前还没有任务哦，请单击右侧按钮添加任务&emsp;
          <el-button type="primary" icon="plus" @click="jump('AddTask')"></el-button>
        </p>
      </div>
    </div>

  </div>
</template>
<script>
  import JHeader from '../components/header.vue'
  import page from '../components/page.vue'
  import navMenu from '../components/navMenu.vue'

  export default{
    components: {
      JHeader,
      page,
      navMenu
    },
    data () {
      return {
        tableData: [{
          date: '2017-06-21',
          name: '暑期留校注意事项',
          province: '常规工作',
          city: '学生管理',
          address: '学院负责人',
          zip: '2017-07-06',
          addFile: '有',
          taskStatus: '未完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }, {
          date: '2017-05-30',
          name: '学校招生',
          province: '常规工作',
          city: '学生管理',
          address: '学院负责人',
          zip: '2017-07-06',
          addFile: '有',
          taskStatus: '未完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }, {
          date: '2016-05-03',
          name: '2016~2017年度第二学期考前动员大会',
          province: '常规工作',
          city: '学生管理',
          address: '学院各辅导员',
          zip: '2017-06-28',
          addFile: '有',
          taskStatus: '未完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }, {
          date: '2016-05-03',
          name: '暑期留校注意事项',
          province: '常规工作',
          city: '学生管理',
          address: '学院负责人',
          zip: '2017-07-06',
          addFile: '有',
          taskStatus: '未完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }, {
          date: '2016-05-03',
          name: '暑期留校注意事项',
          province: '常规工作',
          city: '学生管理',
          address: '学院负责人',
          zip: '2017-07-06',
          addFile: '有',
          taskStatus: '未完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }, {
          date: '2016-05-03',
          name: '暑期留校注意事项',
          province: '常规工作',
          city: '学生管理',
          address: '学院负责人',
          zip: '2017-07-06',
          addFile: '有',
          taskStatus: '已完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }, {
          date: '2016-05-03',
          name: '暑期留校注意事项',
          province: '常规工作',
          city: '学生管理',
          address: '学院负责人',
          zip: '2017-07-06',
          addFile: '有',
          taskStatus: '已完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }, {
          date: '2016-05-03',
          name: '暑期留校注意事项',
          province: '常规工作',
          city: '学生管理',
          address: '学院负责人',
          zip: '2017-07-06',
          addFile: '有',
          taskStatus: '未完成',
          item: '随后，许江荣和全体党员职工一起学习了习近平总书记在中共中央政治局第三十三次集体学习时发表的重要讲话：严肃党内政治生活净化党内政治生态、为全面从严治党打下重要政治基础。学习了王岐山在贵州检查工作时的讲话：当好党内政治生态“护林员”，以新面貌新气象迎接十九大。会议结合《关于组织开展庆祝中国共产党成立96周年纪念活动的通知》精神，讨论了下一步学习与实践活动计划。 '
        }]
      }
    },
    methods: {
      remove (index) {
        this.tableData.splice(index, 1)
        console.log(123)
      },
      jump (address) {
        this.$router.push({name: address})
      }
    }
  }
</script>
<style>
  .el-table th{
    text-align:center;
  }
  .el-table{
    min-height:470px;
  }
  .el-table .cell i{
    margin-right:8px;
    cursor:pointer;
  }
  .el-table .cell i:hover{
    color:#20a0ff;
  }
  .ifNone p{
    line-height:400px;
    color:#aaa;
  }
  .el-form-item__content{
    line-height:30px;
    margin-left:40px;
  }
  .task_detail{
    color:#777;
    text-indent:2em;
    text-align:left;
    overflow : hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
  }
  .taskManage,.item_man,.table{
    height:83%;
  }
  .table{
    background:#f5f5f5;
  }
  .active{
    color:red;
  }
  .operaBtn i{
    width:14px;
    height:14px;
  }
  .el-table{
    cursor:pointer;
  }

</style>
