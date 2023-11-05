<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['Admin_uid'])) {
  include "login.php";
}
include 'init.php';



$statement = $con->prepare("SELECT *,users.user_id AS usernameid FROM users 
INNER JOIN profal ON profal.user_id = users.id 
ORDER BY users.id DESC
");
$statement->execute();
$result = $statement->fetchAll();

if (isset($_GET['deleteid'])) {
  echo "<h1 class='text-center'>Delet item</h1>";
  echo "<div class='container'>"; //start div contane
  $itemid = $_GET['deleteid']; //ا
  $stmt = $con->prepare("DELETE FROM users WHERE id= :mosid");
  $stmt->bindparam(":mosid", $itemid); // هذه المثد يربط
  $stmt->execute();
  $stmt2 = $con->prepare("DELETE FROM profal WHERE user_id= :mosid");
  $stmt2->bindparam(":mosid", $itemid); // هذه المثد يربط
  $stmt2->execute();
  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' حذفت' . "</div>";
  redirectHome($theMsg, 'back');
  echo '</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $uncname     = $_POST['uncname'];
  $email       = $_POST['email'];
  $fname       = $_POST['fname'];
  $lname       = $_POST['lname'];
  $password1   = $_POST['password1'];
  $password2   = $_POST['password2'];
  $age         = $_POST['age'];
  $city        = $_POST['city'];
  $gander      = $_POST['gander'];
  $grop        = $_POST['grop'];
  $hashpass    =sha1($password1);


  $avatarName    = $_FILES['avatar']['name'];
  $avatarSize    = $_FILES['avatar']['size'];
  $avatarTmp    = $_FILES['avatar']['tmp_name'];
  $avatarType   = $_FILES['avatar']['type'];

  // echo $uncname .'<br>';
  // echo $email .'<br>';
  // echo $fname .'<br>';
  // echo $lname .'<br>';
  // echo $password1 .'<br>';
  // echo $password2 .'<br>';
  // echo $age .'<br>';
  // echo $city .'<br>';
  // echo $gander .'<br>';
  // echo $grop .'<br>';
  // echo $avatarName .'<br>';
  // echo $avatarSize .'<br>';
  // echo $avatarTmp .'<br>';
  // echo $avatarType .'<br>';
  $avatar = rand(0, 10000000) . '_' . $avatarName;
  move_uploaded_file($avatarTmp, "..\uploads\avatars\\" . $avatar);

  $stmt = $con->prepare("INSERT INTO
  users(user_id,first_name,list_name,password,email,gender,avatar,grop,city,age,time_data)
  VALUES(:m1 ,:m2, :m3, :m4, :m5,:m6, :m7, :m8, :m9, :m10,now())
  ");
  $stmt->execute(array(
    'm1' => $uncname,
    'm2' => $fname,
    'm3' => $lname,
    'm4' => $hashpass,
    'm5' => $email,
    'm6' => $gander,
    'm7' => $avatar,
    'm8' => $grop,
    'm9' => $city,
    'm10' => $age
  ));
 
 


  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' inserted' . "</div>";
  redirectHome($theMsg, 'back');
}

?>
  <h1 class="text-center">صفحة المستخدمين </h1>

<div class="mt-4 ms-4 me-4" >
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
    اضافه
  </button>

  <table class="table table-success table-striped">
    <thead>
      <tr>
      <th scope="col">ID</th>
        <th scope="col">صوره</th>
        <th scope="col">معرف</th>
        <th scope="col">اسم الكامل</th>
        <th scope="col">ايميل</th>
        <th scope="col">فئه</th>
        <th scope="col">محافظه</th>
        <th scope="col">عمر</th>
        <th scope="col">جامعه</th>
        <th scope="col">قسم</th>
        <th scope="col">نبذه</th>
        <th scope="col">رقم هاتف</th>
        <th scope="col">تلغرام</th>
        <th scope="col">فيس بوك</th>
        <th scope="col">تحكم</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $x=1;
      foreach ($result as $i) {
      ?>
        <tr>
        <td><?php echo $x ?></td>
          <td><img class='dfasgfg' src='../uploads/avatars/<?php echo $i['avatar'] ?>' alt='' /></td>
          <td><?php echo $i['usernameid'] ?></td>
          <td><?php echo $i['first_name'] . ' ' . $i['list_name'] ?></td>
          <td><?php echo $i['email'] ?></td>
          <td><?php echo $i['gender'] ?></td>
          <td><?php echo $i['city'] ?></td>
          <td><?php echo $i['age'] ?></td>
          <td><?php echo $i['colg'] ?></td>
          <td><?php echo $i['division'] ?></td>
          <td><?php echo $i['boi'] ?></td>
          <td><?php echo $i['fonnamber'] ?></td>
          <td><?php echo $i['tergram_id'] ?></td>
          <td><?php echo $i['facebokc_rul'] ?></td>
          <th> <a href='users.php?deleteid=<?php echo $i['id']; ?>' class='btn btn-danger confirm'><i class='fa fa-delete-left'></i></a></th>
        </tr>
      <?php
      $x++;
      }
      ?>
    </tbody>
  </table>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">تسجيل حساب</h5>
        <button style="    margin-left: 0;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- ... -->

        <form class="row g-3" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
          <!-- start -->
          <div class="col-md-4 col-sm-12">
            <input type="text" class="form-control" id="uncname" name="uncname" required placeholder="اسم الفريد">
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
            <input type="password" class="form-control" id="password1" name="password1" required placeholder="ادخل الباورد">
          </div>
          <!-- start -->

          <div class="col-md-4 col-sm-12">
            <input type="password" class="form-control" id="password2" name="password2" required placeholder="تكرار الباسورد">
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
            <label class="form-check-label">
              ذكر
            </label>
            <input class="form-check-input" type="radio" name="gander" value="ذكر">

            <label class="form-check-label">
              انثى
            </label>
            <input class="form-check-input" type="radio" name="gander" value="انثى">
          </div>
          <!-- start  -->
          <!-- start -->
          <div>
            <label class="form-check-label">
              ادمن
            </label>
            <input class="form-check-input" type="radio" name="grop" value="1">

            <label class="form-check-label">
              مستخدم
            </label>
            <input class="form-check-input" type="radio" name="grop" value="0">
          </div>
          <!-- start  -->

         
       

        <!-- ... -->
      </div>
      <div class="modal-footer">

                     <button type="submit" class="btn btn-primary">حفظ المعلومات</button>

      </div> 
    </form>
    </div>
  </div>
</div>


<?php

include  "includes/footer.php";
