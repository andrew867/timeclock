<?php
/**
 * Generate select tag options.
 *
 * Usage:
 *    // Print results of an sql query.
 *    print select_options("SELECT col1 FROM tab ORDER BY 1","curval1");
 *    print select_options("SELECT col1,text1 FROM tab ORDER BY 2","curval1");
 *
 *    // Print a one-dimensional array.
 *    print select_options(array('val1','val2','val3'),'val2');
 *
 *    // Print an array of two value arrays.
 *    print select_options( array( array('val1','text1'), array('val2','text2') ...);
 *
 * Note:
 *    The current selected value can be a scalar value or it can be an array
 *    of values for a <select multiple> tag.
 *
 *    Only <option> tags are returned.
 *
 *    If the global $db is set, it is used as the database resource link identifier,
 *    otherwise the mysql internal default connection is used.
 */

////////////////////////////////////////
function select_options($arg, $val = null) {
    // Return <option> tags for a <select>
    // $arg is a sql string or an array of values or an array of 2 value arrays
    // $val is selected value or an array of selected option values.
    $lookup = make_lookup_array($val);
    if (is_array($arg))
        return _select_options_arr($arg, $lookup);
    $html = ''; // initialize return string
    $db = isset($GLOBALS['db']) ? $GLOBALS['db'] : null;
    $result = mysql_query($arg, $db);
    while ($row = mysql_fetch_row($result)) {
        if (count($row) < 2)
            $row[1] = $row[0];
        $selected = isset($lookup[$row[0]]) ? ' selected="selected"' : '';
        $h1 = htmlentities($row[0]);
        $h2 = htmlentities($row[1]);
        $html .= "<option value=\"$h1\"$selected>$h2</option>\n";
    }

    return substr($html, 0, -1); // remove last LF
}

function _select_options_arr($arr, &$lookup) {
    if (is_array($arr[0]))
        return _select_options_arr2($arr, $lookup);
    $html = ''; // initialize return string
    for ($i = 0, $l = count($arr); $i < $l; $i++) {
        $selected = isset($lookup[$arr[$i]]) ? ' selected="selected"' : '';
        $h1 = $h2 = htmlentities($arr[$i]);
        $html .= "<option value=\"$h1\"$selected>$h2</option>\n";
    }

    return substr($html, 0, -1); // remove last LF
}

function _select_options_arr2($arr, &$lookup) {
    $html = ''; // initialize return string
    for ($i = 0, $l = count($arr); $i < $l; $i++) {
        $selected = isset($lookup[$arr[$i][0]]) ? ' selected="selected"' : '';
        $h1 = htmlentities($arr[$i][0]);
        $h2 = htmlentities($arr[$i][1]);
        $html .= "<option value=\"$h1\"$selected>$h2</option>\n";
    }

    return substr($html, 0, -1); // remove last LF
}

////////////////////////////////////////
function make_lookup_array($val = null) {
    $val = $val == null ? array() : $val;
    $val = is_array($val) ? $val : array($val);

    return array_flip($val);
}

?>
