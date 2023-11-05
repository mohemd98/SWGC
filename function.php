<?php
session_start();
include "connect.php";

$getnamew = $con->prepare("SELECT * FROM users WHERE id= ?");
$getnamew->execute(array($_SESSION["uid"] ));
$name = $getnamew->fetch();
$n1 = $name['first_name'];
$n2 = $name['list_name'];


$sessionUser = $_SESSION['uid'];
if (isset($_POST['n1'])) {
    $f1 = $_POST['n1'];
    $f2 = $_POST['n2'];
    $f3 = $_POST['n3'];
    $f4 = $_POST['n4'];
    $f5 = $_POST['n5'];
    $f6 = $_POST['n6'];

    $stmt = $con->prepare("UPDATE 
        profal 
    SET 
        colg = ?, 
        division = ?, 
        boi = ?, 
        fonnamber = ?,
        tergram_id = ?,
        facebokc_rul = ?
    WHERE 
    user_id = ?");

    $stmt->execute(array($f1, $f2, $f3, $f4, $f5, $f6, $sessionUser));
}

// ---------------------------------------------------------------------------

if (isset($_POST['skill'])) {
    $number = count($_POST["skill"]);
    if ($number > 1) {
        for ($i = 0; $i < $number; $i++) {
            if (trim($_POST["skill"][$i] != '')) {
                $stmt2 = $con->prepare("INSERT INTO
                    skills(user_id, skill,experience)
                    VALUES(:m1 , :m2, :m3)");
                $stmt2->execute(array(
                    'm1' => $sessionUser,
                    'm2' => $_POST["skill"][$i],
                    'm3' => $_POST["rang"][$i]
                ));
            }
        }
        echo "تم الحفظ";
    } else {
        echo "Please Enter Name";
    }
}

// -----------------------------------------------------

// جلب المهارات

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'fetch_skill') {

        $count=1;
        $statement = $con->prepare("SELECT * FROM skills 
		WHERE user_id = '" . $_SESSION["uid"] . "'");
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        if ($total_row > 0) {

            $output = ' <table class="table table-dark table-striped " >
        
            <tr>
                <th>ترقيم</th>
                <th>المهاره</th>
                <th>مستوى المهاره</th>
                <th>حذف المهاره</th>
            </tr>';

            foreach ($result as $row) {
                $output .= "<tr>
                           <td>$count</td>
                           <td>{$row["skill"]}</td>
                           <td>{$row["experience"]}</td>
                           <td>
                               <button class='delete-btn btn btn-danger' data-id='{$row["id"]}'>حذف</button>
                           </td>
                </tr> ";
                $count++;
            }
            $output .=" </table>";
        } else {
            $output = '<div class="text-center"  style="width:100% ;font-size: 26px; height: 50px;background-color: #1C315E; border-radius: 5px; color: white;">لم تضف مهارات</div>';
        }
        echo $output;
    }
}

if (isset($_GET['action'])) {

    // حذف المهار
    if ($_GET['action'] == 'delete_skill') {
        $stu = $_GET['id'];

        $stmt = $con->prepare("DELETE FROM skills WHERE id = :zid");
        $stmt->bindParam(":zid", $stu);
        $stmt->execute();
    }
}



// -------------------------------------------------------------------------------------
// حفظ الصور

if (isset($_FILES["file"]["name"])) {
    if (count($_FILES["file"]["name"]) > 0) {

        //  مامرتب اي شي بحيث حتى مايحفظ اسامي المتشابه


        for ($count = 0; $count < count($_FILES["file"]["name"]); $count++) {
            $file_name = $_FILES["file"]["name"][$count];
            $tmp_name = $_FILES["file"]['tmp_name'][$count];
            $file_array = explode(".", $file_name);
            $file_extension = end($file_array);

            $location = 'uploads/profal/' . $file_name;
            if (move_uploaded_file($tmp_name, $location)) {

                $statement = $con->prepare("INSERT INTO files (user_id, name_file , type) 
                                     VALUES ('" . $_SESSION["uid"]  . "', '" . $file_name . "', 'img')");
                $statement->execute();
            }
        }
    }
}



// نجيب الصور

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'load_image_data') {

        $query = "SELECT * FROM files  WHERE user_id = '" . $_SESSION["uid"] . "' AND type='img' ORDER BY id DESC";
        $statement = $con->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $number_of_rows = $statement->rowCount();
        $output = '';
        $count=1;
        $output .= '
        <table class="table table-success table-striped mt-2">
  <tr>
  <th colspan="4" style="text-align: center;" ><h3>الصــور</h3></th>

  </tr>
';
        if ($number_of_rows > 0) {
            $count = 1;
            foreach ($result as $row) {
                $output .= '
  <tr>
  <th>'.$count.'</th>
   <td><img src="uploads/profal/' . $row["name_file"] . '" class="img-thumbnail" style="max-width: 70px;max-height: 50px; min-width: 70px; min-height: 50px;" /></td>
   <td><button type="button" class="btn btn-danger btn-xs delete" id="' . $row["id"] . '" data-image_name="' . $row["name_file"] . '">حذف</button></td>
   <td><a  href="uploads/profal/' . $row["name_file"] . '" class="btn  btn-xs " style="background-color: #ADE792;">عرض الملف</a></td>
   </tr>
  ';
  $count++;
            }
        } else {
            $output .= '
  <tr>
   <td colspan="6" align="center">لم تضف صور</td>
  </tr>
 ';
        }
        $output .= '</table>';
        echo $output;
    }
}

// حذف الصوره

if (isset($_POST["image_id"])) {
    $file_path = 'uploads/profal/' . $_POST["image_name"];
    if (unlink($file_path)) {
        $statement = $con->prepare("DELETE FROM files WHERE id = '" . $_POST["image_id"] . "'");
        $statement->execute();
    }
}

// -------------------------------------------------------------------------------------------------

// حفظ ملفات البي دي اف


if (isset($_POST['title'])) {


    if (isset($_FILES["pdf"]["name"])) {
        if (count($_FILES["pdf"]["name"]) > 0) {

            //  مامرتب اي شي بحيث حتى مايحفظ اسامي المتشابه


            for ($count = 0; $count < count($_FILES["pdf"]["name"]); $count++) {
                $file_name = $_FILES["pdf"]["name"][$count];
                $tmp_name = $_FILES["pdf"]['tmp_name'][$count];
                $file_array = explode(".", $file_name);
                $file_extension = end($file_array);

                $location = 'uploads/files/' . $file_name;
                if (move_uploaded_file($tmp_name, $location)) {

                    $statement = $con->prepare("INSERT INTO files (user_id, name_file , type) 
                                         VALUES ('" . $_SESSION["uid"]  . "', '" . $file_name . "', 'pdf')");
                    $statement->execute();
                }
            }
        }
    }
}

// نجيب الملفات

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'load_pdf_data') {

        $query = "SELECT * FROM files  WHERE user_id = '" . $_SESSION["uid"] . "' AND type='pdf' ORDER BY id DESC";
        $statement = $con->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $number_of_rows = $statement->rowCount();
        $output = '';
        $count=1;
        $output .= '
        <table class="table table-success table-striped mt-2">
                        <tr>
                        <th colspan="4" style="text-align: center;" ><h3>المستنـدات</h3></th>
                        </tr>
';
        if ($number_of_rows > 0) {
            $count = 1;
            foreach ($result as $row) {
                $output .= '
  <tr>
  <th>'.$count.'</th>
   <td><img src="uploads/files/pdf4.jpg" class="img-thumbnail" style="max-width: 50px;max-height: 50px; min-width: 50px; min-height: 50px;" /></td>
   <td><button type="button" class="btn btn-danger btn-xs deletepdf" id="' . $row["id"] . '" data-image_name="' . $row["name_file"] . '">حذف</button></td>
   <td><a  href="uploads/files/' . $row["name_file"] . '" class="btn  btn-xs " style="background-color: #ADE792;">عرض الملف</a></td>
  </tr>
  ';
  $count++;
            }
        } else {
            $output .= '
  <tr>
   <td colspan="6" align="center">لم تضف مستند</td>
  </tr>
 ';
        }
        $output .= '</table>';
        echo $output;
    }
}

//  نحذف الملف

// حذف الصوره

if (isset($_POST["image_id"])) {
    $file_path = 'uploads/files/' . $_POST["image_name"];
    if (unlink($file_path)) {
        $statement = $con->prepare("DELETE FROM files WHERE id = '" . $_POST["image_id"] . "'");
        $statement->execute();
    }
}
// &&&&&&&&&&&&&&&&&&&^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^///

if (isset($_POST['data'])) {

    $output = '';
    // 	جلب البيانات

    if ($_POST['data'] == 'fetch_my_post') {

        $statement = $con->prepare("SELECT * FROM post 
		INNER JOIN users ON users.id = post.user_id 
		LEFT JOIN follow ON follow.sender_id = post.user_id 
		WHERE  post.user_id = '" . $_SESSION["uid"] . "' 
		GROUP BY post.post_id 
		ORDER BY post.post_id DESC
		");
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        if ($total_row > 0) {

            foreach ($result as $row) {
                $output .= '
                <div class="totilpost row">
                <div class="lavl1 mt-3">
                    <img src="uploads/avatars/' . $row["avatar"] . '" >
                    <a href="sh_pr_us.php?userid=' . $row['id'] . '" >' . $row["first_name"] . " " . $row["list_name"] . '</a>
                </div>
                <div class="lavl3 mt-3">
                    <h3>' . $row["post_title"] . '</h3>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="filtrforpost mt-4 ">
                        <h3>سكن: ' . $row["post_city"] . '-'. $row["post_man"]   .   '</h3>
                        <h3>نوع الطلب: ' . $row["post_type"]   .   '</h3>
                        <h3>الحاجه: ' . $row["post_want"]   .   '</h3>
                        <h3>جنس المطلوب: ' . $row["post_gender"] .   '</h3>
                    </div>
                </div>
                <div class="col-md-8 ">
                    <div class="lavl2">
                    <img src="uploads/post/' . $row["post_img_name"] . '">							
                    </div>
                </div>
                <div class="mt-2 mb-2">
                    <h5>
                    ' . $row["post_content"] . '
                    </h5>
                </div>
                <div class="btn-toolbar mb-3 " role="toolbar" aria-label="Toolbar with button groups">

                <button type="button" class="btn btn-outline-secondary noborder like_button ms-2" data-post_id="' . $row["post_id"] . '"><span class="fa-solid fa-thumbs-up"></span> '
                     // بت لايك
                    . count_total_post_like($con, $row["post_id"]) .'
                    </button>
                    
                <button type="button" class="btn btn-outline-primary noborder post_comment ms-2" id="' . $row["post_id"] . '" data-user_id="' . $row["user_id"] . '">'
                    // عدد التعليقات  و هذه البتن للتعليق
                    . count_comment($con, $row["post_id"]) . '
                    <i class="fa-solid fa-comments"></i>
                    </button>
                    
                    ';

                    if ($row["id"] != $_SESSION['uid']) {

                        $output .=
                        '
                                <div >
                                ' .
                        make_aprov_button($con, $row["post_id"], $_SESSION["uid"]);

                        $output .=  make_save_button($con, $row["post_id"], $_SESSION["uid"]) . '
                                </div>
                        ' ;
                    } else {
                        $output .= '
                        <a href="Interested_post.php?postid_in=' . $row['post_id'] . '"  class="btn btn-primary ms-2" type="submit">عرض المهتمين</a>
                        
                        <button type="button" class="btn btn-danger delet_post ms-2" data-post_id="' . $row["post_id"] . '">
                        <i class="fa-solid fa-trash-can"></i>
                       </button>
                 
                        ';
                    }
    $output .= '

                </div>
                
                <div id="comment_form' . $row["post_id"] . '" style="display:none;">
                    <span id="old_comment' . $row["post_id"] . '"></span>
                    <div class="form-group">
                        <textarea name="comment" class="form-control" id="comment' . $row["post_id"] . '"></textarea>
                    </div>
                    <div class="form-group mt-2" align="right">
                        <button type="button" name="submit_comment" class="btn btn-primary btn-xs submit_comment mb-2">تعليق</button>
                    </div>
                </div>
                </div>
    ';
            }
        } else {
            $output = '<h4>لاتوجد منشورات</h4>';
        }
        echo $output;
    }

    // -------------------------------------------------------------------------------------------------------------------------

    //  نجيب الكومنتات

    if ($_POST["data"] == "fetch_comment") {
        $query = "
		SELECT * FROM comment 
		INNER JOIN users 
		ON users.id = comment.user_id 
		WHERE post_id = '" . $_POST["post_id"] . "' 
		ORDER BY comment_id ASC
		";
        $statement = $con->prepare($query);
        $output = '';
        if ($statement->execute()) {
            $result = $statement->fetchAll();
            $output .= '<div class="overflowprofal">';
			foreach ($result as $row) {
				$profile_image = '<img src="uploads/avatars/' . $row["avatar"] . '" class="img-thumbnail img-responsive" />';
				$output .= '
				<div class="totilpost row">
					<div class="col-md-2 lavl1">
					' . $profile_image . '	
					</div>
					<div class="col-md-10 lavl1 " style="margin-top:16px; padding-left:0">
						<small><b><a href="sh_pr_us.php?userid=' . $row['id'] . '" >' . $row["user_id"] . '</a></b><br/>
						' . $row["comment"] . '
						</small>
					</div>
				</div>
				<br />
				';
			}
			$output .= '</div>';
        }
        echo $output;
    }


    // ----------------------------------------------------------------------------------------------------------------------------------
    
    // نحفظ الكومنتن

    if ($_POST["data"] == 'submit_comment') {
		$data = array(
			':post_id'		=>	$_POST["post_id"],
			':user_id'		=>	$_SESSION["uid"],
			':comment'		=>	$_POST["comment"],
			':timestamp'	=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
		);

		$query = "
		INSERT INTO comment 
		(post_id, user_id, comment, timestamp) 
		VALUES (:post_id, :user_id, :comment, :timestamp)
		";
		$statement = $con->prepare($query);
		$statement->execute($data);

		$notification_query = "
		SELECT user_id, post_content FROM post 
		WHERE post_id = '" . $_POST["post_id"] . "'
		";

		$statement = $con->prepare($notification_query);

		$statement->execute();

		$notification_result = $statement->fetchAll();

		foreach ($notification_result as $notification_row) {
			// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . '</b> has comment on your post - "' . strip_tags(substr($notification_row["post_content"], 0, 20)) . '..."';
			$notification_text = 'علق ' . ' <b> ' . $n1 . ' '.$n2 . ' </b> ' . " على منشورك ";

			$insert_query = "
			INSERT INTO notification 
			(notification_receiver_id, notification_text, read_notification) 
			VALUES ('" . $notification_row['user_id'] . "', '" . $notification_text . "', 'no')
			";

			$statement = $con->prepare($insert_query);
			$statement->execute();
		}
	}


    // -----------------------------------------------------------------------------------------------------------------

    // لايك المنشور

    if ($_POST["data"] == "like") {
        $query = "
		SELECT * FROM tbl_like 
		WHERE post_id = '" . $_POST["post_id"] . "' 
		AND user_id = '" . $_SESSION["uid"] . "'
		";
        $statement = $con->prepare($query);
        $statement->execute();

        $total_row = $statement->rowCount();

        if ($total_row > 0) {
            echo 'You have already like this post';
        } else {
            $insert_query = "
			INSERT INTO tbl_like 
			(user_id, post_id) 
			VALUES ('" . $_SESSION["uid"] . "', '" . $_POST["post_id"] . "')
			";
            $statement = $con->prepare($insert_query);

            $statement->execute();

            $notification_query = "
			SELECT user_id, post_content FROM post 
			WHERE post_id = '" . $_POST["post_id"] . "'
			";

            $statement = $con->prepare($notification_query);

            $statement->execute();

            $notification_result = $statement->fetchAll();

            foreach ($notification_result as $notification_row) {
                // $notification_text = '
				// <b>' . Get_user_name($con, $_SESSION["uid"]) . '</b> has like your post - "' . strip_tags(substr($notification_row["post_content"], 0, 30)) . '..."
				// ';
                $notification_text = ' أعجب ' . ' <b> ' . $n1 . ' '.$n2 . ' </b> ' . " على منشورك ";


                $insert_query = "
				INSERT INTO notification 
					(notification_receiver_id, notification_text, read_notification) 
					VALUES ('" . $notification_row['user_id'] . "', '" . $notification_text . "', 'no')
				";

                $statement = $con->prepare($insert_query);
                $statement->execute();
            }

            echo 'Like';
        }
    }
    // -----------------------------------------------------------------------------------------------------------------

    // هنا نجيب اسامي الي منطين لايك للمنشور

    if ($_POST["data"] == "like_user_list") {
        $query = "
		SELECT * FROM tbl_like 
		INNER JOIN users 
		ON users.id = tbl_like.user_id 
		WHERE tbl_like.post_id = '" . $_POST["post_id"] . "'
		";

        $statement = $con->prepare($query);

        $statement->execute();

        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $output .= '
			<p>' . $row["user_id"] . '</p>
			';
        }

        echo $output;
    }

    // ---------------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------------------------------------------------------

    // حذف المنشور  

    if ($_POST['data'] == 'delete_post') {
        $stmt = $con->prepare("DELETE FROM post WHERE post_id = :zid");
        $stmt->bindParam(":zid", $_POST['post_id']);
        $stmt->execute();   
    }
}
