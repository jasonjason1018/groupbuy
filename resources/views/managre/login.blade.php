@include('managre.include.head')
<link rel="stylesheet" href="/admin/css/bootstrap.min.css">
<link rel="stylesheet" href="/admin/css/bootstrap-theme.css">
<link rel="stylesheet" href="/admin/css/elegant-icons-style.css">
<link rel="stylesheet" href="/admin/css/font-awesome.css">
<link rel="stylesheet" href="/admin/css/style.css">
<link rel="stylesheet" href="/admin/css/style-responsive.css">
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
                <p class="login-img">後台</p>
                <div class="input-group">
                <span class="input-group-addon"><i class="icon_profile"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" autofocus v-model="form.username">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" v-model="form.password">
                </div>
                <div><center style="color:red">@{{ txt??"" }}</center></div>
                <label class="checkbox">
                    <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
                </label>
                <button class="btn btn-primary btn-lg btn-block" type="button" @click="login">Login</button>
            </div>
        </form>
    </div>
</section>
<script src="/admin/vue/login.js"></script>