<?php

function getTitle()
{

	global $pageTitle;

	if (isset($pageTitle)) {

		echo $pageTitle;
	} else {

		echo 'Default';
	}
}

function checkItem($select, $form, $value)
{

	global $con;

	$statement = $con->prepare("SELECT $select FROM $form WHERE $select = ?");

	$statement->execute(array($value));

	$count = $statement->rowCount();

	// هذه العداد اذا الاسم موجود يزود واحد

	return $count;
}

//  هاي للفولو وان فولو


function profal($con, $user_id)
{



	$statement = $con->prepare("SELECT * FROM profal 
	WHERE user_id = '". $user_id ."'");
	$statement->execute();
	$t=$statement->rowCount();

	if($t <= 0 ){
				$stmt = $con->prepare("INSERT INTO
				profal(colg,division,boi,fonnamber,tergram_id,facebokc_rul,user_id)
				VALUES(:m1 , :m2, :m3,:m4,:m5,:m6,:m7)");
				$stmt->execute(array(
					'm1' => "اختر الجامعه",
					'm2' => "لايوجد",
					'm3' => "لايوجد",
					'm4' => "لايوجد",
					'm5' => "لايوجد",
					'm6' => "لايوجد",
					'm7' => $user_id
				));
	}


}
