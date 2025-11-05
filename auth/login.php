<div class="heading_box"><h3><b><i class="fas fa-lock"></i> <?php echo $settings['site_name']; ?> Account Login</b></h3></div>
<?php
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
echo '
<p>Hi:' . $_SESSION['admin_username'] . ' You are already Logged in to your account.</p>
';
}
else
{
if($_SERVER['REQUEST_METHOD'] != 'POST')
{ ?> 

<form id="form1" method="post" action="">
<table width="468" border="0">
<tr>
<td width="126"><p><strong>Account Email</strong></p></td>
<td width="332"><p>
<input name="admin_email" type="text" required id="admin_email" />
</p>
</td>
</tr>
<tr>
<td><p><strong>Admin Password</strong></p></td>
<td><p>
<input type="password" required name="admin_password" id="admin_password" />
</p>
</td>
</tr>
<tr>
  <td><p>&nbsp;</p></td>
  <td><p>
  <input name="submit" type="submit" class="searchbutton" id="submit" value="Login" /> 
  </td>
</tr>
</table>
</form>
<?php 
}
else
{
$errors = array(); 
if(!isset($_POST['admin_email']))
{
$errors[] = 'The Email field must not be empty.';
}
if(!isset($_POST['admin_password']))
{
$errors[] = 'The Password field must not be empty.';
}
if(!empty($errors))
{
echo 'A couple of fields are not filled in correctly.<br /><br />';
echo '<ul>';
foreach($errors as $key => $value)
{
echo '<li>' . $value . '</li>'; 
}
echo '</ul>';
}
else
{
$sql = "SELECT 
admin_id,
admin_username,
admin_email,
admin_datereg,
admin_datelast,
admin_role,
admin_level,
admin_active
FROM
admins
WHERE
admin_email = '" . mysqli_real_escape_string($conn, $_POST['admin_email']) . "'
AND
admin_password = '" . sha1($_POST['admin_password']) . "'
AND
admin_active = '" . mysqli_real_escape_string($conn, 'Active') . "'";
$result = mysqli_query($conn, $sql);
if(!$result)
{
echo '
<p>
<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Something went wrong while logging in. Please try again later.</div>';
}
else
{
if(mysqli_num_rows($result) == 0)
{
echo '
<p>
<div class="error-msg">
<p><i class="fa fa-times-circle"></i>
Account details for '.$_POST['admin_email'].' incorrect please try again.
<br />
<br />
If these details are correct please double check and try again.
</div>';
}
else
{
$_SESSION['signed_in'] = true;
while($row = mysqli_fetch_assoc($result))
{
$_SESSION['admin_id'] 	= $row['admin_id'];
$_SESSION['admin_username'] 	= $row['admin_username'];
$_SESSION['admin_email'] 	= $row['admin_email'];
$_SESSION['admin_datereg'] 	= $row['admin_datereg'];
$_SESSION['admin_datelast'] = $row['admin_datelast'];
$_SESSION['admin_role'] = $row['admin_role'];
$_SESSION['admin_level'] = $row['admin_level'];
$_SESSION['admin_active'] = $row['admin_active'];
}
echo("<script>location.href = 'index.php';</script>");

$date = date("d/m/Y H:i:s A");
mysqli_query($conn, "Update admins
SET  
admin_datelast = '$date'
WHERE 
admin_id='$_SESSION[admin_id]'");

}
}
}
}
}
?>	