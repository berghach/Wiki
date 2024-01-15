<!DOCTYPE html>
<html lang="en">
  <head>
    <!--  meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign up</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="../../assets/images/logo.svg">
                </div>
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form class="pt-3" action="index.php?action=register" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="fullname" id="fullname" placeholder="Fullname">
                    <?php
                        if (isset($_SESSION['register_errors']['fullname'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['fullname'] . '</div>';
                        }
                    ?>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Username" >
                    <?php
                        if (isset($_SESSION['register_errors']['username'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['username'] . '</div>';
                        }
                    ?>
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Email" >
                    <?php
                        if (isset($_SESSION['register_errors']['email'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['email'] . '</div>';
                        }
                    ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Password" >
                    <?php
                        if (isset($_SESSION['register_errors']['password'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['password'] . '</div>';
                        }
                    ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" >
                    <?php
                        if (isset($_SESSION['register_errors']['confirm_pass'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['confirm_pass'] . '</div>';
                        }
                    ?>
                  </div>
                  <div class="mt-3">
                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit">SIGN UP</button>
                  </div>
                    <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="index.php?action=login" class="text-primary">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <!-- endinject -->

    <?php
    // unset($_SESSION['register_errors']);
    ?>
  </body>
</html>