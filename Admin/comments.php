<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['Admin_uid'])) {
  include "login.php";
}
include 'init.php';

$statement = $con->prepare("SELECT *,users.user_id AS usernameid FROM users 
INNER JOIN comment ON comment.user_id = users.id 
INNER JOIN post ON post.user_id = users.id 
");
$statement->execute();
$result = $statement->fetchAll();

if (isset($_GET['deleteid'])) {
  echo "<h1 class='text-center'>Delet item</h1>";
  echo "<div class='container'>"; //start div contane
  $itemid = $_GET['deleteid']; //ا
  $stmt = $con->prepare("DELETE FROM comment WHERE id= :mosid");
  $stmt->bindparam(":mosid", $itemid); // هذه المثد يربط
  $stmt->execute();
  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' حذفت' . "</div>";
  redirectHome($theMsg, 'back');
  echo '</div>';
}
?>
  <h1 class="text-center">صفحة التعليقات</h1>

<div class="container mt-4">
  <table class="table table-success table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">اسم المعلق</th>
        <th scope="col">عنوان االمنشور</th>
        <th scope="col">تعليق</th>
        <th scope="col">تحكم</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $cccc=1;
      foreach ($result as $i) {

      ?>
        <tr>
          <td><?php echo  $cccc ?></td>
          <td><?php echo $i['usernameid'] ?></td> 
          <td><?php echo $i['post_title'] ?></td>
          <td><?php echo $i['comment'] ?></td>
          <th> <a href='comments.php?deleteid=<?php echo $i['id']; ?>' class='btn btn-danger confirm'><i class='fa fa-delete-left'></i></a></th>

         
        </tr>
      <?php
       $cccc++;
      }
      ?>
    </tbody>
  </table>
</div>