<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' &&  $_SESSION['admin_level'] != 'Staff')
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box">
<h3><i class="fas fa-book"></i> Delete Category</h3></div>
<?php
if (isset($_GET['doccat_id']) && is_numeric($_GET['doccat_id']))
{
$doccat_id = $_GET['doccat_id'];
$result = mysqli_query($conn, "DELETE FROM `docs_categories` WHERE doccat_id=$doccat_id")
or die(mysqli_error($conn)); 
echo("<script>location.href = 'index.php?admin&page=categories';</script>");
}
else
{
echo("<div class='error-msg'>
<p><i class='fa fa-times-circle'></i><font-color='red' Cat ID ".$doccat_id." could not be deleted.</font></p>");
}
?>
<?php
}
?>
