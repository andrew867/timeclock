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
$db = mysqli_connect($db_hostname, $db_username, $db_password)
or die("Could not connect to the database.");
mysqli_select_db($db,$db_name);

// Search for employee names beginning with query
$q_search = mysqli_real_escape_string($db,$search);
$query = <<<End_Of_SQL
select displayname
from {$db_prefix}employees
where displayname like '$q_search%'
End_Of_SQL;

$result = mysqli_query($db,$query);
if (!$result) {
    trigger_error('suggest.ajax.php: error: ' . mysqli_error(), E_USER_WARNING);
    die();
}

while ($row = mysql_fetch_assoc($result)) {
    print $row['displayname'] . "\n";
}
?>
