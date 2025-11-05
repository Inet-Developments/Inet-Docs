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
<h3><i class="fas fa-bars"></i> <b><?php echo $settings['site_name'] ?> Document Categories</b></h3></div>
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> Please enter the name of your new Document Category</p></div>';  

// If form submitted
if(isset($_POST['add_cat']))
{ 

$postData = $_POST; 

// Validate Cat Name Field
if(!empty($_POST['doccat_name']))
				
$doccat_name = $_POST['doccat_name'];
$doccat_date = date("d/m/Y H:i:s A");	

// Check Cat is not duplicate.
$select = mysqli_query($conn, "SELECT `doccat_name` FROM docs_categories WHERE `doccat_name` = '".$_POST['doccat_name']."'") or exit(mysqli_error($conn));
if(mysqli_num_rows($select)) {
exit ('<div class="error-msg">
<p><i class="fa fa-times-circle"></i> The Category '.$doccat_name.' has already been created. <a href="index.php?admin&page=categories">Please create another</a>.</div>');
}

// Insert into database

$sql = mysqli_query ($conn, "INSERT INTO docs_categories 
(doccat_name, 
doccat_date)

VALUES 
('" . mysqli_real_escape_string($conn, $doccat_name) . "',
'" . mysqli_real_escape_string($conn, $doccat_date) . "')");
	
// If database connection is valid
if ($conn) {
$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Document Category '.$_POST['doccat_name'].' created.</p></div>'; 
} 
else 
{
$status = 'error';
$statusMsg = '<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Error creating new Document Category '.$_POST['doccat_name'].'.</p>';
}
}
?>

<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>
<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Category Name</h3></td>
</tr>
<tr>
<td>
  <label for="doccat_name"></label>
  <input type="text" name="doccat_name" id="doccat_name" /></td>
</tr>
<tr>
<td>
  <input type="submit" name="add_cat" id="add_cat" value="Add Category" /></td>
</tr>
</table>
</form>

<hr />
<div class="heading_box">
<h3><i class="fas fa-cog"></i> <b>Manage <?php echo $settings['site_name'] ?> Categories</b></h3></div>

<?php
$result = mysqli_query($conn, "SELECT * FROM `docs_categories` ORDER BY `doccat_name` ASC") 
or die(mysqli_error());  
$numrows = mysqli_num_rows($result);
if($numrows == 0){ 
echo "You currently have no Categories in the database."; 
} 
else
{
echo "<table border='0' cellpadding='3' table width='100%'>";
echo "<tr td align='left'> <th><p>Category Name</p></th> <th><p>Date Added</p></th> <th><p>Edit</p></th> <th><p>Delete</p></th></tr>";
while($row = mysqli_fetch_array( $result )) {
echo "<tr>";
echo '<td align="left" valign="top"><p>' . $row['doccat_name'] . '</p></td>';
echo '<td align="left" valign="top"><p>' . $row['doccat_date'] . '</p></td>';
echo '<td align="left" valign="top"><p><a href="index.php?admin&page=categories_edit&doccat_id=', urlencode($row['doccat_id']), '"><i class="fas fa-edit"></i></a></p></td>';
echo '<td align="left" valign="top"><p><a href="index.php?admin&page=categories_delete&doccat_id=', urlencode($row['doccat_id']), '"><i class="fas fa-trash-alt"></i></a></p></td>';
echo "</tr>"; 
} 
echo "</table>";
}
?>
<?php
}
?>