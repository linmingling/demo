<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try {
            ace.settings.check('breadcrumbs', 'fixed')
        } catch (e) {
        }
    </script>

    <ul class="breadcrumb" style="padding: 8px 15px;">
        <{if $breadCrumbs}>
            <{foreach $breadCrumbs as $list}>
                <{if $smarty.foreach.loop.first == true}>
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="#">Home</a>
                    </li>
                <{else}>
                <li>
                    <{$list}>
                </li>
                <{/if}>
            <{/foreach}>
        <{/if}>
    </ul>
    <!-- .breadcrumb -->

    <div class="nav-search" id="nav-search">
        <form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input"
                                           id="nav-search-input" autocomplete="off">
									<i class="icon-search nav-search-icon"></i>
								</span>
        </form>
    </div>
    <!-- #nav-search -->
</div>