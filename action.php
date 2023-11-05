<?php
session_start();
include 'connect.php';

$getnamew = $con->prepare("SELECT * FROM users WHERE id= ?");
$getnamew->execute(array($_SESSION["uid"] ));
$name = $getnamew->fetch();
$n1 = $name['first_name'];
$n2 = $name['list_name'];
// حفظ البيانات

if (isset($_POST['city'])) {
	$avatarTmp    = $_FILES['files']['tmp_name'];
	move_uploaded_file($avatarTmp, "uploads\post\\" . $_FILES['files']['name']);

	$data = array(
		':user_id'			=>	$_SESSION["uid"],
		':post_content'		=>	$_POST["post_content"],
		':post_img_name'	=>	$_FILES['files']['name'],
		':post_city'		=>	$_POST["city"],
		':post_man'			=>	$_POST["mant"],
		':post_title'		=>	$_POST["title"],
		':post_type'		=>	$_POST["chos"],
		':post_want'		=>	$_POST["wont"],
		':gender'		    =>	$_POST["gender"],
		':post_datetime'	=>	date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))
	);
	$statement = $con->prepare("INSERT INTO post 
	(user_id, post_content, post_img_name, post_city,post_man, post_title,post_type, post_want,post_gender, post_datetime) 
	VALUES (:user_id, :post_content,:post_img_name, :post_city,:post_man, :post_title,:post_type, :post_want,:gender, :post_datetime)
	");
	$statement->execute($data);
	//  هنا الاشعارات

	$notification_query = "
	SELECT receiver_id FROM follow 
	WHERE sender_id = '" . $_SESSION["uid"] . "'
	";

	$statement = $con->prepare($notification_query);
	$statement->execute();
	$notification_result = $statement->fetchAll();
	foreach ($notification_result as $notification_row) {

		// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . ' has share new post';
		$notification_text = "تم مشاركه منشورك";

		$insert_query = "
		INSERT INTO notification 
		(notification_receiver_id, notification_text, read_notification) 
		VALUES ('" . $notification_row['receiver_id'] . "', '" . $notification_text . "', 'no')
		";
		$statement = $con->prepare($insert_query);
		$statement->execute();
	}
}

// ---------------------------------------------------------------------------------------------------------

if (isset($_POST['action'])) {

	$output = '';



	// 	جلب البيانات

	if ($_POST['action'] == 'fetch_post') {
		$statement = $con->prepare("SELECT * FROM post 
		INNER JOIN users ON users.id = post.user_id 
		LEFT JOIN follow ON follow.sender_id = post.user_id 
		WHERE follow.receiver_id = '" . $_SESSION["uid"] . "' OR post.user_id = '" . $_SESSION["uid"] . "' 
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
							<div  class="lavl1 mt-3">
								<img  src="uploads/avatars/' . $row["avatar"] . '" >
								<a  href="sh_pr_us.php?userid=' . $row['id'] . '" >' . $row["first_name"] . " " . $row["list_name"] . '</a>
							</div>
							<div class="lavl3 mt-3">
								<h3>' . $row["post_title"] . '</h3>
							</div>
							<div class="col-md-4 mt-2">
								<div class="filtrforpost mt-4 ">
									<h3>سكن: ' . $row["post_city"] . '-' . $row["post_man"]   .   '</h3>
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
					. count_total_post_like($con, $row["post_id"]) . '
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
									';
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
			$output = '<h4>لا توجد منشورات</h4>';
		}
		echo $output;
	}

	// ---------------------------------------------------------------------------------------------------------

	//  هنا اجيب اليوزريه



	if ($_POST['action'] == 'fetch_user') {
		$statement = $con->prepare("SELECT *  FROM users 
							    	WHERE id != '" . $_SESSION["uid"] . "' 
							    	ORDER BY id DESC LIMIT 20");
		$statement->execute();
		$result = $statement->fetchAll();


		foreach ($result as $row) {
			$profile_image = '<img src="uploads/avatars/' . $row["avatar"] . '" class="" />';
			$output .= '
			<div class="row">
				<div class="col-md-3">
					' . $profile_image . '
				</div>
				<div class="col-md-8">
				<h4><a class="harfforlink" href="sh_pr_us.php?userid=' . $row['id'] . '" >' . $row["first_name"] . ' ' . $row["list_name"] . '</a></h4>
				<p class="label label-success">' . Get_bio($con, $row["id"]) . '</p>

					' . make_follow_button($con, $row["id"], $_SESSION["uid"]) . '
				</div>
			</div>
			<br>
		';
		}
		echo $output;
	}
	//                    مال متابعين و متابعهم 
	// 					<span class="label label-success"> ' . NUmberFolloingME($con , $row['id'])  . ' المتابعهم</span>
	// 					<span class="label label-success"> ' .  NumberImFolloing($con , $row['id']) . ' المتابعيني</span>

	// --------------------------------------------------------------------------------------------------------------------------


	//  الفولو

	if ($_POST['action'] == 'follow') {
		$query = "
			INSERT INTO follow 
			(sender_id, receiver_id) 
			VALUES ('" . $_POST["sender_id"] . "', '" . $_SESSION["uid"] . "')
			";
			
		$statement = $con->prepare($query);
		if ($statement->execute()) {
			$sub_query = "
				UPDATE users SET 
				
				 follower_number = follower_number + 1 WHERE id = '" . $_POST["sender_id"] . "'
				";
			$statement = $con->prepare($sub_query);
			$statement->execute();

			// // هنا الاشعارات

			// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . '</b> has follow you.';
			$notification_text = ' تم متابعتك من قبل ' . ' <b> ' . $n1 . ' '.$n2 . ' </b>';

			$insert_query = "
				INSERT INTO notification 
				(notification_receiver_id, notification_text, read_notification) 
				VALUES ('" . $_POST["sender_id"] . "', '" . $notification_text . "', 'no')
				";

			$statement = $con->prepare($insert_query);
			$statement->execute();
		}
	}

	if ($_POST['action'] == 'unfollow') {
		$query = "
			DELETE FROM follow 
			WHERE sender_id = '" . $_POST["sender_id"] . "' 
			AND receiver_id = '" . $_SESSION["uid"] . "'
			";
		$statement = $con->prepare($query);
		if ($statement->execute()) {
			$sub_query = "
				UPDATE users 
				SET follower_number = follower_number - 1 
				WHERE id = '" . $_POST["sender_id"] . "'
				";
			$statement = $con->prepare($sub_query);
			$statement->execute();

			// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . '</b> has unfollow you.';
			$notification_text =  ' <b> ' . $n1 . ' '.$n2 . ' </b> ' . " الغه  المتابعه ";

			$insert_query = "
				INSERT INTO notification 
				(notification_receiver_id, notification_text, read_notification) 
				VALUES ('" . $_POST["sender_id"] . "', '" . $notification_text . "', 'no')
				";
			$statement = $con->prepare($insert_query);

			$statement->execute();
		}
	}
	// --------------------------------------------------------------------------------------------------------------------------


	//  اهتمام

	if ($_POST['action'] == 'icare') {
		$query = "
			INSERT INTO aprov 
			(sender_id, receiver_id) 
			VALUES ('" . $_POST["sender_id"] . "', '" . $_SESSION["uid"] . "')
			";

// اجيب ايدي حتى الاشعار يرروح اله
$getUser = $con->prepare("SELECT * FROM post WHERE post_id= ?");
$getUser->execute(array($_POST["sender_id"]));
$info = $getUser->fetch();
$fornav = $info['user_id'];

		$statement = $con->prepare($query);
		if ($statement->execute()) {
			// // هنا الاشعارات
			// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . '</b>اهتم بمنشورك.';
			$notification_text = 'اهتم  ' . ' <b> ' . $n1 . ' '.$n2 . ' </b> ' . " بمنشورك ";

			$insert_query = "
				INSERT INTO notification 
				(notification_receiver_id, notification_text, read_notification) 
				VALUES ('" . $fornav . "', '" . $notification_text . "', 'no')
				";

			$statement = $con->prepare($insert_query);
			$statement->execute();
		}
	}

	if ($_POST['action'] == 'dontcare') {
		$query = "
			DELETE FROM aprov 
			WHERE sender_id = '" . $_POST["sender_id"] . "' 
			AND receiver_id = '" . $_SESSION["uid"] . "'
			";
			
			// اجيب ايدي حتى الاشعار يرروح اله
		$getUser = $con->prepare("SELECT * FROM post WHERE post_id= ?");
		$getUser->execute(array($_POST["sender_id"]));
		$info = $getUser->fetch();
		$fornav = $info['user_id'];

		$statement = $con->prepare($query);
		if ($statement->execute()) {
			// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . '</b> ازال الاهتمام.';
			$notification_text = 'ازال  ' . ' <b> ' . $n1 . ' '.$n2 . ' </b> ' . " الاهتمام بمنشورك ";

			$insert_query = "
				INSERT INTO notification 
				(notification_receiver_id, notification_text, read_notification) 
				VALUES ('" . $fornav . "', '" . $notification_text . "', 'no')
				";
			$statement = $con->prepare($insert_query);
			$statement->execute();
		}
	}

	// --------------------------------------------------------------------------------------------------------------------------

	//  حفظ

	if ($_POST['action'] == 'save') {
		$query = "
			INSERT INTO save_posts 
			(post_id, user_id) 
			VALUES ('" . $_POST["sender_id"] . "', '" . $_SESSION["uid"] . "')
			";

// اجيب ايدي حتى الاشعار يرروح اله
		$getUser = $con->prepare("SELECT * FROM post WHERE post_id= ?");
		$getUser->execute(array($_POST["sender_id"]));
		$info = $getUser->fetch();
		$fornav = $info['user_id'];

		$statement = $con->prepare($query);
		if ($statement->execute()) {
			// // هنا الاشعارات
			// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . '</b> حفظ منشورك.';
			$notification_text = 'حفظ ' . ' <b> ' . $n1 . ' '.$n2 . ' </b> ' . " منشورك ";

			$insert_query = "
				INSERT INTO notification 
				(notification_receiver_id, notification_text, read_notification) 
				VALUES ('" . $fornav . "', '" . $notification_text . "', 'no')
				";

			$statement = $con->prepare($insert_query);
			$statement->execute();
		}
	}

	if ($_POST['action'] == 'unsave') {
		$query = "
			DELETE FROM save_posts 
			WHERE post_id = '" . $_POST["sender_id"] . "' 
			AND user_id = '" . $_SESSION["uid"] . "'
			";

			// اجيب ايدي حتى الاشعار يرروح اله
		$getUser = $con->prepare("SELECT * FROM post WHERE post_id= ?");
		$getUser->execute(array($_POST["sender_id"]));
		$info = $getUser->fetch();
		$fornav = $info['user_id'];
	

		$statement = $con->prepare($query);
		if ($statement->execute()) {
			// $notification_text = '<b>' . Get_user_name($con, $_SESSION["uid"]) . '</b> ازال الحفظ.';
			$notification_text = 'ازال   ' . ' <b> ' . $n1 . ' '.$n2 . ' </b> ' . "الحفظ من منشورك ";

			$insert_query = "
				INSERT INTO notification 
				(notification_receiver_id, notification_text, read_notification) 
				VALUES ('" . $fornav . "', '" . $notification_text . "', 'no')
				";
			$statement = $con->prepare($insert_query);
			$statement->execute();
		}
	}

	// --------------------------------------------------------------------------------------------------------------------------


	// --------------------------------------------------------------------------------------------------------------------------


	//  نحفظ التعليقات

	if ($_POST["action"] == 'submit_comment') {
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

	// -------------------------------------------------------------------------------------------------------------------------

	//  نجيب الكومنتات

	if ($_POST["action"] == "fetch_comment") {
		$query = "
		SELECT * FROM comment 
		INNER JOIN users 
		ON users.id = comment.user_id 
		WHERE post_id = '" . $_POST["post_id"] . "' 
		ORDER BY comment_id DESC
		";
		$statement = $con->prepare($query);
		$output = '';
		if ($statement->execute()) {
			$result = $statement->fetchAll();
			$output .= '<div class="overflow">';
			// foreach ($result as $row) {
			// 	$profile_image = '<img src="uploads/avatars/' . $row["avatar"] . '" class="img-thumbnail img-responsive" />';
			// 	$output .= '
			// 	<div class="totilpost row">
			// 		<div class="col-md-2 lavl1">
			// 		' . $profile_image . '	
			// 		</div>
			// 		<div class="col-md-10 lavl1 hhhhhh" style="margin-top:16px; padding-left:0">
			// 			<small><b><a href="sh_pr_us.php?userid=' . $row['id'] . '" >@' . $row["user_id"] . '</a></b><br/>
			// 			' . $row["comment"] . '
			// 			</small>
			// 		</div>
			// 	</div>
			// 	<br />
			// 	';
			// }
			foreach ($result as $row) {
				$profile_image = '<img src="uploads/avatars/' . $row["avatar"] . '" class="mt-2 mb-2 ms-2 me-2" />';
				$output .= '
				<div class="totilpost">
					<div class="lavl5">
						' . $profile_image . '
						<h4 class="folnamer">' . $row["first_name"] . " " . $row["list_name"] . '</h4>
					</div>
					<div class="me-4 mb-4">
					' . $row["comment"] . '
					</div>
				</div>
				<br/>';
			}
			$output .= '</div>';
		}
		echo $output;
	}


	// ----------------------------------------------------------------------------------------------------------------------------------

	// لايك المنشور

	if ($_POST["action"] == "like") {
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

			echo 'تم التعليق';
		}
	}
	// -----------------------------------------------------------------------------------------------------------------

	// هنا نجيب اسامي الي منطين لايك للمنشور

	if ($_POST["action"] == "like_user_list") {
		$query = "
		SELECT * FROM tbl_like 
		INNER JOIN users 
		ON users.id = tbl_like.user_id 
		WHERE tbl_like.post_id = '" . $_POST["post_id"] . "'
		LIMIT 6";

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

	//   تدحيث الاشعارت المقروئه

	if ($_POST["action"] == "update_notification_status") {
		$query = "
		UPDATE notification 
		SET read_notification = 'yes' 
		WHERE notification_receiver_id = '" . $_SESSION["uid"] . "'
		";

		$statement = $con->prepare($query);

		$statement->execute();
	}
}
// نجيب اسامي اليوزريه من نبحث
if ($_POST["action"] == "search_user") {
	if ($_POST["query"] != '') {
		$statement = $con->prepare("SELECT * FROM users 
	WHERE user_id LIKE '%" . $_POST["query"] . "%' 
	AND id != '" . $_SESSION["uid"] . "'
	");
		$statement->execute();
		$result = $statement->fetchAll();
		$out = '';
		foreach ($result as $row) {
			$out .= '
			<div class="totilpostgetuser" >
				<div class="lavl1">
					<img src="uploads/avatars/' . $row["avatar"] . '" >
					<a href="sh_pr_us.php?userid=' . $row['id'] . '" class="">' . $row["user_id"] . ' </a> 
				</div>
			</div>
			';
		}
		echo $out;
	}
}
// --------------------------------
// حذف المنشور  

if (isset($_POST['data'])) {
	if ($_POST['data'] == 'delete_post') {
		$stmt = $con->prepare("DELETE FROM post WHERE post_id = :zid");
		$stmt->bindParam(":zid", $_POST['post_id']);
		$stmt->execute();
	}
}
