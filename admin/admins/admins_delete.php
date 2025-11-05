<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' )
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box">
<h3><i class="fas fa-users"></i> Delete Admins &amp; Staff</h3></div>
<?php
if (isset($_GET['admin_id']) && is_numeric($_GET['admin_id']))
{
$admin_id = $_GET['admin_id'];
$result = mysqli_query($conn, "DELETE FROM admins WHERE admin_id=$admin_id")
or die(mysqli_error($conn)); 
echo("<script>location.href = 'index.php?admin&page=admins';</script>");
}
else
{
echo("<div class='error-msg'>
<p><i class='fa fa-times-circle'></i><font-color='red' Admin ".$admin_id." could not be deleted.</font></p>");
}
?>
<?php
}
?>
