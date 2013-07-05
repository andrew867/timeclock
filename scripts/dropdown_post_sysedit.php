<script language="JavaScript">

function office_names() {

var select = document.form.office_name;
select.options[0] = new Option("all");
select.options[0].value = 'all';

<?php

//@$office_name = $post_office_name;
@$office_name = $_POST['office_name'];;

$query = "select * from ".$db_prefix."offices order by officename asc";
$result = mysql_query($query);

$cnt=1;
while ($row=mysql_fetch_array($result)) {
  if ("".$row['officename']."" == stripslashes($office_name)) {
  echo "select.options[$cnt] = new Option(\"".$row['officename']."\",\"".$row['officename']."\", true, true);\n";
  } else {
  echo "select.options[$cnt] = new Option(\"".$row['officename']."\");\n";
  echo "select.options[$cnt].value = \"".$row['officename']."\";\n";
  }
  $cnt++;
}
mysql_free_result($result);
?>
}

function group_names() {
var offices_select = document.form.office_name;
var groups_select = document.form.group_name;
groups_select.options[0] = new Option("all");
groups_select.options[0].value = 'all';

if (offices_select.options[offices_select.selectedIndex].value != 'all') {
  groups_select.length = 0;
}

<?php

$query = "select * from ".$db_prefix."offices order by officename asc";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {
$office_row = addslashes("".$row['officename']."");
?>

if (offices_select.options[offices_select.selectedIndex].text == "<?php echo $office_row; ?>") {
<?php
$query2 = "select * from ".$db_prefix."offices, ".$db_prefix."groups where ".$db_prefix."groups.officeid = ".$db_prefix."offices.officeid 
           and ".$db_prefix."offices.officename = '".$office_row."'
           order by ".$db_prefix."groups.groupname asc";
$result2 = mysql_query($query2);
echo "groups_select.options[0] = new Option(\"all\");\n";
echo "groups_select.options[0].value = 'all';\n";
$cnt = 1;

while ($row2=mysql_fetch_array($result2)) {
  $groups = "".$row2['groupname']."";
  echo "groups_select.options[$cnt] = new Option(\"$groups\");\n";
  echo "groups_select.options[$cnt].value = \"$groups\";\n";
  $cnt++;
}

?>
}
<?php
}
mysql_free_result($result);
mysql_free_result($result2);
?>

if (groups_select.options[groups_select.selectedIndex].value != 'all') {
  groups_select.length = 0;
}
if (offices_select.options[offices_select.selectedIndex].value == 'all') {

<?php

echo "groups_select.options[0] = new Option(\"all\");\n";
echo "groups_select.options[0].value = 'all';\n";

$query3 = "select * from ".$db_prefix."groups order by groupname asc";
$result3 = mysql_query($query3);

$cnt=1;
while ($row3=mysql_fetch_array($result3)) {
  if ("".$row3['groupname']."" == stripslashes($display_group)) {
  echo "groups_select.options[$cnt] = new Option(\"".$row3['groupname']."\",\"".$row3['groupname']."\", true, true);\n";
  } else {
  echo "groups_select.options[$cnt] = new Option(\"".$row3['groupname']."\");\n";
  echo "groups_select.options[$cnt].value = \"".$row3['groupname']."\";\n";
  }
  $cnt++;
}
mysql_free_result($result3);
?>
}
}

</script>
