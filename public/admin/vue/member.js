createApp({
    setup() {
        const data = ref([]);
        const bread = ref([
            "首頁",
            "會員"
        ]);

        const getMemberData = () => {
            axios.post('/axios/getMemberData')
            .then((res) => {
                data.value = res.data;
                console.log(res.data);
            });
        }

        onMounted(() => {
            getMemberData();
            //data.value.push({'name':"jason", 'address':"address", 'mobile':'mobile'})
        })
        return {
            data,
            bread
        }
    },
}).use(ElementPlus).mount('#main-content')