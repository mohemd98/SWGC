<?php
session_start();
$pageTitle = 'gggg';
if (!isset($_SESSION['uid'])) {
    include "login.php";
}
include 'init.php';

$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


$getusers = $con->prepare("SELECT * FROM users WHERE id = '" . $userid . "' ");
$getusers->execute();
$user = $getusers->fetch();

$getprofal = $con->prepare("SELECT * FROM profal WHERE user_id = '" . $userid . "' ");
$getprofal->execute();
$profal = $getprofal->fetch();

$getpost = $con->prepare("SELECT * FROM post WHERE user_id = '" . $userid . "' ");
$getpost->execute();
$posts = $getpost->fetchAll();

$getskills = $con->prepare("SELECT * FROM skills WHERE user_id = '" . $userid . "' ");
$getskills->execute();
$skills = $getskills->fetchAll();
$nuskills = $getskills->rowCount();

$getimg = $con->prepare("SELECT * FROM files WHERE user_id = '" . $userid . "' AND type =  'img' ");
$getimg->execute();
$imgs = $getimg->fetchAll();

$getpdf = $con->prepare("SELECT * FROM files WHERE user_id = '" . $userid . "' AND type =  'pdf' ");
$getpdf->execute();
$pdfs = $getpdf->fetchAll();
$numpdfs = $getpdf->rowCount();


$getimg = $con->prepare("SELECT * FROM files WHERE user_id = '" . $userid . "' AND type =  'img' ");
$getimg->execute();
$im = $getimg->fetch();



// --------------------------------------------------------------------------------------------

?>


<div>
    <div>

        <div class="testone">
            <img src="uploads/avatars/<?php echo $user['avatar']; ?>" class=" mx-auto d-block rounded-circle mt-4" width="150px" height="150px" />
        </div>

        <div class="text-center">
            <h1 style="font-weight: bold;margin: 0;"><?php echo $user['first_name'] . " "; ?><?php echo $user['list_name']; ?></h1>
            <h3 style="color: gray;"><?php echo $user['user_id']; ?></h3>

            <?php echo make_follow_button($con, $userid , $_SESSION["uid"]);  ?>
            <div>
            يتابع<button type="button" class="btn "><?php echo '<div class="ddddf">'.NUmberFolloingME($con, $userid).'</div>'; ?></button>
                المتابعين <button type="button" class="btn "><?php echo '<div class="ddddf">'. NumberImFolloing($con, $userid).'</div>'; ?></button>
                <br>

            </div>
            <div>

                <p>
                    <span class="ddddf">الوصف :</span> <?php
                            if (isset($profal['boi'])) {
                                echo $profal['boi'];
                            } else {
                                echo 'لايوجد';
                            }
                            ?>
                </p>
            </div>
        </div>



    </div>

    <hr>

    <div class="text-center navbarforsu ">
        <a class="btn btn-primary" style="  font-weight: bold;" href="sh_pr_us.php?do=cv&userid=<?php echo $userid; ?>">معـلومات</a>
        <a class="btn btn-primary" style="  font-weight: bold;" href="sh_pr_us.php?do=postes&userid=<?php echo $userid; ?>">مـنشورات</a>
        <a class="btn btn-primary" style="  font-weight: bold;" href="sh_pr_us.php?do=skills&userid=<?php echo $userid; ?>">مهـارات</a>
    </div>
    <hr>

    <!-- ------------------------------------------------------------------------------ -->

    <?php
    $swach = isset($_GET['do']) ? $_GET['do'] : 'cv';
    if ($swach == 'cv') {
        include 'viweprofal/cv_viwe.php';
    } elseif ($swach == 'postes') {
        include 'viweprofal/post_viwe.php';
    } elseif ($swach == 'skills') {
        include 'viweprofal/skills.php';
    }
    ?>


</div>

<input id="fortest" type="hidden" value="<?php echo $userid; ?>">
<!-- هذه النبت ارسل بي الايدي خاص للاي ناشر البوست  -->

<?php
include $tpl . 'footer.php';
?>

<script>
    //   thumbails gallery v21

    var numOfThumbnails = $('.thumbnails').children().length; //جبت رقم الاطفال يعني شكم صوره عندي
    var margenbuttonthumbaols = '.5'; // هنا مارجن الي نريد نخلي
    var totlemargenbuttonthumbaols = (numOfThumbnails - 1) * margenbuttonthumbaols;
    //  هنا المارجن ناقص واحد من عدد الكلي نضربه بالمارجن الي نريده
    var themwidth = (100 - totlemargenbuttonthumbaols) / numOfThumbnails;
    // هنا الوث ميه بالميه ناقص حجم مارجن الكلي نوب نقسمه ع عددالصور

    $('.thumbnails img').css({
        'width': themwidth + '%',
        'margin-right': margenbuttonthumbaols + '%'
    });

    $('.thumbnails img').on('click', function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        //   $('.master-img img').attr('src',$(this).attr('src'));/*  بدون انميشن */

        $('.master-img img').hide().attr('src', $(this).attr('src')).fadeIn(500);

    });

    //    هنا علمود الاسهم يسره ويمنه
    $('.master-img  .right').on('click', function() {

        if ($('.thumbnails  .selected').is(':last-child')) {
            $('.thumbnails img').eq(0).click();
        } else {
            $('.thumbnails .selected').next().click();
        }

    });

    $('.master-img  .left').on('click', function() {

        if ($('.thumbnails  .selected').is(':first-child')) {
            $('.thumbnails img:last').click();
        } else {
            $('.thumbnails .selected').prev().click();
        }

    });
</script>

<!-- تابع للصفحه الرئيسيه  -->
<script>
    fetch_my_post();

    function fetch_my_post() {
        var data = 'fetch_my_post';
        var userid = $('#fortest').val();
        $.ajax({
            url: 'functonforviw.php',
            method: "POST",
            data: {
                data: data,
                userid: userid
            },
            success: function(data) {
                $('#my_post_list_voiw').html(data);
            }
        })
    }

    // ---------------------------------------------------------------------------------------------------

    //  تعليقات
    var post_id;
    var user_id;

    $(document).on('click', '.post_comment', function() {
        post_id = $(this).attr('id');
        user_id = $(this).data('user_id');
        var data = 'fetch_comment';
        $.ajax({
            url: "functonforviw.php",
            method: "POST",
            data: {
                post_id: post_id,
                user_id: user_id,
                data: data
            },
            success: function(data) {
                $('#old_comment' + post_id).html(data);
                $('#comment_form' + post_id).slideToggle('slow');
            }
        })
    });

    $(document).on('click', '.submit_comment', function() {
        var comment = $('#comment' + post_id).val();
        var data = 'submit_comment';
        var receiver_id = user_id;
        if (comment != '') {
            $.ajax({
                url: "functonforviw.php",
                method: "POST",
                data: {
                    post_id: post_id,
                    receiver_id: receiver_id,
                    comment: comment,
                    data: data
                },
                success: function(data) {
                    $('#comment_form' + post_id).slideUp('slow');
                    fetch_my_post();
                }
            })
        }
    });
    // ---------------------------------------------------------------------------------------------------
    //  لايك للمنشور
    $(document).on('click', '.like_button', function() {
        var post_id = $(this).data('post_id');
        var data = 'like';
        $.ajax({
            url: "functonforviw.php",
            method: "POST",
            data: {
                post_id: post_id,
                data: data
            },
            success: function(data) {
                alert(data);
                fetch_my_post();
            }
        })
    });



    // هنا نجيب التايتل بحيث نجيب من العدد من الداتا

    function fetch_post_like_user_list() {
        var fetch_data = '';
        var element = $(this);
        var post_id = element.data('post_id');
        var data = 'like_user_list';
        $.ajax({
            url: "functonforviw.php",
            method: "POST",
            async: false,
            data: {
                post_id: post_id,
                data: data
            },
            success: function(data) {
                fetch_data = data;
            }
        });
        return fetch_data;
    }


    //  حذف المنشور

    $(document).on('click', '.delet_post', function() {
        var post_id = $(this).data('post_id');
        var data = 'delete_post';
        $.ajax({
            url: "functonforviw.php",
            method: "POST",
            data: {
                post_id: post_id,
                data: data
            },
            success: function(data) {
                alert("delet ok");
                fetch_my_post();
            }
        })
    });
    // -------------------------------------------------------

    // ---------------------------------------------------------------------------------------------------------
    // هنا علمود اهتمام 


    $(document).on('click', '.action_button_care_2', function() {
        var sender_id = $(this).data('sender_id');
        var action = $(this).data('action');
        $.ajax({
            url: "fetch_data.php",
            method: "POST",
            data: {
                sender_id: sender_id,
                action: action
            },
            success: function(data) {
                fetch_my_post()
            }
        })
    });
    // ---------------------------------------------------------------------------------------------------------
    // هنا علمود حفظ 
    $(document).on('click', '.action_button_save_2', function() {
        var sender_id = $(this).data('sender_id');
        var action = $(this).data('action');
        $.ajax({
            url: "fetch_data.php",
            method: "POST",
            data: {
                sender_id: sender_id,
                action: action
            },
            success: function(data) {
                fetch_my_post()
            }
        })
    });
  
    // ---------------------------------------------------------------------------------------------------
// علمود الفولو
    $(document).on('click', '.action_button', function() {
            var sender_id = $(this).data('sender_id');
            var action = $(this).data('action');
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    sender_id: sender_id,
                    action: action
                },
                success: function(data) {
                   
                }
            })
        });
</script>