<?php

include 'config.inc.php';

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

// set cookie if 'Remember Me?' checkbox is checked, or reset cookie if 'Reset Cookie?' is checked //

if ($request == 'POST'){
    @$remember_me = $_POST['remember_me'];
    @$reset_cookie = $_POST['reset_cookie'];
    @$fullname = stripslashes($_POST['left_fullname']);
    @$displayname = stripslashes($_POST['left_displayname']);
    if ((isset($remember_me)) && ($remember_me != '1')) {echo "Something is fishy here.\n"; exit;}
    if ((isset($reset_cookie)) && ($reset_cookie != '1')) {echo "Something is fishy here.\n"; exit;}

    // begin post validation //

    if ($show_display_name == "yes") {

        if (isset($displayname)) {
            $displayname = addslashes($displayname);
            $query = "select displayname from ".$db_prefix."employees where displayname = '".$displayname."'";
            $emp_name_result = mysql_query($query);

            while ($row = mysql_fetch_array($emp_name_result)) {
                $tmp_displayname = "".$row['displayname']."";
            }
            if ((!isset($tmp_displayname)) && (!empty($displayname))) {echo "Username is not in the database.\n"; exit;}
            $displayname = stripslashes($displayname);
        }

    } 

    elseif ($show_display_name == "no") {

        if (isset($fullname)) {
            $fullname = addslashes($fullname);
            $query = "select empfullname from ".$db_prefix."employees where empfullname = '".$fullname."'";
            $emp_name_result = mysql_query($query);

            while ($row = mysql_fetch_array($emp_name_result)) {
                $tmp_empfullname = "".$row['empfullname']."";
            }
            if ((!isset($tmp_empfullname)) && (!empty($fullname))) {echo "Username is not in the database.\n"; exit;}
            $fullname = stripslashes($fullname);
        }

    }

    // end post validation //

    if (isset($remember_me)) {

        if ($show_display_name == "yes") {
            setcookie("remember_me", stripslashes($displayname), time() + (60 * 60 * 24 * 365 * 2));
        } 

        elseif ($show_display_name == "no") {
            setcookie("remember_me", stripslashes($fullname), time() + (60 * 60 * 24* 365 * 2));
        }

    } 

    elseif (isset($reset_cookie)) {
        setcookie("remember_me", "", time() - 3600);
    }

    ob_end_flush();
} 

if ($display_weather == 'yes') {

    include 'phpweather.php';
    $metar = get_metar($metar);
    $data = process_metar($metar);
    $mph = "mph";

    // weather info //

    if (!isset($data['temp_f'])) {$temp = '';} else {$temp = $data['temp_f'];}
    if (!isset($data['windchill_f'])) {$windchill = '';} else {$windchill = $data['windchill_f'];}
    if (!isset($data['wind_dir_text_short'])) {$wind_dir = '';} else {$wind_dir = $data['wind_dir_text_short'];}
    if (!isset($data['wind_miles_per_hour'])) {$wind = '';} else {$wind = round($data['wind_miles_per_hour']);}
    if ($wind == 0) {$wind_dir = 'None'; $mph = ''; $wind = '';} else {$wind_dir = $wind_dir;}
    if (!isset($data['visibility_miles'])) {$visibility = '';} else {$visibility = $data['visibility_miles'];}
    if (!isset($data['rel_humidity'])) {$humidity = 'None';} else {$humidity = round($data['rel_humidity'], 0);}
    if (!isset($data['time'])) {$time = '';} else {$time = date($timefmt, $data['time']);}
    if (!isset($data['cloud_layer1_condition'])) {$cloud_cover = '';} else {$cloud_cover = $data['cloud_layer1_condition'];}
    if (($temp <> '') && ($temp >= '70') && ($humidity <> '')) {
        $heatindex = number_format(-42.379 + (2.04901523 * $temp) + (10.1433312 * $humidity) - (0.22475541 * $temp * $humidity)
                                   - (0.00683783 * ($temp * $temp)) - (0.05481717 * ($humidity * $humidity))
                                   + (0.00122874 * ($temp * $temp) * $humidity) + (0.00085282 * $temp * ($humidity * $humidity))
                                   - (0.00000199 * ($temp * $temp) * ($humidity * $humidity)));
    }
    if ((isset($heatindex)) || ($windchill <> '')) {
        if (!isset($heatindex)) {
            $feelslike = $windchill;
        } else {
            $feelslike = $heatindex;
        }
    } else {
        $feelslike = $temp;
    }
}

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=170 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";

// display links in top left of each page //

if ($links == "none") {
    echo "        <tr></tr>\n";
} else {
    echo "        <tr><td class=left_rows height=7 align=left valign=middle></td></tr>\n";

    for ($x=0; $x<count($display_links); $x++) {
        echo "        <tr><td class=left_rows height=18 align=left valign=middle><a class=admin_headings href='$links[$x]'>$display_links[$x]</a></td>
                      </tr>\n";
    }

}

// display form to submit signin/signout information //

echo "        <form name='timeclock' action='$self' method='post'>\n";

if ($links == "none") {
    echo "        <tr><td height=7></td></tr>\n";
} else {
    echo "        <tr><td height=20></td></tr>\n";
}

echo "        <tr><td class=title_underline height=4 align=left valign=middle style='padding-left:10px;'>Please sign in below:</td></tr>\n";
echo "        <tr><td height=7></td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>Name:</td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>\n";

// query to populate dropdown with employee names //

if ($show_display_name == "yes") {

    $query = "select displayname from ".$db_prefix."employees where disabled <> '1'  and empfullname <> 'admin' order by displayname";
    $emp_name_result = mysql_query($query);
    echo "              <select name='left_displayname' tabindex=1>\n";
    echo "              <option value =''>...</option>\n";

    while ($row = mysql_fetch_array($emp_name_result)) {

        $abc = stripslashes("".$row['displayname']."");

        if ((isset($_COOKIE['remember_me'])) && (stripslashes($_COOKIE['remember_me']) == $abc)) {
            echo "              <option selected>$abc</option>\n";
        } else {
            echo "              <option>$abc</option>\n";
        }

    }

    echo "              </select></td></tr>\n";
    mysql_free_result($emp_name_result);
    echo "        <tr><td height=7></td></tr>\n";

} else {

    $query = "select empfullname from ".$db_prefix."employees where disabled <> '1'  and empfullname <> 'admin' order by empfullname";
    $emp_name_result = mysql_query($query);
    echo "              <select name='left_fullname' tabindex=1>\n";
    echo "              <option value =''>...</option>\n";

    while ($row = mysql_fetch_array($emp_name_result)) {

        $def = stripslashes("".$row['empfullname']."");
        if ((isset($_COOKIE['remember_me'])) && (stripslashes($_COOKIE['remember_me']) == $def)) {
            echo "              <option selected>$def</option>\n";
        } else {
            echo "              <option>$def</option>\n";
        }

    }

    echo "              </select></td></tr>\n";
    mysql_free_result($emp_name_result);
    echo "        <tr><td height=7></td></tr>\n";
}

// determine whether to use encrypted passwords or not //

if ($use_passwd == "yes") {	
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>Password:</td></tr>\n";
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>";
    echo          "<input type='password' name='employee_passwd' maxlength='25' size='17' tabindex=2></td></tr>\n";
    echo "        <tr><td height=7></td></tr>\n";
}

echo "        <tr><td height=4 align=left valign=middle class=misc_items>In/Out:</td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>\n";

// query to populate dropdown with punchlist items //

$query = "select punchitems from ".$db_prefix."punchlist";
$punchlist_result = mysql_query($query);

echo "              <select name='left_inout' tabindex=3>\n";
echo "              <option value =''>...</option>\n";

while ($row = mysql_fetch_array($punchlist_result)) {
    echo "              <option>".$row['punchitems']."</option>\n";
}

echo "              </select></td></tr>\n";
mysql_free_result( $punchlist_result );

echo "        <tr><td height=7></td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>Notes:</td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>";  
echo          "<input type='text' name='left_notes' maxlength='250' size='17' tabindex=4></td></tr>\n";

if (!isset($_COOKIE['remember_me'])) {
    echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                  <tr><td nowrap height=4 align=left valign=middle class=misc_items width=10%>Remember&nbsp;Me?</td><td width=90% align=left 
                    class=misc_items style='padding-left:0px;padding-right:0px;' tabindex=5><input type='checkbox' name='remember_me' value='1'></td></tr>
                    </table></td><tr>\n";
} 

elseif (isset($_COOKIE['remember_me'])) {
    echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                  <tr><td nowrap height=4 align=left valign=middle class=misc_items width=10%>Reset&nbsp;Cookie?</td><td width=90% align=left 
                    class=misc_items style='padding-left:0px;padding-right:0px;' tabindex=5><input type='checkbox' name='reset_cookie' value='1'></td></tr>
                    </table></td><tr>\n";
}

echo "        <tr><td height=7></td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items><input type='submit' name='submit_button' value='Submit' align='center' 
                tabindex=6></td></tr></form>\n";

if ($display_weather == "yes") {
    echo "        <tr><td height=25 align=left valign=bottom class=misc_items><font color='00589C'><b><u>Weather Conditions:</u></b></font></td></tr>\n";
    echo "        <tr><td height=7></td></tr>\n";
    echo "        <tr><td align=left valign=middle class=misc_items><b>$city</b></td></tr>\n";
    echo "        <tr><td height=4></td></tr>\n";
    echo "        <tr><td align=left valign=middle class=misc_items>Currently: $temp&#176;</td></tr>\n";
    echo "        <tr><td height=4></td></tr>\n";
    echo "        <tr><td align=left valign=middle class=misc_items>Feels Like: $feelslike&#176;</td></tr>\n";
    echo "        <tr><td height=4></td></tr>\n";
    echo "        <tr><td align=left valign=middle class=misc_items>Skies: $cloud_cover</td></tr>\n";
    echo "        <tr><td height=4></td></tr>\n";
    echo "        <tr><td align=left valign=middle class=misc_items>Wind: $wind_dir $wind$mph</td></tr>\n";
    echo "        <tr><td height=4></td></tr>\n";

    if ($humidity == 'None') {
        echo "        <tr><td align=left valign=middle class=misc_items>Humidity: $humidity</td></tr>\n";
    } else {
        echo "        <tr><td align=left valign=middle class=misc_items>Humidity: $humidity%</td></tr>\n";
    }

    echo "        <tr><td height=4></td></tr>\n";
    echo "        <tr><td align=left valign=middle class=misc_items>Visibility: $visibility miles</td></tr>\n";
    echo "        <tr><td height=4></td></tr>\n";
    echo "        <tr><td align=left valign=middle class=misc_items><font color='FF0000'>Last Updated: $time</font></td></tr>\n";
}

echo "        <tr><td height=90%></td></tr>\n";
echo "      </table></td>\n";

if ($request == 'POST') {

    // signin/signout data passed over from timeclock.php //

    $inout = $_POST['left_inout'];
    $notes = ereg_replace("[^[:alnum:] \,\.\?-]","",strtolower($_POST['left_notes']));

    // begin post validation //

    if ($use_passwd == "yes") {
        $employee_passwd = crypt($_POST['employee_passwd'], 'xy');
    }

    $query = "select punchitems from ".$db_prefix."punchlist";
    $punchlist_result = mysql_query($query);

    while ($row = mysql_fetch_array($punchlist_result)) {
        $tmp_inout = "".$row['punchitems']."";
    }

    if (!isset($tmp_inout)) {echo "In/Out Status is not in the database.\n"; exit;}

    // end post validation //

    if ($show_display_name == "yes") {

        if (!$displayname && !$inout) {
            echo "    <td align=left class=right_main scope=col>\n";
            echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
            echo "        <tr class=right_main_text>\n";
            echo "          <td valign=top>\n";
            echo "<br />\n";
            echo "You have not chosen a username or a status. Please try again.\n";
            include 'footer.php';
            exit;
        }

        if (!$displayname) {
            echo "    <td align=left class=right_main scope=col>\n";
            echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
            echo "        <tr class=right_main_text>\n";
            echo "          <td valign=top>\n";
            echo "<br />\n";
            echo "You have not chosen a username. Please try again.\n";
            include 'footer.php';
            exit;
        }

    } 
    
    elseif ($show_display_name == "no") {

        if (!$fullname && !$inout) {
            echo "    <td align=left class=right_main scope=col>\n";
            echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
            echo "        <tr class=right_main_text>\n";
            echo "          <td valign=top>\n";
            echo "<br />\n";
            echo "You have not chosen a username or a status. Please try again.\n";
            include 'footer.php';
            exit;
        }

        if (!$fullname) {
            echo "    <td align=left class=right_main scope=col>\n";
            echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
            echo "        <tr class=right_main_text>\n";
            echo "          <td valign=top>\n";
            echo "<br />\n";
            echo "You have not chosen a username. Please try again.\n";
            include 'footer.php';
            exit;
        }

    }

    if (!$inout) {
        echo "    <td align=left class=right_main scope=col>\n";
        echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
        echo "        <tr class=right_main_text>\n";
        echo "          <td valign=top>\n";
        echo "<br />\n";
        echo "You have not chosen a status. Please try again.\n";
        include 'footer.php';
        exit;
    }

    @$fullname = addslashes($fullname);
    @$displayname = addslashes($displayname);

    // configure timestamp to insert/update //

    $time = time();
    $hour = gmdate('H',$time);
    $min = gmdate('i',$time);
    $sec = gmdate('s',$time);
    $month = gmdate('m',$time);
    $day = gmdate('d',$time);
    $year = gmdate('Y',$time);
    $tz_stamp = mktime ($hour, $min, $sec, $month, $day, $year);

    if ($use_passwd == "no") {

        if ($show_display_name == "yes") {

            $sel_query = "select empfullname from ".$db_prefix."employees where displayname = '".$displayname."'";
            $sel_result = mysql_query($sel_query);

            while ($row=mysql_fetch_array($sel_result)) {
                $fullname = stripslashes("".$row["empfullname"]."");
                $fullname = addslashes($fullname);
            }
        }

        if (strtolower($ip_logging) == "yes") {
            $query = "insert into ".$db_prefix."info (fullname, `inout`, timestamp, notes, ipaddress) values ('".$fullname."', '".$inout."', 
                      '".$tz_stamp."', '".$notes."', '".$connecting_ip."')";
        } else {
            $query = "insert into ".$db_prefix."info (fullname, `inout`, timestamp, notes) values ('".$fullname."', '".$inout."', '".$tz_stamp."', 
                      '".$notes."')";
        }

        $result = mysql_query($query);

        $update_query = "update ".$db_prefix."employees set tstamp = '".$tz_stamp."' where empfullname = '".$fullname."'";
        $other_result = mysql_query($update_query);

        echo "<head>\n";
        echo "<meta http-equiv='refresh' content=0;url=index.php>\n";
        echo "</head>\n";

    } else {

    if ($show_display_name == "yes") {
        $sel_query = "select empfullname, employee_passwd from ".$db_prefix."employees where displayname = '".$displayname."'";
        $sel_result = mysql_query($sel_query);

        while ($row=mysql_fetch_array($sel_result)) {
            $tmp_password = "".$row["employee_passwd"]."";
            $fullname = "".$row["empfullname"]."";
        }

        $fullname = stripslashes($fullname);
        $fullname = addslashes($fullname);

    } else {

        $sel_query = "select empfullname, employee_passwd from ".$db_prefix."employees where empfullname = '".$fullname."'";
        $sel_result = mysql_query($sel_query);

        while ($row=mysql_fetch_array($sel_result)) {
            $tmp_password = "".$row["employee_passwd"]."";
        }

    }

    if ($employee_passwd == $tmp_password) {

        if (strtolower($ip_logging) == "yes") {
            $query = "insert into ".$db_prefix."info (fullname, `inout`, timestamp, notes, ipaddress) values ('".$fullname."', '".$inout."', 
                      '".$tz_stamp."', '".$notes."', '".$connecting_ip."')";
        } else {
            $query = "insert into ".$db_prefix."info (fullname, `inout`, timestamp, notes) values ('".$fullname."', '".$inout."', '".$tz_stamp."', 
                      '".$notes."')";
        }

        $result = mysql_query($query);
 
        $update_query = "update ".$db_prefix."employees set tstamp = '".$tz_stamp."' where empfullname = '".$fullname."'";
        $other_result = mysql_query($update_query);

        echo "<head>\n";
        echo "<meta http-equiv='refresh' content=0;url=index.php>\n";
        echo "</head>\n";

    } else {

        echo "    <td align=left class=right_main scope=col>\n";
        echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
        echo "        <tr class=right_main_text>\n";
        echo "          <td valign=top>\n";
        echo "<br />\n";

        if ($show_display_name == "yes") {
            $strip_fullname = stripslashes($displayname);
        } else {
            $strip_fullname = stripslashes($fullname);
        }

        echo "You have entered the wrong password for $strip_fullname. Please try again.";
        include 'footer.php'; exit;
    }

}
}
?>
