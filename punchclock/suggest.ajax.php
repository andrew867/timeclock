<?php
/**
 * Supply suggestions for employee names.
 *
 * This is an AJAX form and it returns a simple list of text.
 */

session_start();
if (!isset($_SESSION['application']))
    die("Invalid invocation.");

require_once 'config.inc.php';

// Parse arguments.
$search = isset($_GET['q']) ? $_GET['q'] : null;
if (!$search)
    exit;

// Connect to db.
$db = ($GLOBALS["___mysqli_ston"] = mysqli_connect($db_hostname,  $db_username,  $db_password))
or die("Could not connect to the database.");
mysqli_select_db($GLOBALS["___mysqli_ston"], $db_name);

// Search for employee names beginning with query
$q_search = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $search);
$query = <<<End_Of_SQL
select displayname
from {$db_prefix}employees
where displayname like '$q_search%'
End_Of_SQL;

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    trigger_error('suggest.ajax.php: error: ' . mysqli_error($GLOBALS["___mysqli_ston"]), E_USER_WARNING);
    die();
}

while ($row = mysqli_fetch_assoc($result)) {
    print $row['displayname'] . "\n";
}
?>
