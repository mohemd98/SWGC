  <!-- staet navbar -->

  <div class="minav">
    <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main" aria-controls="main" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="main">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
<?php
$sessionUser = $_SESSION['uid'];
$stmt = $con->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute(array($sessionUser));
$rows = $stmt->fetch();

// if (isset($_SESSION['uid'])){
//   $sessionUser = $_SESSION['uid'];
//   $stmt = $con->prepare("SELECT * FROM users WHERE id=?");
//   $stmt->execute(array($sessionUser));
//   $rows = $stmt->fetch();
//   }
?>
            <?php
            if (isset($_SESSION['uid'])) {
            ?>
            <li class="nav-item">
                <a style="margin-top: -15px;" class="nav-link p-lg-3  " aria-current="page"><?php echo  "<img class='imdhjd' src='uploads/avatars/" . $rows['avatar'] . "' alt=''/>"; ?></a>
              </li>
              <li  class="nav-item ">
                <a class="nav-link p-lg-3 active " aria-current="page" href="dashbord.php">الصفحه الرئيسيه</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-2 p-lg-3" href="allpost.php">صفحه العامه</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-2 p-lg-3" href="profal.php"> بروفابل</a>
              </li>
              <!-- دروب داون لاخر الاخبار -->

              <li class="nav-item dropdown kkkk">
                <a class="nav-link " style="    padding-top: 15px;" href="#" id="view_notification" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-bell"></i>
                  <?php
                  if (isset($_SESSION["uid"])) {
                    $total_notification = Count_notification($con, $_SESSION["uid"]);

                    if ($total_notification > 0) {
                      echo '<span class="btn btn-danger  btn-sm" id="total_notification">' . $total_notification . '</span>';
                    }
                  }
                  ?>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="text-align: right;max-height: 361px;overflow-y: auto;">
                  <?php
                  echo Load_notification($con, $_SESSION["uid"]);
                  ?>
                </ul>
              </li>

            <?php } ?>

            <!-- ---------------------- -->

          </ul>
          <!-- d-none d-lg-block كتله اخفي الي من توصل لحد معين من الشاشات -->
          <div class="nav-item" style="background-color: red; border-radius: 50px;">
            <?php
            if (isset($_SESSION['uid'])) {
              echo '<a style="color: white;" class="nav-link p-2 p-lg-3" href="logout.php">تسجيل خروج</a>';
            } else {
              echo '<a style="color: white;" class="nav-link p-2 p-lg-3" href="login.php">تسجيل دخول</a>';
            }
            ?>
          </div>
        </div>
      </div>
    </nav>

  </div>



 
  <!-- end  navbar -->