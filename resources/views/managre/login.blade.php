<script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<link rel="stylesheet" href="//unpkg.com/element-plus/dist/index.css" />
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//unpkg.com/element-plus"></script>
<script src="//unpkg.com/@element-plus/icons-vue"></script>
<style>
    [v-cloak] {
        display: none;
    }

    body {
        background: url('/admin/img/bg-1.jpg');
        /* width: 100%;
        height: 100%; */
    }
</style>
<section id="main-content" v-cloak>
    <div class="container">
        <form class="login-form">        
            <div class="login-wrap">
                <p class="login-img">後台{{ $params }}</p>
                <div class="input-group">
                <span class="input-group-addon"><i class="icon_profile"></i></span>
                <!-- <input type="text" name="username" class="form-control" placeholder="Username" autofocus v-model="form.username">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" v-model="form.password">
                </div>
                <div><center style="color:red">@{{ errMsg??"" }}</center></div>
                <label class="checkbox">
                    <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
                </label> -->
                <button class="btn btn-primary btn-lg btn-block" type="button" @click="login">Login</button>
            </div>
        </form>
    </div>
</section>
<!-- <script src="/admin/vue/login.js"></script> -->
<script>
    const { createApp, ref, onMounted } = Vue;
    createApp({
        setup() {
            const liffId = ref();
            onMounted(() => {
                liffId.value = "{{ $params }}";
                liff.init({
                    liffId: liffId.value,
                })
                .then(() => {
                    if(!liff.isLoggedIn()){
                        alert('電腦版本無發使用推播訊息功能');
                        return false;
                    }
                    alert(JSON.stringify(liff.getContext()));
                })
                .catch((err) => {
                    message.value = err;
                    data.value.push({ liffId: liffId.value, message: 'err' });
                    console.error(message.value);
                })
            });

            return {
                
            }
        },
    }).use(ElementPlus).mount('#main-content')
</script>