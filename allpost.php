<?php
session_start();
$pageTitle = 'Myprofal';
// if (!isset($_SESSION['uid'])) {
//     include "login.php";
// }
include 'init.php';

?>


<!-- <div class="mb-1 mt-1 container">
    <input type="text" name="search_user" id="search_user" class="form-control input-sm" placeholder="ابحث عن المستخدمين" autocomplete="off" style=" width: 32%; " />
    <div class="list-group mt-3" id="tgtg" style="width: 32%;">
    </div>
</div> -->
<div class="container">
    <div class="row"> 
        <div class="col-md-4 ">
            <input style="background-color: #1C315E;font-size: 25px; color: white; " type="text" name="search_user" id="search_user" class="form-control fgfgggg input-sm mt-3" placeholder="ابحث عن المستخدمين" autocomplete="off" />
            <div class="list-group mt-2 " id="tgtg" style="max-height: 450px; overflow: auto;" >
            </div>
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-header">فلاتر</h5>

                    <?php


                    ?>

                    <!-- -------------------- -->

                    <div class="list-group">
                        <h3>محافظات</h3>
                        <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
                            <?php
                            $query = "SELECT DISTINCT(post_city) FROM post ";
                            $statement = $con->prepare($query);
                            $statement->execute();
                            $result = $statement->fetchAll();
                            foreach ($result as $row) {
                            ?>
                                <div class="list-group-item checkbox">
                                    <label><input type="checkbox" class="common_selector city" value="<?php echo $row['post_city']; ?>"> <?php echo $row['post_city']; ?></label>
                                </div>
                            <?php
                            }

                            ?>
                        </div>
                    </div>

                    <div class="list-group">
                        <h3>نوع النشر</h3>
                        <?php

                        $statement = $con->prepare("SELECT DISTINCT(post_type) FROM post ");
                        $statement->execute();
                        $result = $statement->fetchAll();
                        foreach ($result as $row) {
                        ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector type" value="<?php echo $row['post_type']; ?>"> <?php echo $row['post_type']; ?> </label>
                            </div>
                        <?php
                        }

                        ?>
                    </div>

                    <div class="list-group">
                        <h3>المطلوب</h3>
                        <?php
                        $statement = $con->prepare("SELECT DISTINCT(post_want) FROM post");
                        $statement->execute();
                        $result = $statement->fetchAll();
                        foreach ($result as $row) {
                        ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector want" value="<?php echo $row['post_want']; ?>"> <?php echo $row['post_want']; ?></label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="list-group">
                        <h3>الجنس</h3>
                        <?php
                        $statement = $con->prepare("SELECT DISTINCT(post_gender) FROM post ");
                        $statement->execute();
                        $result = $statement->fetchAll();
                        foreach ($result as $row) {
                        ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector gender" value="<?php echo $row['post_gender']; ?>"> <?php echo $row['post_gender']; ?></label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <!-- ---------------------- -->

                </div>
            </div>
        </div>
        <!-- ---------------------------------------------------------- -->
        <div class="col-md-8">
            <div class="card w-100">
                <div class="card-body ">
                    <h5 class="card-header text-center" style="font-size: 26px; height: 50px;background-color: #1C315E; border-radius: 5px; color: white;">جميع المنشورات</h5>
                    <div id="post_list_all" class='filter_data'></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include $tpl . 'footer.php';

?>


<script>
    filter_data();

    function filter_data() {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'load_all_data';
        var gender = get_filter('gender');
        var city = get_filter('city');
        var type = get_filter('type');
        var want = get_filter('want');
        $.ajax({
            url: "fetch_data.php",
            method: "POST",
            data: {
                action: action,
                gender: gender,
                city: city,
                type: type,
                want: want
            },
            success: function(data) {
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function() {
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function() {
        filter_data();
    });


    // ---------------------------------------------------------------------------------------------------

    //  تعليقات
    var post_id;
    var user_id;

    $(document).on('click', '.post_comment_all', function() {
        post_id = $(this).attr('id');
        user_id = $(this).data('user_id');
        var action = 'fetch_comment_all';
        $.ajax({
            url: "fetch_data.php",
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

    $(document).on('click', '.submit_comment_all', function() {
        var comment = $('#comment' + post_id).val();
        var action = 'submit_comment_all';
        var receiver_id = user_id;
        if (comment != '') {
            $.ajax({
                url: "fetch_data.php",
                method: "POST",
                data: {
                    post_id: post_id,
                    receiver_id: receiver_id,
                    comment: comment,
                    action: action
                },
                success: function(data) {
                    $('#comment_form' + post_id).slideUp('slow');
                    filter_data();
                }
            })
        }
    });


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
                filter_data()
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
                filter_data()
            }
        })
    });
    // ---------------------------------------------------------------------------------------------------


    //  لايك للمنشور


    $(document).on('click', '.like_button', function() {
        var post_id = $(this).data('post_id');
        var action = 'like';
        $.ajax({
            url: "fetch_data.php",
            method: "POST",
            data: {
                post_id: post_id,
                action: action
            },
            success: function(data) {
                alert(data);
                filter_data();
            }
        })
    });

    // علمود من تخلي المؤشر عل اللايك يطلع اسامي الي خالين لايك

    // $('body').tooltip({
    //     selector: '.like_button',
    //     title: fetch_post_like_user_list,
    //     html: true,
    //     placement: 'right'
    // });

    // هنا نجيب التايتل بحيث نجيب من العدد من الداتا

    function fetch_post_like_user_list() {
        var fetch_data = '';
        var element = $(this);
        var post_id = element.data('post_id');
        var action = 'like_user_list';
        $.ajax({
            url: "fetch_data.php",
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
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#search_user").on("keyup", function() {
            var query = $(this).val();
            var action = 'search_user';
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    query: query,
                    action: action
                },
                success: function(date) {
                    $("#tgtg").html(date);
                }
            });
        });
    });
</script>
<!--  فلتره -->