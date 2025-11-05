<div class="heading_box"><h3><i class="fas fa-at"></i> Contact <?php echo $settings['site_name']; ?></h3></div>
<?php 
$postData = $statusMsg = '<div class="info-msg">
  <p>
  <i class="fa fa-info-circle"></i> Please enter your details and complete the Contact form to send us a message.
  </p>
  </div>'; 
$status = 'error'; 
 
// If the form is submitted 
if(isset($_POST['submit'])){ 
$postData = $_POST; 
     
// Validate form fields 
if(!empty($_POST['fullname']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])){ 
         
// Validate reCAPTCHA box 
if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){ 

// Google reCAPTCHA API secret key 
$secretKey = ''. $settings['site_recaptchasecret'].''; 
             
// Verify the reCAPTCHA response 
$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
             
// Decode json data 
$responseData = json_decode($verifyResponse); 
             
// If reCAPTCHA response is valid 
if($responseData->success){ 
                
// Posted form data
$department = !empty($_POST['department'])?$_POST['department']:''; 
$fullname = !empty($_POST['fullname'])?$_POST['fullname']:''; 
$email = !empty($_POST['email'])?$_POST['email']:''; 
$subject = !empty($_POST['subject'])?$_POST['subject']:''; 
$message = !empty($_POST['message'])?$_POST['message']:''; 
                 
// Send email notification to the site admin 
$to = ''.$settings['site_email'].''; 
$subject = ''.$settings['site_name'].' Contact From: '.$fullname.''; 
$htmlContent = "  
<p><b>Department: </b>".$department."</p>
<p><b>Full Name: </b>".$fullname."</p> 
<p><b>Email Address: </b>".$email."</p> 
<p><b>Subject: </b>".$subject."</p> 
<p><b>Message: </b>".$message."</p> "; 
                 
// Always set content-type when sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
// More headers 
$headers .= 'From:'.$fullname.' <'.$email.'>' . "\r\n"; 
                 
// Send email 
@mail($to,$subject,$htmlContent,$headers); 

// Send email confirmation to the user 
$to = ''.$email.''; 
$subject = ''.$settings['site_name'].' Contact Confirmation.'; 
$htmlContent = "  
Dear ".$fullname.", Thank You for contacting ".$settings['site_name'].", We have received your Contact Form message and will respond to you soon.
<br />
<br />
This email address is not monitored so replies will not be received."; 
                 
// Always set content-type when sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
// More headers 
$headers .= 'From:noreply@'.$_SERVER['SERVER_NAME'] .'' . "\r\n"; 
                 
// Send email 
@mail($to,$subject,$htmlContent,$headers); 
                 
$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Thank You, We have received your message and will reply to you soon.</div>'; 
$postData = '';
}else{ 
$statusMsg = '<div class="warning-msg">
<p><i class="fa fa-warning"></i> Robot verification failed, please try again.</div>'; 
} 
}else{ 
$statusMsg = '<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Please check on the reCAPTCHA box.</div>'; 
} 
}else{ 
$statusMsg = '<div class="warning-msg">
<p><i class="fa fa-warning"></i> Please fill all the mandatory fields marked with *.</div>'; 
} 
} 
?>
<?php if(!empty($statusMsg)){ ?>
    <p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form action="" method="post">
<table width="578">
<tr>
<td width="19%"><p><strong>Department</strong></p></td>
<td width="81%"><label for="department"></label>
<select name="department" id="department">
<option value="Webmaster">Webmaster</option>
</select></td>
</tr>
<tr>
<td><p><strong>Fullname*</strong></p></td>
<td><label for="fullname"></label>
<input type="text" name="fullname" value="<?php echo !empty($postData['fullname'])?$postData['fullname']:''; ?>" required id="fullname"></td>
</tr>
<tr>
<td><p><strong>Email Address*</strong></p></td>
<td><label for="email"></label>
<input type="text" name="email" value="<?php echo !empty($postData['email'])?$postData['email']:''; ?>" required id="email"></td>
</tr>
<tr>
<td><p><strong>Subject*</strong></p></td>
<td>
<label for="subject"></label>
<input type="text" name="subject" value="<?php echo !empty($postData['subject'])?$postData['subject']:''; ?>" required id="subject" />
</td>
</tr>
<tr>
<td valign="top"><p><strong>Message*</strong></p></td>
<td><label for="message"></label>
<textarea name="message" cols="45" rows="3" required <?php echo !empty($postData['message'])?$postData['message']:''; ?> id="message"></textarea></td>
</tr>
<tr>
<td><p>&nbsp;</p></td>
<td><div class="g-recaptcha" data-sitekey="<?php echo $settings['site_recaptcha_publickey'] ?>"></div></td>
</tr>
<tr>
<td><p>&nbsp;</p></td>
<td><input type="submit" name="submit" id="submit" value="Send Message"></td>
</tr>
</table>
</form>