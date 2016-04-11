<aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">
                  <li class="active">
                      <a class="" href="../index.php">
                          <i class="icon_house_alt"></i>
                          <span>Home</span>
                      </a>
                  </li>
				  <li class="sub-menu">
          <?php
          if ($use_reports_password == "yes") {

                      echo '<a href="../login_reports.php" class="">';
           }
            elseif ($use_reports_password == "no") {
               echo '<a href="index.php" class="">';
            }
          ?>
                          <i class="icon_document_alt"></i>
                          <span>Reports</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>

                  </li>
                  <li class="sub-menu">
                      <a href="../login.php" class="">
                          <i class="icon_desktop"></i>
                          <span>Administration</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>

                  </li>
                 <li class="sub-menu">
                      <a href="punchclock/menu.php" class="">
                          <i class="icon_table"></i>
                          <span>Punch Clock</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>

                  </li>





              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
