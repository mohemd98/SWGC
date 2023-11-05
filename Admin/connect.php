<?php
$dsn = "mysql:host=localhost;dbname=work";
$user = "root";
$pass = "";
$con = new PDO($dsn, $user, $pass);

function countItems($itam,$table){
    global $con ;
    $stmt2=$con->prepare("SELECT COUNT($itam) FROM $table");
    $stmt2->execute();
     return $stmt2->fetchColumn(); //هذه الدال ترجعلي رقم
}

function getLatest($select,$table,$order,$limit=5){

    global $con;
 
    $getstmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
 
    $getstmt->execute();
 
    $rows=$getstmt->fetchAll();
 
    return $rows;
 
 }

 function redirectHome($theMsg, $ur = null, $seconds = 3)
{

    if ($ur === null) {

        $ur = 'index.php'; // من اعوضه مباشر يطلع خطء
    }else{
        
        //هذه السيرفر يستعمل علمود يرجع ليورا يعني اذا جان اكو شي جاي منه 
        //vido 35

        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''){

            $ur= $_SERVER['HTTP_REFERER'];

        }else{

            $ur='index.php';

        }

    }

    echo $theMsg;

    echo "<div class='alert alert-info'> you will be redirected to homepage after $seconds Seconds</div>";

    header("refresh:$seconds;url=$ur");

    exit();
}