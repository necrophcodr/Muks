<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Stylo Theme for PHP-Fusion V7.02.xx
| Author: Falcon
| Web: www.agxthemes.com
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }
     define("THEME_BULLET", "<img src='".THEME."images/bullet.gif' class='bullet' alt='&raquo;' border='0' />");

require_once THEME."functions.php";
require_once INCLUDES."theme_functions_include.php";

function render_page($license = false) {
	
	add_handler("theme_output");
	global $settings, $main_style, $locale, $mysql_queries_time;
	
	echo "<div class='wrapper'>\n";
	
	//Header
	echo "<div class='main-header'>\n".showbanners()."</div>\n";
	echo "<div class='sub-header clearfix floatfix'>".showsublinks("","")."</div>\n";

	// Content
	echo "<div class='main-bg'>\n";
	if (LEFT) { echo "<div id='side-left'>".LEFT."</div>\n"; }
	if (RIGHT) { echo "<div id='side-right'>".RIGHT."</div>\n"; }
	echo "<div id='side-center' class='".$main_style."'>";
	echo "<div class='upper'>".U_CENTER."</div>\n";
	echo "<div class='content'>".CONTENT."</div>\n";
	echo "<div class='lower'>".L_CENTER."</div>\n";
	echo "</div>\n";
	echo "<div class='clear'></div>\n";
	echo "</div>\n";
	
	//Footer
	echo "<div class='sub-footer-top'></div>\n";
	echo "<div class='sub-footer clearfix'>\n";
if ($settings['rendertime_enabled'] == 1 || ($settings['rendertime_enabled'] == 2 && iADMIN)) {
	echo "<div class='flleft' style='padding-top: 8px;'>".showrendertime()."<br />".showcounter()."</div>\n";
  } else { echo "<div class='flleft' style='padding: 15px 0 6px 0;'>".showcounter()."</div>\n"; }
    echo "<div class='flright' style='padding: 15px 0 6px 0;'>".showsubdate()."</div>\n";
	echo "</div>\n";
	
	echo "<div class='main-footer clearfix'>\n";
	echo "<div class='flleft'>\n";
	if (!$license) { echo showcopyright(); }
	echo "<br />Theme designed by <a href='http://www.agxthemes.com'>Falcon</a></div>\n";
	echo "<div class='flright' style='width: 50%; text-align: right;'>".stripslashes($settings['footer'])."</div>\n";
	echo "</div>\n";
	
	echo "</div>\n";

}

function render_comments($c_data, $c_info){
	global $locale;
	
	if (!empty($c_data)){
		echo "<div class='comments floatfix'>\n";
		
	if ($c_info['admin_link'] !== false) {
	    echo "<div class='floatfix'>\n";
	    echo "<div class='comment_admin'>".$c_info['admin_link']."</div>\n";
		echo "</div>\n";
	}

		foreach($c_data as $data) {
			
			echo "<div class='comment-main spacer'>\n";
			echo "<div class='tbl2'>\n";
		if ($data['edit_dell'] !== false) { echo "<div style='float:right' class='comment_actions'>".$data['edit_dell']."\n</div>\n"; }
			echo "<a href='".FUSION_REQUEST."#c".$data['comment_id']."' id='c".$data['comment_id']."' name='c".$data['comment_id']."'>#".$data['i']."</a> |\n";
			echo "<span class='comment-name'>".$data['comment_name']."</span>\n";
			echo "<span class='small'>".$data['comment_datestamp']."</span>\n";
			echo "</div>\n<div class='tbl1 comment_message'>".$data['comment_message']."</div>\n";
			echo "</div>\n";
			
		}
		
	if ($c_info['c_makepagenav'] !== false) {
			echo "<div class='comment-main clearfix spacer'>\n";
			echo "<div class='flleft'>".$c_info['c_makepagenav']."</div>\n";
			echo "</div>\n";
	}
		
		echo "</div>\n";
			
	} else {
	    echo "<div class='nocomments-message spacer'>".$locale['c101']."</div>\n";
	}
 
}

function render_news($subject, $news, $info) {
global $locale, $settings, $aidlink;

set_image("edit", THEME."images/icons/news_edit.png");
	
	echo "<div class='capmain-top'></div>\n";
	echo "<div class='capmain-news floatfix'>\n";
	echo "<div class='flleft'>".$subject."</div>\n";
if (iADMIN && checkrights("N")) {
	echo "<div class='flright clearfix' style='padding-right: 13px;'>\n";
    echo "<a href='".ADMIN."news.php".$aidlink."&amp;action=edit&amp;news_id=".$info['news_id']."'><img src='".get_image("edit")."' alt='".$locale['global_076']."' title='".$locale['global_076']."' /></a>\n";
	echo "</div>\n"; }
	echo "</div>\n";
	echo "<div class='spacer'>\n";
	echo "<div class='news_info middle-border floatfix'>\n";
	echo "<ul>\n";
	echo "<li class='date'>".showdate("%d %b %Y", $info['news_date'])."</li>\n";
	echo "<li class='author'>".profile_link($info['user_id'], $info['user_name'], $info['user_status'])."</li>\n";
if ($info['cat_id']) { echo "<li class='cat'><a href='".BASEDIR."news_cats.php?cat_id=".$info['cat_id']."'>".$info['cat_name']."</a></li>\n";
	} else { echo "<li class='cat'><a href='".BASEDIR."news_cats.php?cat_id=0'>".$locale['global_080']."</a></li>\n"; }
if ($info['news_ext'] == "y" || ($info['news_allow_comments'] && $settings['comments_enabled'] == "1")) {
    echo "<li class='reads'>".$info['news_reads'].$locale['global_074']."</li>\n"; }
if ($info['news_allow_comments'] && $settings['comments_enabled'] == "1") {
    echo "<li class='comments'><a href='".BASEDIR."news.php?readmore=".$info['news_id']."#comments'>".$info['news_comments'].($info['news_comments'] == 1 ? $locale['global_073b'] : $locale['global_073'])."</a></li>\n"; }
	echo "</ul>\n";
    echo "</div>\n";
	echo "<div class='main-body floatfix'>\n";
if ($info['news_sticky'] == "1") {
	echo "<div style='position:absolute; padding-top:3px;'><img src='".THEME."images/icons/sticky.png' alt='sticky' width='41px' border='0' height='41px' /></div>";
	}
	echo $info['cat_image'].$news."<br />\n";
if (!isset($_GET['readmore']) && $info['news_ext'] == "y") {
	echo "<div class='flright'>\n";
	echo "<a href='".BASEDIR."news.php?readmore=".$info['news_id']."' class='button'><span class='rightarrow icon'></span>".$locale['global_072']."</a>\n";
	echo "</div>\n";
}
	echo "</div>\n";
	echo "</div>\n";

}

function render_article($subject, $article, $info) {
global $locale, $settings, $aidlink;

set_image("edit", THEME."images/icons/article_edit.png");
	
	echo "<div class='capmain-top'></div>\n";
	echo "<div class='capmain-articles floatfix'>\n";
	echo "<div class='flleft'>".$subject."</div>\n";
if (iADMIN && checkrights("A")) {
	echo "<div class='flright clearfix' style='padding-right: 13px;'>\n";
    echo "<a href='".ADMIN."articles.php".$aidlink."&amp;action=edit&amp;article_id=".$info['article_id']."'><img src='".get_image("edit")."' alt='".$locale['global_076']."' title='".$locale['global_076']."' /></a>\n";
	echo "</div>\n"; }
	echo "</div>\n";
	echo "<div class='spacer'>\n";
	echo "<div class='news_info middle-border floatfix'>\n";
	echo "<ul>\n";
	echo "<li class='date'>".showdate("%d %b %Y", $info['article_date'])."</li>\n";
	echo "<li class='author'>".profile_link($info['user_id'], $info['user_name'], $info['user_status'])."</li>\n";
if ($info['cat_id']) {
	echo "<li class='cat'><a href='".BASEDIR."articles.php?cat_id=".$info['cat_id']."'>".$info['cat_name']."</a></li>\n";
	} else { echo "<li class='cat'><a href='".BASEDIR."articles.php?cat_id=0'>".$locale['global_080']."</a></li>\n"; }
	echo "<li class='reads'>".$info['article_reads'].$locale['global_074']."</li>\n";
if ($info['article_allow_comments'] && $settings['comments_enabled'] == "1") {
	echo "<li class='comments'><a href='".BASEDIR."articles.php?article_id=".$info['article_id']."#comments'>".$info['article_comments'].($info['article_comments'] == 1 ? $locale['global_073b'] : $locale['global_073'])."</a></li>\n"; }
	echo "</ul>\n";
    echo "</div>\n";
	echo "<div class='main-body floatfix'>".($info['article_breaks'] == "y" ? nl2br($article) : $article)."</div>\n";
	echo "</div>\n";
	
}

function opentable($title) {

	echo "<div class='capmain-top'></div>\n";
	echo "<div class='capmain'>".$title."</div>\n";

	echo "<div class='main-body  floatfix spacer'>\n";

}

function closetable() {

	echo "</div>\n";

}

function openside($title, $collapse = false, $state = "on") {

	global $panel_collapse; $panel_collapse = $collapse;
	
	echo "<div class='scapmain-top'></div>\n";
	echo "<div class='scapmain clearfix'>\n";
	echo "<div class='flleft'>".$title."</div>\n";
	if ($collapse == true) {
		$boxname = str_replace(" ", "", $title);
		echo "<div class='flright' style='padding-top: 2px;'>".panelbutton($state, $boxname)."</div>\n";
	}
	echo "</div>\n";
	
	echo "<div class='side-body spacer'>\n";
	if ($collapse == true) { echo panelstate($state, $boxname); }
	
}

function closeside() {
	
	global $panel_collapse;

	if ($panel_collapse == true) { echo "</div>\n"; }
	echo "</div>\n";

}

?>