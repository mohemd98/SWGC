<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['Admin_uid'])) {
    include "login.php";
}
include 'init.php';

$statement = $con->prepare("SELECT *,users.user_id AS usernameid FROM users 
INNER JOIN skills ON skills.user_id = users.id 
ORDER BY users.id DESC
");
$statement->execute();
$result = $statement->fetchAll();

if (isset($_GET['deleteid'])) {
    echo "<h1 class='text-center'>Delet item</h1>";
    echo "<div class='container'>"; //start div contane
    $itemid = $_GET['deleteid']; //ا
    $stmt = $con->prepare("DELETE FROM skills WHERE id= :mosid");
    $stmt->bindparam(":mosid", $itemid); // هذه المثد يربط
    $stmt->execute();
    $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' حذفت' . "</div>";
    redirectHome($theMsg, 'back');
    echo '</div>';
}
?>
  <h1 class="text-center">صفحة المهارات</h1>

<div class="container mt-4">
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">اسم </th>
                <th scope="col">مهاره</th>
                <th scope="col">مستوى</th>
                <th scope="col">تحكم</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $uu=1;
            foreach ($result as $i) {

            ?>
                <tr>
                    <td><?php echo $uu ?></td>
                    <td><?php echo $i['usernameid'] ?></td>
                    <td><?php echo $i['skill'] ?></td>
                    <td><?php echo $i['experience'] ?></td>
                    <th> <a href='skilles.php?deleteid=<?php echo $i['id']; ?>' class='btn btn-danger confirm'><i class='fa fa-delete-left'></i></a></th>
                </tr>
            <?php
            $uu++;
            }
            ?>
        </tbody>
    </table>
</div>