<?php

include 'config.inc.php';

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

// set cookie if 'Remember Me?' checkbox is checked, or reset cookie if 'Reset Cookie?' is checked //

if ($show_display_name == "yes") {
    $emp_name_field = "displayname";
} else {
    $emp_name_field = "empfullname";
}

if ($request == 'POST') {
    @$remember_me = $_POST['remember_me'];
    @$reset_cookie = $_POST['reset_cookie'];
    @$fullname = $_POST['left_fullname'];
    @$displayname = $_POST['left_displayname'];
    if ((isset($remember_me)) && ($remember_me != '1')) {
        echo "Something is fishy here.\n";
        exit;
    }
    if ((isset($reset_cookie)) && ($reset_cookie != '1')) {
        echo "Something is fishy here.\n";
        exit;
    }

    // begin post validation //

    if ($show_display_name == "yes") {

        if (isset($displayname)) {
            $tmp_displayname = tc_select_value("displayname", "employees", "displayname = ?", $displayname);
            if ((!isset($tmp_displayname)) && (!empty($displayname))) {
                echo "Username is not in the database.\n";
                exit;
            }
            $emp_name = $tmp_displayname;
        }

    } elseif ($show_display_name == "no") {

        if (isset($fullname)) {
            $tmp_empfullname = tc_select_value("empfullname", "employees", "empfullname = ?", $fullname);
            if ((!isset($tmp_empfullname)) && (!empty($fullname))) {
                echo "Username is not in the database.\n";
                exit;
            }
            $emp_name = $tmp_empfullname;
        }

    }

    // end post validation //

    if (isset($remember_me)) {
        setcookie("remember_me", $emp_name, time() + (60 * 60 * 24 * 365 * 2));
    } elseif (isset($reset_cookie)) {
        setcookie("remember_me", "", time() - 3600);
    }

    ob_end_flush();
}



echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=200 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";

// display links in top left of each page //

if ($links == "none") {
    echo "        <tr></tr>\n";
} else {
    echo "        <tr><td class=left_rows height=7 align=left valign=middle></td></tr>\n";

    for ($x = 0; $x < count($display_links); $x++) {
        echo "        <tr><td class=left_rows height=18 align=left valign=middle><a class=admin_headings href='$links[$x]' target='_new'>$display_links[$x]</a></td>
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
    echo "              <select name='left_displayname' tabindex=1>\n";
} else {
    echo "              <select name='left_fullname' tabindex=1>\n";
}

$emp_name_result = tc_select($emp_name_field, "employees", "disabled <> '1' AND empfullname <> 'admin' ORDER BY $emp_name_field");
echo "              <option value =''>...</option>\n";
while ($row = mysqli_fetch_array($emp_name_result)) {
    $abc = "" . $row[$emp_name_field] . "";

    if ((isset($_COOKIE['remember_me'])) && ($_COOKIE['remember_me'] == $abc)) {
        echo "              <option selected>$abc</option>\n";
    } else {
        echo "              <option>$abc</option>\n";
    }
}
echo "              </select></td></tr>\n";
((mysqli_free_result($emp_name_result) || (is_object($emp_name_result) && (get_class($emp_name_result) == "mysqli_result"))) ? true : false);
echo "        <tr><td height=7></td></tr>\n";


// determine whether to use encrypted passwords or not //

if ($use_passwd == "yes") {
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>Password:</td></tr>\n";
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>";
    echo "<input type='password' name='employee_passwd' maxlength='25' size='17' tabindex=2></td></tr>\n";
    echo "        <tr><td height=7></td></tr>\n";
}

echo "        <tr><td height=4 align=left valign=middle class=misc_items>In/Out:</td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>\n";

// query to populate dropdown with punchlist items //

$punchlist_result = tc_select("punchitems",  "punchlist");

echo "              <select name='left_inout' tabindex=3>\n";
echo "              <option value =''>...</option>\n";

while ($row = mysqli_fetch_array($punchlist_result)) {
    echo "              <option>" . $row['punchitems'] . "</option>\n";
}

echo "              </select></td></tr>\n";
((mysqli_free_result($punchlist_result) || (is_object($punchlist_result) && (get_class($punchlist_result) == "mysqli_result"))) ? true : false);

echo "        <tr><td height=7></td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>Notes:</td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items>";
echo "<input type='text' name='left_notes' maxlength='250' size='17' tabindex=4></td></tr>\n";

if (!isset($_COOKIE['remember_me'])) {
    echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                  <tr><td nowrap height=4 align=left valign=middle class=misc_items width=10%>Remember&nbsp;Me?</td><td width=90% align=left
                    class=misc_items style='padding-left:0px;padding-right:0px;' tabindex=5><input type='checkbox' name='remember_me' value='1'></td></tr>
                    </table></td><tr>\n";
} elseif (isset($_COOKIE['remember_me'])) {
    echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                  <tr><td nowrap height=4 align=left valign=middle class=misc_items width=10%>Reset&nbsp;Cookie?</td><td width=90% align=left
                    class=misc_items style='padding-left:0px;padding-right:0px;' tabindex=5><input type='checkbox' name='reset_cookie' value='1'></td></tr>
                    </table></td><tr>\n";
}

echo "        <tr><td height=7></td></tr>\n";
echo "        <tr><td height=4 align=left valign=middle class=misc_items><input type='submit' name='submit_button' value='Submit' align='center'
                tabindex=6></td></tr></form>\n";


if ($display_weather == 'yes') {
    echo '<tr><td>';
    include 'sidebar-metar-display.php';
    echo '</td></tr>';
}



echo "      </table></td>\n";

if ($request == 'POST') {

    // signin/signout data passed over from timeclock.php //

    $inout = $_POST['left_inout'];
    $notes = ereg_replace("[^[:alnum:] \,\.\?-]", "", strtolower($_POST['left_notes']));

    // begin post validation //

    if ($use_passwd == "yes") {
        $employee_passwd = crypt($_POST['employee_passwd'], 'xy');
    }

    $punchlist_result = tc_select("punchitems", "punchlist");

    while ($row = mysqli_fetch_array($punchlist_result)) {
        $tmp_inout = "" . $row['punchitems'] . "";
    }

    if (!isset($tmp_inout)) {
        echo "In/Out Status is not in the database.\n";
        exit;
    }

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

    } elseif ($show_display_name == "no") {

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

    // configure timestamp to insert/update //

    $time = time();
    $hour = gmdate('H', $time);
    $min = gmdate('i', $time);
    $sec = gmdate('s', $time);
    $month = gmdate('m', $time);
    $day = gmdate('d', $time);
    $year = gmdate('Y', $time);
    $tz_stamp = mktime($hour, $min, $sec, $month, $day, $year);

    if ($use_passwd == "no") {

        if ($show_display_name == "yes") {
            $fullname = tc_select_value("empfullname", "employees", "displayname = ?", $displayname);
        }

        $clockin = array("fullname" => $fullname, "inout" => $inout, "timestamp" => $tz_stamp, "notes" => $notes);
        if (strtolower($ip_logging) == "yes") {
            $clockin["ipaddress"] = $connecting_ip;
        }

        tc_insert_strings("info", $clockin);
        tc_update_strings("employees", array("tstamp" => $tz_stamp), "empfullname = ?", $fullname);

        echo "<head>\n";
        echo "<meta http-equiv='refresh' content=0;url=index.php>\n";
        echo "</head>\n";

    } else {

        $sel_result = tc_select(
            "empfullname, employee_passwd",
            "employees",
            "$emp_name_field = ?",
            $emp_name
        );
        while ($row = mysqli_fetch_array($sel_result)) {
            $tmp_password = "" . $row["employee_passwd"] . "";
            $fullname = "" . $row["empfullname"] . "";
        }

        if ($employee_passwd == $tmp_password) {

            $clockin = array("fullname" => $fullname, "inout" => $inout, "timestamp" => $tz_stamp, "notes" => $notes);
            if (strtolower($ip_logging) == "yes") {
                $clockin["ipaddress"] = $connecting_ip;
            }

            tc_insert_strings("info", $clockin);
            tc_update_strings("employees", array("tstamp" => $tz_stamp), "empfullname = ?", $fullname);

            echo "<head>\n";
            echo "<meta http-equiv='refresh' content=0;url=index.php>\n";
            echo "</head>\n";

        } else {

            echo "    <td align=left class=right_main scope=col>\n";
            echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
            echo "        <tr class=right_main_text>\n";
            echo "          <td valign=top>\n";
            echo "<br />\n";
            echo "You have entered the wrong password for $emp_name. Please try again.";
            include 'footer.php';
            exit;
        }

    }
}
?>
