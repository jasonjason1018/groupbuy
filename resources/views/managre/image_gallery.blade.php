@extends('managre.layouts.listLayout')
@section('content')
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
	@include('managre.include.header')
	@include('managre.include.menu')
	<section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <h3 class="page-header"><i class="fa fa-laptop"></i> 首頁</h3> -->
                    <ol class="breadcrumb">
                        <li v-for="(v, k) in bread" :key="k"><i class="fa fa-home" v-if="k == 0"></i><a href="">@{{ v }}</a></li>
                    </ol>
                </div>
            </div>

            <div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" v-for="(v, k) in infoBox" :key="k">
                    <div class="info-box dark-bg">
                        <el-image src="https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg"></el-image>
                    </div>
                </div>
            </div>
        </section>
    </section>
	<script>
        createApp({
            setup() {
                const bread = ref([
                    "圖庫",
                ]);

                const infoBox = ref();

                const apiData = {
                    table:{
                        '商品':"product",
                        '訂單':"order_list",
                        '會員':"product"
                    }
                }

                const getData = () => {
                    axios.post('/axios/getIndexData', apiData)
                    .then((res) => {
                        infoBox.value = res.data
                    });
                }

                onMounted(() => {
                    getData();
                })

                return {
                    infoBox,
                    bread
                }
            },
        }).use(ElementPlus).mount('#main-content')
    </script>
@endsection