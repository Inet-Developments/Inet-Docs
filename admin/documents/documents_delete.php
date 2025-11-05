<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' &&  $_SESSION['admin_level'] != 'Staff')
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box"><h3><i class="fas fa-book"></i> Delete Document</h3></div>
<?php
if (isset($_GET['doccontent_id']) && is_numeric($_GET['doccontent_id']))
{
$doccontent_id = $_GET['doccontent_id'];
$result = mysqli_query($conn, "DELETE FROM `docs_content` WHERE doccontent_id=$doccontent_id")

or die(mysqli_error($conn)); 

echo("<script>location.href = 'index.php?admin&page=documents';</script>");
}
else
{
echo("<div class='error-msg'>
<p><i class='fa fa-times-circle'></i><font-color='red' Document ".$doccontent_id." could not be deleted.</font></p>");
}
?>
<?php
}
?>
