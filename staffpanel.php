<?php
ob_start();
require_once("include/bittorrent.php");
dbconn();
require_once(get_langfile_path());
loggedinorreturn();
stdhead($lang_staffpanel['title_admin']);
print("<h1 align=center>".$lang_staffpanel['title_admin']."</h1>");
?>
<?php
if (get_user_class() < UC_MODERATOR)
{
	stdmsg($lang_staffpanel['permission_err'],$lang_staffpanel['permission_err_dt']);
	stdfoot();
	exit;
}
else {
?>
<div class="row">
<div class="container">
<div role="tabpanel">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">主页</a></li>
		<li role="presentation"><a href="#user" aria-controls="user" role="tab" data-toggle="tab">用户</a></li>
		<li role="presentation"><a href="#site" aria-controls="site" role="tab" data-toggle="tab">网站</a></li>
		<li role="presentation"><a href="#tool" aria-controls="tool" role="tab" data-toggle="tab">工具</a></li>
		<li role="presentation"><a href="#webmaster" aria-controls="tool" role="tab" data-toggle="tab">站长</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="home">欢迎使用网站后台！</div>
		<div role="tabpanel" class="tab-pane fade" id="user" style="margin-top:20px;">
		<div class="list-group">
		<?php if (get_user_class() >= UC_MODERATOR) {?>
			<a href="ipcheck.php" class="list-group-item">
				<h4 class="list-group-item-heading">同 IP 登录查询</h4>
				<p class="list-group-item-text">查询相同 IP 的用户。</p>
			</a>
			<a href="allagents.php" class="list-group-item">
				<h4 class="list-group-item-heading">在线客户端</h4>
				<p class="list-group-item-text">查询在线（下载 / 上传 / 做种）的客户端。</p>
			</a>
			<a href="uploaders.php" class="list-group-item">
				<h4 class="list-group-item-heading">发布员管理</h4>
				<p class="list-group-item-text">查询发布员统计信息。</p>
			</a>
			<a href="amountbonus.php" class="list-group-item">
				<h4 class="list-group-item-heading">给予魔力值</h4>
				<p class="list-group-item-text">对所有用户都给予若干量魔力值。</p>
			</a>
		<?php }?>
		<?php if (get_user_class() >= UC_ADMINISTRATOR) {?>
			<a href="adduser.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">添加用户</h4>
				<p class="list-group-item-text">在后台添加新用户。</p>
			</a>
			<a href="reset.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">重置密码</h4>
				<p class="list-group-item-text">忘记密码了，可以在这里重新设置</p>
			</a>
			<a href="staffmess.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">批量 PM</h4>
				<p class="list-group-item-text">对所有用户发送消息。</p>
			</a>
		<?php }?>
		<?php if (get_user_class() >= UC_SYSOP) {?>
			<a href="deletedisabled.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">删除被禁用户</h4>
				<p class="list-group-item-text">删除所有被封禁的用户。</p>
			</a>
			<a href="amountupload.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">给予上传量</h4>
				<p class="list-group-item-text">给予用户上传量。</p>
			</a>
		<?php }?>
		</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="site" style="margin-top:20px;">
		<div class="list-group">
		<?php if (get_user_class() >= UC_MODERATOR) {?>
			<a href="admanage.php" class="list-group-item">
				<h4 class="list-group-item-heading">广告管理</h4>
				<p class="list-group-item-text">输入广告代码，在网站中展示广告。</p>
			</a>
			<a href="stats.php" class="list-group-item">
				<h4 class="list-group-item-heading">统计信息</h4>
				<p class="list-group-item-text">网站的统计信息。</p>
			</a>
		<?php }?>
		<?php if (get_user_class() >= UC_ADMINISTRATOR) {?>
			<a href="polloverview.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">投票概况</h4>
				<p class="list-group-item-text">每个投票的情况。</p>
			</a>
			<a href="freeleech.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">活动模式</h4>
				<p class="list-group-item-text">是给用户发福利的时候了。</p>
			</a>
			<a href="faqmanage.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">常见问题管理</h4>
				<p class="list-group-item-text">编辑网站的常见问题。</p>
			</a>
			<a href="modrules.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">规则管理</h4>
				<p class="list-group-item-text">编辑网站的规则。</p>
			</a>
			<a href="catmanage.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">种子分类管理</h4>
				<p class="list-group-item-text">编辑网站的种子分类。</p>
			</a>
		<?php }?>
		<?php if (get_user_class() >= UC_SYSOP) {?>
			<a href="forummanage.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">论坛管理</h4>
				<p class="list-group-item-text">管理论坛版块。</p>
			</a>
		<?php }?>
		</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="tool" style="margin-top:20px;">
		<div class="list-group">
		<?php if (get_user_class() >= UC_MODERATOR) {?>
			<a href="cheaters.php" class="list-group-item">
				<h4 class="list-group-item-heading">异常流量</h4>
				<p class="list-group-item-text">寻找作弊用户。</p>
			</a>
			<a href="testip.php" class="list-group-item">
				<h4 class="list-group-item-heading">测试 IP</h4>
				<p class="list-group-item-text">测试 IP 地址是否被封禁。</p>
			</a>
			<a href="clearcache.php" class="list-group-item">
				<h4 class="list-group-item-heading">清理缓存</h4>
				<p class="list-group-item-text">清理 Memcache 产生的缓存。</p>
			</a>
		<?php }?>
		<?php if (get_user_class() >= UC_ADMINISTRATOR) {?>
			<a href="warned.php" class="list-group-item list-group-item-warning">
				<h4 class="list-group-item-heading">被警告用户</h4>
				<p class="list-group-item-text">查看当前被警告的用户。</p>
			</a>
		<?php }?>
		<?php if (get_user_class() >= UC_SYSOP) {?>
			<a href="mysql_stats.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">MySQL 统计</h4>
				<p class="list-group-item-text">查看 MySQL 数据库统计信息。</p>
			</a>
			<a href="massmail.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">批量发送 E-Mail</h4>
				<p class="list-group-item-text">发送 E-Mail 给所有用户。</p>
			</a>
			<a href="docleanup.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">执行清理</h4>
				<p class="list-group-item-text">清理所有产生的缓存。</p>
			</a>
			<a href="bans.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">IP 封禁</h4>
				<p class="list-group-item-text">对 IP 地址进行封禁 / 解封操作。</p>
			</a>
			<a href="maxlogin.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">登录失败查询</h4>
				<p class="list-group-item-text">查询企图登录的用户。</p>
			</a>
			<a href="bitbucketlog.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">图片上传</h4>
				<p class="list-group-item-text">查询图片上传记录。</p>
			</a>
			<a href="bannedemails.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">邮箱黑名单</h4>
				<p class="list-group-item-text">不允许注册的邮箱。</p>
			</a>
			<a href="allowedemails.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">邮箱白名单</h4>
				<p class="list-group-item-text">允许注册的邮箱。</p>
			</a>
			<a href="location.php" class="list-group-item list-group-item-danger">
				<h4 class="list-group-item-heading">IP 数据库</h4>
				<p class="list-group-item-text">管理 IP 地址的归属地、ISP、上传下载网速等。</p>
			</a>
		<?php }?>
		</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="webmaster">欢迎使用网站后台！</div>
	</div>
</div>
</div>
</div>
<?php }
stdfoot();
?>
