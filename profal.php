<?php
session_start();
$pageTitle = 'Myprofal';
if (!isset($_SESSION['uid'])) {
    include "login.php";
}
include 'init.php';
$sessionUser = $_SESSION['uid'];
$stmt = $con->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute(array($sessionUser));
$rows = $stmt->fetch();

$contfollwingme = $con->prepare("SELECT * FROM follow WHERE sender_id='" . $_SESSION["uid"] . "' ");
$contfollwingme->execute();
$folowme = $contfollwingme->rowCount();

$contamfollwing = $con->prepare("SELECT * FROM follow WHERE receiver_id='" . $_SESSION["uid"] . "' ");
$contamfollwing->execute();
$imfolow = $contamfollwing->rowCount();


?>

<div>
    <div class="pronav" style="margin-bottom: 10px;margin-top: 10px;">
        <ul class="nav justify-content-center">
            <li class="nav-item" style="color: black;">
                <a class="nav-link "  aria-current="page" href="profal.php?do=Manage"><i class="fa-solid fa-house"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  href="profal.php?do=mycv"><i class="fa-solid fa-address-book"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  href="profal.php?do=fo"><i class="fa-solid fa-file-circle-plus"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  href="profal.php?do=sv" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-paste"></i></a>
            </li>
        </ul>
    </div>
    <!-- ------------------------ -->
    <div class="">
        <?php
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        if ($do == 'Manage') {
            include 'profal/manage.php';
        } elseif ($do == 'mycv') {
            include 'profal/edat.php';
        } elseif ($do == 'fo') {
            include 'profal/folders.php';
        } elseif ($do == 'sv') {
            include 'profal/save_posts.php';
        }
        ?>
    </div>

</div>


<!-- --------------------------------------------------------- -->

<?php include $tpl . 'footer.php';   ?>


<script>
    $(document).ready(function() {
  
        //  -----------------------------------------------------------------------------
        //  ارسال البيانات
        $("#edat_send_all").on("click", function(e) {
            e.preventDefault();
            $.ajax({
                url: "function.php",
                method: "POST",
                data: $('#edat_form').serialize(),
                success: function(date) {
                    alert("تم التعديل");
                }
            });
        });
        // -------------------------------------------------------------------------
        $(document).ready(function() {
            var i = 1;
            $('#add').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="skill[]" placeholder="اسم المهاره" class="form-control name_list" /> 	<td> <select name="rang[]" id="cars"><option value="قليل">قليل</option><option value="جيد">جيد</option><option value="جيد جدا">جيد جدا</option><option value="ممتاز">ممتاز</option></select></td> </td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

            $('#submit').click(function() {
                $.ajax({
                    url: "function.php",
                    method: "POST",
                    data: $('#add_name').serialize(),
                    success: function(data) {
                        alert(data);
                        $('#add_name')[0].reset();
                        fetch_skills();

                    }
                });
            });
        });

        // -----------------------------------------------------------------------------------------
        fetch_skills();

        function fetch_skills() {
            var action = 'fetch_skill';
            $.ajax({
                url: 'function.php',
                method: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#table_data_skills').html(data);
                }
            })
        }

        // ------------------------------------------------------------
        //  حذف المهارات 
        $(document).on("click", ".delete-btn", function() {
            var action = 'delete_skill';
            var stid = $(this).data("id");
            //  alert(stid);
            $.ajax({
                url: "function.php",
                method: "GET",
                data: {
                    "id": stid,
                    action: action
                },
                success: function(date) {
                    fetch_skills();
                }
            });
        });

        //  -------------------------------------------------------
        // حفظ الصور

        $('#uuuuu').click(function() {

            var form_data = new FormData();
            var files = $('#multiple_files')[0].files;

            for (var i = 0; i < files.length; i++) {
                form_data.append("file[]", document.getElementById('multiple_files').files[i]);
            }
            $.ajax({
                url: "function.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    alert("تم الحفظ");
                    load_image_data();
                }
            });
        });
        // نجيب الصور


        load_image_data();

        function load_image_data() {
            var action = 'load_image_data';
            $.ajax({

                url: "function.php",
                method: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#image_profal').html(data);
                }
            });
        }

        // نحذف الصور
        $(document).on('click', '.delete', function() {
            var image_id = $(this).attr("id");
            var image_name = $(this).data("image_name");
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "function.php",
                    method: "POST",
                    data: {
                        image_id: image_id,
                        image_name: image_name
                    },
                    success: function(data) {
                        load_image_data();
                        alert("Image removed");
                    }
                });
            }
        });

        // -----------------------------------------------------------------------------------------------------


        //  ارسال البي دي اف

        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "function.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    load_pdf_data();
                    alert("تم الحفظ");
                }
            });
        });



        load_pdf_data();

        function load_pdf_data() {
            var action = 'load_pdf_data';
            $.ajax({

                url: "function.php",
                method: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#pdf_get').html(data);
                }
            });
        }


        // نحذف الملف
        $(document).on('click', '.deletepdf', function() {
            var image_id = $(this).attr("id");
            var image_name = $(this).data("image_name");
            if (confirm("Are you sure you want to remove it?")) {
                $.ajax({
                    url: "function.php",
                    method: "POST",
                    data: {
                        image_id: image_id,
                        image_name: image_name
                    },
                    success: function(data) {
                        load_pdf_data();
                        alert("Image removed");
                    }
                });
            }
        });


    });
</script>

<!-- تابع للصفحه الرئيسيه  -->
<script>
    fetch_my_post();

    function fetch_my_post() {
        var data = 'fetch_my_post';
        $.ajax({
            url: 'function.php',
            method: "POST",
            data: {
                data: data
            },
            success: function(data) {
                $('#my_post_list').html(data);
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
            url: "function.php",
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
                url: "function.php",
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
            url: "function.php",
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
            url: "function.php",
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
            url: "function.php",
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
</script>


<!--  
                *********************  بيانات المحفوظه   *********************
                *********************                     *********************
                
                                           -->

<script>
    $(document).ready(function() {
        // جلب البيانات
        fetch_save_post();

        function fetch_save_post() {
            var action = 'fetch_post';
            $.ajax({
                url: 'save_posts.php',
                method: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#post_list_save').html(data);
                }
            })
        }

        // ---------------------------------------------------------------------------------------------------------
        // هنا علمود اهتمام 


        $(document).on('click', '.action_button_care', function() {
            var sender_id = $(this).data('sender_id');
            var action = $(this).data('action');
            $.ajax({
                url: "save_posts.php",
                method: "POST",
                data: {
                    sender_id: sender_id,
                    action: action
                },
                success: function(data) {
                    fetch_save_post();
                }
            })
        });
        // ---------------------------------------------------------------------------------------------------------
        // هنا علمود حفظ 


        $(document).on('click', '.action_button_save', function() {
            var sender_id = $(this).data('sender_id');
            var action = $(this).data('action');
            $.ajax({
                url: "save_posts.php",
                method: "POST",
                data: {
                    sender_id: sender_id,
                    action: action
                },
                success: function(data) {
                    fetch_save_post();
                }
            })
        });
        // ---------------------------------------------------------------------------------------------------

        //  تعليقات
        var post_id;
        var user_id;

        $(document).on('click', '.post_comment_save', function() {
            post_id = $(this).attr('id');
            user_id = $(this).data('user_id');
            var action = 'fetch_comment';
            $.ajax({
                url: "save_posts.php",
                method: "POST",
                data: {
                    post_id: post_id,
                    user_id: user_id,
                    action: action
                },
                success: function(data) {
                    $('#old_comment' + post_id).html(data);
                    $('#comment_form' + post_id).slideToggle('slow');
                }
            })
        });

        $(document).on('click', '.submit_comment_save', function() {
            var comment = $('#comment' + post_id).val();
            var action = 'submit_comment';
            var receiver_id = user_id;
            if (comment != '') {
                $.ajax({
                    url: "save_posts.php",
                    method: "POST",
                    data: {
                        post_id: post_id,
                        receiver_id: receiver_id,
                        comment: comment,
                        action: action
                    },
                    success: function(data) {
                        $('#comment_form' + post_id).slideUp('slow');
                        fetch_save_post();
                    }
                })
            }
        });


        // ---------------------------------------------------------------------------------------------------


        //  لايك للمنشور


        $(document).on('click', '.like_button_save', function() {
            var post_id = $(this).data('post_id');
            var action = 'like';
            $.ajax({
                url: "save_posts.php",
                method: "POST",
                data: {
                    post_id: post_id,
                    action: action
                },
                success: function(data) {
                    alert(data);
                    fetch_save_post();
                }
            })
        });

        // علمود من تخلي المؤشر عل اللايك يطلع اسامي الي خالين لايك

        $('body').tooltip({
            selector: '.like_button',
            title: fetch_post_like_user_list,
            html: true,
            placement: 'top'
        });

        // هنا نجيب التايتل بحيث نجيب من العدد من الداتا

        function fetch_post_like_user_list() {
            var fetch_data = '';
            var element = $(this);
            var post_id = element.data('post_id');
            var action = 'like_user_list';
            $.ajax({
                url: "save_posts.php",
                method: "POST",
                async: false,
                data: {
                    post_id: post_id,
                    action: action
                },
                success: function(data) {
                    fetch_data = data;
                }
            });
            return fetch_data;
        }


        // --------------------------------------------------------------------------------------------------

        //  حذف المنشور

        $(document).on('click', '.delet_post', function() {
            var post_id = $(this).data('post_id');
            var data = 'delete_post';
            $.ajax({
                url: "save_posts.php",
                method: "POST",
                data: {
                    post_id: post_id,
                    data: data
                },
                success: function(data) {
                    alert("delet ok");
                    fetch_save_post();
                }
            })
        });
        
   

    });
    
</script>