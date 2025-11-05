<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' && $_SESSION['admin_level'] != 'Staff')
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box">
<h3><i class="fas fa-id-card"></i> <b>Edit Profile For <?php echo $_SESSION['admin_username'] ?></b></h3></div>
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> Please enter your new Email Address to Update.</p></div>'; 

$admin_id = $_SESSION['admin_id'];
$result = mysqli_query($conn, "SELECT * FROM `admins` WHERE `admin_id` = $admin_id")
or die(mysqli_error()); 
$row = mysqli_fetch_array($result);
{

if (isset($_POST['update_admin_email'])) {
	
$postData = $_POST; 

if(!empty($_POST['admin_email']))

if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$admin_email = $_POST['admin_email'];

mysqli_query($conn, "Update `admins`
SET 
admin_email = '$admin_email'

WHERE 
admin_id = '$admin_id'");

if ($conn) {
$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Email Address has been Updated to '.$admin_email.'.</p></div>'; 
} 
else 
{
$status = 'error';
$statusMsg = '<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Email Addres has not been Updated.</p>';
}
}
}
?>
<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Edit Email Address</h3></td>
</tr>
<tr>
<td>
<label for="admin_email"></label>
<input name="admin_email" type="text" id="admin_email" value="<?php echo $row['admin_email']; ?>" /></td>
</tr>
<tr>
<td>
<input type="submit" name="update_admin_email" id="update_admin_email" value="Update Email" /></td>
</tr>
</table>
</form>
<hr />
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> Please enter your new Password to Update.</p></div>'; 

$admin_id = $_SESSION['admin_id'];
$result = mysqli_query($conn, "SELECT * FROM `admins` WHERE `admin_id` = $admin_id")
or die(mysqli_error()); 
$row = mysqli_fetch_array($result);
{

if (isset($_POST['update_admin_password'])) {
	
$postData = $_POST; 

if(!empty($_POST['admin_password']))

if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$admin_password = $_POST['admin_password'];

mysqli_query($conn, "Update `admins`
SET 
admin_password = '" . sha1($_POST['admin_password']) . "'

WHERE 
admin_id = '$admin_id'");

if ($conn) {
$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Password has been Updated, Please logout and login again.</p></div>'; 
} 
else 
{
$status = 'error';
$statusMsg = '<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Password has not been Updated.</p>';
}
}
}
?>
<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Edit Password</h3></td>
</tr>
<tr>
<td>
<label for="admin_password"></label>
<input name="admin_password" type="password" id="admin_password" value="<?php echo $row['admin_password']; ?>" /></td>
</tr>
<tr>
<td>
<input type="submit" name="update_admin_password" id="update_admin_password" value="Update Password" /></td>
</tr>
</table>
</form>
<?php
}
?>