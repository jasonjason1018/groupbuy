const { createApp, ref, onMounted } = Vue;
createApp({
    setup() {
        const form = ref({
            'username':'',
            'password':'',
            'table':'admin_member',
            'login':true
        });
        const errMsg = ref();

        const login = () => {
            if(form.value.username == '' || form.value.password == ''){
                errMsg.value = form.value.username == ''?"帳號不可為空!":"密碼不可為空!";
                return false;
            }
            errMsg.value = "";
            const url = "/checkLogin";
            axios.post(url, form.value)
            .then((res) => {
                if(res.data){
                    window.location = '/managre/index';
                    return false;
                }
                errMsg.value = "帳號或密碼錯誤";
            })
            .catch((err) => {
                console.error(`Error: ${err}`);
            })
        }
        
        return {
            form,
            login,
            errMsg
        }
    },
}).use(ElementPlus).mount('#main-content')