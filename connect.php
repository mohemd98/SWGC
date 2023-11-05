<?php

$dsn = "mysql:host=localhost;dbname=work";
$user = "root";
$pass = "";
$con = new PDO($dsn, $user, $pass);
// $con->exec("SET NAMES utf8");


// هنا بتن علمود حفظ او غير حفظ

function make_save_button($con, $sender_id, $receiver_id)
{
	$statement = $con->prepare("SELECT * FROM save_posts 
	WHERE post_id = '" . $sender_id . "' 
	AND user_id = '" . $receiver_id . "'
	");
	$statement->execute();
	$total_row = $statement->rowCount();
	$output = '';
	if ($total_row > 0) {
		$output = '<button type="button" name="follow_button" class="btn  btn-primary  action_button_save" 
		data-action="unsave" data-sender_id="' . $sender_id . '">الغاء الحفظ</button>';
	} else {
		$output = '<button type="button" name="follow_button" class="btn btn_save_color action_button_save" 
		data-action="save" data-sender_id="' . $sender_id . '">حفظ</button>';
	}
	return $output;
}

// هنا بتن علمود يهتم او غير مهتم

function make_aprov_button($con, $sender_id, $receiver_id)
{
	$statement = $con->prepare("SELECT * FROM aprov 
	WHERE sender_id = '" . $sender_id . "' 
	AND receiver_id = '" . $receiver_id . "'
	");
	$statement->execute();
	$total_row = $statement->rowCount();
	$output = '';
	if ($total_row > 0) {
		$output = '<button type="button" name="follow_button" class="btn btn-primary action_button_care ms-2" 
		data-action="dontcare" data-sender_id="' . $sender_id . '">الغاء اهتمام</button>';
	} else {
		$output = '<button type="button" name="follow_button" class="btn btn_save_color action_button_care ms-2" 
		data-action="icare" data-sender_id="' . $sender_id . '">انا مهتم</button>';
	}
	return $output;
}


// هنا بتن الفولو وانة فولو

function make_follow_button($con, $sender_id, $receiver_id)
{
	$statement = $con->prepare("SELECT * FROM follow 
	WHERE sender_id = '" . $sender_id . "' 
	AND receiver_id = '" . $receiver_id . "'
	");
	$statement->execute();
	$total_row = $statement->rowCount();
	$output = '';
	if ($total_row > 0) {
		$output = '<button type="button" name="follow_button" class="btn action_button unfolo" 
		data-action="unfollow" data-sender_id="' . $sender_id . '"><i class="fa-solid fa-minus"></i></button>';
	} else {
		$output = '<button type="button" name="follow_button" class="btn   action_button folo" 
		data-action="follow" data-sender_id="' . $sender_id . '"><i class="fa-solid fa-plus"></i> </button>';
	}
	return $output;
}


// عدد التعليقات

function count_comment($con, $post_id)
{
	$query = "
	SELECT * FROM comment 
	WHERE post_id = '" . $post_id . "'
	";
	$statement = $con->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

// عدد الي مسوين مشاركه

function count_retweet($con, $post_id)
{
	$query = "
	SELECT * FROM repost 
	WHERE post_id = '" . $post_id . "'
	";
	$statement = $con->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

// عدد اللايكات

function count_total_post_like($con, $post_id)
{
	$query = "
	SELECT * FROM tbl_like 
	WHERE post_id = '" . $post_id . "'
	";

	$statement = $con->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

//  الاسم


function Get_user_name($con, $user_id)
{
	$query = "
	SELECT user_id FROM users 
	WHERE id = '" . $user_id . "'
	";

	$statement = $con->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	foreach ($result as $row) {
		return $row["user_id"];
	}
}

// عدد الاشعارات

function Count_notification($con, $receiver_id)
{
	$statement = $con->prepare("SELECT COUNT(notification_id) as total 
		FROM notification 
		WHERE notification_receiver_id = '" . $receiver_id . "' AND read_notification = 'no'");

	$statement->execute();

	$result = $statement->fetchAll();

	foreach ($result as $row) {
		return $row["total"];
	}
}

// تحميل الاشعارات

function Load_notification($con, $receiver_id)
{
	$query = "SELECT * FROM notification WHERE notification_receiver_id = '" . $receiver_id . "' ORDER BY notification_id DESC";
	$statement = $con->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$total_row = $statement->rowCount();

	$output = '';

	if ($total_row > 0) {
		foreach ($result as $row) {
			$output .= '<li><a class="dropdown-item " href="#">' . $row["notification_text"] . '</a></li>';
		}
	}
	return $output;
}


// عدد المتابعهم

function NumberImFolloing($con, $userID)
{
	$sender = $con->prepare("SELECT * FROM follow WHERE sender_id = '" . $userID . "' ");
	$sender->execute();
	return $sender->rowCount();
}
//  عدد المتابعهم
function NUmberFolloingME($con, $userID)
{
	$rerr = $con->prepare("SELECT * FROM follow WHERE receiver_id = '" . $userID . "' ");
	$rerr->execute();
	return $rerr->rowCount();
}
// جزء من البايو

function Get_bio($con, $user_id)
{
	$query = "SELECT * FROM profal WHERE user_id = '" . $user_id . "'";
	$statement = $con->prepare($query);
	$statement->execute();
	$result = $statement->fetch();
	if (isset($result['user_id'])) {
		if ($result['boi'] == "لايوجد") {
			return "لايوجد نبذه";
		} else {
			$text = $result['boi'];
			return $text;
		}
	} else {
		return "لايوجد نبذه";
	}
}

// FETCH_DATA
// هنا بتن علمود حفظ او غير حفظ

function make_save_button_2($con, $sender_id, $receiver_id)
{
	$statement = $con->prepare("SELECT * FROM save_posts 
	WHERE post_id = '" . $sender_id . "' 
	AND user_id = '" . $receiver_id . "'
	");
	$statement->execute();
	$total_row = $statement->rowCount();
	$output = '';
	if ($total_row > 0) {
		$output = '<button type="button" name="follow_button" class="btn btn-primary action_button_save_2" 
		data-action="unsave_2" data-sender_id="' . $sender_id . '">الغاء الحفظ</button>';
	} else {
		$output = '<button type="button" name="follow_button" class="btn btn_save_color action_button_save_2" 
		data-action="save_2" data-sender_id="' . $sender_id . '">حفظ</button>';
	}
	return $output;
}

// هنا بتن علمود يهتم او غير مهتم

function make_aprov_button_2($con, $sender_id, $receiver_id)
{
	$statement = $con->prepare("SELECT * FROM aprov 
	WHERE sender_id = '" . $sender_id . "' 
	AND receiver_id = '" . $receiver_id . "'
	");
	$statement->execute();
	$total_row = $statement->rowCount();
	$output = '';
	if ($total_row > 0) {
		$output = '<button type="button" name="follow_button" class="btn btn-primary action_button_care_2 ms-2" 
		data-action="dontcare_2" data-sender_id="' . $sender_id . '">الغاء اهتمام</button>';
	} else {
		$output = '<button type="button" name="follow_button" class="btn btn_save_color action_button_care_2 ms-2" 
		data-action="icare_2" data-sender_id="' . $sender_id . '">انا مهتم</button>';
	}
	return $output;
}