@extends('managre.layouts.listLayout')
@section('content')
    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-theme.css" rel="stylesheet">
    <link href="/admin/css/elegant-icons-style.css" rel="stylesheet" />
    <link href="/admin/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/style-responsive.css" rel="stylesheet" />
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
                <div class="col-lg-12">
                    <el-table :data="data" style="width:100%" border>
                        <el-table-column label="序號" prop="id" align="center"></el-table-column>
                        <el-table-column label="購買人" prop="buyer" align="center"></el-table-column>
                        <el-table-column label="商品名稱" prop="product_name" align="center"></el-table-column>
                        <el-table-column label="購買日期" prop="buy_date" align="center"></el-table-column>
                        <el-table-column label="領貨日期" prop="delivery_date" align="center"></el-table-column>
                        <el-table-column label="備註" prop="remark" align="center"></el-table-column>
                        <el-table-column label="購買數量" prop="buy_quantity" align="center"></el-table-column>
                        <el-table-column label="訂單總金額" prop="total_price" align="center"></el-table-column>
                        <!-- <el-table-column align="center">
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
                        </el-table-column> -->
                    </el-table>
                </div>
            </div>
        </section>
    </section>
    <script src="/admin/vue/order.js"></script>
@endsection
