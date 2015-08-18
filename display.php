<?php

$row_count = 0;
$page_count = 0;

while ($row = mysql_fetch_array($result)) {

    $display_stamp = "" . $row["timestamp"] . "";
    $time = date($timefmt, $display_stamp);
    $date = date($datefmt, $display_stamp);

    if ($row_count == 0) {

        if ($page_count == 0) {

            // display sortable column headings for main page //
?>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PHP TimeClock, Admin">
    <meta name="author" content="Wael Ali">
    <meta name="keyword" content="PHP TimeClock, Bootstrap, Responsive">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Admin Login</title>
   <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
   
 
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
	<link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
	
	
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
	
	<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
     <div class="row">
                  <div class="col-sm-6">
                      <section class="panel">   
<?php
            echo "            <table class=table width=100% border=0 cellpadding=2 cellspacing=0>\n";

            if (!isset($_GET['printer_friendly'])) {
                echo "             
                <a href='timeclock.php?printer_friendly=true'>printer friendly page</a>
                \n";
            }

            echo "              <tr >\n";
          /*   echo "                <td >
                                    <a 
                                    href='$current_page?sortcolumn=empfullname&sortdirection=$sortnewdirection'>Name</a></td>\n";
            echo "                <td ><a 
                                    href='$current_page?sortcolumn=inout&sortdirection=$sortnewdirection'>In/Out</a></td>\n";
            echo "                <td ><a 
                                    href='$current_page?sortcolumn=tstamp&sortdirection=$sortnewdirection'>Time</a></td>\n";
            echo "                <td ><a 
                                    href='$current_page?sortcolumn=tstamp&sortdirection=$sortnewdirection'>Date</a></td>\n"; */

            if ($display_office_name == "yes") {
                echo "                <td ><a 
                                        href='$current_page?sortcolumn=office&sortdirection=$sortnewdirection'>Office</a></td>\n";
            }

            if ($display_group_name == "yes") {
                echo "                <td ><a 
                                        href='$current_page?sortcolumn=groups&sortdirection=$sortnewdirection'>Group</a></td>\n";
            }

            echo "                <td ><a
                                    href='$current_page?sortcolumn=notes&sortdirection=$sortnewdirection'><u>Notes</u></a></td>\n";
            echo "              </tr>\n";

        } else {

            // display report name and page number of printed report above the column headings of each printed page //

            $temp_page_count = $page_count + 1;
        }

        echo "              <tr >\n";
        echo "                <td '>Name</td>\n";
        echo "                <td >In/Out</td>\n";
        echo "                <td 
                           >Time</td>\n";
        echo "                <td 
                          >Date</td>\n";

        if ($display_office_name == "yes") {
            echo "                <td >Office</td>\n";
        }

        if ($display_group_name == "yes") {
            echo "                <td >Group</td>\n";
        }

        echo "                <td ><a >Notes</td>\n";
        echo "              </tr>\n";
    }

    // begin alternating row colors //

    $row_color = ($row_count % 2) ? $color1 : $color2;

    // display the query results //

    $display_stamp = $display_stamp + @$tzo;
    $time = date($timefmt, $display_stamp);
    $date = date($datefmt, $display_stamp);

    if ($show_display_name == "yes") {
        echo stripslashes("              <tr ><td >" . $row["displayname"] . "</td>\n");
    } elseif ($show_display_name == "no") {
        echo stripslashes("              <tr ><td >" . $row["empfullname"] . "</td>\n");
    }

    echo "                <td " . $row["color"] . ";>" . $row["inout"] . "</td>\n";
    echo "                <td >" . $time . "</td>\n";
    echo "                <td >" . $date . "</td>\n";

    if ($display_office_name == "yes") {
        echo "                <td >" . $row["office"] . "</td>\n";
    }

    if ($display_group_name == "yes") {
        echo "                <td >" . $row["groups"] . "</td>\n";
    }

    echo stripslashes("                <td >" . $row["notes"] . "</td>\n");
    echo "              </tr>\n";

    $row_count++;

    // output 40 rows per printed page //

    if ($row_count == 40) {
        echo "              <tr ></tr>\n";
        $row_count = 0;
        $page_count++;
    }

}

echo "            </table>\n";
echo "</div></div></section>";


if (!isset($_GET['printer_friendly'])) {
    echo "          </td></tr>\n";
}

mysql_free_result($result);
?>
