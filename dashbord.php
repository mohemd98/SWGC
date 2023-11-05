<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['uid'])) {
    include "login.php";
}
include 'init.php';


// $tement = $con->prepare("SELECT * FROM users 
// WHERE id != '" . $_SESSION["uid"] . "' ");
// $tement->execute();
// $re = $tement->fetchAll();

// foreach($re as $i){

// $sender= $con->prepare("SELECT * FROM follow 
// WHERE sender_id = '" . $i["id"] . "' ");
// $sender->execute();
// $rerr= $con->prepare("SELECT * FROM follow 
// WHERE receiver_id = '" . $i["id"] . "' ");
// $rerr->execute();

//    echo '<button type="button" class="btn btn-primary">'. $sender->rowCount().'</button>';
//    echo '<button type="button" class="btn btn-primary">'.$i['user_id'].'</button>';
//    echo '<button type="button" class="btn btn-primary">'. $rerr->rowCount().'</button>';

//    echo "<br><br><br><br><br>";

// }

?>


<div class="container">
    <div class="row mt-1">
        <div class="col-md-4">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-header text-center" style="font-size: 26px; height: 50px;background-color: #1C315E; border-radius: 5px; color: white;">الاشخاص المقترحون</h5>
                    <div class="card-body dash-user">
                        <div id="user_list"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ---------------------------------------------------------- -->
        <div class="col-md-8">
            <div class="card w-85">
                <div class="card-body text-center">
                    <!-- <input type="search" name="" style="width: 90%;" id="" placeholder="كتابة منشور"> -->
                    <h5 class="card-header text-center" style="font-size: 26px; height: 50px;background-color: #1C315E; border-radius: 5px; color: white;">نشر منشور</h5>

                    <!-- Button trigger modal -->
                    <!-- <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    أضف منشور
                    </button> -->
                    <div class="row dashbord-post-posts">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary mt-3 " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                عمـل
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                مـنحه
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                دوره
                            </button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">منشور</h5>
                                    <button type="button" style="margin-left: 0;" class="btn-close postnepos" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" class="row" id="post_form" enctype="multipart/form-data">

                                        <!--  -->
                                        <div class="col-md-6 ">
                                            <label for="" class="form-label">اختر صوره</label>
                                            <input class="form-control" name="files" type="file" required>
                                        </div>
                                        <!--  -->
                                        <div class="col-md-6">
                                            <label for="inputState" class="form-label">المحافظه</label>
                                            <select id="inputState" class="form-select" name="city" required>
                                                <option value="أربيل">أربيل</option>
                                                <option value="الأنبار">الأنبار</option>
                                                <option value="بابل">بابل</option>
                                                <option value="بغداد">بغداد</option>
                                                <option selected value="البصرة">البصرة</option>
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


                                        <!--  -->
                                        <div class="col-md-6 mt-2">
                                            <label for="" class="form-label">اختر المنطقه</label>
                                            <input class="form-control" name="mant" type="text" placeholder="منطقه" required />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label for="" class="form-label">عنوان الرئيسي</label>
                                            <input class="form-control" name="title" type="text" placeholder="العنوان الرئيسي للمنشور" required />
                                        </div>

                                        <!--  -->
                                        <div class="col-md-12">
                                            <label class="form-label" for="post_content"> </label>
                                            <textarea class="form-control" placeholder="اكتب محتوى الي تريد نشره" id="post_content" style="height: 100px" name="post_content" required></textarea>
                                        </div>

                                        <!-- ------------------------------------------- -->
                                        <div class="typinpt1">
                                            <label class="form-check-label">منحه</label>
                                            <input class="form-check-input" type="radio" name="chos" value="منحه" required>
                                        </div>
                                        <div class="typinpt2">
                                            <label class="form-check-label">دوره</label>
                                            <input class="form-check-input" type="radio" name="chos" value="دوره" required>
                                        </div>
                                        <div class="typinpt3">
                                            <label class="form-check-label">عمل</label>
                                            <input class="form-check-input" type="radio" name="chos" value="عمل" required>
                                        </div>
                                        <!-- -------------------------------------------- -->

                                        <div class="wantinput1">
                                            <label class="form-check-label">ابحث عن</label>
                                            <input class="form-check-input" type="radio" name="wont" value="ابحث عن" required>
                                        </div>
                                        <div class="wantinput2">
                                            <label class="form-check-label">احتاج الى</label>
                                            <input class="form-check-input" type="radio" name="wont" value="احتاج الى" required>
                                        </div>
                                        <!-- -------------------------------------------- -->
                                        <div class="typinpt1">
                                            <label class="form-check-label">ذكر</label>
                                            <input class="form-check-input" type="radio" name="gender" value="ذكر" required>
                                        </div>
                                        <div class="typinpt2">
                                            <label class="form-check-label">انثى</label>
                                            <input class="form-check-input" type="radio" name="gender" value="انثى" required>
                                        </div>
                                        <div class="typinpt3">
                                            <label class="form-check-label">كلا الجنسين</label>
                                            <input class="form-check-input" type="radio" name="gender" value="كلا الجنسين" required>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" id="send"  value="انشر" class="btn btn-primary">
                                </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card w-85">
                <div class="card-body">
                    <h5 class="card-header text-center" style="font-size: 26px; height: 50px;background-color: #1C315E; border-radius: 5px; color: white;">المنشورات</h5>
                    <div class="panel-body">
                        <div id="post_list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
include $tpl . 'footer.php';
include 'ajax.php';
?>
