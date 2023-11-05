



		<div class="footer"></div>
		<script src="<?php echo $js ?>all.min.js"></script>
		<script src="<?php echo $js ?>bootstrap.bundle.min.js"></script>
		<!-- <script src="<?php echo $js ?>bootstrap.bundle.min.js.map"></script> -->
		<script src="<?php echo $js ?>jquery-3.6.0.min"></script>
		<script src="<?php echo $js ?>style.js"></script>
		<script>
			        //   تدحيث الاشعارت المقروئه

			$('#view_notification').click(function() {
            var action = 'update_notification_status';
            $.ajax({
                url: "action.php",
                method: "post",
                data: {
                    action: action
                },
                success: function(data) {
                    $('#total_notification').remove();
                }
            })
        });
		        //   تدحيث الاشعارت المقروئه
		</script>
</body>
</html>