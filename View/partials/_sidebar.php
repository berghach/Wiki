<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <?php
      if(isset($_SESSION['User_session'])){
          echo '<li class="nav-item nav-profile">
                  <a href="#" class="nav-link">
                    <div class="nav-profile-image">
                      <img src="assets/images/faces/face1.jpg" alt="profile">
                      <span class="login-status online"></span>
                    </div>
                    <div class="nav-profile-text d-flex flex-column">
                      <span class="font-weight-bold mb-2">'.$_SESSION['User_session']['fullname'].'</span>
                      <span class="text-secondary text-small">'.$_SESSION['User_session']['role'].'</span>
                    </div>
                    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?action=default">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                  </a>
                </li>';
        }else{
          echo '<li class="nav-item">
                  <a class="nav-link" href="index.php?action=default">
                    <span class="menu-title">Home</span>
                    <i class="mdi mdi-home menu-icon"></i>
                  </a>
                </li>';
        }
      ?>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#category" aria-expanded="false" aria-controls="category">
        <span class="menu-title">Categories</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="category">
        <ul class="nav flex-column sub-menu">
          <?php
          foreach($categories as $row){
            echo '<li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">'.$row->getName().'</a></li>';
          }
          ?>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#tag" aria-expanded="false" aria-controls="tag">
        <span class="menu-title">Tags</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="tag">
        <ul class="nav flex-column sub-menu">
          <?php
          foreach($tags as $row){
            echo '<li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">'.$row->getName().'</a></li>';
          }
          ?>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/icons/mdi.html">
        <span class="menu-title">Icons</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php?action=forms">
        <span class="menu-title">Forms</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/charts/chartjs.html">
        <span class="menu-title">Charts</span>
        <i class="mdi mdi-chart-bar menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/tables/basic-table.html">
        <span class="menu-title">Tables</span>
        <i class="mdi mdi-table-large menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
        <span class="menu-title">Sample Pages</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-medical-bag menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal mb-3">Wikis</h6>
        </div>
        <button class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Add a wiki</button>
        <div class="mt-4">
          <div class="border-bottom">
            <p class="text-secondary">Categories</p>
          </div>
          <ul class="gradient-bullet-list mt-4">
            <li>Free</li>
            <li>Pro</li>
          </ul>
        </div>
      </span>
    </li>
  </ul>
</nav>