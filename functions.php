<?php

function _tc_bind_param($stmt, $params, $types) {
    if (is_null($params)) {
        $params = array();
    }

    if (!is_array($params)) {
        $params = array($params);
    }

    if (empty($params)) { return; }

    if (is_null($types)) {
        $types = str_repeat("s", count($params));
    }

    $refs = array();
    foreach ($params as $key => $value) {
        $refs[$key] = &$params[$key];
    }
    array_unshift($refs, $types);
    return call_user_func_array(array($stmt, 'bind_param'), @$refs);
}

function tc_execute($query, $params = array(), $types = null) {
    if (!($stmt = $GLOBALS["___mysqli_ston"]->prepare($query))) {
        error_log("Failed to prepare $query: " . mysqli_error($GLOBALS["___mysqli_ston"]));
        return false;
    }
    _tc_bind_param($stmt, $params, $types);
    if (!$stmt->execute()) {
        error_log("Failed to execute: " . $stmt->error);
        return false;
    }
    return $stmt->close();
}

function tc_query($query, $params = array(), $types = null) {
    if (!($stmt = $GLOBALS["___mysqli_ston"]->prepare($query))) {
        error_log("Failed to prepare $query: " . mysqli_error($GLOBALS["___mysqli_ston"]));
        return false;
    }
    _tc_bind_param($stmt, $params, $types);
    if (!$stmt->execute()) {
        error_log("Failed to execute: " . $stmt->error);
        return false;
    }
    return $stmt->get_result();
}

function tc_select($what, $from, $where = '1=1', $params = array(), $types = null) {
    global $db_prefix;
    return tc_query("SELECT $what FROM ${db_prefix}$from WHERE $where", $params, $types);
}

function tc_select_value($what, $from, $where = '1=1', $params = array(), $types = null) {
    global $db_prefix;
    $result = tc_query("SELECT $what FROM ${db_prefix}$from WHERE $where", $params, $types);
    $value = null;
    while ($row = mysqli_fetch_array($result)) {
        $value = $row[0];
    }
    return $value;
}

function tc_delete($from, $where, $params = array(), $types = null) {
    global $db_prefix;
    return tc_query("DELETE FROM ${db_prefix}$from WHERE $where", $params, $types);
}

function tc_insert_strings($db, $keyvals) {
    global $db_prefix;
    $keys = '';
    $places = '';
    $types = '';
    $values = array();
    foreach ($keyvals as $key => $value) {
        if (!empty($keys)) {
            $keys .= ",";
            $places .= ",";
        }
        $keys .= "`$key`";
        $places .= "?";
        $types .= "s";
        $values[] = "$value";
    }
    tc_execute("INSERT INTO ${db_prefix}$db ($keys) VALUES ($places)", $values, $types);
    return mysqli_insert_id($GLOBALS["___mysqli_ston"]);
}

function tc_update_strings($db, $keyvals, $where = '1=1', $bind = array(), $types = null) {
    global $db_prefix;
    $places = '';
    $set_types = '';
    $values = array();
    foreach ($keyvals as $key => $value) {
        if (!empty($places)) {
            $places .= ",";
        }
        $places .= "`$key` = ?";
        $set_types .= "s";
        $values[] = "$value";
    }
    if (!is_array($bind)) {
        $bind = array($bind);
    }
    if (!is_null($types)) {
        $types = $set_types . $types;
    }
    tc_execute("UPDATE ${db_prefix}$db SET $places WHERE $where", array_merge($values, $bind), $types);
}

function btag($tag, $attr = array()) {
    $begin = array(htmlentities($tag));
    foreach ($attr as $key => $value) {
        $begin[] = htmlentities($key) . "=\"" . htmlentities($value) . "\"";
    }
    return "<" . implode(" ", $begin) . ">";
}

function tag($tag, $content = "", $attr = array()) {
    return btag($tag, $attr) . htmlentities($content) . "</" . htmlentities($tag) . ">";
}

function html_options($result, $selected='') {
    $rv = array();
    while ($row = mysqli_fetch_array($result)) {
        $value = htmlentities($row[0]);
        $display = htmlentities(is_null(@$row[1]) ? $row[0] : $row[1]);
        $sel = ($row[0] == $selected) ? " selected" : "";
        $rv[] = "<option value=\"$value\"$sel>$display</option>\n";
    }
    return implode("", $rv);
}

function yes_no_bool($val, $default=false) {
    if (strtolower(@$val) == 'yes') {
        return true;
    }
    if (strtolower(@$val) == 'no') {
        return false;
    }
    return $default;
}

function value_or_null($val) {
    return ((strlen(trim(@$val)) == 0) ? null : $val);
}

function has_value($val) {
    return (strlen(trim(@$val)) != 0);
}

function secsToHours($secs, $round_time) {

    /* The logic for this function was written by Adam Woodbeck, who initially wrote it to round to the
       nearest 15 minutes. It has been expanded to round to the nearest 5, 10, 20, and 30 minutes, as well
       as giving the option to not round at all. */

    /* This function will convert seconds to hours in decimal form */

    $hours = $secs / 3600.0;
    $mins = ($secs % 3600.0) / 60.0;
    $hours = floor($hours);

    /* Add the minutes back on as a percentage of an hour (e.g. 8.25 hours == 8 hours, 15 minutes) */

    if ($round_time == '1') {
        if ($mins >= 57.5)
            $hours += 1.0;
        elseif ($mins >= 52.5)
            $hours += 0.92;
        elseif ($mins >= 47.5)
            $hours += 0.83;
        elseif ($mins >= 42.5)
            $hours += 0.75;
        elseif ($mins >= 37.5)
            $hours += 0.67;
        elseif ($mins >= 32.5)
            $hours += 0.58;
        elseif ($mins >= 27.5)
            $hours += 0.50;
        elseif ($mins >= 22.5)
            $hours += 0.42;
        elseif ($mins >= 17.5)
            $hours += 0.33;
        elseif ($mins >= 12.5)
            $hours += 0.25;
        elseif ($mins >= 7.5)
            $hours += 0.17;
        elseif ($mins >= 2.5)
            $hours += 0.08;
    } elseif ($round_time == '2') {
        if ($mins >= 55.0)
            $hours += 1.0;
        elseif ($mins >= 45.0)
            $hours += 0.83;
        elseif ($mins >= 35.0)
            $hours += 0.67;
        elseif ($mins >= 25.0)
            $hours += 0.50;
        elseif ($mins >= 15.0)
            $hours += 0.33;
        elseif ($mins >= 5.0)
            $hours += 0.17;
    } elseif ($round_time == '3') {
        if ($mins >= 52.5)
            $hours += 1.0;
        elseif ($mins >= 37.5)
            $hours += 0.75;
        elseif ($mins >= 22.5)
            $hours += 0.5;
        elseif ($mins >= 7.5)
            $hours += 0.25;
    } elseif ($round_time == '4') {
        if ($mins >= 50.0)
            $hours += 1.0;
        elseif ($mins >= 30.0)
            $hours += 0.67;
        elseif ($mins >= 10.0)
            $hours += 0.33;
    } elseif ($round_time == '5') {
        if ($mins >= 45.0)
            $hours += 1.0;
        elseif ($mins >= 15.0)
            $hours += 0.5;
    } elseif (empty($round_time)) {
        $hours += $mins / 60.0;
        $hours = round($hours, 2);
    }

    return number_format($hours, 2);
}

function disabled_acct($get_user) {

    $query = "select empfullname, disabled from employees where empfullname = '" . addslashes($get_user) . "'";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

    while ($row = mysqli_fetch_array($result)) {

        if ("" . $row["disabled"] . "" == 1) {
            echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
            echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>The account for $get_user is
                disabled</td></tr>\n";
            echo "  <tr class=right_main_text>\n";
            echo "    <td align=center valign=top scope=row>\n";
            echo "      <table width=300 border=0 cellpadding=5 cellspacing=0>\n";
            echo "        <tr class=right_main_text><td align=center>Either re-enable the account or go back to the <a class=admin_headings
                      href='timeadmin.php'>\"Add/Edit/Delete Time\"</a> page and choose an account that is not disabled.</td></tr>\n";
            echo "      </table><br /></td></tr></table>\n";
            exit;
        }
    }
}

function get_ipaddress() {

    if (empty($REMOTE_ADDR)) {
        if (!empty($_SERVER) && isset($_SERVER['REMOTE_ADDR'])) {
            $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
        } else if (!empty($_ENV) && isset($_ENV['REMOTE_ADDR'])) {
            $REMOTE_ADDR = $_ENV['REMOTE_ADDR'];
        } else if (@getenv('REMOTE_ADDR')) {
            $REMOTE_ADDR = getenv('REMOTE_ADDR');
        }
    }
    if (empty($HTTP_X_FORWARDED_FOR)) {
        if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED_FOR'])) {
            $HTTP_X_FORWARDED_FOR = $_ENV['HTTP_X_FORWARDED_FOR'];
        } else if (@getenv('HTTP_X_FORWARDED_FOR')) {
            $HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR');
        }
    }
    if (empty($HTTP_X_FORWARDED)) {
        if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED'])) {
            $HTTP_X_FORWARDED = $_SERVER['HTTP_X_FORWARDED'];
        } else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED'])) {
            $HTTP_X_FORWARDED = $_ENV['HTTP_X_FORWARDED'];
        } else if (@getenv('HTTP_X_FORWARDED')) {
            $HTTP_X_FORWARDED = getenv('HTTP_X_FORWARDED');
        }
    }
    if (empty($HTTP_FORWARDED_FOR)) {
        if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $HTTP_FORWARDED_FOR = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED_FOR'])) {
            $HTTP_FORWARDED_FOR = $_ENV['HTTP_FORWARDED_FOR'];
        } else if (@getenv('HTTP_FORWARDED_FOR')) {
            $HTTP_FORWARDED_FOR = getenv('HTTP_FORWARDED_FOR');
        }
    }
    if (empty($HTTP_FORWARDED)) {
        if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED'])) {
            $HTTP_FORWARDED = $_SERVER['HTTP_FORWARDED'];
        } else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED'])) {
            $HTTP_FORWARDED = $_ENV['HTTP_FORWARDED'];
        } else if (@getenv('HTTP_FORWARDED')) {
            $HTTP_FORWARDED = getenv('HTTP_FORWARDED');
        }
    }
    if (empty($HTTP_VIA)) {
        if (!empty($_SERVER) && isset($_SERVER['HTTP_VIA'])) {
            $HTTP_VIA = $_SERVER['HTTP_VIA'];
        } else if (!empty($_ENV) && isset($_ENV['HTTP_VIA'])) {
            $HTTP_VIA = $_ENV['HTTP_VIA'];
        } else if (@getenv('HTTP_VIA')) {
            $HTTP_VIA = getenv('HTTP_VIA');
        }
    }
    if (empty($HTTP_X_COMING_FROM)) {
        if (!empty($_SERVER) && isset($_SERVER['HTTP_X_COMING_FROM'])) {
            $HTTP_X_COMING_FROM = $_SERVER['HTTP_X_COMING_FROM'];
        } else if (!empty($_ENV) && isset($_ENV['HTTP_X_COMING_FROM'])) {
            $HTTP_X_COMING_FROM = $_ENV['HTTP_X_COMING_FROM'];
        } else if (@getenv('HTTP_X_COMING_FROM')) {
            $HTTP_X_COMING_FROM = getenv('HTTP_X_COMING_FROM');
        }
    }
    if (empty($HTTP_COMING_FROM)) {
        if (!empty($_SERVER) && isset($_SERVER['HTTP_COMING_FROM'])) {
            $HTTP_COMING_FROM = $_SERVER['HTTP_COMING_FROM'];
        } else if (!empty($_ENV) && isset($_ENV['HTTP_COMING_FROM'])) {
            $HTTP_COMING_FROM = $_ENV['HTTP_COMING_FROM'];
        } else if (@getenv('HTTP_COMING_FROM')) {
            $HTTP_COMING_FROM = getenv('HTTP_COMING_FROM');
        }
    }

    // Gets the default ip sent by the user //

    if (!empty($REMOTE_ADDR)) {
        $direct_ip = $REMOTE_ADDR;
    }

    // Gets the proxy ip sent by the user //

    $proxy_ip = '';
    if (!empty($HTTP_X_FORWARDED_FOR)) {
        $proxy_ip = $HTTP_X_FORWARDED_FOR;
    } else if (!empty($HTTP_X_FORWARDED)) {
        $proxy_ip = $HTTP_X_FORWARDED;
    } else if (!empty($HTTP_FORWARDED_FOR)) {
        $proxy_ip = $HTTP_FORWARDED_FOR;
    } else if (!empty($HTTP_FORWARDED)) {
        $proxy_ip = $HTTP_FORWARDED;
    } else if (!empty($HTTP_VIA)) {
        $proxy_ip = $HTTP_VIA;
    } else if (!empty($HTTP_X_COMING_FROM)) {
        $proxy_ip = $HTTP_X_COMING_FROM;
    } else if (!empty($HTTP_COMING_FROM)) {
        $proxy_ip = $HTTP_COMING_FROM;
    }

    // Returns the true IP if it has been found, else FALSE //

    if (empty($proxy_ip)) {
        // True IP without proxy
        return $direct_ip;
    } else {
        $is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $proxy_ip, $regs);
        if ($is_ip && (count($regs) > 0)) {
            // True IP behind a proxy
            return $regs[0];
        } else {
            // Can't define IP: there is a proxy but we don't have
            // information about the true IP
            return false;
        }
    }
}

function ip_range($network, $ip) {

    /**
     * Based on IP Pattern Matcher
     * Originally by J.Adams <jna@retina.net>
     * Found on <http://www.php.net/manual/en/function.ip2long.php>
     * Modified by Robbat2 <robbat2@users.sourceforge.net>
     *
     * Matches:
     * xxx.xxx.xxx.xxx        (exact)
     * xxx.xxx.xxx.[yyy-zzz]  (range)
     * xxx.xxx.xxx.xxx/nn     (CIDR)
     *
     * Does not match:
     * xxx.xxx.xxx.xx[yyy-zzz]  (range, partial octets not supported)
     *
     * @param   string   string of IP range to match
     * @param   string   string of IP to test against range
     *
     * @return  boolean    always true
     *
     * @access  public
     */

    $result = true;

    if (preg_match('|([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)/([0-9]+)|', $network, $regs)) {
        // performs a mask match
        $ipl = ip2long($ip);
        $rangel = ip2long($regs[1] . '.' . $regs[2] . '.' . $regs[3] . '.' . $regs[4]);

        $maskl = 0;

        for ($i = 0; $i < 31; $i++) {
            if ($i < $regs[5] - 1) {
                $maskl = $maskl + pow(2, (30 - $i));
            }
        }

        if (($maskl & $rangel) == ($maskl & $ipl)) {
            return true;
        } else {
            return false;
        }
    } else {
        // range based
        $maskocts = explode('.', $network);
        $ipocts = explode('.', $ip);

        // perform a range match
        for ($i = 0; $i < 4; $i++) {
            if (preg_match('|\[([0-9]+)\-([0-9]+)\]|', $maskocts[$i], $regs)) {
                if (($ipocts[$i] > $regs[2])
                    || ($ipocts[$i] < $regs[1])
                ) {
                    $result = false;
                } // end if
            } else {
                if ($maskocts[$i] <> $ipocts[$i]) {
                    $result = false;
                }
            }
        }
    }

    return $result;
}

function setTimeZone() {

    global $use_client_tz;
    global $use_server_tz;

    if ($use_client_tz == "yes") {
        if (isset($_COOKIE['tzoffset'])) {
            $tzo = $_COOKIE['tzoffset'];
            settype($tzo, "integer");
            $tzo = $tzo * 60;
        }
    } elseif ($use_server_tz == "yes") {
        $tzo = date('Z');
    } else {
        $tzo = 0;
    }
}

?>