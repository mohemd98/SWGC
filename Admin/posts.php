<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['Admin_uid'])) {
  include "login.php";
}
include 'init.php';



$statement = $con->prepare("SELECT *,users.user_id AS usernameid FROM users 
INNER JOIN post ON post.user_id = users.id 
ORDER BY users.id DESC
");
$statement->execute();
$result = $statement->fetchAll();
if (isset($_GET['deleteid'])) {
  echo "<h1 class='text-center'>Delet item</h1>";
  echo "<div class='container'>"; //start div contane
  $itemid = $_GET['deleteid']; //ا
  $stmt = $con->prepare("DELETE FROM post WHERE post_id= :mosid");
  $stmt->bindparam(":mosid", $itemid); // هذه المثد يربط
  $stmt->execute();
  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' حذفت' . "</div>";
  redirectHome($theMsg, 'back');
  echo '</div>';
}
?>
  <h1 class="text-center">صفحة المنشورات</h1>

<div class="container mt-4">
  <table class="table table-success table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">معرف</th>
        <th scope="col">محتوى</th>
        <th scope="col">صور</th>
        <th scope="col">محافظه</th>
        <th scope="col">منطقه</th>
        <th scope="col">عنوان</th>
        <th scope="col">نوع</th>
        <th scope="col">الحاجه</th>
        <th scope="col">الفئه</th>
        <th scope="col">تاريخ</th>
        <th scope="col">تحكم</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $jdfg=1;
      foreach ($result as $i) {

      ?>
        <tr>
          <td><?php echo $jdfg ?></td>
          <td><?php echo $i['usernameid'] ?></td>
          <td style="width: 240px;"><?php echo $i['post_content'] ?></td>
          <td><img class='dfasgfg' src='../uploads/post/<?php echo $i['post_img_name'] ?> ' alt='' /></td>
          <td><?php echo $i['post_city'] ?></td>
          <td><?php echo $i['post_man'] ?></td>
          <td><?php echo $i['post_title'] ?></td>
          <td><?php echo $i['post_type'] ?></td>
          <td><?php echo $i['post_want'] ?></td>
          <td><?php echo $i['post_gender'] ?></td>
          <td><?php echo $i['post_datetime'] ?></td>
          <th> <a href='posts.php?deleteid=<?php echo $i['id']; ?>' class='btn btn-danger confirm'><i class='fa fa-delete-left'></i></a></th>
        </tr>
      <?php
      $jdfg++;
      }
      ?>
    </tbody>
  </table>
</div>