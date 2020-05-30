<div class="sidebar" data-color="purple" data-background-color="white" data-image="./assets/img/sidebar-1.jpg">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
  <div class="logo"><a href="#" class="simple-text logo-normal">
      PHP Time Clock
    </a></div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item active">
        <a class="nav-link" href="./index.php">
          <i class="material-icons">house</i>
          <p>Home</p>
        </a>
      </li>
      <li class="nav-item ">
        <?php
        if ($use_reports_password == "yes") {
          echo '<a class="nav-link" href="login_reports.php" ><i class="material-icons">library_books</i><p>Reports</p></a>';
         }
          elseif ($use_reports_password == "no") {
             echo '<a class="nav-link" href="reports/index.php"><i class="material-icons">library_books</i><p>Reports</p></a>';
          }
        ?>

      </li>
      <li class="nav-item ">
        <a class="nav-link" href="./punchclock/menu.php">
          <i class="material-icons">content_paste</i>
          <p>Punchclock</p>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="./login.php">
          <i class="material-icons">person</i>
          <p>Login</p>
        </a>
      </li>
<li>
  <?php
  echo '

  					';
  echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
  echo "  <tr valign=top>\n";
  echo "    <td class=table width=170 align=left scope=col>\n";
  echo "      <table  width=100% border=0 cellpadding=1 cellspacing=0>\n";

  // display links in top left of each page //

  if ($links == "none") {
      echo "        <tr></tr>\n";
  } else {
      echo "        <tr><td class=left_rows height=7 align=left valign=middle></td></tr>\n";

      for ($x = 0; $x < count($display_links); $x++) {
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
  echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>Name:</td></tr>\n";
  echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>\n";

  // query to populate dropdown with employee names //

  if ($show_display_name == "yes") {

      $query = "select displayname from " . $db_prefix . "employees where disabled <> '1'  and empfullname <> 'admin' order by displayname";
      $emp_name_result = mysqli_query($db,$query);
      echo "              <select class=form-control input-lg m-bot15 name='left_displayname' tabindex=1>\n";
      echo "              <option value =''>...</option>\n";

      while ($row = mysqli_fetch_array($emp_name_result)) {

          $abc = stripslashes("" . $row['displayname'] . "");

          if ((isset($_COOKIE['remember_me'])) && (stripslashes($_COOKIE['remember_me']) == $abc)) {
              echo "              <option selected>$abc</option>\n";
          } else {
              echo "              <option>$abc</option>\n";
          }

      }

      echo "              </select></td></tr>\n";
      mysqli_free_result($emp_name_result);
      echo "        <tr><td height=7></td></tr>\n";

  } else {

      $query = "select empfullname from " . $db_prefix . "employees where disabled <> '1'  and empfullname <> 'admin' order by empfullname";
      $emp_name_result = mysqli_query($db,$query);
      echo "              <select class=form-control input-lg m-bot15 name='left_fullname' tabindex=1>\n";
      echo "              <option value =''>...</option>\n";

      while ($row = mysqli_fetch_array($emp_name_result)) {

          $def = stripslashes("" . $row['empfullname'] . "");
          if ((isset($_COOKIE['remember_me'])) && (stripslashes($_COOKIE['remember_me']) == $def)) {
              echo "              <option selected>$def</option>\n";
          } else {
              echo "              <option>$def</option>\n";
          }

      }

      echo "              </select></td></tr>\n";
      mysqli_free_result($emp_name_result);
      echo "        <tr><td height=7></td></tr>\n";
  }

  // determine whether to use encrypted passwords or not //

  if ($use_passwd == "yes") {
      echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>Password:</td></tr>\n";
      echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>";
      echo "<input class='form-control round-input' type='password' name='employee_passwd' maxlength='25' ></td></tr>\n";
      echo "        <tr><td height=7></td></tr>\n";
  }

  echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>In/Out:</td></tr>\n";
  echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>\n";

  // query to populate dropdown with punchlist items //

  $query = "select punchitems from " . $db_prefix . "punchlist";
  $punchlist_result = mysqli_query($db,$query);

  echo "              <select class=form-control input-lg m-bot15 name='left_inout' tabindex=3>\n";
  echo "              <option value =''>...</option>\n";

  while ($row = mysqli_fetch_array($punchlist_result)) {
      echo "              <option>" . $row['punchitems'] . "</option>\n";
  }

  echo "              </select></td></tr>\n";
  mysqli_free_result($punchlist_result);

  echo "        <tr><td height=7></td></tr>\n";
  echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>Notes:</td></tr>\n";
  echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2>";
  echo "<input class='form-control input-lg m-bot15' type='text' name='left_notes' maxlength='250' size='17' tabindex=4></td></tr>\n";

  if (!isset($_COOKIE['remember_me'])) {
      echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                    <tr><td nowrap height=4 align=left valign=middle class=control-label col-lg-2 width=10%>Remember&nbsp;Me?</td><td width=90% align=left
                      class=control-label col-lg-2 style='padding-left:0px;padding-right:0px;' tabindex=5><input type='checkbox' name='remember_me' value='1'></td></tr>
                      </table></td><tr>\n";
  } elseif (isset($_COOKIE['remember_me'])) {
      echo "        <tr><td width=100%><table width=100% border=0 cellpadding=0 cellspacing=0>
                    <tr><td nowrap height=4 align=left valign=middle class=control-label col-lg-2 width=10%>Reset&nbsp;Cookie?</td><td width=90% align=left
                      class=control-label col-lg-2 style='padding-left:0px;padding-right:0px;' tabindex=5><input type='checkbox' name='reset_cookie' value='1'></td></tr>
                      </table></td><tr>\n";
  }

  echo "        <tr><td height=7></td></tr>\n";
  echo "        <tr><td height=4 align=left valign=middle class=control-label col-lg-2><input class='btn btn-success btn-lg' type='submit' name='submit_button' value='Submit' ></td></tr></form>\n";

  if ($display_weather == "yes") {
      echo "        <tr><td height=25 align=left valign=bottom class=control-label col-lg-2><font color='00589C'><b><u>Weather Conditions:</u></b></font></td></tr>\n";
      echo "        <tr><td height=7></td></tr>\n";
      echo "        <tr><td align=left valign=middle class=control-label col-lg-2><b>$city</b></td></tr>\n";
      echo "        <tr><td height=4></td></tr>\n";
      echo "        <tr><td align=left valign=middle class=control-label col-lg-2>Currently: $temp&#176;</td></tr>\n";
      echo "        <tr><td height=4></td></tr>\n";
      echo "        <tr><td align=left valign=middle class=control-label col-lg-2>Feels Like: $feelslike&#176;</td></tr>\n";
      echo "        <tr><td height=4></td></tr>\n";
      echo "        <tr><td align=left valign=middle class=control-label col-lg-2>Skies: $cloud_cover</td></tr>\n";
      echo "        <tr><td height=4></td></tr>\n";
      echo "        <tr><td align=left valign=middle class=control-label col-lg-2>Wind: $wind_dir $wind$mph</td></tr>\n";
      echo "        <tr><td height=4></td></tr>\n";

      if ($humidity == 'None') {
          echo "        <tr><td align=left valign=middle class=control-label col-lg-2>Humidity: $humidity</td></tr>\n";
      } else {
          echo "        <tr><td align=left valign=middle class=control-label col-lg-2>Humidity: $humidity%</td></tr>\n";
      }

      echo "        <tr><td height=4></td></tr>\n";
      echo "        <tr><td align=left valign=middle class=control-label col-lg-2>Visibility: $visibility</td></tr>\n";
      echo "        <tr><td height=4></td></tr>\n";
      echo "        <tr><td align=left valign=middle class=control-label col-lg-2><font color='FF0000'>Last Updated: $time</font></td></tr>\n";
  }

  echo "        <tr><td height=90%></td></tr>\n";
  echo "      </table></td>\n";



  if ($request == 'POST') {

      // signin/signout data passed over from timeclock.php //

      $inout = $_POST['left_inout'];
      $notes = preg_replace("[^[:alnum:] \,\.\?-]", "", strtolower($_POST['left_notes']));

      // begin post validation //

      if ($use_passwd == "yes") {
          $employee_passwd = crypt($_POST['employee_passwd'], 'xy');
      }

      $query = "select punchitems from " . $db_prefix . "punchlist";
      $punchlist_result = mysqli_query($db,$query);

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
            echo'<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
              echo "    <td align=left class=table scope=col>\n";
              echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
              echo "        <tr class=table_text>\n";
              echo "          <td valign=top>\n";
              echo "<br />\n";
              echo "You have not chosen a username or a status. Please try again.\n";
              echo '</div>';
              //include 'footer.php';
              exit;
          }

          if (!$displayname) {
             echo'<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
              echo "    <td align=left class=table scope=col>\n";
              echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
              echo "        <tr class=table_text>\n";
              echo "          <td valign=top>\n";
              echo "<br />\n";
              echo "You have not chosen a username. Please try again.\n";
               echo '</div>';
              //include 'footer.php';
              exit;
          }

      } elseif ($show_display_name == "no") {

          if (!$fullname && !$inout) {
              echo'<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
              echo "    <td align=left class=table scope=col>\n";
              echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
              echo "        <tr class=table_text>\n";
              echo "          <td valign=top>\n";
              echo "<br />\n";
              echo "You have not chosen a username or a status. Please try again.\n";
               echo '</div>';
              //include 'footer.php';
              exit;
          }

          if (!$fullname) {
              echo'<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
              echo "    <td align=left class=table scope=col>\n";
              echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
              echo "        <tr class=table_text>\n";
              echo "          <td valign=top>\n";
              echo "<br />\n";
              echo "You have not chosen a username. Please try again.\n";
               echo '</div>';
              //include 'footer.php';
              exit;
          }

      }

      if (!$inout) {
          echo'<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
          echo "    <td align=left class=table scope=col>\n";
          echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
          echo "        <tr class=table_text>\n";
          echo "          <td valign=top>\n";
          echo "<br />\n";
          echo "You have not chosen a status. Please try again.\n";
              echo '</div>';
          //include 'footer.php';
          exit;
      }

      @$fullname = addslashes($fullname);
      @$displayname = addslashes($displayname);

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

              $sel_query = "select empfullname from " . $db_prefix . "employees where displayname = '" . $displayname . "'";
              $sel_result = mysqli_query($db,$sel_query);

              while ($row = mysqli_fetch_array($sel_result)) {
                  $fullname = stripslashes("" . $row["empfullname"] . "");
                  $fullname = addslashes($fullname);
              }
          }

          if (strtolower($ip_logging) == "yes") {
              $query = "insert into " . $db_prefix . "info (fullname, `inout`, timestamp, notes, ipaddress) values ('" . $fullname . "', '" . $inout . "',
                        '" . $tz_stamp . "', '" . $notes . "', '" . $connecting_ip . "')";
          } else {
              $query = "insert into " . $db_prefix . "info (fullname, `inout`, timestamp, notes) values ('" . $fullname . "', '" . $inout . "', '" . $tz_stamp . "',
                        '" . $notes . "')";
          }

          $result = mysqli_query($db,$query);

          $update_query = "update " . $db_prefix . "employees set tstamp = '" . $tz_stamp . "' where empfullname = '" . $fullname . "'";
          $other_result = mysqli_query($db,$update_query);

          echo "<head>\n";
          echo "<meta http-equiv='refresh' content=0;url=index.php>\n";
          echo "</head>\n";

      } else {

          if ($show_display_name == "yes") {
              $sel_query = "select empfullname, employee_passwd from " . $db_prefix . "employees where displayname = '" . $displayname . "'";
              $sel_result = mysqli_query($db,$sel_query);

              while ($row = mysqli_fetch_array($sel_result)) {
                  $tmp_password = "" . $row["employee_passwd"] . "";
                  $fullname = "" . $row["empfullname"] . "";
              }

              $fullname = stripslashes($fullname);
              $fullname = addslashes($fullname);

          } else {

              $sel_query = "select empfullname, employee_passwd from " . $db_prefix . "employees where empfullname = '" . $fullname . "'";
              $sel_result = mysqli_query($db,$sel_query);

              while ($row = mysqli_fetch_array($sel_result)) {
                  $tmp_password = "" . $row["employee_passwd"] . "";
              }

          }

          if ($employee_passwd == $tmp_password) {

              if (strtolower($ip_logging) == "yes") {
                  $query = "insert into " . $db_prefix . "info (fullname, `inout`, timestamp, notes, ipaddress) values ('" . $fullname . "', '" . $inout . "',
                        '" . $tz_stamp . "', '" . $notes . "', '" . $connecting_ip . "')";
              } else {
                  $query = "insert into " . $db_prefix . "info (fullname, `inout`, timestamp, notes) values ('" . $fullname . "', '" . $inout . "', '" . $tz_stamp . "',
                        '" . $notes . "')";
              }

              $result = mysqli_query($db,$query);

              $update_query = "update " . $db_prefix . "employees set tstamp = '" . $tz_stamp . "' where empfullname = '" . $fullname . "'";
              $other_result = mysqli_query($db,$update_query);

              echo "<head>\n";
              echo "<meta http-equiv='refresh' content=0;url=index.php>\n";
              echo "</head>\n";

          } else {
              echo'<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
              echo "    <td align=left class=table scope=col>\n";
              echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
              echo "        <tr class=table_text>\n";
              echo "          <td valign=top>\n";
              echo "<br />\n";


              if ($show_display_name == "yes") {
                  $strip_fullname = stripslashes($displayname);
              } else {
                  $strip_fullname = stripslashes($fullname);
              }

              echo "You have entered the wrong password for $strip_fullname. Please try again.";
               echo '</div>';
            //  include 'footer.php';
              exit;
          }

      }
  }

   ?>
</li>
    </ul>
  </div>
</div>
