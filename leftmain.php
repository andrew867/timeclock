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
    @$barcode = (yes_no_bool($barcode_clockin) ? $_POST['left_barcode'] : "");
    if ((isset($remember_me)) && ($remember_me != '1')) {
        echo "Something is fishy here.\n";
        exit;
    }
    if ((isset($reset_cookie)) && ($reset_cookie != '1')) {
        echo "Something is fishy here.\n";
        exit;
    }

    // begin post validation //
    $errors = array();

    if (has_value($barcode)) {
        $tmp_name = tc_select_value($emp_name_field, "employees", "barcode = ?", $barcode);
        if (!has_value($tmp_name)) {
            $errors[] = "Invalid barcode '$barcode'";
        } elseif (isset($emp_name) and $emp_name != $tmp_name) {
            $errors[] = "Username / Barcode mismatch";
        } else {
            $emp_name = $tmp_name;
        }
    }

    $tmp_name = '';
    if (yes_no_bool($show_display_name)) {
        if (has_value($displayname)) {
            $tmp_name = tc_select_value($emp_name_field, "employees", "displayname = ?", $displayname);
            if (!has_value($tmp_name)) {
                $errors[] = "Invalid username '$displayname'";
            }
        }
    } else {
        if (has_value($fullname)) {
            $tmp_name = tc_select_value($emp_name_field, "employees", "empfullname = ?", $fullname);
            if (!has_value($tmp_name)) {
                $errors[] = "Invalid username '$fullname'";
            }
        }
    }

    if (has_value($tmp_name)) {
        if (isset($emp_name) and $emp_name != $tmp_name) {
            $errors[] = "Username / Barcode mismatch";
        } else {
            $emp_name = $tmp_name;
        }
    }

    // end post validation //

    if (empty($errors)) {
        if (isset($remember_me)) {
            setcookie("remember_me", $emp_name, time() + (60 * 60 * 24 * 365 * 2));
        } elseif (isset($reset_cookie)) {
            setcookie("remember_me", "", time() - 3600);
        }
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

echo "        <form name='timeclock' action='$self' autocomplete='off' method='post'>\n";

if ($links == "none") {
    echo "        <tr><td height=7></td></tr>\n";
} else {
    echo "        <tr><td height=20></td></tr>\n";
}

if (yes_no_bool($barcode_clockin)) {
    echo <<<BARCODE_CLOCKIN
        <tr><td height="4" align="left" valign="middle" class="misc_items">Barcode:</td></tr>
        <tr><td height="4" align="left" valign="middle" class="misc_items">
            <input type="text" id="left_barcode" name="left_barcode" maxlength="250" size="17" value="" autocomplete="off" autofocus>
            <input type="text" style="display:none;"><!-- prevent login name auto-fill due to password field below -->
        </td></tr>
        <tr><td height="7"></td></tr>
BARCODE_CLOCKIN;
}

if (yes_no_bool($barcode_clockin) and yes_no_bool($manual_clockin)) {
    echo '<tr><td height="7"><hr></td></tr>';
}

if (yes_no_bool($manual_clockin)) {
    echo "        <tr><td class=title_underline height=4 align=left valign=middle style='padding-left:10px;'>Please sign in below:</td></tr>\n";
    echo "        <tr><td height=7></td></tr>\n";
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>Name:</td></tr>\n";
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>\n";

    // query to populate dropdown with employee names //

    if ($show_display_name == "yes") {
        echo "              <select name='left_displayname'>\n";
    } else {
        echo "              <select name='left_fullname'>\n";
    }

    echo "              <option value =''>...</option>\n";
    echo html_options(
        tc_select($emp_name_field, "employees", "disabled <> '1' AND empfullname <> 'admin' ORDER BY $emp_name_field"),
        @$_COOKIE['remember_me']
    );
    echo "              </select></td></tr>\n";
    echo "        <tr><td height=7></td></tr>\n";

    // determine whether to use encrypted passwords or not //

    if ($use_passwd == "yes") {
        echo "        <tr><td height=4 align=left valign=middle class=misc_items>Password:</td></tr>\n";
        echo "        <tr><td height=4 align=left valign=middle class=misc_items>";
        echo "<input type='password' name='employee_passwd' maxlength='25' size='17'></td></tr>\n";
        echo "        <tr><td height=7></td></tr>\n";
    }

    echo "        <tr><td height=4 align=left valign=middle class=misc_items>In/Out:</td></tr>\n";
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>\n";

    // populate dropdown with punchlist items //

    echo "              <select name='left_inout'>\n";
    echo "              <option value =''>...</option>\n";
    echo html_options(tc_select("punchitems",  "punchlist"));
    echo "              </select></td></tr>\n";

    echo "        <tr><td height=7></td></tr>\n";
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>Notes:</td></tr>\n";
    echo "        <tr><td height=4 align=left valign=middle class=misc_items>";
    echo "<input type='text' name='left_notes' maxlength='250' size='17'></td></tr>\n";

    if (!isset($_COOKIE['remember_me'])) {
        echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                      <tr><td nowrap height=4 align=left valign=middle class=misc_items width=10%>Remember&nbsp;Me?</td><td width=90% align=left
                        class=misc_items style='padding-left:0px;padding-right:0px;'><input type='checkbox' name='remember_me' value='1'></td></tr>
                        </table></td><tr>\n";
    } elseif (isset($_COOKIE['remember_me'])) {
        echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                      <tr><td nowrap height=4 align=left valign=middle class=misc_items width=10%>Reset&nbsp;Cookie?</td><td width=90% align=left
                        class=misc_items style='padding-left:0px;padding-right:0px;'><input type='checkbox' name='reset_cookie' value='1'></td></tr>
                        </table></td><tr>\n";
    }
    echo "        <tr><td height=7></td></tr>\n";
}

echo "        <tr><td height=4 align=left valign=middle class=misc_items><input type='submit' name='submit_button' value='Submit' align='center'></td></tr></form>\n";


if (yes_no_bool($display_weather)) {
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

    # Trying to toggle, look up the "punchnext" toggle state:
    if (!has_value($inout) and has_value($emp_name)) {
        $result = tc_query(<<<QUERY
   SELECT p.punchnext
     FROM ${db_prefix}employees AS e
LEFT JOIN ${db_prefix}info      AS i ON (e.empfullname = i.fullname AND e.tstamp = i.timestamp)
LEFT JOIN ${db_prefix}punchlist AS p ON (i.inout = p.punchitems)
    WHERE e.$emp_name_field = ?
QUERY
        , $emp_name);
        while ($row = mysqli_fetch_array($result)) {
            $inout = $row[0];
        }
    }
    elseif (has_value($inout)) {
        $inout = tc_select_value("punchitems", "punchlist", "punchitems = ?", $inout);
        if (!has_value($inout)) {
            echo "In/Out Status is not in the database.\n";
            exit;
        }
    }

    if ($use_passwd == "yes") {
        $employee_passwd = crypt($_POST['employee_passwd'], 'xy');
    }

    // end post validation //

    if (!has_value($emp_name) && !has_value($inout)) {
        $errors[] = "You have not chosen a username or a status. Please try again.";
    }
    elseif (!has_value($emp_name)) {
        $errors[] = "You have not chosen a username. Please try again.";
    }
    elseif (!has_value($inout)) {
        $errors[] = "You have not chosen a status. Please try again.";
    }

    if (!empty($errors)) {
        echo "    <td align=left class=right_main scope=col>\n";
        echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
        echo "        <tr class=right_main_text>\n";
        echo "          <td valign=top>\n";
        echo "<br />\n";
        echo implode("<br>\n", $errors);
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

    if (has_value($barcode) or $use_passwd == "no") {

        if (!has_value($fullname)) {
            $fullname = tc_select_value("empfullname", "employees", "$emp_name_field = ?", $emp_name);
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
