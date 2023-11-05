<?php

session_start();

$noNavbar12 = '';
$pageTitle = 'Login';
if (isset($_SESSION['uid'])) { //لازم يختلف عن سيشن الادمن
    header('location:dashbord.php'); // هنا اذا مسجل كبل طبلي ع صفحه ما حاجه كل مايطب يسجل
}
include 'connect.php';
include 'includes/functions/functions.php';
//login.php
$message = '';
if (isset($_POST["login_user"])) {
    $statement = $con->prepare("SELECT  id, user_id , password FROM users WHERE user_id = :user_email");
    $statement->execute(array('user_email'    =>    $_POST["username"]));
    $count = $statement->rowCount();
    if ($count > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if (sha1($_POST["password"]) == $row["password"]) {
                $_SESSION['user'] = $row['user_id']; // ثبتلي شيشن باليوزر
                $_SESSION['uid'] = $row['id']; //ثبتلي السيشن بالايدي
                profal($con, $_SESSION['uid']);
                header('location:dashbord.php'); // طببني للصفحه
                exit();
            } else {
                $message = "<div class='t1'>رمز الدخول خطاء</div>";
            }
        }
    } else {
        $message = "<div class='t2'>خطاء في اسم المستخدم</div>";
    }
}
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="layout/css/all.min.css" />
    <link rel="stylesheet" href="layout/css/bootstrap.min.css" />
    <link rel="stylesheet" href="layout/css/bootstrap.min.css.map" />
    <style>
        /* Made with love by Mutiullah Samim*/

        /* @import url('https://fonts.googleapis.com/css?family=Numans'); */

        html,
        body {
            background-image: url('544750.jpg');
            background-color: rgba(0, 0, 0, 0.61);
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
            font-family: 'Numans', sans-serif;
        }

        .t1 {
            background-color: rgba(255, 255, 255, 0.2);
            color: red;
            border-radius: 20px;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            -ms-border-radius: 20px;
            -o-border-radius: 20px;
            font-size: 20px;
            display: inline-flex;
            margin-left: 30%;
            padding-left: 10px;
            padding-right: 10px;
            text-align: center;
            margin-bottom: 10px;
        }
        .t2 {
            background-color: rgba(255, 255, 255, 0.2);
            color: red;
            border-radius: 20px;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            -ms-border-radius: 20px;
            -o-border-radius: 20px;
            font-size: 20px;
            display: inline-flex;
            margin-left: 20%;
            padding-left: 10px;
            padding-right: 10px;
            text-align: center;
            margin-bottom: 10px;
        }

        .container {
            height: 100%;
            align-content: center;
        }

        .card {
            height: 370px;
            margin-top: auto;
            margin-bottom: auto;
            width: 400px;
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        .social_icon span {
            font-size: 60px;
            margin-left: 10px;
            color: #12dbff;
        }

        .social_icon span:hover {
            color: white;
            cursor: pointer;
        }

        .card-header h3 {
            color: white;
        }

        .social_icon {
            position: absolute;
            right: 20px;
            top: -45px;
        }

        .input-group-prepend span {
            width: 50px;
            background-color: #12c8ff;
            color: black;
            border: 0 !important;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 10px !important;
            border-bottom-right-radius: 10px !important;

        }

        .input-group .frordubtn {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        input:focus {
            outline: 0 0 0 0 !important;
            box-shadow: 0 0 0 0 !important;

        }

        .remember {
            color: white;
        }

        .remember input {
            width: 20px;
            height: 20px;
            margin-left: 15px;
            margin-right: 5px;
        }

        .login_btn {
            color: black;
            background-color: #12d0ff;
            width: 100px;
        }

        .login_btn:hover {
            color: black;
            background-color: white;
        }

        .links {
            color: white;
        }

        .links a {
            margin-left: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3 style="text-align: center;">تسجيل الدخول</h3>
                </div>
                <div class="card-body">
                    <form method="POST" id="">
                        <?php echo $message; ?>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="username" class="form-control frordubtn" placeholder="معرف">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control frordubtn" placeholder="رمز السري">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login_user" value="تسجيل دخول" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        ليس لديك حساب؟<a href="signup.php">تسجيل حساب</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="layout/css/all.min.css"></script>
<script src="layout/css/bootstrap.min.css"></script>