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

        const handleDelete = (id) => {
            const params = {
                'table':'product',
                'id':id
            }
            Swal.fire({
                title: "確定刪除?",
                showCancelButton: true,
                confirmButtonText: "刪除",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/axios/deleteData', params)
                    .finally(() => {
                        getData();
                    });
                }
            });
        }

        const getData = () => {
            const params = {
                table:"product",
            }
            axios.post('/axios/getProductList', params)
            .then((res) => {
                console.log(res.data);
                data.value = res.data;
            })
            .finally(() => {
                //getProductOderCount();
            });
        }

        const productDelivery = (id, name) => {
            params = {
                id: id,
                productName: name
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