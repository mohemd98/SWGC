<div class="row manageprofal">
    <div class="col-sm-12 col-md-3">
        <div class="imge-profale text-center">
            <?php
            echo  "<img src='uploads/avatars/" . $rows['avatar'] . "' alt=''/>";
            ?>

            <div class="nameuser text-center">
                <?php
                echo '
                                <button type="button" class="btn btn-dd btn-sm"> المتابعين ' . $folowme . '</button>
                                <button type="button" class="btn btn-dd btn-md">' . $_SESSION['user'] . '</button>
                                <button type="button" class="btn btn-dd btn-sm"> يتابع ' . $imfolow . '</button>

                          ';
                ?>
            </div>
            <!-- ------------------------------------ -->

            <!-- Button trigger modal -->
            <button style="    font-family: bold;" type="button" class="btn btn-dark hgkjfk" data-bs-toggle="modal" data-bs-target="#exampleModalee">
                تعديل المعلومات
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل حساب</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="    margin-left: 0;"></button>
                    </div>
                    <div class="modal-body">

                        <!-- start signup form -->
                        <div class="container sinin-page text-end">

                            <form class="row g-3" method="POST" enctype="multipart/form-data">
                                <!-- start -->

                                <div class="col-md-6">
                                    <label for="uncname" class="form-label">اسم الفريد</label>
                                    <input type="text" class="form-control" id="uncname" name="uncname" value="<?php echo $rows['user_id']; ?>" required>
                                </div>
                                <!-- start -->

                                <div class="col-md-6">
                                    <label for="email" class="form-label">ايميل</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $rows['email']; ?>" required>
                                </div>
                                <!-- start -->

                                <div class="col-md-6">
                                    <label for="fname" class="form-label">اسم الاول</label>
                                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $rows['first_name']; ?>" required>
                                </div>
                                <!-- start -->

                                <div class="col-md-6">
                                    <label for="lname" class="form-label">اسم الاخير</label>
                                    <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $rows['list_name']; ?>" required>
                                </div>
                                <!-- start -->

                                <div class="col-md-6">
                                    <label for="password1" class="form-label">باسورد</label>
                                    <input type="password" class="form-control" id="password1" name="password1" value="<?php echo $rows['password']; ?>" required>
                                </div>
                                <!-- start -->

                                <div class="col-md-4">
                                    <label for="city" class="form-label">محافظه</label>
                                    <select id="city" class="form-select" name="city" required>
                                        <option <?php if ($rows['city'] == "بصره") {
                                                    echo 'selected';
                                                } ?> value="بصره"> البصره </option>
                                        <option <?php if ($rows['city'] == "بغداد") {
                                                    echo 'selected';
                                                } ?> value="بغداد"> بغداد </option>
                                        <option <?php if ($rows['city'] == "نجف") {
                                                    echo 'selected';
                                                } ?> value="نجف"> نجف </option>
                                        <option <?php if ($rows['city'] == "كربلاء") {
                                                    echo 'selected';
                                                } ?> value="كربلاء"> كربلاء </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "أربيل") {
                                                    echo 'selected';
                                                } ?> value="أربيل"> أربيل </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "الأنبار") {
                                                    echo 'selected';
                                                } ?> value="الأنبار"> الأنبار </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "بابل") {
                                                    echo 'selected';
                                                } ?> value="بابل"> بابل </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "دهوك") {
                                                    echo 'selected';
                                                } ?> value="دهوك"> دهوك </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "الديوانية") {
                                                    echo 'selected';
                                                } ?> value="الديوانية"> الديوانية </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "ديالى") {
                                                    echo 'selected';
                                                } ?> value="ديالى"> ديالى </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "ذي قار") {
                                                    echo 'selected';
                                                } ?> value="ذي قار"> ذي قار </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "السليمانية") {
                                                    echo 'selected';
                                                } ?> value="السليمانية"> السليمانية </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "صلاح الدين") {
                                                    echo 'selected';
                                                } ?> value="صلاح الدين"> صلاح الدين </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "كركوك") {
                                                    echo 'selected';
                                                } ?> value="كركوك"> كركوك </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "المثنى") {
                                                    echo 'selected';
                                                } ?> value="المثنى"> المثنى </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "ميسان") {
                                                    echo 'selected';
                                                } ?> value="ميسان"> ميسان </option>
                                        <!-- -------------- -->
                                        <option <?php if ($rows['city'] == "نينوى") {
                                                    echo 'selected';
                                                } ?> value="نينوى"> نينوى </option>
                                        <!-- -------------- -->
                                    </select>

                                </div>
                                <!-- start -->

                                <!-- start -->

                                <div class="col-md-2">
                                    <label for="age" class="form-label">العمر</label>
                                    <input type="number" class="form-control" id="age" name="age" value="<?php echo $rows['age']; ?>" required>
                                </div>
                                <!-- start -->
                                <div>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        ذكر
                                    </label>
                                    <input class="form-check-input" type="radio" name="gander" value="ذكر" <?php if ($rows['gender'] == 'ذكر') {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        انثى
                                    </label>
                                    <input class="form-check-input" type="radio" name="gander" value="انثى" <?php if ($rows['gender'] == 'انثى') {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                </div>
                                <!-- start  -->
                                <div class="col-md-2">
                                    <label>صوره</label>
                                    <input type="file" name="profile_image" id="profile_image" />
                                    <input type="hidden" name="profile_image" value="<?php echo $rows['avatar']; ?>" />
                                </div>


                        </div>
                        <!-- ecd signup form -->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="edit_profile" class="btn btn-primary">تعديل</button>

                    </div>
                </div>
            </div>
        </div>
        </form>

        <!-- ------------------- -->
    </div>
    <!-- -------------------------------------------------------------------------------- -->


    <!--  -->
    <div class="col-sm-12 col-md-9">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-header text-center" style="font-size: 26px; height: 50px;background-color: #1C315E; border-radius: 5px; color: white;">منشوراتي</h5>
                <div class="card-body">
                    <div id="my_post_list" class="row"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php


if (isset($_POST['edit_profile'])) {
    $file_name = '';
    if (isset($_POST['profile_image'])) {
        $file_name = $_POST['profile_image'];
    }

    if ($_FILES['profile_image']['name'] != '') {
        if ($file_name != '') {
            @unlink('uploads\avatars\\' . $file_name);
        }
        $image_name = explode(".", $_FILES['profile_image']['name']);
        $extension = end($image_name);
        $temporary_location = $_FILES['profile_image']['tmp_name'];
        $file_name = rand() . '.' . strtolower($extension);
        $location = 'uploads\avatars\\' . $file_name;
        move_uploaded_file($temporary_location, $location);
    }

    $uncname = $_POST['uncname'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password1 = $_POST['password1'];
    $city = $_POST['city'];
    $age = $_POST['age'];
    $gander = $_POST['gander'];

    $stmt = $con->prepare("UPDATE users SET user_id = ?, first_name = ?, list_name = ?, password = ? ,
     email = ?, gender = ?, avatar = ?, city = ? , age = ? WHERE id = ?");
    $stmt->execute(array($uncname, $fname, $lname, $password1,  $email, $gander, $file_name, $city, $age, $_SESSION['uid']));
}
