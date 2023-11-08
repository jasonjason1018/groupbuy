@include('managre.include.head')
@include('vendor.include.header')
@include('vendor.include.menu')
<link rel="shortcut icon" href="img/favicon.png">
<link href="/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="/admin/css/bootstrap-theme.css" rel="stylesheet">
<link href="/admin/css/elegant-icons-style.css" rel="stylesheet" />
<link href="/admin/css/font-awesome.min.css" rel="stylesheet" />    
<link href="/admin/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
<link href="/admin/assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
<link href="/admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
<link rel="stylesheet" href="/admin/css/owl.carousel.css" type="text/css">
<link href="/admin/css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
<link rel="stylesheet" href="/admin/css/fullcalendar.css">
<link href="/admin/css/widgets.css" rel="stylesheet">
<link href="/admin/css/style.css" rel="stylesheet">
<link href="/admin/css/style-responsive.css" rel="stylesheet" />
<link href="/admin/css/xcharts.min.css" rel=" stylesheet">  
<link href="/admin/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
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
                <el-table :data="data" style="width:100%" border>
                    <el-table-column label="序號" prop="id" align="center"></el-table-column>
                    <el-table-column label="使用者名稱" prop="username" align="center"></el-table-column>
                    <el-table-column label="公司名稱" prop="company" align="center"></el-table-column>
                    <el-table-column label="狀態" align="center">
                        <template #default="scope">
                            <template v-if="scope.row.status == 1">
                                <div style="color:green">啟用</div>
                            </template>
                            <template v-else>
                                <div style="color:red">關閉</div>
                            </template>
                        </template>
                    </el-table-column>
                    <!-- <el-table-column label="" prop="" align="center"></el-table-column> -->
                    <el-table-column align="center">
                        <template #header>
                            <el-button size="small" type="primary" @click="handleEdit()">新增</el-button>
                        </template>
                        <template #default="scope">
                            <el-button
                                size="small"
                                @click="handleEdit(`${scope.row.id}`)"
                            >
                                編輯
                            </el-button>
                            <el-button
                                size="small"
                                type="danger"
                                @click="handleDelete(`${scope.row.id}`)"
                            >
                                刪除
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </section>
</section>
<script>
    const { createApp, ref, onMounted } = Vue;
    createApp({
        setup() {
            
            const data = ref();
            
            const handleEdit = (id = '') => {
                const url = ref('/vendor/adminEdit');
                if(id != ''){
                    url.value = `${url.value}/${id}`;
                }
                window.location.href = url.value;
            }

            const getAdminData = () => {
                axios.post('/vendorAxios/getAdminData')
                .then((res) => {
                    data.value = res.data;
                })
            }

            const handleDelete = (id) => {
                Swal.fire({
                    title: "確定刪除?",
                    showCancelButton: true,
                    confirmButtonText: "刪除",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/vendorAxios/deleteData', {id: id})
                        .finally(() => {
                            getAdminData();
                        })     
                    }
                });
            }

            onMounted(() => {
                getAdminData();
            });

            return {
                data,
                handleEdit,
                handleDelete,
            }
        },
    }).use(ElementPlus).mount('#main-content')
</script>