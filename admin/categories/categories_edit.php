<?php
// If signed in and admin level is Admin
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' &&  $_SESSION['admin_level'] != 'Staff')
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box">
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> Please enter your new Category name to Update.</p></div>';

$doccat_id = $_GET['doccat_id'];
$result = mysqli_query($conn, "SELECT * FROM docs_categories WHERE doccat_id=$doccat_id")
or die(mysqli_error()); 
$row = mysqli_fetch_array($result);
{
?>
<h3><i class="fas fa-edit"></i> <b>Edit Category <?php echo $row['doccat_name'] ?></b></h3></div>
<?php
if (isset($_POST['update_cat'])) {

$postData = $_POST; 

if(!empty($_POST['doccat_name']))

$doccat_name = $_POST['doccat_name'];

if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "Update `docs_categories`
SET 
doccat_name = '$doccat_name'

WHERE 
doccat_id = '$doccat_id'");

if ($conn) {
$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Category has been Updated.</p></div>'; 
} 
else 
{
$status = 'error';
$statusMsg = '<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Category has not been Updated.</p>';
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
<td width="20%"><h3>Edit Category Name</h3></td>
</tr>
<tr>
<td>
  <label for="doccat_name"></label>
  <input name="doccat_name" type="text" id="doccat_name" value="<?php echo $row['doccat_name']; ?>" /></td>
</tr>
<tr>
<td>
  <input type="submit" name="update_cat" id="update_cat" value="Update Category" /></td>
</tr>
</table>
</form>
<?php
}
?>