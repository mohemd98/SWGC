<?php
session_start();
if (!isset($_SESSION['uid'])) {
    include "login.php";
}
include 'init.php';

$statement_int = $con->prepare("SELECT * FROM aprov 
INNER JOIN users ON users.id = aprov.receiver_id 
WHERE sender_id =  ' " . $_GET['postid_in'] . " ' ");
$statement_int->execute();
$result_int = $statement_int->fetchAll();

$stmt = $con->prepare("SELECT * FROM post WHERE post_id =  ' " . $_GET['postid_in'] . " ' ");
$stmt->execute();
$row = $stmt->fetch();

?>

<div class="container">
    <h1 class='text-center mt-3' style="font-size: 26px; height: 40px;background-color: #1C315E; border-radius: 5px; color: white;">المهتمين</h1>
    <div class="row">
        <div class="col-md-4 improve">
            <?php
            foreach ($result_int as $user_intrested) {
                        ?>
                            <div class="mt-4 gg" >
                                <img class="lavl1e"  src="uploads/avatars/<?php echo $user_intrested["avatar"] ?>">
                                <a  class="lavl2e"  href="sh_pr_us.php?userid=<?php echo $user_intrested['id'] ?> "><?php echo $user_intrested["user_id"] ?></a>
                            </div>
                        <?php
            }
            ?>
        </div>
        <!-- ------------------------ -->
        <div class="col-md-8" >
            <div class="postintrest row">
                <div class="mb-4 mt-4 text-center">
                    <h3><?php echo  $row["post_title"] ?></h3>
                </div>
                <div class="col-md-6">
                    <div class="">
                        <h3><?php echo "سكن: ".  $row["post_city"]." ". $row["post_man"] ?></h3>
                        <h3><?php echo 'نوع الطلب: ' . $row["post_type"] ?></h3>
                        <h3><?php echo "الحاجه: ". $row["post_want"] ?></h3>
                        <h3><?php echo "جنس المطلوب: ". $row["post_gender"] ?></h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="photo">
                        <img src="uploads/post/<?php echo  $row["post_img_name"] ?>">
                    </div>
                </div>
                <div>
                    <h5 class="mt-4">
                        <?php echo  $row["post_content"] ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>