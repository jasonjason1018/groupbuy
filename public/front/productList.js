const { createApp, ref, onMounted } = Vue;
createApp({
    setup() {
        const offset = ref(1);
        const productTotal = ref(0);
        const data = ref();
        const form = ref({
            buy_quantity:'',
            remark:''
        });
        const sku = ref([]);

        const goToBackend = () => {
            // location.href="/admin/login";
            window.open('/admin/login', '_blank');
        }

        const handlePagination = (type) => {
            if(type == 'next'){
                offset.value ++;
            }else{
                offset.value --;
            }
            sku.value = [];
            form.value.buy_quantity = '';
            form.value.remark = '';
            getProductTotal();
        }

        const getProductTotal = () => {
            axios.post('front/getProductTotal')
            .then((res) => {
                console.log(res.data);
                productTotal.value = res.data
            })
            .finally(() => {
                getProductList();
            });
        }

        const getProductList = () => {
            axios.post('/front/getProductId')
            .then((resp) => {
                console.log('re', resp.data);
                if(resp.data != ''){
                    offset.value = resp.data;
                }
            })
            .finally(() => {
                axios.post('front/getProductList', { 'offset':offset.value })
                .then((res) => {
                    res.data[0].sku = res.data[0].sku == '[]'?"":JSON.parse(res.data[0].sku);
                    data.value = res.data;
                })
            })
        }

        const getSku = (sku) => {
            return JSON.parse(sku);
        }

        const buyThisProduct = (id) => {
            const arr_sku = [];
            const msg = ref();
            for (const v of data.value[0].sku) {
                if (sku.value[v.select] === undefined) {
                    msg.value = 'err';
                    break;
                }
                arr_sku.push({ 'name': v.select, 'value': sku.value[v.select] });
            }
            if(msg.value == 'err'){
                alert('請選擇商品規格!!');
                msg.value = '';
                return false;
            }
            
            if(form.value.buy_quantity == ''){
                alert('請選擇購買數量');
                return false;
            }
            form.value.totalPrice = data.value[0].price * form.value.buy_quantity;
            form.value.quantity = data.value[0].quantity;
            form.value.productId = data.value[0].id;
            form.value.product_name = id;
            form.value.sku = arr_sku;

            axios.post('/front/userBuyProduct', form.value)
            .then((res) => {
                if(res.data == 'undefined'){
                    window.location.href = "/";
                    return false;
                }
                sku.value = [];
                form.value.buy_quantity = '';
                form.value.remark = '';
                getProductList();
            })

        }

        onMounted(() => {
            getProductTotal();
        })

        return {
            data,
            goToBackend,
            getSku,
            buyThisProduct,
            form,
            sku,
            offset,
            productTotal,
            handlePagination,
        }
    },
}).use(ElementPlus).mount('#main-content')