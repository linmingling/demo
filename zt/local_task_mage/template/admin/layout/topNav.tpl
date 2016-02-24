<div class="navbar navbar-default" id="navbar">
<script type="text/javascript">
    try{ace.settings.check('navbar' , 'fixed')}catch(e){}
</script>

<div class="navbar-container" id="navbar-container">
<div class="navbar-header pull-left">
    <a href="#" class="navbar-brand">
        <small>
            <i class="icon-leaf"></i>
            任务管理后台
        </small>
    </a><!-- /.brand -->
</div><!-- /.navbar-header -->

<div class="navbar-header pull-right" role="navigation">
    <ul class="nav ace-nav" style="height: auto">
        <li class="light-blue">
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" src="<{$config.imageUrl}>/user.jpg" alt="Jason's Photo">
			<span class="user-info">
				<small>欢饮您,</small>
				<{if $user['name']}>
					<{$user['name']}>
				<{/if}>
			</span>

                <i class="icon-caret-down"></i>
            </a>

            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <!--
                <li>
                    <a href="#">
                        <i class="icon-cog"></i>
                        Settings
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="icon-user"></i>
                        Profile
                    </a>
                </li>

                <li class="divider"></li>
                -->
                <li>
                    <a href="#">
                        <a href="<{$config['controllerUrl']}>/index.php?m=user&s=login&a=loginout">退出登录</a>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</div><!-- /.navbar-header -->
</div><!-- /.container -->
</div>