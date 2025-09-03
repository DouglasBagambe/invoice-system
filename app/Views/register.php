<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url()?>/public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>/public/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url()?>/public/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>/public/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url()?>/public/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
	.input-group{
		margin-left:32px;
	}
	#try
	{
		margin-left: 30%;
	}
	.error-message {
		color: red;
		font-size: 12px;
		margin-top: 5px;
		display: none;
	}
	.success-message {
		color: green;
		font-size: 14px;
		margin-top: 10px;
		text-align: center;
	}
	.help-block {
		font-size: 12px;
		color: #666;
		margin-top: 5px;
	}
</style>
</head>
<body class="hold-transition register-page" align="center">
<div class="register-box">
  </div>
  <!-- /.register-logo -->

 
        <div class="col-md-4" id="try">
          <!-- general form elements -->
          <div class="box box-info"  style="box-shadow: 5px 10px 8px #888888;">
            
 	</br></br>
  	<div align="center">
  	<img src ="<?= base_url()?>/public/dist/img/Emax_logo.jpg" class="" alt="Emax Logo" height="150" width="210"></div>
  </br>
    <p class="login-box-msg">Create your account</p>

    <form action="" method="post" role="form" id="registerForm">
    <div class="box-body">
      
      <!-- Email Field (Required) -->
      <div class="form-group">
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control col-sm-8" required="required" placeholder="Email Address *">
        </div>
        <div id="emailError" class="error-message"></div>
      </div>

      <!-- First Name Field (Optional) -->
      <div class="form-group">
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="first_name" id="first_name" class="form-control col-sm-8" placeholder="First Name">
        </div>
        <div id="firstNameError" class="error-message"></div>
      </div>

      <!-- Last Name Field (Optional) -->
      <div class="form-group">
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="last_name" id="last_name" class="form-control col-sm-8" placeholder="Last Name">
        </div>
        <div id="lastNameError" class="error-message"></div>
      </div>

      <!-- Password Field (Required) -->
      <div class="form-group">
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" name="password" id="password" class="form-control col-sm-8" required="required" placeholder="Password *">
        </div>
        <div id="passwordError" class="error-message"></div>
      </div>

      <!-- Confirm Password Field (Required) -->
      <div class="form-group">
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control col-sm-8" required="required" placeholder="Confirm Password *">
        </div>
        <div id="confirmPasswordError" class="error-message"></div>
      </div>

      <!-- Signature Field (Optional) -->
      <div class="form-group">
        <div class="input-group col-sm-10">
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <input type="file" name="signature" id="signature" class="form-control col-sm-8" accept="image/*" placeholder="Upload Signature (Optional)">
        </div>
        <div id="signatureError" class="error-message"></div>
        <small class="help-block" style="margin-left: 32px; color: #666;">You can add your signature now or later from your profile</small>
      </div>
        <!-- /.col -->
        <div class="box-footer" style="margin-right: 10px; ">
              <label class="col-sm-1"></label>
              <input type="submit" name="register" value="Register" class="btn btn-info col-sm-10" id="submit"></br>
              <div id="registerMessage" style="margin-top: 10px;"></div>
        </div>
        
        <!-- Login Link -->
        <div class="box-footer" style="text-align: center; padding-top: 0;">
            <p>Already have an account? <a href="<?= base_url('/login') ?>" class="text-center">Sign In</a></p>
        </div>
    </div>
              
</div>
    </form>
</div></div>

<!-- jQuery 3 -->
<script src="<?= base_url()?>/public/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url()?>/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= base_url()?>/public/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script>
  var base_url = "<?= base_url(); ?>"; 
</script>
<script>
  $(document).ready(function() {
    
    // Real-time validation
    $('#email').on('blur', function() {
        validateEmail();
    });
    
    $('#password').on('blur', function() {
        validatePassword();
    });
    
    $('#confirm_password').on('blur', function() {
        validateConfirmPassword();
    });

    function validateEmail() {
        var email = $('#email').val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email) {
            showError('emailError', 'Email is required');
            return false;
        } else if (!emailRegex.test(email)) {
            showError('emailError', 'Please enter a valid email address');
            return false;
        } else {
            hideError('emailError');
            return true;
        }
    }
    
    function validatePassword() {
        var password = $('#password').val();
        
        if (!password) {
            showError('passwordError', 'Password is required');
            return false;
        } else if (password.length < 6) {
            showError('passwordError', 'Password must be at least 6 characters long');
            return false;
        } else {
            hideError('passwordError');
            return true;
        }
    }
    
    function validateConfirmPassword() {
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();
        
        if (!confirmPassword) {
            showError('confirmPasswordError', 'Please confirm your password');
            return false;
        } else if (password !== confirmPassword) {
            showError('confirmPasswordError', 'Passwords do not match');
            return false;
        } else {
            hideError('confirmPasswordError');
            return true;
        }
    }
    
    function showError(elementId, message) {
        $('#' + elementId).text(message).show();
    }
    
    function hideError(elementId) {
        $('#' + elementId).hide();
    }

    // Form submission
    $("#registerForm").submit(function(e) {
        e.preventDefault(); // Prevent form from submitting normally

        // Validate all fields
        var isValid = true;
        isValid = validateEmail() && isValid;
        isValid = validatePassword() && isValid;
        isValid = validateConfirmPassword() && isValid;
        
        if (!isValid) {
            return false;
        }

        var email = $('#email').val();
        var firstName = $('#first_name').val();
        var lastName = $('#last_name').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();
        var signatureFile = $('#signature')[0].files[0];

        var formData = new FormData();
        formData.append('email', email);
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('password', password);
        formData.append('confirm_password', confirmPassword);
        
        // Add signature file if provided
        if (signatureFile) {
            formData.append('signature', signatureFile);
        }

        // Disable submit button to prevent double submission
        $('#submit').prop('disabled', true).val('Registering...');

        $.ajax({
            url: base_url + '/login/userregister',
            type: "POST",
            data: formData,
            dataType: "json",
            processData: false,  // Prevent jQuery from processing data
            contentType: false,  // Prevent setting contentType header
            success: function(response) {
                if (response.status == "success") {
                    console.log("Registration success");
                    $("#registerMessage").html('<span style="color: green;">' + response.message + '</span>');
                    setTimeout(function() {
                        window.location.href = base_url + "/dashboard";
                    }, 1500);
                } else {
                    $("#registerMessage").html('<span style="color: red;">' + response.message + '</span>');
                    $('#submit').prop('disabled', false).val('Register');
                }
            },
            error: function(xhr) {
                console.log("AJAX error: ", xhr.responseText); // Debugging log
                $("#registerMessage").html('<span style="color: red;">Something went wrong! Please try again.</span>');
                $('#submit').prop('disabled', false).val('Register');
            }
        });
    });
});
</script>
</body>
</html>
