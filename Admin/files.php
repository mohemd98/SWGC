<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['Admin_uid'])) {
  include "login.php";
}
include 'init.php';


// $statement = $con->prepare("SELECT * FROM post 
// INNER JOIN users ON users.id = post.user_id 
// LEFT JOIN follow ON follow.sender_id = post.user_id 
// WHERE follow.receiver_id = '" . $_SESSION["uid"] . "' OR post.user_id = '" . $_SESSION["uid"] . "' 
// GROUP BY post.post_id 
// ORDER BY post.post_id DESC
// ");

$statement = $con->prepare("SELECT * FROM files 
INNER JOIN users ON users.id = files.user_id  ");
$statement->execute();
$result = $statement->fetchAll();

if (isset($_GET['deleteid'])) {
  echo "<h1 class='text-center'>Delet item</h1>";
  echo "<div class='container'>"; //start div contane
  $itemid = $_GET['deleteid']; //ا
  $stmt = $con->prepare("DELETE FROM files WHERE id= :mosid");
  $stmt->bindparam(":mosid", $itemid); // هذه المثد يربط
  $stmt->execute();
  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' حذفت' . "</div>";
  redirectHome($theMsg, 'back');
  echo '</div>';
}

?>
  <h1 class="text-center">صفحة المستندات</h1>

<div class="container mt-4">
  <table class="table table-success table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">اسم الكامل</th>
        <th scope="col">معرف </th>
        <th scope="col">صور</th>
        <th scope="col">فئه</th>
        <th scope="col">تحكم</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $yy=1;
      foreach ($result as $i) {

      ?>
        <tr>
          <td><?php echo $yy?></td>
          <td><?php echo $i['name_file'] ?></td>
          <td><?php echo $i['user_id'] ?></td>
          <td><?php if ($i['type'] == "img") {
              ?>
              <img class='dfasgfg' src='../uploads/profal/<?php echo $i['name_file'] ?> ' alt='' />
            <?php
              }
            ?>
          </td>
          <td><?php echo $i['type'] ?></td>
          <th> <a href='files.php?deleteid=<?php echo $i['id']; ?>' class='btn btn-danger confirm'><i class='fa fa-delete-left'></i></a></th>

        </tr>
      <?php
      $yy++;
      }
      ?>
    </tbody>
  </table>
</div>