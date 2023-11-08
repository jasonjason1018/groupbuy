@include('managre.include.head')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <!-- <h3 class="page-header"><i class="fa fa-laptop"></i> 首頁</h3> -->
                <!-- <ol class="breadcrumb">
                    <li v-for="(v, k) in bread" :key="k"><i class="fa fa-home" v-if="k == 0"></i><a href="">@{{ v }}</a></li>
                </ol> -->
            </div>
            <div class="col-lg-12">
                <el-form :model="form" label-width="120px" >
                    
                    <el-form-item label="公司名稱">
                        <el-input v-model="form.company">
                    </el-form-item>

                    <el-form-item label="帳號">
                        <el-input v-model="form.username">
                    </el-form-item>

                    <el-form-item label="密碼">
                        <el-input type="password" show-password v-model="form.password">
                    </el-form-item>

                    <el-form-item label="liffId">
                        <el-input v-model="form.companyId">
                    </el-form-item>

                    <el-form-item label="Token">
                        <el-input type="password" show-password v-model="form.accessToken">
                    </el-form-item>
                    
                    <el-form-item label="狀態">
                        <el-switch v-model="form.status">
                    </el-form-item>
                    
                    <el-form-item>
                        <el-button @click="prev">上一頁</el-button>
                        <el-button type="primary" @click="onSubmit">@{{ nowPage }}</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </section>
</section>
<script>
    const id = @json($params)??'';
    const { createApp, ref, onMounted } = Vue;
    createApp({
        setup() {

        	const nowPage = id == ''?'新增':'編輯';
            
            const form = ref({
            	company: '',
            	username: '',
            	password: '',
            	companyId: '',
            	accessToken: '',
            	status: true
            });

            const getAdminEditData = () => {
                axios.post('/vendorAxios/getAdminData', {id: id})
                .then((res) => {
                    form.value = res.data[0];
                    form.value.status = form.value.status == 1?true:false;
                })
            }

            const onSubmit = () => {
            	axios.post('/vendorAxios/insertEditData', {form: form.value, id: id})
            	.then((res) => {
            		if(res.data != true){
            			alert(res.data);
            			return false;
            		}
					prev();
            	})
            }

            const prev = () => {
            	window.location.href="/vendor/index";
            }

            onMounted(() => {
            	if(id != ''){
            		getAdminEditData();
            	}
            });

            return {
                form,
                nowPage,
                onSubmit,
                prev,
            }
        },
    }).use(ElementPlus).mount('#main-content')
</script>
