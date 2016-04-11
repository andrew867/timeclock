<header class="header dark-bg">
    <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
    </div>

    <!--logo start-->
    <a href="index.php" class="logo">PHP<span class="lite"> TimeClock</span></a>
    <!--logo end-->



    <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">


            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="profile-ava">
                        <img alt="" src="../img/avatar1_small.jpg">
                    </span>
                    <span class="username">USER</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>


                    <li>
                      <?php if ((isset($_SESSION['valid_user'])) || (isset($_SESSION['valid_reports_user'])) || (isset($_SESSION['time_admin_valid_user']))) {
                       echo' <a href="../logout.php"><i class="icon_key_alt"></i> Log Out</a>';
                      }
                      else{
                         echo' <a href="../login.php"><i class="icon_key_alt"></i> Login</a>';
                      }
                      ?>
                    </li>

                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
    </div>
</header>
<!--header end-->
<?php



// display the logo in top left of each page. This will be $logo you setup in config.inc.php. //
// It will also link you back to your index page. //

if ($logo == "none") {
    echo "    <td height=35 align=left></td>\n";

} else {

    echo "<td align=left><a href='../index.php'><img border=0 src='../$logo'></a></td>\n";
}

// if db is out of date, report it here //

if (($dbexists <> "1") || (@$my_dbversion <> $dbversion)) {
    echo "    <td no class=notprint valign=middle align=left style='font-size:13;font-weight:bold;color:#AA0000'><p>***Your database is out of date.***<br />
                                                                                &nbsp;&nbsp;&nbsp;Upgrade it via the admin section.</p></td>\n";
}

// display a 'reset cookie' message if $use_client_tz = "yes" //

if ($date_link == "none") {
    if ($use_client_tz == "yes") {
        echo "    <td class=notprint valign=middle align=right style='font-size:9px;'>
      <p>If the times below appear to be an hour off, click <a href='../resetcookie.php' style='font-size:9px;'>here</a> to reset.<br />
         If that doesn't work, restart your web browser and reset again.</p></td>\n";
    }
    echo "    <td colspan=2 scope=col align=right valign=middle><a style='color:#000000;font-family:Tahoma;font-size:10pt;text-decoration:none;'>";

} else {

    if ($use_client_tz == "yes") {
        echo "    <td class=notprint valign=middle align=right style='font-size:9px;'>
      <p>If the times below appear to be an hour off, click <a href='../resetcookie.php' style='font-size:9px;'>here</a> to reset.<br />
        If that doesn't work, restart your web browser and reset again.</p></td>\n";
    }
    echo "    <td colspan=2 scope=col align=right valign=middle><a href='$date_link' style='color:#000000;font-family:Tahoma;font-size:10pt;
        text-decoration:none;'>";
}

include 'sidenav.php';

?>
