<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

global $nuked, $user, $language;
translate("modules/Admin/lang/" . $language . ".lang.php");
include("modules/Admin/design.php");

/* Contant pour le patch points */
define("POINTS", $nuked['prefix'] . "_points");
define("ADMPOINTS", $nuked['prefix'] . "_points");


if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}

if($_REQUEST['op'] != "menu")
admintop();

if ($visiteur == 9)
{
    function add_user()
    {
        global $nuked, $language;

		$sql_config = mysql_query("SELECT mail, icq, msn, aim, yim, xfire, facebook, originea, steam, twiter, skype, lien FROM ". $nuked['prefix'] ."_users_config");
		list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12) = mysql_fetch_array($sql_config);

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
        . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
        . "</div></div>\n"
        . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Admin&amp;page=user\">" . _NAMEMEMBERS . "</a> | "
        . "</b>" . _ADDUSER . "<b> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\">" . _TEAMMANAGEMENT . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_config\">" . _USERCONFIG . "</a><br />"
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_valid\">" . _USERVALIDATION . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\">" . _BAN . "</a></b></div><br />\n"
        . "<form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=do_user\">\n"
        . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
        . "<tr><td><b>" . _NICK . " :</b></td><td><input type=\"text\" name=\"nick\" size=\"30\" maxlength=\"80\" /> *</td></tr>\n"
        . "<tr><td><b>" . _PASSWORD . " :</b></td><td><input type=\"password\" name=\"pass_reg\" size=\"10\" maxlength=\"80\" /> *</td></tr>\n"
        . "<tr><td><b>" . _PASSWORD . " (" . _CONFIRMPASS . ") :</b></td><td><input type=\"password\" name=\"pass_conf\" size=\"10\" maxlength=\"80\" /> *</td></tr>\n"
        . "<tr><td><b>" . _MAIL . " :</b></td><td><input type=\"text\" name=\"mail\" size=\"30\" maxlength=\"80\" /> *</td></tr>\n";
		if ($c1 == 'on'){echo "<tr><td><b>" . _MAIL . " " . _PUBLIC . " : </b></td><td><input type=\"text\" name=\"email\" size=\"80\" maxlength=\"80\" value=\"" . $email . "\" /></td></tr>\n";}
		if ($c2 == 'on'){echo "<tr><td><b>" . _ICQ . " : </b></td><td><input type=\"text\" name=\"icq\" size=\"15\" maxlength=\"15\" value=\"" . $icq . "\" /></td></tr>\n";}
		if ($c3 == 'on'){echo "<tr><td><b>" . _MSN . " : </b></td><td><input type=\"text\" name=\"msn\" size=\"30\" maxlength=\"80\" value=\"" . $msn . "\" /></td></tr>\n";}
		if ($c4 == 'on'){echo "<tr><td><b>" . _AIM . " : </b></td><td><input type=\"text\" name=\"aim\" size=\"30\" maxlength=\"30\" value=\"" . $aim . "\" /></td></tr>\n";}
		if ($c5 == 'on'){echo "<tr><td><b>" . _YIM . " : </b></td><td><input type=\"text\" name=\"yim\" size=\"30\" maxlength=\"30\" value=\"" . $yim . "\" /></td></tr>\n";}
		if ($c6 == 'on'){echo "<tr><td><b>" . _XFIRE . " : </b></td><td><input type=\"text\" name=\"xfire\" size=\"30\" maxlength=\"30\" value=\"" . $xfire . "\" /></td></tr>\n";}
		if ($c7 == 'on'){echo "<tr><td><b>" . _FACEBOOK . " : </b></td><td><input type=\"text\" name=\"facebook\" size=\"30\" maxlength=\"30\" value=\"" . $facebook . "\" /></td></tr>\n";}
		if ($c8 == 'on'){echo "<tr><tr><td><b>" . _ORIGINEA . " : </b></td><td><input type=\"text\" name=\"origin\" size=\"30\" maxlength=\"30\" value=\"" . $origin . "\" /></td></tr>\n";}
		if ($c9 == 'on'){echo "<tr><td><b>" . _STEAM . " : </b></td><td><input type=\"text\" name=\"steam\" size=\"30\" maxlength=\"30\" value=\"" . $steam . "\" /></td></tr>\n";}
		if ($c10 == 'on'){echo "<tr><td><b>" . _TWITER . " : </b></td><td><input type=\"text\" name=\"twitter\" size=\"30\" maxlength=\"30\" value=\"" . $twitter . "\" /></td></tr>\n";}
		if ($c11 == 'on'){echo "<tr><td><b>" . _SKYPE . " : </b></td><td><input type=\"text\" name=\"skype\" size=\"30\" maxlength=\"30\" value=\"" . $skype . "\" /></td></tr>\n";}
        echo "<tr><td><b>" . _COUNTRY . " :</b></td><td><select name=\"country\">\n";

        if ($language == "french") $pays = "France.gif";

        $rep = Array();
        $handle = @opendir("images/flags");
        while (false !== ($f = readdir($handle)))
        {
            if ($f != ".." && $f != "." && $f != "index.html" && $f != "Thumbs.db")
            {
                $rep[] = $f;
            }
        }

        closedir($handle);
        sort ($rep);
        reset ($rep);

        while (list ($key, $filename) = each ($rep))
        {
            if ($filename == $pays)
            {
                $checked = "selected=\"selected\"";
            }
            else
            {
                $checked = "";
            }

            list ($country, $ext) = explode ('.', $filename);
            echo "<option value=\"" . $filename . "\" " . $checked . ">" . $country . "</option>\n";
        }

        echo "</select></td></tr>\n"
        . "<tr><td><b>" . _GAME . " :</b></td><td><select name=\"game\">\n";

        $sql = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
        while (list($game_id, $nom) = mysql_fetch_array($sql))
        {
            $nom = printSecuTags($nom);

            echo "<option value=\"" . $game_id . "\">" . $nom . "</option>\n";
        }

        echo "</select></td></tr>\n"
        . "<tr><td><b>" . _LEVEL . " :</b></td><td><select name=\"niveau\">\n"
        . "<option>1</option>\n"
        . "<option>2</option>\n"
        . "<option>3</option>\n"
        . "<option>4</option>\n"
        . "<option>5</option>\n"
        . "<option>6</option>\n"
        . "<option>7</option>\n"
        . "<option>8</option>\n"
        . "<option>9</option></select></td></tr>\n"
        . "<tr><td><b>" . _TEAM . " : </b></td><td><select name=\"team\"><option value=\"\">" . _TEAMNONE . "</option>\n";

        select_cat();

        echo "</select></td></tr>\n"
        . "<tr><td><b>" . _TEAM . " 2 : </b></td><td><select name=\"team2\"><option value=\"\">" . _TEAMNONE . "</option>\n";

        select_cat();

        echo "</select></td></tr>\n"
        . "<tr><td><b>" . _TEAM . " 3 : </b></td><td><select name=\"team3\"><option value=\"\">" . _TEAMNONE . "</option>\n";

        select_cat();

        echo "</select></td></tr>\n"
        . "<tr><td><b>" . _RANKTEAM . " : </b></td><td><select name=\"rang\"><option value=\"\">" . _NORANK . "</option>\n";

        select_rank();

        echo"</select></td></tr>\n"
        . "<tr><td><b>" . _URL . " :</b></td><td><input type=\"text\" name=\"url\" size=\"40\" maxlength=\"80\" /></td></tr>\n"
        . "<tr><td><b>" . _AVATAR . " :</b></td><td><input type=\"text\" name=\"avatar\" size=\"40\" maxlength=\"100\" /></td></tr>\n"
        . "<tr><td><b>" . _SIGN . " :</b></td><td><textarea class=\"editor\" name=\"signature\" rows=\"10\" cols=\"55\"></textarea></td></tr></table>\n"
        . "<div style=\"text-align:center;padding-top:10px;\"><input type=\"submit\" value=\"" . _ADDUSER . "\" /></div>\n"
        . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function edit_user($id_user)
    {
        global $nuked, $language, $user;

        $sql = mysql_query("SELECT niveau, pseudo, pass, url, mail, email, icq, msn, aim, yim, rang, team, team2, team3, country, game, avatar, signature, xfire, facebook ,origin, steam, twitter, skype FROM " . USER_TABLE . " WHERE id = '" . $id_user . "'");
        list($niveau, $nick, $pass, $url, $mail, $email, $icq, $msn, $aim, $yim, $rang, $team, $team2, $team3, $pays, $game, $avatar, $signature, $xfire, $facebook ,$origin, $steam, $twitter, $skype) = mysql_fetch_array($sql);
		
		$sql_config = mysql_query("SELECT mail, icq, msn, aim, yim, xfire, facebook, originea, steam, twiter, skype, lien FROM ". $nuked['prefix'] ."_users_config");
		list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12) = mysql_fetch_array($sql_config);

        if ($team != "")
        {
            $sql2 = mysql_query("SELECT titre FROM " . TEAM_TABLE . " WHERE cid = '" . $team . "'");
            list($user_team) = mysql_fetch_array($sql2);
        }
        else
        {
            $user_team = _TEAMNONE;
        }

        if ($team2 != "")
        {
            $sql3 = mysql_query("SELECT titre FROM " . TEAM_TABLE . " WHERE cid = '" . $team2 . "'");
            list($user_team2) = mysql_fetch_array($sql3);
        }
        else
        {
            $user_team2 = _TEAMNONE;
        }

        if ($team3 != "")
        {
            $sql4 = mysql_query("SELECT titre FROM " . TEAM_TABLE . " WHERE cid = '" . $team3 . "'");
            list($user_team3) = mysql_fetch_array($sql4);
        }
        else
        {
            $user_team3 = _TEAMNONE;
        }

        if ($rang > 0)
        {
            $sql5 = mysql_query("SELECT titre FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rang . "'");
            list($rank_name) = mysql_fetch_array($sql5);
        }
        else
        {
            $rank_name = _NORANK;
        }

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
        . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
        . "</div></div>\n"
        . "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=update_user\">\n"
        . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
        . "<tr><td><b>" . _NICK . " :</b></td><td><input type=\"text\" name=\"nick\" size=\"30\" maxlength=\"80\" value=\"" . $nick . "\" /> *</td></tr>\n"
        . "<tr><td><b>" . _PASSWORD . " :</b></td><td><input type=\"password\" name=\"pass_reg\" size=\"10\" maxlength=\"80\" autocomplete=\"off\" /></td></tr>\n"
        . "<tr><td><b>" . _PASSWORD . " (" . _CONFIRMPASS . ") :</b></td><td><input type=\"password\" name=\"pass_conf\" size=\"10\" maxlength=\"80\" autocomplete=\"off\" /></td></tr>\n"
        . "<tr><td><b>" . _MAIL . " :</b></td><td><input type=\"text\" name=\"mail\" size=\"30\" maxlength=\"80\" value=\"" . $mail . "\" /> *</td></tr>\n";

		if ($c1 == 'on'){echo "<tr><td><b>" . _MAIL . " " . _PUBLIC . " : </b></td><td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"80\" value=\"" . $email . "\" /></td></tr>\n";}
		if ($c2 == 'on'){echo "<tr><td><b>" . _ICQ . " : </b></td><td><input type=\"text\" name=\"icq\" size=\"15\" maxlength=\"15\" value=\"" . $icq . "\" /></td></tr>\n";}
		if ($c3 == 'on'){echo "<tr><td><b>" . _MSN . " : </b></td><td><input type=\"text\" name=\"msn\" size=\"30\" maxlength=\"80\" value=\"" . $msn . "\" /></td></tr>\n";}
		if ($c4 == 'on'){echo "<tr><td><b>" . _AIM . " : </b></td><td><input type=\"text\" name=\"aim\" size=\"30\" maxlength=\"30\" value=\"" . $aim . "\" /></td></tr>\n";}
		if ($c5 == 'on'){echo "<tr><td><b>" . _YIM . " : </b></td><td><input type=\"text\" name=\"yim\" size=\"30\" maxlength=\"30\" value=\"" . $yim . "\" /></td></tr>\n";}
		if ($c6 == 'on'){echo "<tr><td><b>" . _XFIRE . " : </b></td><td><input type=\"text\" name=\"xfire\" size=\"30\" maxlength=\"30\" value=\"" . $xfire . "\" /></td></tr>\n";}
		if ($c7 == 'on'){echo "<tr><td><b>" . _FACEBOOK . " : </b></td><td><input type=\"text\" name=\"facebook\" size=\"30\" maxlength=\"30\" value=\"" . $facebook . "\" /></td></tr>\n";}
		if ($c8 == 'on'){echo "<tr><tr><td><b>" . _ORIGINEA . " : </b></td><td><input type=\"text\" name=\"origin\" size=\"30\" maxlength=\"30\" value=\"" . $origin . "\" /></td></tr>\n";}
		if ($c9 == 'on'){echo "<tr><td><b>" . _STEAM . " : </b></td><td><input type=\"text\" name=\"steam\" size=\"30\" maxlength=\"30\" value=\"" . $steam . "\" /></td></tr>\n";}
		if ($c10 == 'on'){echo "<tr><td><b>" . _TWITER . " : </b></td><td><input type=\"text\" name=\"twitter\" size=\"30\" maxlength=\"30\" value=\"" . $twitter . "\" /></td></tr>\n";}
		if ($c11 == 'on'){echo "<tr><td><b>" . _SKYPE . " : </b></td><td><input type=\"text\" name=\"skype\" size=\"30\" maxlength=\"30\" value=\"" . $skype . "\" /></td></tr>\n";}
        echo"<tr><td><b>" . _COUNTRY . " :</b></td><td><select name=\"country\">\n";

        $rep = Array();
        $handle = @opendir("images/flags");
        while (false !== ($f = readdir($handle)))
        {
            if ($f != ".." && $f != "." && $f != "index.html" && $f != "Thumbs.db")
            {
                $rep[] = $f;
            }
        }
        closedir($handle);
        sort ($rep);
        reset ($rep);

        while (list ($key, $filename) = each ($rep))
        {
                if ($filename == $pays)
                {
                    $checked = "selected=\"selected\"";
                }
                else
                {
                    $checked = "";
                }

                list ($country, $ext) = explode ('.', $filename);
                echo "<option value=\"" . $filename . "\" " . $checked . ">" . $country . "</option>\n";
        }

        echo "</select></td></tr>\n"
        . "<tr><td><b>" . _GAME . " :</b></td><td><select name=\"game\">\n";

        $sql = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
        while (list($game_id, $nom) = mysql_fetch_array($sql))
        {
            $nom = printSecuTags($nom);

            if ($game_id == $game)
            {
                $checked1 = "selected=\"selected\"";
            }
            else
            {
                $checked1 = "";
            }

            echo "<option value=\"" . $game_id . "\" " . $checked1 . ">" . $nom . "</option>\n";
        }

        if ($user[0] == $id_user)
        {
            echo"</select><input type=\"hidden\" name=\"niveau\" value=\"" . $niveau . "\" /></td></tr>\n";
        }
        else
        {
            echo"</select></td></tr>\n"
            . "<tr><td><b>" . _LEVEL . " :</b></td><td><select name=\"niveau\"><option>" . $niveau . "</option>\n"
            . "<option>1</option>\n"
            . "<option>2</option>\n"
            . "<option>3</option>\n"
            . "<option>4</option>\n"
            . "<option>5</option>\n"
            . "<option>6</option>\n"
            . "<option>7</option>\n"
            . "<option>8</option>\n"
            . "<option>9</option></select></td></tr>\n";
        }

        echo "<tr><td><b>" . _TEAM . " : </b></td><td><select name=\"team\"><option value=\"" . $team . "\">" . $user_team . "</option>\n";

        select_cat();

        echo "<option value=\"\">" . _TEAMNONE . "</option></select></td></tr>\n"
        . "<tr><td><b>" . _TEAM . " 2 : </b></td><td><select name=\"team2\"><option value=\"" . $team2 . "\">" . $user_team2 . "</option>\n";

        select_cat();

        echo "<option value=\"\">" . _TEAMNONE . "</option></select></td></tr>\n"
        . "<tr><td><b>" . _TEAM . " 3 : </b></td><td><select name=\"team3\"><option value=\"" . $team3 . "\">" . $user_team3 . "</option>\n";

        select_cat();

        echo "<option value=\"\">" . _TEAMNONE . "</option></select></td></tr>\n"
        . "<tr><td><b>" . _RANKTEAM . " : </b></td><td><select name=\"rang\"><option value=\""  . $rang . "\">" . $rank_name . "</option>\n";

        select_rank();

        echo"<option value=\"\">" . _NORANK . "</option></select></td></tr>\n"
        . "<tr><td><b>" . _URL . " :</b></td><td><input type=\"text\" name=\"url\" size=\"40\" maxlength=\"80\" value=\"" . $url . "\" /></td></tr>\n"
        . "<tr><td><b>" . _AVATAR . " :</b></td><td><input type=\"text\" name=\"avatar\" size=\"40\" maxlength=\"100\" value=\"" . $avatar . "\" /></td></tr>\n"
        . "<tr><td><b>" . _SIGN . " :</b></td><td><textarea class=\"editor\" name=\"signature\" rows=\"10\" cols=\"55\">" . $signature . "</textarea></td></tr>\n";

        /* modif Patch points */
        $sql = mysql_query("SELECT pts FROM " . POINTS . " WHERE user_id = '" . $id_user . "' ");
        list($nbpoints) = mysql_fetch_array($sql);

        if($nbpoints >= "2"){ $S = "s"; }
        if($nbpoints == "") {$nbpoints = 0;}

        echo"<tr>
                <td><b>" . _MESPTS6 . " :</b></td>
                <td>" . _MESPTS5 . "</b> <input type=\"text\" name=\"points\" size=\"4\" maxlength=\"100\" value=\"" . $nbpoints . "\" /> " . _MESPTS3 . "" . $S . " "._MESPTS7."</td>
            </tr>\n";
        /* Fin du patch Points */


        echo"<tr><td colspan=\"2\">&nbsp;<input type=\"hidden\" name=\"id_user\" value=\"" . $id_user . "\" /><input type=\"hidden\" name=\"pass\" value=\"" . $pass . "\" /><input type=\"hidden\" name=\"old_nick\" value=\"".$nick."\" /></td></tr>\n"
        . "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"" . _MODIFUSER . "\" /></td></tr></table>\n"
        . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";

    }

    function update_user($id_user, $team, $team2, $team3, $rang, $nick, $mail, $email, $url, $icq, $msn, $aim, $yim, $country, $niveau, $pass_reg, $pass_conf, $pass, $game, $avatar, $signature, $old_nick, $xfire, $facebook ,$origin, $steam, $twitter, $skype, $points)
    {
        global $nuked, $user;

        /* Patch Points */
        $sql = mysql_query("SELECT id FROM " . POINTS . " WHERE user_id = '" . $id_user . "' ");
        $count = mysql_num_rows($sql);
 
        if($count)
        {
            $sql = mysql_query("UPDATE " . POINTS . " SET pts = '" . $pts . "' WHERE user_id = '" . $id_user . "'");
        }else{
            $sql = mysql_query("INSERT INTO " . POINTS . "  (`user_id`, `pts`)  VALUES ('".$id_user."', '".$points."')");
        }
        /* Patch Points */
        
        $nick = verif_pseudo($nick, $old_nick);
        
		if ($nick == "error1"){
            echo "<br /><br /><div style=\"text-align: center;\">" . _BADUSERNAME . "</div><br /><br />";
            redirect("index.php?file=Admin&page=user&op=edit_user&id_user=".$id_user, 2);
            closetable();
            footer();
            exit();
        }
    
        if ($nick == "error2"){
            echo "<br /><br /><div style=\"text-align: center;\">" . _NICKINUSE . "</div><br /><br />";
            redirect("index.php?file=Admin&page=user&op=edit_user&id_user=".$id_user, 2);
            closetable();
            footer();
            exit();
        }
    
        if ($nick == "error3"){
            echo "<br /><br /><div style=\"text-align: center;\">" . _NICKBANNED . "</div><br /><br />";
            redirect("index.php?file=Admin&page=user&op=edit_user&id_user=".$id_user, 2);
            closetable();
            footer();
            exit();
        }
    
        if (strlen($nick) > 30){
            echo "<br /><br /><div style=\"text-align: center;\">" . _NICKTOLONG . "</div><br /><br />";
            redirect("index.php?file=Admin&page=user&op=edit_user&id_user=".$id_user, 2);
            closetable();
            footer();
            exit();
        }

        if ($mail == "")
        {
            echo "<div class=\"notification error png_bg\">\n"
            . "<div>\n"
            . "" . _EMPTYFIELD . ""
            . "</div>\n"
            . "</div>\n";
            redirect("index.php?file=Admin&page=user&op=edit_user&id_user=" . $id_user, 2);
            adminfoot();
            footer();
            exit();
        }
        else if ($pass_reg != $pass_conf)
        {
            echo "<div class=\"notification error png_bg\">\n"
            . "<div>\n"
            . "" . _2PASSFAIL . ""
            . "</div>\n"
            . "</div>\n";
            redirect("index.php?file=Admin&page=user&op=edit_user&id_user=" . $id_user, 2);
            adminfoot();
            footer();
            exit();
        }
        else
        {
            if ($pass_reg != '') {
                $cryptpass = 'pass = \'' . nk_hash($pass_reg).'\', ';
            } else {
                $cryptpass = '';
            }


            if ($rang != "")
            {
                $sql_rank = mysql_query("SELECT ordre FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rang . "'");
                list($ordre) = mysql_fetch_array($sql_rank);
            }
            else
            {
                $ordre = 0;
            }

            $nick = htmlentities($nick, ENT_QUOTES);

            $signature = mysql_real_escape_string(stripslashes($signature));
            $email = mysql_real_escape_string(stripslashes($email));
            $icq = mysql_real_escape_string(stripslashes($icq));
            $msn = mysql_real_escape_string(stripslashes($msn));
            $aim = mysql_real_escape_string(stripslashes($aim));
            $yim = mysql_real_escape_string(stripslashes($yim));
            $xfire = mysql_real_escape_string(stripslashes($xfire));
            $facebook = mysql_real_escape_string(stripslashes($facebook));
            $steam = mysql_real_escape_string(stripslashes($steam));
            $origin = mysql_real_escape_string(stripslashes($origin));
            $twitter = mysql_real_escape_string(stripslashes($twitter));
            $skype = mysql_real_escape_string(stripslashes($skype));
            $url = mysql_real_escape_string(stripslashes($url));
            $avatar = mysql_real_escape_string(stripslashes($avatar));

            $signature = html_entity_decode($signature);
            $email = htmlentities($email);
            $icq = htmlentities($icq);
            $msn = htmlentities($msn);
            $aim = htmlentities($aim);
            $yim = htmlentities($yim);
            $xfire = htmlentities($xfire);
            $facebook = htmlentities($facebook);
            $steam = htmlentities($steam);
            $origin = htmlentities($origin);
            $twitter = htmlentities($twitter);
            $skype = htmlentities($skype);            
            $url = htmlentities($url);
            $avatar = htmlentities($avatar);

            $sql = mysql_query("UPDATE " . USER_TABLE . " SET team = '" . $team . "', team2 = '" . $team2 . "', team3 = '" . $team3 . "', rang = '" . $rang . "', ordre = '" . $ordre . "', pseudo = '" . $nick . "', mail = '" . $mail . "', email = '" . $email . "', icq = '" . $icq . "', msn = '" . $msn . "', aim = '" . $aim . "', yim = '" . $yim . "', url = '" . $url . "', country = '" . $country . "', niveau = '" . $niveau . "', " . $cryptpass . "game = '" . $game . "', avatar = '" . $avatar . "', signature = '" . $signature . "', xfire = '" . $xfire . "', facebook = '" . $facebook . "', origin = '" . $origin . "', steam = '" . $steam . "', twitter = '" . $twitter . "' , skype = '" . $skype . "' WHERE id = '" . $id_user . "'");

            // Action
            $texteaction = "". _ACTIONMODIFUSER .": ".$nick."";
            $acdate = time();
            $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
            //Fin action

            echo "<div class=\"notification success png_bg\">\n"
            . "<div>\n"
            . "" . _INFOSMODIF . "\n"
            . "</div>\n"
            . "</div>\n";
            redirect("index.php?file=Admin&page=user", 2);
        }
    }

    function do_user($team, $team2, $team3, $rang, $nick, $mail, $email, $url, $icq, $msn, $aim, $yim, $country, $niveau, $pass_reg, $pass_conf, $game, $avatar, $signature, $xfire, $facebook ,$origin, $steam, $twitter, $skype)
    {
        global $nuked, $user;

        if ($pass_reg == "" || $pass_conf == "" || $nick == "" || $mail == "")
        {
            echo "<div class=\"notification error png_bg\">\n"
            . "<div>\n"
            . "" . _EMPTYFIELD . ""
            . "</div>\n"
            . "</div>\n";
            redirect("index.php?file=Admin&page=user&op=add_user", 2);
            adminfoot();
            footer();
            exit();
        }
        else if ($pass_reg != $pass_conf)
        {
            echo "<div class=\"notification error png_bg\">\n"
            . "<div>\n"
            . "" . _2PASSFAIL . ""
            . "</div>\n"
            . "</div>\n";
            redirect("index.php?file=Admin&page=user&op=add_user", 2);
            adminfoot();
            footer();
            exit();
        }
        else
        {
            $cryptpass = nk_hash($pass_reg);
            
            do {
                $id_user = sha1(uniqid());
            } while (mysql_num_rows(mysql_query('SELECT * FROM ' . USER_TABLE . ' WHERE id=\'' . $id_user . '\' LIMIT 1')) != 0);
            
            $date = time();
            $nick = htmlentities($nick, ENT_QUOTES);

            $signature = mysql_real_escape_string(stripslashes($signature));
            $email = mysql_real_escape_string(stripslashes($email));
            $icq = mysql_real_escape_string(stripslashes($icq));
            $msn = mysql_real_escape_string(stripslashes($msn));
            $aim = mysql_real_escape_string(stripslashes($aim));
            $yim = mysql_real_escape_string(stripslashes($yim));
            $xfire = mysql_real_escape_string(stripslashes($xfire));
            $facebook = mysql_real_escape_string(stripslashes($facebook));
            $steam = mysql_real_escape_string(stripslashes($steam));
            $origin = mysql_real_escape_string(stripslashes($origin));
            $twitter = mysql_real_escape_string(stripslashes($twitter));
            $skype = mysql_real_escape_string(stripslashes($skype));
            $url = mysql_real_escape_string(stripslashes($url));
            $avatar = mysql_real_escape_string(stripslashes($avatar));

            $signature = html_entity_decode($signature);
            $email = htmlentities($email);
            $icq = htmlentities($icq);
            $msn = htmlentities($msn);
            $aim = htmlentities($aim);
            $yim = htmlentities($yim);
            $xfire = htmlentities($xfire);
            $facebook = htmlentities($facebook);
            $steam = htmlentities($steam);
            $origin = htmlentities($origin);
            $twitter = htmlentities($twitter);
            $skype = htmlentities($skype);
            $url = htmlentities($url);
            $avatar = htmlentities($avatar);

            $sql = mysql_query("INSERT INTO " . USER_TABLE . "  ( `id` , `team` , `team2` , `team3` , `rang` , `ordre` , `pseudo` , `mail` , `email` , `icq` , `msn` , `aim` , `yim` , `url` , `pass` , `niveau` , `date` , `avatar` , `signature` , `user_theme` , `user_langue` , `game` , `country` , `count` , `xfire` , `facebook` , `origin` , `steam` , `twitter` , `skype` ) VALUES ( '" . $id_user . "' , '" . $team . "' , '" . $team2 . "' , '" . $team3 . "' , '" . $rang . "' , '' , '" . $nick . "' , '" . $mail . "' , '" . $email . "' , '" . $icq . "' , '" . $msn . "' , '" . $aim . "' , '" . $yim . "' , '" . $url . "' , '" . $cryptpass . "' , '" . $niveau . "' , '" . $date . "' , '" . $avatar . "' , '" . $signature . "' , '' , '' , '" . $game . "' , '" . $country . "' , '' , '" . $xfire . "' , '" . $facebook . "', '" . $origin . "' , '" . $steam . "' , '" . $twitter . "' , '" . $skype . "')");
            // Action
            $texteaction = "". _ACTIONADDUSER .": ".$nick."";
            $acdate = time();
            $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
            //Fin action
            echo "<div class=\"notification success png_bg\">\n"
            . "<div>\n"
            . "" . _USERADD . "\n"
            . "</div>\n"
            . "</div>\n";
            redirect("index.php?file=Admin&page=user", 2);
        }
    }

    function del_user($id_user)
    {
        global $nuked, $user;

        $sql = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $id_user . "'");
        list($nick) = mysql_fetch_array($sql);
        $nick = mysql_real_escape_string($nick);
        $del1 = mysql_query("DELETE FROM " . USER_TABLE . " WHERE id = '" . $id_user . "'");
        $del2 = mysql_query("DELETE FROM " . USER_DETAIL_TABLE . " WHERE user_id = '" . $id_user . "'");
        $del3 = mysql_query("DELETE FROM " . USERBOX_TABLE . " WHERE user_for = '" . $id_user . "'");
        $del4 = delModerator($id_user);
        // Action
        $texteaction = "". _ACTIONDELUSER .": ".$nick."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _USERDEL . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user", 2);
    }

    function main()
    {
        global $nuked, $user, $language;

        if ($_REQUEST['query'] != "")
        {
            $and = "AND (UT.pseudo LIKE '%" . $_REQUEST['query'] . "%')";
            $url_page = "index.php?file=Admin&amp;page=user&amp;query=" . $_REQUEST['query'] . "&amp;orderby=" . $_REQUEST['orderby'];
        }
        else
        {
            $url_page = "index.php?file=Admin&amp;page=user&amp;orderby=" . $_REQUEST['orderby'];
            $and = "";
        }

        $nb_membres = 30;

        $sql3 = mysql_query("SELECT UT.id FROM " . USER_TABLE . " as UT WHERE UT.niveau > 0 " . $and);
        $count = mysql_num_rows($sql3);

        if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_membres - $nb_membres;
        echo "<link rel=\"stylesheet\" href=\"css/jquery.autocomplete.css\" type=\"text/css\" media=\"screen\" />\n";
        echo "<script type=\"text/javascript\">\n"
        . "<!--\n"
        . "\n"
        . "function deluser(pseudo, id)\n"
        . "{\n"
        . "if (confirm('" . _DELBLOCK . " '+pseudo+' ! " . _CONFIRM . "'))\n"
        . "{document.location.href = 'index.php?file=Admin&page=user&op=del_user&id_user='+id;}\n"
        . "}\n"
        . "\n"
        . "// -->\n"
        . "</script>\n";

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
    . "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><form method=\"get\" action=\"index.php\">\n"
        . "<div style=\"text-align: center;\"><b>" . _SEARCH . " : </b><input type=\"text\" id=\"query\" name=\"query\" size=\"25\" />&nbsp;<input type=\"submit\" value=\"ok\" />\n"
        . "<input type=\"hidden\" name=\"file\" value=\"Admin\" />\n"
        . "<input type=\"hidden\" name=\"page\" value=\"user\" /></div></form>\n"
        . "<div style=\"text-align: center;\">" . _NAMEMEMBERS . "<b> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=add_user\">" . _ADDUSER . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\">" . _TEAMMANAGEMENT . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_config\">" . _USERCONFIG . "</a><br />"        
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_valid\">" . _USERVALIDATION . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\">" . _BAN . "</a></b></div><br />\n";


        if ($_REQUEST['orderby'] == "date")
        {
            $order_by = "UT.date DESC";
        }
        else if ($_REQUEST['orderby'] == "level")
        {
            $order_by = "UT.niveau DESC, UT.date DESC";
        }
        else if ($_REQUEST['orderby'] == "last_date")
        {
            $order_by = "ST.date DESC";
        }
        else if ($_REQUEST['orderby'] == "pseudo")
        {
            $order_by = "UT.pseudo";
        }
        else
        {
            $order_by = "UT.niveau DESC, UT.date DESC";
        }

        echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"80%\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\"><tr><td align=\"right\">" . _ORDERBY . " : ";

        if ($_REQUEST['orderby'] == "level" || !$_REQUEST['orderby'])
        {
            echo "<b>" . _LEVEL . "</b> | ";
        }
        else
        {
            echo "<a href=\"index.php?file=Admin&amp;page=user&amp;orderby=level\">" . _LEVEL . "</a> | ";
        }

        if ($_REQUEST['orderby'] == "pseudo")
        {
            echo "<b>" . _NICK . "</b> | ";
        }
        else
        {
            echo "<a href=\"index.php?file=Admin&amp;page=user&amp;orderby=pseudo\">" . _NICK . "</a> | ";
        }

        if ($_REQUEST['orderby'] == "date")
        {
            echo "<b>" . _DATEUSER . "</b> | ";
        }
        else
        {
            echo "<a href=\"index.php?file=Admin&amp;page=user&amp;orderby=date\">" . _DATEUSER . "</a> | ";
        }

        if ($_REQUEST['orderby'] == "last_date")
        {
            echo "<b>" . _LAST. " " ._VISIT . "</b>";
        }
        else
        {
            echo "<a href=\"index.php?file=Admin&amp;page=user&amp;orderby=last_date\">" . _LAST. " " ._VISIT . "</a>";
        }

        echo "&nbsp;</td></tr></table>\n";

        if ($count > $nb_membres)
        {
            echo" <table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"80%\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\"><tr><td>\n";
            number($count, $nb_membres, $url_page);
            echo "</td></tr></table>\n";
        }

        echo "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"80%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
        . "<tr>\n"
        . "<td style=\"width: 30%;\" align=\"center\"><b>" . _NICK . "</b></td>\n"
        . "<td style=\"width: 10%;\" align=\"center\"><b>" . _LEVEL . "</b></td>\n"
        . "<td style=\"width: 15%;\" align=\"center\"><b>" . _DATEUSER . "</b></td>\n"
        . "<td style=\"width: 25%;\" align=\"center\"><b>" . _LAST. " " ._VISIT . "</b></td>\n"
        . "<td style=\"width: 10%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
        . "<td style=\"width: 10%;\" align=\"center\"><b>" . _DELETE . "</b></td></tr>\n";

        $req = "SELECT UT.id, UT.pseudo, UT.niveau, UT.date, ST.date FROM " . USER_TABLE . " as UT LEFT OUTER JOIN " . SESSIONS_TABLE . " as ST ON UT.id=ST.user_id WHERE UT.niveau > 0 " . $and . " ORDER BY " . $order_by . " LIMIT " . $start . ", " . $nb_membres;
        $sql = mysql_query($req);
        while (list($id_user, $pseudo, $niveau, $date, $last_used) = mysql_fetch_array($sql))
        {
            $date = nkDate($date);
            $last_used == '' ? $last_used = '-' : $last_used = nkDate($last_used);

            echo "<tr>\n"
            . "<td>&nbsp;" . $pseudo . "</td>\n"
            . "<td align=\"center\">" . $niveau . "</td>\n"
            . "<td align=\"center\">" . $date . "</td>\n"
            . "<td align=\"center\">" . $last_used . "</td>\n"
            . "<td align=\"center\"><a href=\"index.php?file=Admin&amp;page=user&amp;op=edit_user&amp;id_user=" . $id_user . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITUSER . "\" /></a></td>\n"
            . "<td align=\"center\">";

            if ($user[0] == $id_user)
            {
                echo "-";
            }
            else
            {
                echo "<a href=\"javascript:deluser('" . mysql_real_escape_string(stripslashes($pseudo)) . "', '" . $id_user . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELETEUSER . "\" /></a>";
            }

            echo "</td></tr>\n";
        }

        if ($count == 0 && $_REQUEST['query'] != "")
        {
            echo "<tr><td colspan=\"5\" align=\"center\">" . _NORESULTFOR . " <b><i>" . $_REQUEST['query'] . "</i></b></td></tr>\n";
        }
        else if ($count == 0)
        {
            echo "<tr><td colspan=\"5\" align=\"center\">" . _NOUSERINDB . "</td></tr>\n";
        }

        echo "</table>\n";

        if ($count > $nb_membres)
        {
            echo" <table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"80%\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\"><tr><td>\n";
            number($count, $nb_membres, $url_page);
            echo "</td></tr></table>\n";
        }

        echo "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

   function main_cat()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
        . "<!--\n"
        . "\n"
        . "function delcat(titre, id)\n"
        . "{\n"
        . "if (confirm('" . _DELBLOCK . " '+titre+' ! " . _CONFIRM . "'))\n"
        . "{document.location.href = 'index.php?file=Admin&page=user&op=del_cat&cid='+id;}\n"
        . "}\n"
        . "\n"
        . "// -->\n"
        . "</script>\n";

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
        . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
        . "</div></div>\n"
        . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Admin&amp;page=user\">" . _NAMEMEMBERS . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=add_user\">" . _ADDUSER . "</a> | "
        . "</b>" . _TEAMMANAGEMENT . "<b> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_config\">" . _USERCONFIG . "</a><br />"        
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_valid\">" . _USERVALIDATION . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\">" . _BAN . "</a></b></div><br />\n"
        . "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
        . "<tr>\n"
        . "<td style=\"width: 30%;\" align=\"center\"><b>" . _NAME . "</b></td>\n"
        . "<td style=\"width: 30%;\" align=\"center\"><b>" . _GAME . "</b></td>\n"
        . "<td style=\"width: 10%;\" align=\"center\"><b>" . _ORDER . "</b></td>\n"
        . "<td style=\"width: 15%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
        . "<td style=\"width: 15%;\" align=\"center\"><b>" . _DELETE . "</b></td></tr>\n";

        $sql = mysql_query("SELECT cid, titre, ordre, game FROM " . TEAM_TABLE . " ORDER BY game, ordre");
        $nbcat=mysql_num_rows($sql);

        if ($nbcat>0)
        {
            while (list($cid, $titre, $ordre, $game) = mysql_fetch_array($sql))
            {
                $titre = printSecuTags($titre);

                if ($game > 0)
                {
                    $sql_game = mysql_query("SELECT name FROM " . GAMES_TABLE . " WHERE id = '" . $game . "'");
                    list($game_name) = mysql_fetch_array($sql_game);
                    $game_name = htmlentities($game_name);
                }
                else
                {
                    $game_name = "N/A";
                }

                echo "<tr>\n"
                . "<td style=\"width: 30%;\" align=\"center\">" . $titre . "</td>\n"
                . "<td style=\"width: 30%;\" align=\"center\">" . $game_name . "</td>\n"
                . "<td style=\"width: 10%;\" align=\"center\">" . $ordre . "</td>\n"
                . "<td style=\"width: 15%;\" align=\"center\"><a href=\"index.php?file=Admin&amp;page=user&amp;op=edit_cat&amp;cid=" . $cid . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISTEAM . "\" /></a></td>\n"
                . "<td style=\"width: 15%;\" align=\"center\"><a href=\"javascript:delcat('" . mysql_real_escape_string(stripslashes($titre)) . "', '" . $cid . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISTEAM . "\" /></a></td></tr>\n";
            }
    }
    else
    {
        echo "<tr><td align=\"center\" colspan=\"5\">" ._NOTEAMINDB. "</td></tr>\n";
    }

        echo "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=add_cat\"><b>" . _ADDTEAM . "</b></a> ]</div>\n"
        . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>";
    }

    function add_cat()
    {
        global $language;

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
        . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
        . "</div></div>\n"
        . "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=send_cat\">\n"
        . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
        . "<tr><td><b>" . _NAME . " : </b><input type=\"text\" name=\"titre\" size=\"32\" />&nbsp;<b>" . _ORDER . " : </b><input type=\"text\" name=\"ordre\" size=\"2\" /></td></tr>\n"
        . "<tr><td><b>" . _TAGPRE . " : </b><input type=\"text\" name=\"tag\" size=\"10\" />&nbsp;<b>" . _TAGSUF . " : </b><input type=\"text\" name=\"tag2\" size=\"10\" /></td></tr>\n"
        . "<tr><td><b>" . _GAME . " :</b> <select name=\"game\">\n";

        $sql = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
        while (list($game_id, $nom) = mysql_fetch_array($sql))
        {
            $nom = printSecuTags($nom);

            echo "<option value=\"" . $game_id . "\">" . $nom . "</option>\n";
        }

        echo "</select></td></tr><tr><td>&nbsp;</td></tr></table>\n"
        . "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _CREATETEAM . "\" /></div>\n"
        . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function send_cat($titre, $game, $tag, $tag2, $ordre)
    {
        global $nuked, $user;

        $titre = mysql_real_escape_string(stripslashes($titre));
        $tag = mysql_real_escape_string(stripslashes($tag));
        $tag2 = mysql_real_escape_string(stripslashes($tag2));

        $sql = mysql_query("INSERT INTO " . TEAM_TABLE . " ( `cid` , `titre`, `tag` , `tag2` , `ordre` , `game`) VALUES ( '' , '" . $titre . "' , '" . $tag . "' , '" . $tag2 . "' , '" . $ordre . "' , '" . $game . "')");
        // Action
        $texteaction = "". _ACTIONADDCATUSER .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _TEAMADD . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_cat", 2);
    }

    function edit_cat($cid)
    {
        global $nuked, $language;

        $sql = mysql_query("SELECT titre, tag, tag2, ordre, game FROM " . TEAM_TABLE . " WHERE cid = '" . $cid . "'");
        list($titre, $tag, $tag2, $ordre, $game) = mysql_fetch_array($sql);

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
        . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
        . "</div></div>\n"
        . "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=modif_cat\">\n"
        . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
        . "<tr><td><b>" . _NAME . " : </b><input type=\"text\" name=\"titre\" size=\"32\" value=\"" . $titre . "\" />&nbsp;<b>" . _ORDER . " : </b><input type=\"text\" name=\"ordre\" size=\"2\" value=\"" . $ordre . "\" /></td></tr>\n"
        . "<tr><td><b>" . _TAGPRE . " : </b><input type=\"text\" name=\"tag\" size=\"10\" value=\"" . $tag . "\" />&nbsp;<b>" . _TAGSUF . " : </b><input type=\"text\" name=\"tag2\" size=\"10\" value=\"" . $tag2 . "\" /></td></tr>\n"
        . "<tr><td><b>" . _GAME . " :</b> <select name=\"game\">\n";

        $sql = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
        while (list($game_id, $nom) = mysql_fetch_array($sql))
        {
            $nom = printSecuTags($nom);

            if ($game == $game_id)
            {
                $checked = "selected=\"selected\"";
            }
            else
            {
                $checked = "";
            }

            echo "<option value=\"" . $game_id . "\" " . $checked . ">" . $nom . "</option>\n";
        }

        echo "</select></td></tr><tr><td>&nbsp;<input type=\"hidden\" name=\"cid\" value=\"" . $cid . "\" /></td></tr></table>\n"
        . "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _MODIFTHISTEAM . "\" /></div>\n"
        . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function modif_cat($cid, $titre, $game, $tag, $tag2, $ordre)
    {
        global $nuked, $user;

        $titre = mysql_real_escape_string(stripslashes($titre));
        $tag = mysql_real_escape_string(stripslashes($tag));
        $tag2 = mysql_real_escape_string(stripslashes($tag2));

        $sql = mysql_query("UPDATE " . TEAM_TABLE . " SET titre = '" . $titre . "', tag = '" . $tag . "', tag2 = '" . $tag2 . "', ordre = '" . $ordre . "', game = '" . $game . "' WHERE cid = '" . $cid . "'");
        // Action
        $texteaction = "". _ACTIONEDITCATUSER .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<br /><br /><div style=\"text-align: center;\">" . _TEAMMODIF . "</div><br /><br />";
        redirect("index.php?file=Admin&page=user&op=main_cat", 2);
    }

    function select_cat()
    {
        global $nuked;

        $sql = mysql_query("SELECT cid, titre FROM " . TEAM_TABLE . " ORDER BY ordre, titre");
        while (list($cid, $titre) = mysql_fetch_array($sql))
        {
            $titre = printSecuTags($titre);

            echo "<option value=\"" . $cid . "\">" . $titre . "</option>\n";
        }
    }

    function del_cat($cid)
    {
        global $nuked, $user;
        $sql2 = mysql_query("SELECT titre FROM " . TEAM_TABLE . " WHERE cid = '" . $cid . "'");
        list($titre) = mysql_fetch_array($sql2);
        $titre = mysql_real_escape_string($titre);
        $sql = mysql_query("DELETE FROM " . TEAM_TABLE . " WHERE cid = '" . $cid . "'");

        // Action
        $texteaction = "". _ACTIONDELCATUSER .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action

        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _TEAMDEL . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_cat", 2);
    }

    function main_ip()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
        . "<!--\n"
        . "\n"
        . "function delip(titre, id)\n"
        . "{\n"
        . "if (confirm('" . _DELBLOCK . " '+titre+' ! " . _CONFIRM . "'))\n"
        . "{document.location.href = 'index.php?file=Admin&page=user&op=del_ip&ip_id='+id;}\n"
        . "}\n"
        . "\n"
        . "// -->\n"
        . "</script>\n";

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
        . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
        . "</div></div>\n"
        . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Admin&amp;page=user\">" . _NAMEMEMBERS . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=add_user\">" . _ADDUSER . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\">" . _TEAMMANAGEMENT . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_config\">" . _USERCONFIG . "</a><br />"        
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a> | "
        . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_valid\">" . _USERVALIDATION . "</a> | "
        . "</b>" . _BAN . "</div><br />\n"
        . "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
        . "<tr>\n"
        . "<td style=\"width: 25%;\" align=\"center\"><b>" . _NICK . "</b></td>\n"
        . "<td style=\"width: 25%;\" align=\"center\"><b>" . _MAIL . "</b></td>\n"
        . "<td style=\"width: 20%;\" align=\"center\"><b>" . _IP . "</b></td>\n"
        . "<td style=\"width: 15%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
        . "<td style=\"width: 15%;\" align=\"center\"><b>" . _DELETE . "</b></td></tr>\n";

        $sql = mysql_query("SELECT id, ip, pseudo, email FROM " . BANNED_TABLE . " ORDER BY id DESC");
        $nbip = mysql_num_rows($sql);

        if ($nbip > 0)
        {
            while (list($ip_id, $ip, $pseudo, $email) = mysql_fetch_array($sql))
            {
                $pseudo = htmlentities($pseudo);


                echo "<tr>\n"
                . "<td style=\"width: 25%;\" align=\"center\">" . $pseudo . "</td>\n"
                . "<td style=\"width: 25%;\" align=\"center\">" . $email . "</td>\n"
                . "<td style=\"width: 20%;\" align=\"center\">" . $ip . "</td>\n"
                . "<td style=\"width: 15%;\" align=\"center\"><a href=\"index.php?file=Admin&amp;page=user&amp;op=edit_ip&amp;ip_id=" . $ip_id . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISIP . "\" /></a></td>\n"
                . "<td style=\"width: 15%;\" align=\"center\"><a href=\"javascript:delip('" . $ip . "','" . $ip_id . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISIP . "\" /></a></td></tr>\n";
            }
        }
        else
        {
            echo "<tr><td align=\"center\" colspan=\"5\">" ._NOIPINDB. "</td></tr>\n";
        }

        echo "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=add_ip\"><b>" . _ADDIP . "</b></a> ]</div>\n"
        . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    function add_ip()
    {
        global $language;

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
		. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
		. "</div></div>\n"
		. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=send_ip\">\n"
		. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		. "<tr><td><b>" . _NICK . " : </b></td><td><input type=\"text\" name=\"pseudo\" size=\"30\" /></td></tr>\n"
		. "<tr><td><b>" . _MAIL . " : </b></td><td><input type=\"text\" name=\"email\" size=\"40\" /></td></tr>\n"
		. "<tr><td><b>" . _IP . " : </b></td><td><input type=\"text\" name=\"ip\" size=\"30\" /></td></tr>\n"
		. "<tr><td><b>" . _DUREE . " : </b></td><td>\n"
		. "<select id=\"dure\" name=\"dure\">\n"
		. "<option value=\"86400\">". _1JOUR ."</option>\n"
		. "<option value=\"604800\">". _7JOUR ."</option>\n"
		. "<option value=\"2678400\">". _1MOIS ."</option>\n"
		. "<option value=\"31708800\">". _1AN ."</option>\n"
		. "<option value=\"0\">". _AVIE ."</option>\n"
		. "</select></td></tr>\n"
		. "<tr><td colspan=\"2\"><b>" . _REASON . "</b><br /><textarea class=\"editor\" name=\"texte\" rows=\"10\" cols=\"55\"></textarea></td></tr>\n"
		. "<tr><td colspan=\"2\">&nbsp;</td></tr></table>\n"
		. "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _TOBAN . "\" /></div>\n"
		. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function edit_ip($ip_id)
    {
        global $language;

        $sql = mysql_query("SELECT ip, pseudo, email, dure, texte FROM " . BANNED_TABLE . " WHERE id = '" . $ip_id . "'");
        list($ip, $pseudo, $email, $dure, $text_ban) = mysql_fetch_array($sql);

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
		. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
		. "</div></div>\n"
		. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=modif_ip\">\n"
		. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		. "<tr><td><b>" . _NICK . " : </b></td><td><input type=\"text\" name=\"pseudo\" size=\"30\" value=\"" . $pseudo . "\" /></td></tr>\n"
		. "<tr><td><b>" . _MAIL . " : </b></td><td><input type=\"text\" name=\"email\" size=\"40\" value=\"" . $email . "\" /></td></tr>\n"
		. "<tr><td><b>" . _IP . " : </b></td><td><input type=\"text\" name=\"ip\" size=\"30\" value=\"" . $ip . "\" /></td></tr>\n"
		. "<tr><td><b>" . _DUREE . " : </b></td><td>\n"
		. "<select id=\"dure\" name=\"dure\" value=\"" . $dure . "\">\n"
		. "<option value=\"86400\">". _1JOUR ."</option>\n"
		. "<option value=\"604800\">". _7JOUR ."</option>\n"
		. "<option value=\"2678400\">". _1MOIS ."</option>\n"
		. "<option value=\"31708800\">". _1AN ."</option>\n"
		. "<option value=\"0\">". _AVIE ."</option>\n"
		. "</select></td></tr>\n"
		. "<tr><td colspan=\"2\"><b>" . _REASON . "</b><br /><textarea class=\"editor\" name=\"texte\" rows=\"10\" cols=\"55\">" . $text_ban . "</textarea></td></tr>\n"
		. "<tr><td colspan=\"2\">&nbsp;<input type=\"hidden\" name=\"ip_id\" value=\"" . $ip_id . "\" /></td></tr></table>\n"
		. "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _MODIFTHISIP . "\" /></div>\n"
		. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";

    }

    function send_ip($ip, $pseudo, $email, $dure, $texte)
    {
        global $nuked, $user;
        $pseudo = mysql_real_escape_string(stripslashes($pseudo));
        $texte = mysql_real_escape_string(stripslashes($texte));
        if($dure == 0 || $dure ==86400 ||$dure ==604800 ||$dure ==2678400 ||$dure == 31708800)
        {
            $sql = mysql_query("INSERT INTO " . BANNED_TABLE . " ( `id` , `ip` , `pseudo` , `email` ,`date` ,`dure` , `texte` ) VALUES ( '' , '" . $ip . "' , '" . $pseudo . "' , '" . $email . "', '" . time() . "' , '" . $dure . "' , '" . $texte . "' )");
        }
        else
        {
            exit();
        }
        // Action
        $texteaction = "". _ACTIONADDBAN .": ".$pseudo."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _IPADD . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_ip", 2);
    }

    function modif_ip($ip_id, $ip, $pseudo, $email, $dure, $texte)
    {
        global $nuked, $user;
        $pseudo = mysql_real_escape_string(stripslashes($pseudo));
        $texte = mysql_real_escape_string(stripslashes($texte));

        if($dure == 0 || $dure ==86400 ||$dure ==604800 ||$dure ==2678400 ||$dure == 31708800)
        {
        $sql = mysql_query("UPDATE " . BANNED_TABLE . " SET ip = '" . $ip . "', pseudo = '" . $pseudo . "', email = '" . $email . "', dure = '" . $dure . "', texte = '" . $texte . "' WHERE id = '" . $ip_id . "'");
        }
        else
        {
            exit();
        }
        // Action
        $texteaction = "". _ACTIONMODIFBAN .": ".$pseudo."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _IPMODIF . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_ip", 2);
    }

    function del_ip($ip_id)
    {
        global $nuked, $user;
         $sql2 = mysql_query("SELECT pseudo FROM " . BANNED_TABLE . " WHERE id = '" . $ip_id . "'");
        list($pseudo) = mysql_fetch_array($sql2);
        $pseudo = mysql_real_escape_string($pseudo);
        $sql = mysql_query("DELETE FROM " . BANNED_TABLE . " WHERE id = '" . $ip_id . "'");
        // Action
        $texteaction = "". _ACTIONSUPBAN .": ".$pseudo."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _IPDEL . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_ip", 2);
    }

    function main_rank()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
    . "<!--\n"
    . "\n"
    . "function delrank(titre, id)\n"
    . "{\n"
    . "if (confirm('" . _DELBLOCK . " '+titre+' ! " . _CONFIRM . "'))\n"
    . "{document.location.href = 'index.php?file=Admin&page=user&op=del_rank&rid='+id;}\n"
    . "}\n"
        . "\n"
    . "// -->\n"
    . "</script>\n";

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
    . "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Admin&amp;page=user\">" . _NAMEMEMBERS . "</a> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=add_user\">" . _ADDUSER . "</a> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\">" . _TEAMMANAGEMENT . "</a> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_config\">" . _USERCONFIG . "</a><br />"    
    . "</b>" . _RANKMANAGEMENT . "<b> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_valid\">" . _USERVALIDATION . "</a> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\">" . _BAN . "</a></b></div><br />\n"
    . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"70%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
    . "<tr>\n"
    . "<td style=\"width: 40%;\" align=\"center\"><b>" . _TITLE . "</b></td>\n"
    . "<td style=\"width: 20%;\" align=\"center\"><b>" . _ORDER . "</b></td>\n"
    . "<td style=\"width: 20%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
    . "<td style=\"width: 20%;\" align=\"center\"><b>" . _DELETE . "</b></td></tr>";

        $sql = mysql_query("SELECT id, titre, ordre FROM " . TEAM_RANK_TABLE . " ORDER BY ordre, titre");
        $nbrank=mysql_num_rows($sql);

        if ($nbrank > 0)
    {
            while (list($rid, $titre, $ordre) = mysql_fetch_array($sql))
            {
                $titre = printSecuTags($titre);


                echo "<tr>\n"
                . "<td style=\"width: 40%;\" align=\"center\">" . $titre . "</td>\n"
                . "<td style=\"width: 20%;\" align=\"center\">" . $ordre . "</td>\n"
                . "<td style=\"width: 20%;\" align=\"center\"><a href=\"index.php?file=Admin&amp;page=user&amp;op=edit_rank&amp;rid=" . $rid . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISRANK . "\" /></a></td>\n"
                . "<td style=\"width: 20%;\" align=\"center\"><a href=\"javascript:delrank('" . mysql_real_escape_string(stripslashes($titre)) . "', '" . $rid . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISRANK . "\" /></a></td></tr>\n";
            }
    }
    else
    {
            echo "<tr><td align=\"center\" colspan=\"4\">" ._NORANKINDB. "</td></tr>\n";
    }

        echo "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=add_rank\"><b>" . _ADDRANK . "</b></a> ]</div>\n"
    . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    function add_rank()
    {
        global $language;
        echo"<script type=\"text/javascript\" src=\"modules/Admin/jscolor/jscolor.js\"></script>";
        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
    . "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=send_rank\"enctype=\"multipart/form-data\">\n"
    . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
    . "<tr><td><b>" . _TITLE . " :</b> <input type=\"text\" name=\"titre\" size=\"30\" /></td></tr>\n"
    . "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" /></td></tr>\n"
    . "<tr><td><b>" . _UPLOADIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n"
    . "<tr><td><b>" . _COLOR . " :</b> <input class=\"color\"type=\"text\" name=\"color\" style=\"width:60px;\" value=\"" . $color . "\" /></td></tr>\n"    
    . "<tr><td><b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" size=\"1\" value=\"0\" /></td></tr>\n"
    . "<tr><td>&nbsp;</td></tr></table>\n"
    . "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _ADDRANK . "\" /></div>\n"
    . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function edit_rank($rid)
    {
        global $nuked, $language;
        echo"<script type=\"text/javascript\" src=\"modules/Admin/jscolor/jscolor.js\"></script>";

        $sql = mysql_query("SELECT titre, ordre, image, couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rid . "'");
        list($titre, $ordre, $image, $couleur) = mysql_fetch_array($sql);
        $titre = printSecuTags($titre);

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
    . "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Admin&amp;page=user&amp;op=modif_rank\"enctype=\"multipart/form-data\">\n"
    . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
    . "<tr><td><b>" . _TITLE . " :</b> <input type=\"text\" name=\"titre\" size=\"30\" value=\"" . $titre . "\" /></td></tr>\n"
    . "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" value=\"" . $image . "\" /></td></tr>\n"
    . "<tr><td><b>" . _UPLOADIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n"
    . "<tr><td><b>" . _COLOR . " :</b> <input class=\"color\"type=\"text\" name=\"color\" style=\"width:60px;\" value=\"" . $couleur . "\" /></td></tr>\n"    
    . "<tr><td><b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" size=\"1\" value=\"" . $ordre . "\" /></td></tr>\n"
    . "<tr><td>&nbsp;<input type=\"hidden\" name=\"rid\" value=\"" . $rid . "\" /></td></tr></table>\n"
    . "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _MODIFTHISRANK . "\" /></div>\n"
    . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

   function send_rank($titre, $ordre, $urlimage, $upimage, $color)
    {
        global $nuked, $user;

		$filename = $_FILES['upimage']['name'];

		if ($filename != "") {
			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
				$url_image = "upload/User/Rank/" . $filename;
				move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
				@chmod ($url_image, 0644);
			} else {
				echo "<div class=\"notification error png_bg\">\n"
				   . "<div>\n"
				   . "No image file !"
				   . "</div>\n"
				   . "</div>\n";
				redirect("index.php?file=News&page=admin", 2);
				adminfoot();
				footer();
				die;
			}
		} else {
			$url_image = $urlimage;
		}

        $titre = mysql_real_escape_string(stripslashes($titre));

        $sql = mysql_query("INSERT INTO " . TEAM_RANK_TABLE . " VALUES ( '' , '" . $titre . "' , '" . $ordre . "', '" . $url_image . "', '" . $color . "' )");
        // Action
        $texteaction = "". _ACTIONADDRANK .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _RANKADD . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_rank", 2);
    }
    function modif_rank($rid, $titre, $ordre, $urlimage, $upimage, $color)
    {
        global $nuked, $user;

        $titre = mysql_real_escape_string(stripslashes($titre));
        
        $filename = $_FILES['upimage']['name'];
		if ($filename != "") {
			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			if (!preg_match("`\.php`i", $filename) && !preg_match("`\.htm`i", $filename) && !preg_match("`\.[a-z]htm`i", $filename) && (preg_match("`jpg`i", $ext) || preg_match("`jpeg`i", $ext) || preg_match("`gif`i", $ext) || preg_match("`png`i", $ext))) {
				$url_image = "upload/User/Rank/" . $filename;
				move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
				@chmod ($url_image, 0644);
			} else {
				echo "<div class=\"notification error png_bg\">\n"
				   . "<div>\n"
				   . "No image file !"
				   . "</div>\n"
				   . "</div>\n";
				redirect("index.php?file=News&page=admin", 2);
				adminfoot();
				footer();
				die;
			}
		} else {
			$url_image = $urlimage;
		}


        $sql = mysql_query("UPDATE " . TEAM_RANK_TABLE . " SET titre = '" . $titre . "', ordre = '" . $ordre . "', image = '" . $url_image . "', couleur = '" . $color . "' WHERE id = '" . $rid . "'");
        $sql2 = mysql_query("UPDATE " . USER_TABLE . " SET ordre = '" . $ordre . "' WHERE rang = '" . $rid . "'");
        // Action
        $texteaction = "". _ACTIONMODIFRANK .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _RANKMODIF . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_rank", 2);
    }

    
    function del_rank($rid)
    {
        global $nuked;
        $sql3 = mysql_query("SELECT titre FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rid . "'");
        list($titre) = mysql_fetch_array($sql3);
        $titre = mysql_real_escape_string($titre);
        $sql = mysql_query("DELETE FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rid . "'");
        $sql2 = mysql_query("UPDATE " . USER_TABLE . " SET ordre = 0 WHERE rang = '" . $rid . "'");
        // Action
        $texteaction = "". _ACTIONDELRANK .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _RANKDEL . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Admin&page=user&op=main_rank", 2);
    }

    function select_rank()
    {
        global $nuked;

        $sql = mysql_query("SELECT id, titre FROM " . TEAM_RANK_TABLE . " ORDER BY ordre, titre");
        while (list($rid, $titre) = mysql_fetch_array($sql))
        {
            $titre = htmlentities($titre);

            echo "<option value=\"" . $rid . "\">" . $titre . "</option>\n";
        }
    }

    function validation($id_user)
    {
        global $nuked;

        $date2 = nkDate(time());
        $sql = mysql_query("SELECT pseudo, mail FROM " . USER_TABLE . " WHERE id = '" . $id_user . "'");
        list($pseudo, $mail) = mysql_fetch_array($sql);

        $upd = mysql_query("UPDATE " . USER_TABLE . " SET niveau = 1 WHERE id = '" . $id_user . "'");

    $subject = $nuked['name'] . " : " . _REGISTRATION . ", " . $date2;
    $corps = $pseudo . ", " . _VALIDREGISTRATION . "\r\n" . $nuked['url'] . "/index.php?file=User&op=login_screen\r\n\r\n\r\n" . $nuked['name'] . " - " . $nuked['slogan'];
    $from = "From: " . $nuked['name'] . " <" . $nuked['mail'] . ">\r\nReply-To: " . $nuked['mail'];

    $subject = @html_entity_decode($subject);
    $corps = @html_entity_decode($corps);
    $from = @html_entity_decode($from);

    mail($mail, $subject, $corps, $from);

        echo "<br /><br /><div style=\"text-align: center;\">" . _USERVALIDATE . "</div><br /><br />";
        redirect("index.php?file=Admin&page=user&op=main_valid", 2);
    }

    function main_valid()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
    . "<!--\n"
    . "\n"
    . "function deluser(pseudo, id)\n"
    . "{\n"
    . "if (confirm('" . _DELBLOCK . " '+pseudo+' ! " . _CONFIRM . "'))\n"
    . "{document.location.href = 'index.php?file=Admin&page=user&op=del_user&id_user='+id;}\n"
    . "}\n"
    . "// -->\n"
    . "</script>\n";

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
    . "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
    . "</div></div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Admin&amp;page=user\">" . _NAMEMEMBERS . "</a> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=add_user\">" . _ADDUSER . "</a> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\">" . _TEAMMANAGEMENT . "</a> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_config\">" . _USERCONFIG . "</a><br />"    
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a> | "
    . "</b>" . _USERVALIDATION . "<b> | "
    . "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\">" . _BAN . "</a></b></div><br />\n"
    . "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
    . "<tr>\n"
    . "<td style=\"width: 20%;\" align=\"center\"><b>" . _NICK . "</b></td>\n"
    . "<td style=\"width: 20%;\" align=\"center\"><b>" . _MAIL . "</b></td>\n"
    . "<td style=\"width: 15%;\" align=\"center\"><b>" . _DATEUSER . "</b></td>\n"
    . "<td style=\"width: 15%;\" align=\"center\"><b>" . _VALIDUSER . "</b></td>\n"
    . "<td style=\"width: 15%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
    . "<td style=\"width: 15%;\" align=\"center\"><b>" . _DELETE . "</b></td></tr>\n";

        $theday = time();
        $sql = mysql_query("SELECT id, pseudo, mail, date FROM " . USER_TABLE . " WHERE niveau = 0 ORDER BY date");
        $nb_user = mysql_num_rows($sql);
        $compteur = 0;
        while (list($id_user, $pseudo, $mail, $date) = mysql_fetch_array($sql))
        {
            if ($nuked['validation'] == "admin")
            {
                $limit_time = $date + 864000;
            }
            else
            {
                $limit_time = $date + 86400;
            }

            $user_date = nkDate($date);

            if ($limit_time < $theday)
            {
                $compteur++;
                $del = mysql_query("DELETE FROM " . USER_TABLE . " WHERE niveau = 0 AND id = '" . $id_user . "'");
            }


            echo "<tr>"
            . "<td style=\"width: 20%;\">&nbsp;" . $pseudo . "</td>"
            . "<td style=\"width: 25%;\" align=\"center\"><a href=\"mailto:" . $mail . "\">" . $mail . "</a></td>\n"
            . "<td style=\"width: 15%;\" align=\"center\">" . $user_date . "</td>\n"
            . "<td style=\"width: 15%;\" align=\"center\"><a href=\"index.php?file=Admin&amp;page=user&amp;op=validation&amp;id_user=" . $id_user . "\"><img style=\"border: 0;\" src=\"images/valid.gif\" alt=\"\" title=\"" . _VALIDTHISUSER . "\" /></a></a></td>\n"
            . "<td style=\"width: 10%;\" align=\"center\"><a href=\"index.php?file=Admin&amp;page=user&amp;op=edit_user&amp;id_user=" . $id_user . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITUSER . "\" /></a></a></td>\n"
            . "<td style=\"width: 15%;\" align=\"center\"><a href=\"javascript:deluser('" . mysql_real_escape_string(stripslashes($pseudo)) . "', '" . $id_user . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELETEUSER . "\" /></a></td></tr>\n";
        }
        if ($compteur > 0)
        {
            if($compteur == 1)
            {
                $text = "".$compteur." "._1USNOTACTION."";
            }
            else
            {
                $text = "".$compteur." "._USNOTACTION."";
            }
            $upd = mysql_query("INSERT INTO ". $nuked['prefix'] ."_notification  (`date` , `type` , `texte`)  VALUES ('".$theday."', '3', '".$text."')");
        }
        if ($nb_user == 0)
        {
            echo "<tr><td align=\"center\" colspan=\"6\">" . _NOUSERVALIDATION . "</td></tr>\n";
        }

        echo "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&amp;page=user\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    /**
     * Delete moderator from FORUM_TABLE with a user ID
     * @param integer $idUser : a user ID
     * @return bool : true if delete success, false if not
     */
    function delModerator($idUser)
    {
        $resultQuery = mysql_query("SELECT id,moderateurs FROM " . FORUM_TABLE . " WHERE moderateurs LIKE '%" . $idUser . "%'");
        while (list($forumID, $listModos) = mysql_fetch_row($resultQuery))
        {
            if (is_int(strpos($listModos, '|'))) //Multiple moderators in this category
            {
                $tmpListModos = explode('|', $listModos);
                $tmpKey = array_search($idUser, $tmpListModos);
                if ($tmpKey !== false)
                {
                    unset($tmpListModos[$tmpKey]);
                    $tmpListModos = implode('|', $tmpListModos);
                    $updateQuery = mysql_query("UPDATE " . FORUM_TABLE . " SET moderateurs = '" . $tmpListModos . "' WHERE id = '" . $forumID . "'");
                }
            }
            else
            {
                if ($idUser == $listModos) // Only one moderator in this category
                {
                    $updateQuery = mysql_query("UPDATE " . FORUM_TABLE . " SET moderateurs = '' WHERE id = '" . $forumID . "'");
                }
                // Else, no moderator in this category
            }
        }
        if ($resultQuery)
            return true;
        else
            return false;
    }

	  function main_config()
    {
        global $nuked, $language;
		$sql = mysql_query("SELECT mail, icq, msn, aim, yim, xfire, facebook, originea, steam, twiter, skype, lien, nivoreq FROM ". $nuked['prefix'] ."_users_config");
		list($mail, $icq, $msn, $aim, $yim, $xfire, $facebook, $originea, $steam, $twiter, $skype, $lien, $niveau) = mysql_fetch_array($sql);
		
		if ($mail == "on"){$checked_mail = "checked=\"checked\"";} if ($icq == "on"){$checked_icq = "checked=\"checked\"";}
		if ($msn == "on"){$checked_msn = "checked=\"checked\"";} if ($aim == "on"){$checked_aim = "checked=\"checked\"";} 
		if ($yim == "on"){$checked_yim = "checked=\"checked\"";} if ($xfire == "on"){$checked_xfire = "checked=\"checked\"";}
		if ($facebook == "on"){$checked_facebook = "checked=\"checked\"";} if ($originea == "on"){$checked_originea = "checked=\"checked\"";}
		if ($steam == "on"){$checked_steam = "checked=\"checked\"";} if ($twiter == "on"){$checked_twiter = "checked=\"checked\"";} 
		if ($skype == "on"){$checked_skype = "checked=\"checked\"";} if ($lien == "on"){$checked_lien = "checked=\"checked\"";}
		
		
	 echo "<div class=\"content-box\">\n"
        . "<div class=\"content-box-header\"><h3>" . _USERADMIN . "</h3>\n"
        . "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/user.php\" rel=\"modal\">\n"
		. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
		. "</div></div>\n"
		. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Admin&amp;page=user\">" . _NAMEMEMBERS . "</a> | "
		. "<a href=\"index.php?file=Admin&amp;page=user&amp;op=add_user\">" . _ADDUSER . "</a> | "
		. "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_cat\">" . _TEAMMANAGEMENT . "</a> | "
		. "</b>" . _USERCONFIG . "<b><br />"
		. "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a> | "
		. "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_valid\">" . _USERVALIDATION . "</a> | "
		. "<a href=\"index.php?file=Admin&amp;page=user&amp;op=main_ip\">" . _BAN . "</a></b></div><br />\n"
		. "<form method=\"post\" name=\"selection\" action=\"index.php?file=Admin&amp;page=user&amp;op=send_config\"\">\n"
		. "<table width=\"100\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		. "<tr><td width=\"25%\"><b>" . _MAIL . " :</b></td><td width=\"75%\"><input type=\"checkbox\" name=\"mail\" value=\"on\" " . $checked_mail . "></td></tr>\n"
		. "<tr><td><b>" . _ICQ . " :</b></td><td><input type=\"checkbox\" name=\"icq\" value=\"on\" " . $checked_icq . "></td></tr>\n"
		. "<tr><td><b>" . _MSN . " :</b></td><td><input type=\"checkbox\" name=\"msn\" value=\"on\" " . $checked_msn . "></td></tr>\n"
		. "<tr><td><b>" . _AIM . " :</b></td><td><input type=\"checkbox\" name=\"aim\" value=\"on\" " . $checked_aim . "></td></tr>\n"
		. "<tr><td><b>" . _YIM . " :</b></td><td><input type=\"checkbox\" name=\"yim\" value=\"on\" " . $checked_yim . "></td></tr>\n"
		. "<tr><td><b>" . _XFIRE . " :</b></td><td><input type=\"checkbox\" name=\"xfire\" value=\"on\" " . $checked_xfire . "></td></tr>\n"
		. "<tr><td><b>" . _FACEBOOK . " :</b></td><td><input type=\"checkbox\" name=\"facebook\" value=\"on\" " . $checked_facebook . "></td></tr>\n"
		. "<tr><td><b>" . _ORIGINEA . " :</b></td><td><input type=\"checkbox\" name=\"originea\" value=\"on\" " . $checked_originea . "></td></tr>\n"
		. "<tr><td><b>" . _STEAM . " :</b></td><td><input type=\"checkbox\" name=\"steam\" value=\"on\" " . $checked_steam . "></td></tr>\n"
		. "<tr><td><b>" . _TWITER . " :</b></td><td><input type=\"checkbox\" name=\"twiter\" value=\"on\" " . $checked_twiter . "></td></tr>\n"
		. "<tr><td><b>" . _SKYPE . " :</b></td><td><input type=\"checkbox\" name=\"skype\" value=\"on\" " . $checked_skype . "></td></tr>\n"
		. "<tr><td><b>" . _LINK . "</b> - " . _LINKCOM . " :</b></td><td><input type=\"checkbox\" name=\"lien\" value=\"on\" " . $checked_lien . "></td></tr>\n"
		. "<tr><td><b>" . _LEVELREQUIRED . " :</b></td><td>\n"
        . "<select name=\"niveau\" >\n"
        . "<option>" . $niveau . "</option>\n"
        . "<option>0</option>\n"        
        . "<option>1</option>\n"
        . "<option>2</option>\n"
        . "<option>3</option>\n"
        . "<option>4</option>\n"
        . "<option>5</option>\n"
        . "<option>6</option>\n"
        . "<option>7</option>\n"
        . "<option>8</option>\n"
        . "<option>9</option></select></td></tr>\n"		
		
		. "<tr><td align=\"center\"><input type=\"submit\" value=\"" . _MODIFCONFIG . "\" /></td><td><input type=\"button\" value=\"" . _COTOUT . "\" onclick=\"toutcocher();\"> - \n"
        . "<input type=\"button\" value=\"" . _DECOTOUT . "\" onclick=\"toutdecocher();\"></td></tr>\n"
		. "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin&page=user\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
		
	 echo '<script language="javascript">
		  function toutcocher() 
		  {
		  for(i=0;i<document.selection.length;i++) 
		  { 
		  if(document.selection.elements[i].type=="checkbox") 
		  document.selection.elements[i].checked=true; 
		  } 
		  }
		  function toutdecocher()
		  {
		  for(i=0;i<document.selection.length;i++) 
		  {
		  if(document.selection.elements[i].type=="checkbox"); 
		  document.selection.elements[i].checked=false;; 
		  } 
		  }
		  </script>';

	}
	  function send_config($mail, $icq, $msn, $aim, $yim, $xfire, $facebook, $originea, $steam, $twiter, $skype, $lien, $niveau)
    {       
	    global $nuked, $user;
	    if ($mail != 'on'){$mail = "off";} if ($icq != 'on'){$icq = "off";} if ($msn != 'on'){$msn = "off";} if ($aim != 'on'){$aim = "off";} if ($yim != 'on'){$yim = "off";}
	    if ($xfire != 'on'){$xfire = "off";} if ($facebook != 'on'){$facebook = "off";} if ($originea != 'on'){$originea = "off";} if ($steam != 'on'){$steam = "off";} 
		if ($twiter != 'on'){$twiter = "off";} if ($skype != 'on'){$skype = "off";} if ($lien != 'on'){$lien = "off";}

     
	    $update = mysql_query("UPDATE ". $nuked['prefix'] ."_users_config SET mail = '" . $mail . "' , icq = '" . $icq . "' , msn = '" . $msn . "' , aim = '" . $aim . "', yim = '" . $yim . "' , xfire = '" . $xfire . "' , facebook = '" . $facebook . "' , originea = '" . $originea . "' , steam = '" . $steam . "' , twiter = '" . $twiter . "' , skype = '" . $skype . "' , lien = '" . $lien . "' , nivoreq = '" . $niveau . "' WHERE id='1'");
		
		$texteaction = "". _ACTIONMODIFUSER .".";
		$acdate = time();
		$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");

		echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _CONFIGUPDATED . "\n"
				. "</div>\n"
				. "</div>\n";
        redirect("index.php?file=Admin&page=user", 2);
	}

   
    switch ($_REQUEST['op'])
    {
        case "main_config":
        main_config();
        break;
			
        case "send_config":
        send_config($_REQUEST['mail'], $_REQUEST['icq'], $_REQUEST['msn'], $_REQUEST['aim'], $_REQUEST['yim'], $_REQUEST['xfire'], $_REQUEST['facebook'], $_REQUEST['originea'], $_REQUEST['steam'], $_REQUEST['twiter'], $_REQUEST['skype'], $_REQUEST['lien'], $_REQUEST['niveau']);
        break;

        case "update_user":
            update_user($_REQUEST['id_user'], $_REQUEST['team'], $_REQUEST['team2'], $_REQUEST['team3'], $_REQUEST['rang'], $_REQUEST['nick'], $_REQUEST['mail'], $_REQUEST['email'], $_REQUEST['url'], $_REQUEST['icq'], $_REQUEST['msn'], $_REQUEST['aim'], $_REQUEST['yim'], $_REQUEST['country'], $_REQUEST['niveau'], $_REQUEST['pass_reg'], $_REQUEST['pass_conf'], $_REQUEST['pass'], $_REQUEST['game'], $_REQUEST['avatar'], $_REQUEST['signature'], $_REQUEST['old_nick'], $_REQUEST['xfire'], $_REQUEST['facebook'], $_REQUEST['origin'], $_REQUEST['steam'], $_REQUEST['twitter'], $_REQUEST['skype'], $_REQUEST['points']);
            break;

        case "add_user":
            add_user();
            break;

        case "do_user":
            do_user($_REQUEST['team'], $_REQUEST['team2'], $_REQUEST['team3'], $_REQUEST['rang'], $_REQUEST['nick'], $_REQUEST['mail'], $_REQUEST['email'], $_REQUEST['url'], $_REQUEST['icq'], $_REQUEST['msn'], $_REQUEST['aim'], $_REQUEST['yim'], $_REQUEST['country'], $_REQUEST['niveau'], $_REQUEST['pass_reg'], $_REQUEST['pass_conf'], $_REQUEST['game'], $_REQUEST['avatar'], $_REQUEST['signature'], $_REQUEST['xfire'], $_REQUEST['facebook'], $_REQUEST['origin'], $_REQUEST['steam'], $_REQUEST['twitter'], $_REQUEST['skype']);
            break;

        case "edit_user":
            edit_user($_REQUEST['id_user']);
            break;

        case "del_user":
            del_user($_REQUEST['id_user']);
            break;

         case "send_cat":
            send_cat($_REQUEST['titre'], $_REQUEST['game'], $_REQUEST['tag'], $_REQUEST['tag2'], $_REQUEST['ordre']);
            break;

        case "add_cat":
            add_cat();
            break;

        case "main_cat":
            main_cat();
            break;

        case "edit_cat":
            edit_cat($_REQUEST['cid']);
            break;

        case "modif_cat":
            modif_cat($_REQUEST['cid'], $_REQUEST['titre'], $_REQUEST['game'], $_REQUEST['tag'], $_REQUEST['tag2'], $_REQUEST['ordre']);
            break;

        case "del_cat":
            del_cat($_REQUEST['cid']);
            break;

        case "main_ip":
            main_ip();
            break;

        case "add_ip":
            add_ip();
            break;

        case "edit_ip":
            edit_ip($_REQUEST['ip_id']);
            break;

        case "send_ip":
            send_ip($_REQUEST['ip'], $_REQUEST['pseudo'], $_REQUEST['email'],$_REQUEST['dure'], $_REQUEST['texte']);
            break;

        case "modif_ip":
            modif_ip($_REQUEST['ip_id'], $_REQUEST['ip'], $_REQUEST['pseudo'], $_REQUEST['email'],$_REQUEST['dure'], $_REQUEST['texte']);
            break;

        case "del_ip":
            del_ip($_REQUEST['ip_id']);
            break;

        case "main_rank":
            main_rank();
            break;

        case "add_rank":
            add_rank();
            break;

        case "edit_rank":
            edit_rank($_REQUEST['rid']);
            break;

        case "send_rank":
            send_rank($_REQUEST['titre'], $_REQUEST['ordre'], $_REQUEST['urlimage'], $_REQUEST['upimage'],  $_REQUEST['color']);
            break;

        case "modif_rank":
            modif_rank($_REQUEST['rid'], $_REQUEST['titre'], $_REQUEST['ordre'], $_REQUEST['urlimage'], $_REQUEST['upimage'], $_REQUEST['color']);
            break;

        case "del_rank":
            del_rank($_REQUEST['rid']);
            break;

        case "main_valid":
            main_valid();
            break;

        case "validation":
            validation($_REQUEST['id_user']);
            break;

        case "main":
            main();
            break;

        default:
            main();
            break;
    }

}
else if ($visiteur > 1)
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
}
else
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
}
adminfoot();

?>
