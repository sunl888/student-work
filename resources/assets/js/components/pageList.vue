<template>
	<div>
		<div class="page_num_box">
	                  显示:
	      <el-select @change="change()" class="page_num" size="small" v-model="perPage">
	          <el-option label="5" :value="5"></el-option>
	          <el-option label="10" :value="10"></el-option>
	          <el-option label="15" :value="15"></el-option>
	          <el-option label="20" :value="20"></el-option>
	          <el-option label="30" :value="30"></el-option>
	          <el-option label="40" :value="40"></el-option>
	      </el-select>
	      项结果
	    </div>
	    <el-pagination
	      class="page"
	      layout="prev, pager, next"
	      :total="total"
	      :current-page="currentPage"
	      :page-size="perPage"
	      @current-change="change">
	    </el-pagination> 		
	</div>
</template>
<script>
export default{
	props: {
		queryName: {
			type: String,
			default: null
		},
		total: {
			type: Number,
			default: 0
		},
		perPage: {
			type: Number,
			default: 20
		},
		currentPage: {
			type: Number,
			default: 1
		}
	},
	methods: {
		getList (page = 1, sort) {
                if(this.queryName){
                    this.loading = true;
                    this.$http.get(this.queryName, {
                        params: {
                            limit: this.perPage,
                            page
                        }
                    }).then(res => {
                       this.total = res.data.meta.pagination.total;
                        this.loading = false;
                        // this.perPage = res.data.meta.pagination.per_page
                    }).catch(err => {
                        this.loading = false;
                    })
                }
            },
            change (currentPage) {
                this.getList(currentPage);
            }
	}
}
</script>
<style>
	
</style>