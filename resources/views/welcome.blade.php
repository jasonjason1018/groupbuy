<script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<link rel="stylesheet" href="//unpkg.com/element-plus/dist/index.css" />
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//unpkg.com/element-plus"></script>
<script src="//unpkg.com/@element-plus/icons-vue"></script>
<!-- <a href="/admin/login"><button>後台</button></a>
<a href="/vendor/login"><button>站方後台</button></a> -->
<section id="main-content">
    <!-- <div>@{{ liffId }}</div> -->
    <el-table :data="data" style="width:100%" border>
        <el-table-column label="LIFF ID" prop="liffId" align="center"></el-table-column>
    </el-table>
</section>
<script>
    const { createApp, ref, onMounted } = Vue;
    createApp({
        setup() {
            const data = ref([]);
            const liffId = ref();
            const message = ref();

            onMounted(() => {
                liffId.value = location.pathname.split('/')[1];
                liff.init({
                    liffId: liffId.value
                })
                .then((res) => {
                    //console.log(liff.isLoggedIn());
                    data.value.push({ liffId: liffId.value, message: 'OK' });
                })
                .catch((err) => {
                    message.value = err;
                    data.value.push({ liffId: liffId.value, message: err });
                    console.error(message.value);
                })
                console.log('data', data.value);
                // data.value.push({ liffId: liffId.value, message: message.value });
            });

            return {
                data
            }
        },
    }).use(ElementPlus).mount('#main-content')
</script>