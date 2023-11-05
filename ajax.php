<script>
    $(document).ready(function() {

        // حفظ البيانات

        $('#post_form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "action.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(data) {
                    alert("تم النشر");
                    $("#post_form").trigger("reset");
                    fetch_post();
                }
            });

        });

        // ---------------------------------------------------------------------------------------------------------

        // جلب البيانات

        fetch_post();

        function fetch_post() {
            var action = 'fetch_post';
            $.ajax({
                url: 'action.php',
                method: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#post_list').html(data);
                }
            })
        }

        // ---------------------------------------------------------------------------------------------------------

        fetch_user();

        // هنا اجيب المستخدمين
        function fetch_user() {
            var action = 'fetch_user';
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#user_list').html(data);
                }
            });
        }

        // ---------------------------------------------------------------------------------------------------------
        // هنا علمود الفولو


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
                    fetch_user();
                    fetch_post();
                }
            })
        });
         // ---------------------------------------------------------------------------------------------------------
        // هنا علمود اهتمام 


        $(document).on('click', '.action_button_care', function() {
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
                    fetch_user();
                    fetch_post();
                }
            })
        });
             // ---------------------------------------------------------------------------------------------------------
        // هنا علمود حفظ 


        $(document).on('click', '.action_button_save', function() {
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
                    fetch_user();
                    fetch_post();
                }
            })
        });
        // ---------------------------------------------------------------------------------------------------

        //  تعليقات
        var post_id;
        var user_id;

        $(document).on('click', '.post_comment', function() {
            post_id = $(this).attr('id');
            user_id = $(this).data('user_id');
            var action = 'fetch_comment';
            $.ajax({
                url: "action.php",
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

        $(document).on('click', '.submit_comment', function() {
            var comment = $('#comment' + post_id).val();
            var action = 'submit_comment';
            var receiver_id = user_id;
            if (comment != '') {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {
                        post_id: post_id,
                        receiver_id: receiver_id,
                        comment: comment,
                        action: action
                    },
                    success: function(data) {
                        $('#comment_form' + post_id).slideUp('slow');
                        fetch_post();
                    }
                })
            }
        });


        // ---------------------------------------------------------------------------------------------------


        //  لايك للمنشور


        $(document).on('click', '.like_button', function() {
            var post_id = $(this).data('post_id');
            var action = 'like';
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    post_id: post_id,
                    action: action
                },
                success: function(data) {
                    alert(data);
                    fetch_post();
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
                url: "action.php",
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
                url: "action.php",
                method: "POST",
                data: {
                    post_id: post_id,
                    data: data
                },
                success: function(data) {
                    alert("delet ok");
                    fetch_post();
                }
            })
        });
        // ---------------------------------------------------------------------------------------


        // ----------------------------------------------------------------------------------------------------------
    });
</script>