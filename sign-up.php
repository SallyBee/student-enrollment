<?php
session_start();
require_once('class.user.php');
$user = new USER();

if($user->is_loggedin()!="")
{
	$user->redirect('home.php');
}

if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['txt_uname']);
	$umail = strip_tags($_POST['txt_umail']);
	$upass = strip_tags($_POST['txt_upass']);
	$fname = strip_tags($_POST['txt_fname']);
	$lname = strip_tags($_POST['txt_lname']);
	$dob   = strip_tags($_POST['txt_dob']);
	$department = strip_tags($_POST['txt_department']);
	$level = strip_tags($_POST['txt_level']);
	$phone = strip_tags($_POST['txt_phone']);
	$hostel = strip_tags($_POST['txt_hostel']);
	$tuition_amt = strip_tags($_POST['txt_tuition_amt']);
	$name_of_spon = strip_tags($_POST['txt_name_of_spon']);
	$phone_num_spon = strip_tags($_POST['txt_phone_num_spon']);
	$gender = strip_tags($_POST['txt_gender']);
	
	if($uname=="")	{
		$error[] = "provide username !";	
	}
	else if ($fname == "") {
		$error[] = "provide first name";
	}
	else if($umail=="")	{
		$error[] = "provide email id !";	
	}
	else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = 'Please enter a valid email address !';
	}
	else if($upass=="")	{
		$error[] = "provide password !";
	}
	else if(strlen($upass) < 6){
		$error[] = "Password must be atleast 6 characters";	
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_name, user_email FROM users WHERE user_name=:uname OR user_email=:umail");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['user_name']==$uname) {
				$error[] = "sorry username already taken !";
			}
			else if($row['user_email']==$umail) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				if($user->register($uname,$umail,$upass,$fname,$lname,$dob,$department,$level,$phone,$hstel,$tuition_amt,$name_of_spon,$phone_num_spon,$gender)){	
					$user->redirect('sign-up.php?joined');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coding Cage : Sign up</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Sign up.</h2><hr />
            <?php
			if(isset($error))
			{
			 	foreach($error as $error)
			 	{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
				}
			}
			else if(isset($_GET['joined']))
			{
				 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
			}
			?>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $umail;}?>" />
            </div>
            <div class="form-group">
            	<input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_fname" placeholder="First Name" value="<?php if(isset($error)){echo $fname;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_lname" placeholder="Last Name" value="<?php if(isset($error)){echo $lname;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_dob" placeholder="Date of birth" value="<?php if(isset($error)){echo $dob;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_department" placeholder="Department" value="<?php if(isset($error)){echo $department;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_level" placeholder="Level" value="<?php if(isset($error)){echo $level;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_phone" placeholder="Phone" value="<?php if(isset($error)){echo $phone;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_hostel" placeholder="Hostel" value="<?php if(isset($error)){echo $tuition_amt;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_tuition_amt" placeholder="Tuition" value="<?php if(isset($error)){echo $hostel;}?>" />
            </div>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_name_of_spon" placeholder="Sponsor" value="<?php if(isset($error)){echo $name_of_spon;}?>" />
            </div>

            <!-- -->
            <div class="form-group">
            <input type="text" class="form-control" name="txt_phone_num_spon" placeholder="Phone number of sponsor" value="<?php if(isset($error)){echo $phone_num_spon;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_gender" placeholder="Gender" value="<?php if(isset($error)){echo $gender;}?>" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
            	<button type="submit" class="btn btn-primary" name="btn-signup">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ! <a href="index.php">Sign In</a></label>
        </form>
       </div>
</div>

</div>

</body>
</html>