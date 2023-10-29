createApp({
    setup() {
        const data = ref();
        
        const bread = ref([
            "首頁",
            "商品"
        ]);

        const handleEdit = (id) => {
            const url = ref("/managre/productEdit");
            if(id != undefined){
                url.value = `${ url.value }/${ id }`;
            }
            window.location.href = url.value;
        }

        const getApiData = {
            'table':{
                '0':"product",
            }
        }

        const handleDelete = (id) => {
            const url = ref("/managre/productEdit");
            const apiData = {
                'table':'product',
                'id':id
            }
            axios.post('/axios/deleteData', apiData)
            .finally(() => {
                getData();
            });
        }

        const getProductOderCount = () => {
            data.value.forEach((v, k) => {
                const params = {
                    'id': v.id,
                }
                axios.post('/axios/getProductOderCount', params)
                .then((res) => {
                    data.value[k].orderCount = res.data;
                })
            });
        }

        const getData = () => {
            axios.post('/axios/getData', getApiData)
            .then((res) => {
                data.value = res.data[0];
            })
            .finally(() => {
                getProductOderCount();
            });
        }

        const productDelivery = (id) => {
            params = {
                'id': id
            }
            axios.post('/axios/productDelivery', params)
            .then((res) => {
                getData();
            });
        }

        onMounted(() => {
            getData();
        })
        return {
            data,
            bread,
            handleEdit,
            handleDelete,
            productDelivery
        }
    },
}).use(ElementPlus).mount('#main-content')