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
        <el-table-column label="UserId" prop="userId" align="center"></el-table-column>
    </el-table>
    <el-table :data="product_data" style="width:100%" border>
        <el-table-column label="品名" prop="name" align="center"></el-table-column>
        <el-table-column label="圖片" prop="img" align="center">
            <template #default="scope">
                <img :src="scope.row.img" style="width: 200px;">
            </template>
        </el-table-column>
        <el-table-column align="center">
            <template #default="scope">
                <el-button @click="share(scope.row)">分享</el-button>
            </template>
        </el-table-column>
    </el-table>
</section>
<script>
    const { createApp, ref, onMounted } = Vue;
    createApp({
        setup() {
            const data = ref([]);
            const liffId = ref();
            const message = ref();
            const product_data = ref([
                {
                    name: '書',
                    img: 'https://image.knowing.asia/3d4b0acf-a65d-4839-87f3-51cd4deb7539/6e6551ddf6e18cc68e51aff08a412641.png',
                },
                {
                    name: '筆',
                    img: 'https://img.tw.my-best.com/content_section/choice_component/sub_contents/c0744f32ce1b59807bce75875385035f.jpg?ixlib=rails-4.3.1&q=70&lossless=0&w=690&fit=max&s=d8362f6c114f1c1893a2dd31c2034430',
                },
            ]);

            onMounted(() => {
                liffId.value = '2000777378-djn4NEmW';
                liff.init({
                    liffId: liffId.value,
                })
                .then(() => {
                    // if(!liff.isLoggedIn()){
                    //     liff.login();
                    // }
                    data.value.push({ liffId: liffId.value, userId: liff.getContext().userId });
                    alert(JSON.stringify(liff.getContext()));
                })
                .catch((err) => {
                    message.value = err;
                    data.value.push({ liffId: liffId.value, message: 'err' });
                    console.error(message.value);
                })
            });

            const share = (scope) => {
                console.log(liff.getContext());
                // alert(JSON.stringify(liff.getContext()));
                // return false;
                liff.sendMessages([
                    {
                        type:'template',
                        altText: 'alt text',
                        template: {
                            type: 'buttons',
                            thumbnailImageUrl: scope.img,
                            title: 'title',
                            text: scope.name,
                            actions: [
                                {
                                    type: 'uri',
                                    label: 'label',
                                    uri: 'https://google.com'
                                }
                            ]
                        }
                    },
                ]);
            }

            return {
                data,
                product_data,
                share,
            }
        },
    }).use(ElementPlus).mount('#main-content')
</script>