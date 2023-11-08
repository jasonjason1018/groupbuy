@include('managre.include.head')
<section id="main-content">
    <el-button size="middle" type="primary" @click="viewAllProduct">查看所有商品</el-button>
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
</section>
<script>
    const id = "{{ $id }}";
    const { createApp, ref, onMounted } = Vue;
    createApp({
        setup() {
            const data = ref();
            const sku = ref([]);
             const form = ref({
                buy_quantity:'',
                remark:''
            });

            const viewAllProduct = () => {
                window.open('/productList', '_blank');
            }

            const getProduct = () => {
                axios.post('/front/getProduct', {'id': id})
                .then((res) => {
                    res.data[0].sku = res.data[0].sku == '[]'?"":JSON.parse(res.data[0].sku);
                    data.value = res.data;
                })
            }

            onMounted(() => {
                getProduct();
            })

            return {
                data,
                viewAllProduct,
                id,
                sku,
                form,
            }
        },
    }).use(ElementPlus).mount('#main-content')
</script>