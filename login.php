<?php
require_once("include/bittorrent.php");
dbconn();

$langid = 0 + $_GET['sitelanguage'];
if ($langid)
{
	$lang_folder = validlang($langid);
	if(get_langfolder_cookie() != $lang_folder)
	{
		set_langfolder_cookie($lang_folder);
		header("Location: " . $_SERVER['PHP_SELF']);
	}
}
require_once(get_langfile_path("", false, $CURLANGDIR));

failedloginscheck ();
cur_user_check () ;
stdhead($lang_login['head_login']);

$s = "<select class=\"form-control\" style=\"width:20%;\" name=\"sitelanguage\" onchange='submit()'>\n";

$langs = langlist("site_lang");

foreach ($langs as $row)
{
	if ($row["site_lang_folder"] == get_langfolder_cookie()) $se = "selected=\"selected\""; else $se = "";
	$s .= "<option value=\"". $row["id"] ."\" ". $se. ">" . htmlspecialchars($row["lang_name"]) . "</option>\n";
}
$s .= "\n</select>";
?>
<form class="form-inline" method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<?php
print("<div align=\"right\">".$lang_login['text_select_lang']. $s . "</div>");
?>
</form>
<?php

unset($returnto);
if (!empty($_GET["returnto"])) {
	$returnto = $_GET["returnto"];
	if (!$_GET["nowarn"]) {
		print("<h1>" . $lang_login['h1_not_logged_in']. "</h1>\n");
		print("<p><b>" . $lang_login['p_error']. "</b> " . $lang_login['p_after_logged_in']. "</p>\n");
	}
}
?>
<div class="row" style="padding-top:10px;">
<div class="col-sm-4">
<div class="alert alert-danger"><?php echo $lang_login['p_you_have']?> <b><?php echo remaining ();?></b> <?php echo $lang_login['p_remaining_tries']?></div>
<form class="form-horizontal" role="form" method="post" action="takelogin.php">
<div class="form-group">
<label for="username" class="col-sm-4 control-label"><?php echo $lang_login['rowhead_username']?></label>
<div class="col-sm-8"><input class="form-control" type="text" name="username" id="username" placeholder="输入..." required autofocus /></div>
</div>
<div class="form-group">
<label for="password" class="col-sm-4 control-label"><?php echo $lang_login['rowhead_password']?></label>
<div class="col-sm-8"><input class="form-control" type="password" name="password" id="password" placeholder="输入..." required/></div>
</div>
<?php
show_image_code ();
if ($securelogin == "yes") 
	$sec = "checked=\"checked\" disabled=\"disabled\"";
elseif ($securelogin == "no")
	$sec = "disabled=\"disabled\"";
elseif ($securelogin == "op")
	$sec = "";

if ($securetracker == "yes") 
	$sectra = "checked=\"checked\" disabled=\"disabled\"";
elseif ($securetracker == "no")
	$sectra = "disabled=\"disabled\"";
elseif ($securetracker == "op")
	$sectra = "";
?>
<div class="form-group">
<label class="col-sm-4 control-label"><?php echo $lang_login['text_advanced_options']?></label>
</div>
<div class="form-group">
<label class="col-sm-4 control-label" for="logout"><?php echo $lang_login['text_auto_logout']?></label>
<div class="checkbox col-sm-8"><label><input type="checkbox" id="logout" name="logout" value="yes" /><?php echo $lang_login['checkbox_auto_logout']?></label>
</div></div>
<div class="form-group">
<label class="col-sm-4 control-label" for="securelogin"><?php echo $lang_login['text_restrict_ip']?></label>
<div class="checkbox col-sm-8"><label><input type="checkbox" name="securelogin" id="securelogin" value="yes" /><?php echo $lang_login['checkbox_restrict_ip']?></label>
</div></div>
<div class="form-group">
<label class="col-sm-4 control-label"><?php echo $lang_login['text_ssl']?></label>
<div class="col-sm-8">
<div class="checkbox"><label><input type="checkbox" name="ssl" id="ssl" value="yes" <?php echo $sec?> /><?php echo $lang_login['checkbox_ssl']?></label></div>
<div class="checkbox"><label><input type="checkbox" name="trackerssl" value="yes" <?php echo $sectra?> /><?php echo $lang_login['checkbox_ssl_tracker']?></label></div>
</div></div>
<div class="col-sm-offset-4 col-sm-8">
<div class="form-group">
<input type="submit" value="<?php echo $lang_login['button_login']?>" class="btn btn-success" />&nbsp;<input type="reset" value="<?php echo $lang_login['button_reset']?>" class="btn btn-info" />
</div></div>
<?php

if (isset($returnto))
	print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($returnto) . "\" />\n");

?>
</form>
</div>
<div class="col-sm-8">
<div class="alert alert-warning" role="alert"><?php echo $lang_login['p_need_cookies_enables']?></div>
<div class="alert alert-warning" role="alert"><b><?php echo $maxloginattempts;?></b> <?php echo $lang_login['p_fail_ban']?></div>
<p><?php echo $lang_login['p_no_account_signup']?></p>
<?php
if ($smtptype != 'none'){
?>
<p><?php echo $lang_login['p_forget_pass_recover']?></p>
<p><?php echo $lang_login['p_resend_confirm']?></p>
<?php
}
if ($showhelpbox_main != 'no'){?>
<h2><?php echo $lang_login['text_helpbox'] ?><font class="small"> - <?php echo $lang_login['text_helpbox_note'] ?><font id= "waittime" color="red"></font></h2>
<?php
print("<table width='100%' border='1' cellspacing='0' cellpadding='1'><tr><td class=\"text\">\n");
print("<iframe src='" . get_protocol_prefix() . $BASEURL . "/shoutbox.php?type=helpbox' width='650' height='180' frameborder='0' name='sbox' marginwidth='0' marginheight='0'></iframe><br /><br />\n");
print("<form action='" . get_protocol_prefix() . $BASEURL . "/shoutbox.php' id='helpbox' method='get' target='sbox' name='shbox'>\n");
print($lang_login['text_message']."<input type='text' id=\"hbtext\" name='shbox_text' autocomplete='off' style='width: 500px; border: 1px solid gray' ><input type='submit' id='hbsubmit' class='btn' name='shout' value=\"".$lang_login['sumbit_shout']."\" /><input type='reset' class='btn' value=".$lang_login['submit_clear']." /> <input type='hidden' name='sent' value='yes'><input type='hidden' name='type' value='helpbox' />\n");
print("<div id=sbword style=\"display: none\">".$lang_login['sumbit_shout']."</div>");
print(smile_row("shbox","shbox_text"));
print("</form>");
}
print("</div></div>");
stdfoot();
