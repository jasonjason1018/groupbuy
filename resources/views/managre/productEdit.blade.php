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
                    <el-form :model="form" label-width="120px" >
                        
                        <el-form-item label="商品名稱">
                            <el-input v-model="form.name">
                        </el-form-item>

                        <el-form-item label="商品說明">
                            <!-- <el-input type="textarea" v-model="form.description"> -->
                            <textarea id="description" v-model="form.description"></textarea>
                        </el-form-item>
                        
                        <el-form-item label="規格">
                            <el-button size="small" type="primary" text @click="dialogVisible = true">
                                新增規格
                            </el-button>
                            
                            <template  v-for="(v, k) in form.sku" :key="k">
                                <el-select :placeholder="`${v.select}`">
                                    <template  v-for="(value, index) in v.option" :key="index">
                                        <el-option :label="`${value.value}`"></el-option>
                                    </template>
                                </el-select>
                                <el-button @click="removeSku(k)">刪除</el-button>
                                &nbsp;&nbsp;
                            </template>
                            
                            <el-dialog v-model="dialogVisible" title="新增規格" align-center @close="clearSkuFlash">
                                <el-form :model="form" label-width="120px" >
                                    <el-form-item label="規格名稱">
                                        <el-input v-model="select.select" placeholder="(ex.尺寸、顏色...)"></el-input>
                                    </el-form-item>
                                    <el-form-item label="  ">
                                        <el-button @click="addInput">新增</el-button>
                                    </el-form-item>
                                    <el-form-item label="  " v-for="(input, index) in select.option" :key="index">
                                        <span>
                                            <el-input
                                                v-model="input.value"
                                                placeholder="Please input"
                                            >
                                                <template #append v-if="select.option.length > 1">
                                                    <el-button @click="removeInput(`${ index }`)">刪除</el-button>
                                                </template>
                                            </el-input>
                                        </span>
                                    </el-form-item>
                                </el-form>
                                <template #footer>
                                    <span class="dialog-footer">
                                        <el-button @click="dialogVisible = false">Cancel</el-button>
                                        <el-button type="primary" @click="dialogOnSubmit">
                                            Confirm
                                        </el-button>
                                    </span>
                                </template>
                            </el-dialog>
                        </el-form-item>

                        <el-form-item label="價格">
                            <el-input v-model="form.price">
                        </el-form-item>
                        
                        <el-form-item label="狀態">
                            <el-switch v-model="form.status">
                        </el-form-item>

                        <el-form-item label="商品數量">
                            <el-input v-model="form.quantity">
                        </el-form-item>

                        <el-form-item label="備註">
                            <el-input type="textarea" v-model="form.remark"></el-textarea>
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
    </script>
	<script src="/admin/vue/productEdit.js"></script>
@endsection
