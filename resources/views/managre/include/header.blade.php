<style>
    [v-cloak] {
        display: none;
    }
</style>
<section id="header-content">
    <header class="header dark-bg">
        <div class="toggle-nav">
            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
        </div>

        <a href="/managre/index" class="logo">團購 <span class="lite">管理系統</span></a>

        <div class="nav search-row" id="top_menu">
            <ul class="nav top-menu">                    
                <li>
                    <form class="navbar-form">
                        <input class="form-control" placeholder="Search" type="text">
                    </form>
                </li>                    
            </ul>
        </div>

        <div class="top-nav notification-row">                
            <ul class="nav pull-right top-menu">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="profile-ava"></span>
                            <span class="username" v-cloak>{{ session('username') }}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up">
                            <img>
                        </div>
                        <li>
                            <a href="/admin/logout"><i class="icon_key_alt"></i> 登出</a>
                        </li>
                        <li><a></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>
</section>
<script src="/admin/vue/include/header.js"></script>