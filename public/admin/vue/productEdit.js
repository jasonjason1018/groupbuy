createApp({
    setup() {
        const dialogVisible = ref(false);

        const select = ref({
            'select':'',
            'option': [{ value: "" }]
        });

        const inputs = ref([{ value: "" }]);

        const form = ref({
            name: '',
            description:'',
            sku:[],
            price:'',
            status:true,
            quantity:'',
            remark:'',
        })

        const nowPage = ref('編輯');

        const params = ref({
            'table':'product',
        });

        const bread = ref([
            "首頁",
            "商品"
        ]);

        const initBread = () => {
            if(id == ''){
                nowPage.value = '新增';
            }
            bread.value.push(`${ nowPage.value }商品`);
        }

        const initCKEditor = () => {
            CKEDITOR.replace('description');
        };

        const onSubmit = () => {
            form.value.description = CKEDITOR.instances['description'].getData();
            form.value.status = form.value.status?"1":"0";
            params.value.data = form.value;
            params.value.id = id;
            const url = '/axios/insertEdit';
            axios.post(url, params.value)
            .then((res) => {
                if(res.status == 200){
                    if(res.data == '請確認所有欄位是否都有填寫!'){
                        alert(res.data);
                        return false;
                    }
                    prev();
                }
            })
            .catch((err) => {
                console.error(`err:${err}`)
            })
        }

        const prev = () => {
            window.location.href = "/managre/product";
        }

        const getEditData = () => {
            if(id != ''){
                const url = '/axios/getEditData';
                const params = {
                    'table':'product',
                    'id':id
                }
                axios.post(url, params)
                .then((res) => {
                    form.value = res.data[0];
                    form.value.status = form.value.status?true:false;
                    form.value.sku = form.value.sku == null?[]:JSON.parse(form.value.sku);
                    console.log('FORM', form.value);
                })
            }
        }

        const addInput = () => {
            select.value.option.push({ value: "" });
        }

        const removeInput = (index) => {
            select.value.option.splice(index, 1)
        }

        const dialogOnSubmit  = async () => {
            const selectCopy = JSON.parse(JSON.stringify(select.value));
            form.value.sku.push(selectCopy);
            dialogVisible.value = false;
        }

        const clearSkuFlash = () => {
            select.value.select = '';
            select.value.option = [{ value: "" }]; 
        }

        const removeSku = (index) => {
            form.value.sku.splice(index, 1)
        }

        onMounted(() => {
            initBread();
            initCKEditor();
            getEditData();
        })

        
        return {
            bread,
            nowPage,
            form,
            onSubmit,
            prev,
            dialogVisible,
            addInput,
            removeInput,
            select,
            clearSkuFlash,
            dialogOnSubmit,
            removeSku,
        }
    },
}).use(ElementPlus).mount('#main-content')