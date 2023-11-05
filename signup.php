<?php
session_start();
$noNavbar12 = '';
$pageTitle = 'Sign in';
if (isset($_SESSION['uid'])) {
    header('location:dashbord.php');
}
include 'connect.php';
include 'includes/functions/functions.php';

//  حفظ البيانات
$erroeNum=0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formErrors = array();
    $uncname = $_POST['uncname'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $city = $_POST['city'];
    $age = $_POST['age'];
    $gander = $_POST['gander'];
    $avatarName    = $_FILES['avatar']['name'];
    $avatarSize    = $_FILES['avatar']['size'];
    $avatarTmp    = $_FILES['avatar']['tmp_name'];
    $avatarType   = $_FILES['avatar']['type'];
    $avatarAllExtenstion = array("jpeg", "jpg", "png", "gif");
    $avatarExtenstion = explode('.', $avatarName);
    $dump = strtolower(end($avatarExtenstion));
    $avatar = rand(0, 10000000) . '_' . $avatarName;
    move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);
    if (isset($uncname)) {
        $uncname = filter_var($uncname, FILTER_SANITIZE_STRING);
        if (strlen($uncname) <= 2) {
            $formErrors[] = 'المعرف يتكون من 3 احرف على الاقل';
            $erroeNum++;
        }
    }
    if ($age <= 13) {
        $formErrors[] = 'يجب ان يكون العمر اكبر من 12 سنه';
        $erroeNum++;
    }
    if (isset($password1) && isset($password2)) {
        if (empty($password1)) {
            $formErrors[] = 'ادخل رمز المرور';
            $erroeNum++;
        }
        if (sha1($password1) !== sha1($password2)) {
            $formErrors[] = 'رمز المرور غير متطابق';
            $erroeNum++;
        }
    }
    if (isset($email)) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_SANITIZE_EMAIL) != true) {
            $formErrors[] = 'ادخل ايميل صحيح';
            $erroeNum++;
        }
    }

    if (empty($gander)) {
        $formErrors[] = 'اختر فئه ';
        $erroeNum++;
    }

    if(empty($formErrore) && $erroeNum==0){
        $check = checkItem("user_id", "users", $uncname);
        if ($check == 1) {
            $formErrors[] = 'المعرف مستعمل';
        } else {
            $stmt = $con->prepare("INSERT INTO
            users(user_id,first_name,list_name,password,email,gender,avatar,grop,city,age,time_data)
            VALUES(:m1 , :m2, :m3,:m4,:m5,:m6,:m7, 0,:m8 ,:m9,now())");
            $stmt->execute(array(
                'm1' => $uncname,
                'm2' => $fname,
                'm3' => $lname,
                'm4' => sha1($password1),
                'm5' => $email,
                'm6' => $gander,
                'm7' => $avatar,
                'm8' => $city,
                'm9' => $age
            ));
            $succesMsg = 'تم عمليه التسجيل بنجاح';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="layout/css/all.min.css" />
    <link rel="stylesheet" href="layout/css/bootstrap.min.css" />
    <link rel="stylesheet" href="layout/css/bootstrap.min.css.map" />
    <style>
        html,
        body {
            background-image: url('544750.jpg');
            background-color: rgba(0, 0, 0, 0.61);
            background-size:  cover;
            background-repeat: no-repeat;
            height: 100%;
            font-family: 'Numans', sans-serif;
        }

        .t1 {
            background-color: #ccc;
            color: red;
            border-radius: 20px;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            -ms-border-radius: 20px;
            -o-border-radius: 20px;
            text-align: center;
            font-size: 20px;
        }

        .container {
            height: 100%;
            align-content: center;
        }

        .card {
            height: 395px;
            margin-top: auto;
            margin-bottom: auto;
            width: 1000px;
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
        <div class="text-center">
            <?php
            if (!empty($formErrors)) {
                echo '  <div class="text-center">';
                foreach ($formErrors as $erroe) {
                    echo '<div class="alert alert-danger mt-2">' . $erroe . '</div>';
                }
                echo '</div>';
            }
            if (isset($succesMsg)){
                echo '<div class="alert alert-success mt-2 ">' . $succesMsg . '</div>';
                $seconds=3;
                $ur='login.php';
                header("refresh:$seconds;url=$ur");
            }
            ?>
        </div>
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>تسجيل حساب</h3>
                </div>

                <div class="card-body">
                    <form class="row g-3" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <!-- start -->
                        <div class="col-md-4 col-sm-12">
                            <input type="text" class="form-control" id="uncname" name="uncname" required placeholder="User ID">
                        </div>
                        <!-- start -->
                        <div class="col-md-4 col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" required placeholder="ايميل">
                        </div>
                        <!-- start -->

                        <div class="col-md-4 col-sm-12">
                            <input type="text" class="form-control" id="fname" name="fname" required placeholder="اسم الاول">
                        </div>
                        <!-- start -->

                        <div class="col-md-4 col-sm-12">
                            <input type="text" class="form-control" id="lname" name="lname" required placeholder="اسم الاخير">
                        </div>
                        <!-- start -->

                        <div class="col-md-4 col-sm-12">
                            <input type="password" class="form-control" id="password1" name="password1" required placeholder="رمز الدخول">
                        </div>
                        <!-- start -->

                        <div class="col-md-4 col-sm-12">
                            <input type="password" class="form-control" id="password2" name="password2" required placeholder="اعد رمز الدخول">
                        </div>

                        <!-- start -->

                        <div class="col-md-4 col-sm-12">
                            <input type="number" class="form-control" id="age" name="age" required placeholder="العمر">
                        </div>

                        <!-- start -->

                        <div class="col-md-4 col-sm-12">
                            <select id="city" class="form-select" name="city" required>
                                <option selected value="0">اختر المحافظه</option>
                                <option value="أربيل">أربيل</option>
                                <option value="الأنبار">الأنبار</option>
                                <option value="بابل">بابل</option>
                                <option value="بغداد">بغداد</option>
                                <option value="البصرة">البصرة</option>
                                <option value="دهوك">دهوك</option>
                                <option value="الديوانية">الديوانية</option>
                                <option value="ديالى">ديالى</option>
                                <option value="ذي قار">ذي قار</option>
                                <option value="السليمانية">السليمانية</option>
                                <option value="صلاح الدين">صلاح الدين</option>
                                <option value="كركوك">كركوك</option>
                                <option value="كربلاء">كربلاء</option>
                                <option value="المثنى">المثنى</option>
                                <option value="ميسان">ميسان</option>
                                <option value="النجف">النجف</option>
                                <option value="نينوى">نينوى</option>
                            </select>
                        </div>
                        <!-- start -->

                        <div class="col-md-4 col-sm-12">
                            <input type="file" class="form-control" id="avatar" name="avatar" required>
                        </div>
                        <!-- start -->
                        <div>
                            <label class="form-check-label" style="font-size: 20px; color: red;">
                                ذكر
                            </label>
                            <input class="form-check-input" type="radio" name="gander" required value="ذكر">

                            <label class="form-check-label" style="font-size: 20px; color: red;">
                                انثى
                            </label>
                            <input class="form-check-input" type="radio" name="gander" required value="انثى">
                        </div>
                        <!-- start  -->

                        <div class="card-footer text-muted">
                            <div class="col-12 ">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>

                        </div>
                    </form>

                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        <a class="loginform" href="login.php">تسجيل دخول</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="layout/css/all.min.css"></script>
<script src="layout/css/bootstrap.min.css"></script>