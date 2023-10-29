@include('managre.include.head')
<section id="main-content">
    <el-button size="middle" type="primary" @click="goToBackend">前往後台</el-button>
    <el-table :data="data" style="width:100%" border>
        <el-table-column align="center" label="商品名稱" prop="name"></el-table-column>
        <el-table-column align="center" label="商品資訊" prop="description">
            <template #default="scope">
                <div v-html="scope.row.description"></div>
            </template>
        </el-table-column>
        <el-table-column align="center" label="規格" prop="sku">
            <template #default="scope">
                <template v-for="(v, k) in scope.row.sku" :key="k">
                    <el-select :placeholder="`${v.select}`" v-model="sku[v.select]">
                        <template  v-for="(value, index) in v.option" :key="index">
                            <el-option :label="`${value.value}`" :value="`${ value.value }`"></el-option>
                        </template>
                    </el-select>
                </template>
            </template>
        </el-table-column>
        <el-table-column align="center" label="售價" prop="price"></el-table-column>
        <el-table-column align="center" label="備註">
            <el-input type="textarea" v-model="form.remark">
        </el-table-column>
        <el-table-column align="center" label="購買數量">
            <template #default="scope">
                <el-select placeholder="購買數量" v-model="form.buy_quantity">
                    <template v-for="quantity in scope.row.quantity" :key="quantity">
                        <el-option :label="quantity" :value="quantity"></el-option>
                    </template>
                </el-select>
            </template>
        </el-table-column>
        <el-table-column align="center">
            <template #default="scope">
                <el-button
                    size="small"
                    type="primary"
                    @click="buyThisProduct(`${scope.row.id}`)"
                >
                    購買
                </el-button>
            </template>
        </el-table-column>
    </el-table>

    <center>
        <el-button type="primary" v-if="offset != 1" @click="handlePagination('prev')">上一個商品</el-button>
        <el-button type="primary" v-if="offset < productTotal" @click="handlePagination('next')">下一個商品</el-button>
    </center>
</section>
<script src="/front/productList.js"></script>