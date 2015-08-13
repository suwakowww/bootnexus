<?php
require "include/bittorrent.php";
dbconn();
require_once(get_langfile_path());
loggedinorreturn(true);
stdhead($lang_staff['head_staff']);

$Cache->new_page('staff_page', 900, true);
if (!$Cache->get_page()){
$Cache->add_whole_row();
begin_main_frame();
print("<div class=\"container\">");
$secs = 900;
$dt = TIMENOW - $secs;
$onlineimg = "<img class=\"button_online\" src=\"pic/trans.gif\" alt=\"online\" title=\"".$lang_staff['title_online']."\" />";
$offlineimg = "<img class=\"button_offline\" src=\"pic/trans.gif\" alt=\"offline\" title=\"".$lang_staff['title_offline']."\" />";
$sendpmimg = "<img class=\"button_pm\" src=\"pic/trans.gif\" alt=\"pm\" />";
//--------------------- FIRST LINE SUPPORT SECTION ---------------------------//
unset($ppl);
$res = sql_query("SELECT * FROM users WHERE users.support='yes' AND users.status='confirmed' ORDER BY users.username") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
	$countryrow = get_country_row($arr['country']);
	$ppl .= "<tr><td class=embedded>". get_username($arr['id']) ."</td><td class=embedded><img width=24 height=15 src=\"pic/flag/".$countryrow[flagpic]."\" title=\"".$countryrow['name']."\" style=\"padding-bottom:1px;\"></td>
 <td class=embedded> ".(strtotime($arr['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>".
 "<td class=embedded><a href=sendmessage.php?receiver=".$arr['id']." title=\"".$lang_staff['title_send_pm']."\">".$sendpmimg."</a></td>".
 "<td class=embedded>".$arr['supportlang']."</td>".
 "<td class=embedded>".$arr['supportfor']."</td></tr>\n";
}

begin_frame($lang_staff['text_firstline_support']."<font class=small> - [<a class=altlink href=contactstaff.php><b>".$lang_staff['text_apply_for_it']."</b></a>]</font>");
?>
<?php echo $lang_staff['text_firstline_support_note'] ?>
<br /><br />
<table class="table">
	<thead>
	<tr>
		<th><?php echo $lang_staff['text_username'] ?></th>
		<th><?php echo $lang_staff['text_country'] ?></th>
		<th><?php echo $lang_staff['text_online_or_offline'] ?></th>
		<th><?php echo $lang_staff['text_contact'] ?></th>
		<th><?php echo $lang_staff['text_language'] ?></th>
		<th><?php echo $lang_staff['text_support_for'] ?></th>
	</tr>
	</thead>
	<tbody>
	<?php echo $ppl?>
	</tbody>
</table>
<?php
end_frame();

//--------------------- FIRST LINE SUPPORT SECTION ---------------------------//

//--------------------- film critics section ---------------------------//
unset($ppl);
$res = sql_query("SELECT * FROM users WHERE users.picker='yes' AND users.status='confirmed' ORDER BY users.username") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
	$countryrow = get_country_row($arr['country']);
	$ppl .= "<tr><td>". get_username($arr['id']) ."</td><td><img width=24 height=15 src=\"pic/flag/".$countryrow['flagpic']."\" title=\"".$countryrow['name']."\" style=\"padding-bottom:1px;\"></td>
 <td> ".(strtotime($arr['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>".
 "<td><a href=sendmessage.php?receiver=".$arr['id']." title=\"".$lang_staff['title_send_pm']."\">".$sendpmimg."</a></td>".
 "<td>".$arr['pickfor']."</td></tr>\n";
}

begin_frame($lang_staff['text_movie_critics']."<font class=small> - [<a class=altlink href=contactstaff.php><b>".$lang_staff['text_apply_for_it']."</b></a>]</font>");
?>
<?php echo $lang_staff['text_movie_critics_note'] ?>
<br /><br />
<table class="table">
	<thead>
	<tr>
		<th><?php echo $lang_staff['text_username'] ?></th>
		<th><?php echo $lang_staff['text_country'] ?></th>
		<th><?php echo $lang_staff['text_online_or_offline'] ?></th>
		<th><?php echo $lang_staff['text_contact'] ?></th>
		<th><?php echo $lang_staff['text_responsible_for'] ?></th>
	</tr>
	</thead>
	<tbody>
	<?php echo $ppl?>
	</tbody>
</table>
<?php
end_frame();

//--------------------- film critics section ---------------------------//

//--------------------- forum moderators section ---------------------------//
unset($ppl);
$res = sql_query("SELECT forummods.userid AS userid, users.last_access, users.country FROM forummods LEFT JOIN users ON forummods.userid = users.id GROUP BY userid ORDER BY forummods.forumid, forummods.userid") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
	$countryrow = get_country_row($arr['country']);
	$forums = "";
	$forumres = sql_query("SELECT forums.id, forums.name FROM forums LEFT JOIN forummods ON forums.id = forummods.forumid WHERE forummods.userid = ".sqlesc($arr[userid]));
	while ($forumrow = mysql_fetch_array($forumres)){
		$forums .= "<a href=forums.php?action=viewforum&forumid=".$forumrow['id'].">".$forumrow['name']."</a>, ";
	}
	$forums = rtrim(trim($forums),",");
	$ppl .= "<tr><td class=embedded>". get_username($arr['userid']) ."</td><td class=embedded ><img width=24 height=15 src=\"pic/flag/".$countryrow['flagpic']."\" title=\"".$countryrow['name']."\" style=\"padding-bottom:1px;\"></td>
 <td class=embedded> ".(strtotime($arr['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>".
 "<td class=embedded><a href=sendmessage.php?receiver=".$arr['userid']." title=\"".$lang_staff['title_send_pm']."\">".$sendpmimg."</a></td>".
 "<td class=embedded>".$forums."</td></tr>\n";
}

begin_frame($lang_staff['text_forum_moderators']."<font class=small> - [<a class=altlink href=contactstaff.php><b>".$lang_staff['text_apply_for_it']."</b></a>]</font>");
?>
<?php echo $lang_staff['text_forum_moderators_note'] ?>
<br /><br />
<table class="table">
	<thead>
	<tr>
		<th><?php echo $lang_staff['text_username'] ?></th>
		<th><?php echo $lang_staff['text_country'] ?></th>
		<th><?php echo $lang_staff['text_online_or_offline'] ?></th>
		<th><?php echo $lang_staff['text_contact'] ?></th>
		<th><?php echo $lang_staff['text_forums'] ?></th>
	</tr>
	</thead>
	<tbody>
	<?php echo $ppl?>
	</tbody>
</table>
<?php
end_frame();

//--------------------- film critics section ---------------------------//

//--------------------- general staff section ---------------------------//
unset($ppl);
$res = sql_query("SELECT * FROM users WHERE class > ".UC_VIP." AND status='confirmed' ORDER BY class DESC, username") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
	if($curr_class != $arr['class'])
	{
		$curr_class = $arr['class'];
		if ($ppl != "")
			$ppl .= "<tr><th>&nbsp;</th></tr>";
		$ppl .= "<tr><th>" . get_user_class_name($arr["class"],false,true,true) . "</th></tr>";
		$ppl .= "<thead><tr>" . 
		"<th>" . $lang_staff['text_username'] . "</th>".
		"<th>" . $lang_staff['text_country'] . "</th>".
		"<th>" . $lang_staff['text_online_or_offline'] . "</th>".
		"<th>" . $lang_staff['text_contact'] . "</th>".
		"<th>" . $lang_staff['text_duties'] . "</th>".
		"</tr></thead><tbody>";
	}
	$countryrow = get_country_row($arr['country']);
	$ppl .= "<tr><td>". get_username($arr['id']) ."</td><td><img width=24 height=15 src=\"pic/flag/".$countryrow['flagpic']."\" title=\"".$countryrow['name']."\" style=\"padding-bottom:1px;\"></td>
 <td> ".(strtotime($arr['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>".
 "<td><a href=sendmessage.php?receiver=".$arr['id']." title=\"".$lang_staff['title_send_pm']."\">".$sendpmimg."</a></td>".
 "<td>".$arr['stafffor']."</td></tr>\n";
}

begin_frame($lang_staff['text_general_staff']."<font class=small> - [<a class=altlink href=contactstaff.php><b>".$lang_staff['text_apply_for_it']."</b></a>]</font>");
?>
<?php echo $lang_staff['text_general_staff_note'] ?>
<br /><br />
<table class="table">
	<?php echo $ppl?>
	</tbody>
</table>
<?php
end_frame();

//--------------------- general staff section ---------------------------//


//--------------------- VIP section ---------------------------//

unset($ppl);
$res = sql_query("SELECT * FROM users WHERE class=".UC_VIP." AND status='confirmed' ORDER BY username") or sqlerr();
while ($arr = mysql_fetch_assoc($res))
{
	$countryrow = get_country_row($arr['country']);
	$ppl .= "<tr><td class=embedded>". get_username($arr['id']) ."</td><td class=embedded><img width=24 height=15 src=\"pic/flag/".$countryrow['flagpic']."\" title=\"".$countryrow['name']."\" style=\"padding-bottom:1px;\"></td>
 <td class=embedded> ".(strtotime($arr['last_access']) > $dt ? $onlineimg : $offlineimg)."</td>".
 "<td class=embedded><a href=sendmessage.php?receiver=".$arr['id']." title=\"".$lang_staff['title_send_pm']."\">".$sendpmimg."</a></td>".
 "<td class=embedded>".$arr['stafffor']."</td></tr>\n";
}

begin_frame($lang_staff['text_vip']);
?>
<?php echo $lang_staff['text_vip_note'] ?>
<br /><br />
<table class="table">
	<thead>
	<tr>
		<th><?php echo $lang_staff['text_username'] ?></th>
		<th><?php echo $lang_staff['text_country'] ?></th>
		<th><?php echo $lang_staff['text_online_or_offline'] ?></th>
		<th><?php echo $lang_staff['text_contact'] ?></th>
		<th><?php echo $lang_staff['text_reason'] ?></th>
	</tr>
	</thead>
	<tbody>
	<?php echo $ppl?>
	</tbody>
</table>
<?php
end_frame();

//--------------------- VIP section ---------------------------//
print("</div>");
end_main_frame();
	$Cache->end_whole_row();
	$Cache->cache_page();
}
echo $Cache->next_row();
stdfoot();
