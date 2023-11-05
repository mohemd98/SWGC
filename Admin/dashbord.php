<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['Admin_uid'])) {
  include "login.php";
}
include 'init.php';
$numuser = 10; //number of latest users
$Latestuser = getLatest("*", "users", "id", $numuser);
$Latestpost = getLatest("*", "post", "post_id", $numuser);
$Latestcomment = getLatest("*", "comment", "comment_id", $numuser);
$Latestfilse = getLatest("*", "files", "id", $numuser);


?>

<div class="container home-stats">
  <!-- start contaner one-->
  <h1 class="text-center">صفحة التحكم</h1>
  <div class='row'>
    <div class='col-md-3'>
      <div class='stat s1'>
      <i class="fa-solid fa-users"></i>        <div class="info honerme">
          المستخدمين
          <span class=""><a  href="users.php"><?php echo
                                    countItems('user_id', 'users')
                                    ?></a></span>
        </div>
      </div>
    </div>
    <div class='col-md-3'>
      <div class='stat s2'>
      <i class="fa-regular fa-paste"></i>        <div class="info">
          منشورات
          <span><a href="posts.php?do=Manage&page=Pending">
              <?php echo
              countItems('post_id', 'post')
              ?>
            </a></span>
        </div>

      </div>
    </div>
    <div class='col-md-3'>
      <div class='stat s3'>
      <i class="fa-regular fa-comments"></i>        <div class="info">
          تعليقات
          <span><a href="comments.php"><?php echo
                                        countItems('comment_id', 'comment')
                                        ?></a></span>
        </div>

      </div>
    </div>
    <div class='col-md-3'>
      <div class='stat s4'>
      <i class="fa-regular fa-folder-closed"></i>        <div class="info">
          ملفات
          <span><a href="files.php"><?php echo
                                    countItems('id', 'files')
                                    ?></a></span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end contaner one-->

<!-- start contaner tow-->
<div class="container latest">
  <div class="row mb-4 ">
    <div class="col-sm-6">
      <div class="card card-default">
        <div class="card-header">
          <i class="fa fa-users ms-2"></i> اخر اليوزريه
        
        </div>
        <div class="card-body">
          <ul class="list-unstyled latest-users">
            <?php
            if (!empty($Latestuser)) {
              foreach ($Latestuser as $user) {
                echo '<li>';
                echo '<div class="dfsdf ms-2 me-2">' . $user['user_id'] . '</div>';
                echo '<a href="members.php?do=Edit&userid=' . $user['id'] . '">';
                echo '<span class="ms-2 me-2 btn btn-danger pull-right "> ';
                echo 'X';
                echo '</span>';
                echo '</a>';
                echo '</li>';
              }
            } else {
              echo 'there\'s no record to show';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- --------------------------------------- -->
    <div class="col-sm-6">
      <div class="card card-default">
        <div class="card-header">
        <i class="fa-regular fa-paste ms-2"></i>اخر منشورات
       
        </div>
        <div class="card-body">
          <ul class="list-unstyled latest-users">
            <?php
            if (!empty($Latestpost)) {
              foreach ($Latestpost as $post) {
                echo '<li>';
                echo '<div class="dfsdf ms-2 me-2">' . $post['post_man'] . '</div>';
                echo '<a href="members.php?do=Edit&userid=' . $post['post_id'] . '">';
                echo '<span class="ms-2 me-2 btn btn-danger pull-right "> ';
                echo 'X';
                echo '</span>';
                echo '</a>';
                echo '</li>';
              }
            } else {
              echo 'there\'s no record to show';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!--********************************************************** -->
  <div class="row mb-4">
    <div class="col-sm-6">
      <div class="card card-default">
        <div class="card-header">
        <i class="fa-regular fa-comments ms-2"></i>اخر تعليقات
        
        </div>
        <div class="card-body">
          <ul class="list-unstyled latest-users">
            <?php
            if (!empty($Latestcomment)) {
              foreach ($Latestcomment as $comment) {
                echo '<li>';
                echo '<div class="dfsdf ms-2 me-2">' . $comment['comment'] . '</div>';
                echo '<a href="members.php?do=Edit&userid=' . $comment['comment_id'] . '">';
                echo '<span class="ms-2 me-2 btn btn-danger pull-right "> ';
                echo 'X';
                echo '</span>';
                echo '</a>';
                echo '</li>';
              }
            } else {
              echo 'there\'s no record to show';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- --------------------------------------- -->
    <div class="col-sm-6">
      <div class="card card-default">
        <div class="card-header">
        <i class="fa-regular fa-folder-closed ms-2"></i>
          اخر ملفات
      
        </div>
        <div class="card-body">
          <ul class="list-unstyled latest-users">
            <?php
            if (!empty($Latestfilse)) {
              foreach ($Latestfilse as $filse) {
                echo '<li>';
                echo '<div class="dfsdf ms-2 me-2">' . $filse['name_file'] . '</div>';
                echo '<a href="members.php?do=Edit&userid=' . $filse['id'] . '">';
                echo '<span class="ms-2 me-2 btn btn-danger pull-right "> ';
                echo 'X';
                echo '</span>';
                echo '</a>';
                echo '</li>';
              }
            } else {
              echo 'there\'s no record to show';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div><!-- end contaner tow-->

<?php
// include  "includes/footer.php";