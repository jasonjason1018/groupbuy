createApp({
    setup() {
    	const bread = ref([
    		"首頁",
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