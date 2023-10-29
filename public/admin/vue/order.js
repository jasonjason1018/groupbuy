createApp({
    setup() {
        const data = ref([]);
        const bread = ref([
            "首頁",
            "訂單"
        ]);

        const getOrderList = () => {
            axios.post('/axios/getOrderList')
            .then((res) => {
                data.value = res.data;
            });
        }
        
        onMounted(() => {
            getOrderList();
        })

        return {
            data,
            bread,
        }
    },
}).use(ElementPlus).mount('#main-content')