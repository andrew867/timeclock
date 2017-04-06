<script language="JavaScript">

    function office_names() {

        var select = document.form.office_name;
        select.options[0] = new Option("Choose One");
        select.options[0].value = '';

        <?php

        @$office_name = $_POST['office_name'];

        $query = "select * from ".$db_prefix."offices";
        $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

        $cnt=1;
        while ($row=mysqli_fetch_array($result)) {
          if ("".$row['officename']."" == stripslashes($office_name)) {
          echo "select.options[$cnt] = new Option(\"".$row['officename']."\",\"".$row['officename']."\", true, true);\n";
          } else {
          echo "select.options[$cnt] = new Option(\"".$row['officename']."\");\n";
          echo "select.options[$cnt].value = \"".$row['officename']."\";\n";
          }
          $cnt++;
        }
        ((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
        ?>
    }

    function group_names() {
        var offices_select = document.form.office_name;
        var groups_select = document.form.group_name;
        groups_select.options[0] = new Option("Choose One");
        groups_select.options[0].value = '';

        if (offices_select.options[offices_select.selectedIndex].value != '') {
            groups_select.length = 0;
        }

        <?php

        $query = "select * from ".$db_prefix."offices";
        $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

        while ($row=mysqli_fetch_array($result)) {
        $office_row = addslashes("".$row['officename']."");
        ?>

        if (offices_select.options[offices_select.selectedIndex].text == "<?php echo $office_row; ?>") {
            <?php
            $query2 = "select * from ".$db_prefix."offices, ".$db_prefix."groups where ".$db_prefix."groups.officeid = ".$db_prefix."offices.officeid
                       and ".$db_prefix."offices.officename = '".$office_row."'";
            $result2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
            echo "groups_select.options[0] = new Option(\"...\");\n";
            echo "groups_select.options[0].value = '';\n";
            $cnt = 1;

            while ($row2=mysqli_fetch_array($result2)) {
              $groups = "".$row2['groupname']."";
              echo "groups_select.options[$cnt] = new Option(\"$groups\");\n";
              echo "groups_select.options[$cnt].value = \"$groups\";\n";
              $cnt++;
            }

            ?>
        }
        <?php
        }
        ((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
        ((mysqli_free_result($result2) || (is_object($result2) && (get_class($result2) == "mysqli_result"))) ? true : false);
        ?>

        if (groups_select.options[groups_select.selectedIndex].value != '') {
            groups_select.length = 0;
        }
    }

</script>
