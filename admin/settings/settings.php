<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' )
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<script type="text/javascript" src="includes/tiny/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
selector: 'textarea', 
height: 200,
plugins: [
'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'emoticons'
],
toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
'forecolor backcolor emoticons | help',
a_plugin_option: true,
a_configuration_option: 400
});
</script>
<div class="heading_box">
<h3><i class="fas fa-cogs"></i> <b><?php echo $settings['site_name'] ?> Site Settings</b></h3></div>
<?php
if (isset($_POST['update_settings'])) 
{  

if(!empty($_POST['site_name'])
&&
!empty($_POST['site_desc'])
&&
!empty($_POST['site_footer'])
&&
!empty($_POST['site_email'])
&&
!empty($_POST['site_recaptchakey'])
&&
!empty($_POST['site_recaptchasecret']))	

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$site_name = $_POST['site_name'];
$site_desc = $_POST['site_desc'];
$site_footer = $_POST['site_footer'];
$site_email = $_POST['site_email'];
$site_recaptchakey = $_POST['site_recaptchakey'];
$site_recaptchasecret = $_POST['site_recaptchasecret'];

$sql = "UPDATE settings
SET 
site_name = '$site_name',
site_desc = '$site_desc',
site_footer = '$site_footer',
site_email = '$site_email',
site_recaptchakey = '$site_recaptchakey',
site_recaptchasecret = '$site_recaptchasecret'
";

if (mysqli_query($conn, $sql)) {
echo '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Site Settings have been Updated.</div>'; 
} else {
echo "Error updating settings: " . mysqli_error($conn);
}
}
?>
<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Site Name</h3></td>
</tr>
<tr>
<td>
<label for="site_name"></label>
<input name="site_name" type="text" id="site_name" value="<?php echo $settings['site_name']; ?>" /></td>
</tr>
<tr>
<td><h3>Site Homepage Description</h3></td>
</tr>
<tr>
<td>
<label for="site_desc"></label>
<textarea name="site_desc" id="site_desc" cols="45" rows="5"><?php echo $settings['site_desc'] ?></textarea></td>
</tr>
<tr>
<td><h3>Site Footer</h3></td>
</tr>
<tr>
<td>
<label for="site_footer"></label>
<input name="site_footer" id="site_footer" value="<?php echo $settings['site_footer'] ?>" /></td>
</tr>
<tr>
<td><h3>Site Contact Email</h3></td>
</tr>
<tr>
<td>
<label for="site_email"></label>
<input name="site_email" type="text" id="site_email" value="<?php echo $settings['site_email'] ?>" size="30" /></td>
</tr>
<tr>
<td><h3>Site Google Recaptcha Public Key</h3></td>
</tr>
<tr>
<td>
<label for="site_recaptchakey"></label>
<input name="site_recaptchakey" type="text" id="site_recaptchakey" value="<?php echo $settings['site_recaptchakey'] ?>" size="30" /> 
(<a href="https://www.google.com/recaptcha/admin/" target="_blank">Get Keys</a>)</td>
</tr>
<tr>
<td><h3>Site Google Recaptcha Secret Key</h3></td>
</tr>
<tr>
<td>
<label for="site_recaptchasecret"></label>
<input name="site_recaptchasecret" type="text" id="site_recaptchasecret" value="<?php echo $settings['site_recaptchasecret'] ?>" size="30" /></td>
</tr>
<tr>
<td>
<input type="submit" name="update_settings" id="update_settings" value="Update Settings" /></td>
</tr>
</table>
</form>
<?php
}
?>