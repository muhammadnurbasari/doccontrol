<!DOCTYPE html>
<html lang="en">
    
<head>
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/matrix-login.css" />
        <link href="<?= base_url('assets/'); ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <link href="<?= base_url('assets/'); ?>notify/PNotifyBrightTheme.css" rel="stylesheet" />
        <script src="<?= base_url('assets/'); ?>js/jquery-3.4.1.min.js"></script>  
</head>
    <body>
        <div id="loginbox">            
            <form class="form-login" method="post" action="<?= base_url('result/login'); ?>">
				 <div class="control-group normal_text"> <h3><i class="icon-th-large"></i> DOC CONTROL APP</h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" placeholder="Username" name="username" autocomplete="off"/>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" placeholder="Password" name="password" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                	<div class="controls">
	                	<div class="main_input_box">
	                		<button class="btn btn-primary submit" type="button">LOGIN</button>
	                	</div>
	                </div>
                </div>
            </form>
        </div>
        
        <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>  
        <script src="<?= base_url('assets/'); ?>js/bootstrap.min.js"></script>  
        <script src="<?= base_url('assets/'); ?>notify/PNotify.js"></script>  
        <script src="<?= base_url('assets/'); ?>js/matrix.login.js"></script>

        <script type="text/javascript">
        	$(document).ready(function() {
        		$('body').on('click','button.submit', function() {
        			var form = $("form.form-login");
        			var here = $(this);
        			var redirect = '<?php echo base_url('result/dashboard'); ?>'
        			$.ajax({
        				url : form.attr('action'),
        				data : form.serialize(),
        				type : 'post',
        				success : function(response) {
        					console.log(response)
        					here.html('LOADING...');
        					setTimeout(function() {
	        					if (response != Number(1)) {
	        						PNotify.error({
	        							text : response
	        						});
        						here.html('LOGIN');
	        					} else {
	        						PNotify.success({
	        							text : 'LOGIN BERHASIL'
	        						});
        							here.html('LOGIN');
	        						setTimeout(function() {
	        							window.location.replace(redirect);
	        						}, 1000);
	        					}
        					}, 1000);
        				}
        			});
        		});
        	});
        </script>

    </body>

</html>
