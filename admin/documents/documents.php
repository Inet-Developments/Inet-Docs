<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' &&  $_SESSION['admin_level'] != 'Staff')
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<script type="text/javascript" src="includes/tiny/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
selector: 'textarea',  // change this value according to your HTML
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
<h3><i class="fas fa-book"></i> <b><?php echo $settings['site_name'] ?> Documents</b></h3></div>
<?php
$postData = $statusMsg = '<div class="info-msg">
<p><i class="fa fa-info-circle"></i> Please enter your new documentation information.</p></div>'; 
if(isset($_POST['add_document']))
{  

$postData = $_POST; 

if(!empty($_POST['doccat_name'])
&&
!empty($_POST['doccontent_title'])
&&
!empty($_POST['doccontent_content']))
				
$doccat_name = $_POST['doccat_name'];
$doccontent_author = $_SESSION['admin_username'];
$doccontent_title = $_POST['doccontent_title'];
$doccontent_content = $_POST['doccontent_content'];
$doccontent_dated = date("l jS \of F Y H:i:s A");	
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

	
$sql = mysqli_query ($conn, "INSERT INTO docs_content 
(doccat_name, 
doccontent_author, 
doccontent_title,
doccontent_content,
doccontent_dated,
doccontent_updated)
VALUES 
(
'" . mysqli_real_escape_string($conn, $_POST['doccat_name']) . "', 
'" . mysqli_real_escape_string($conn, $_SESSION['admin_username']) . "',  
'" . mysqli_real_escape_string($conn, $_POST['doccontent_title']) . "',
'" . mysqli_real_escape_string($conn, $_POST['doccontent_content']) . "',
'". $doccontent_dated = date("d/m/Y H:i:s A") ."',
'" . mysqli_real_escape_string($conn, '`Not Updated`') . "')");

if ($conn) {
$status = 'success'; 
$statusMsg = '<div class="success-msg">
<p><i class="fa fa-check-circle"></i> Document '.$_POST['doccontent_title'].' has been created and added to Category '.$_POST['doccat_name'].'.</div>'; 
} 
else 
{
$status = 'error'; 
$statusMsg = '<div class="error-msg">
<p><i class="fa fa-times-circle"></i> Document '.$_POST['doccontent_title'].' could not be created.</p>';
}
}
?>
<?php if(!empty($statusMsg)){ ?>
<p class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></p>
<?php } ?>

<?php
$result = mysqli_query($conn, "SELECT * FROM docs_categories") 
or die(mysqli_error());  
$numrows = mysqli_num_rows($result);
if($numrows == 0){ 
echo "You currently have no Document Categories created, Create them to add Documents."; 
} 
else
{
?>
<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Document Title</h3></td>
</tr>
<tr>
<td valign="top">
<label for="doccontent_title"></label>
<input type="text" name="doccontent_title" id="doccontent_title" /></td>
</tr>
<tr>
<td><h3>Document Content</h3></td>
</tr>
<tr>
<td>
<label for="doccontent_content"></label>
<textarea name="doccontent_content" id="doccontent_content" cols="45" rows="5"></textarea></td>
</tr>
<tr>
<td><h3>Document Category</h3></td>
</tr>
<tr>
<td>
<select name="doccat_name" id="doccat_name">
<?php
$result = mysqli_query($conn, "SELECT * FROM docs_categories ORDER BY doccat_name ASC") 
or die(mysqli_error());  
while($row=mysqli_fetch_assoc($result)){ 
echo "<option value=\"$row[doccat_name]\">$row[doccat_name]</option>\n";  
}
?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="add_document" id="add_document" value="Add Document" /></td>
</tr>
</table>
</form>
<?php
}
?>
<hr />
<div class="heading_box">
<h3><i class="fas fa-cog"></i> <b>Manage <?php echo $settings['site_name'] ?> Documents</b></h3></div>
<?php
$result = mysqli_query($conn, "SELECT * FROM `docs_content` ORDER BY doccat_name ASC") 
or die(mysqli_error());  
$numrows = mysqli_num_rows($result);
if($numrows == 0){ 
echo "You currently have no Documents in the database."; 
} 
else
{
echo "<table border='0' cellpadding='3' table width='100%'>";
echo "<tr td align='left'> <th><p>Title</p></th> <th><p>Category</p></th> <th><p>Date Added</p></th> <th><p>Edit</p></th> <th><p>Delete</p></th></tr>";
while($row = mysqli_fetch_array( $result )) {
echo "<tr>";
echo '<td align="left" valign="top"><p>' . $row['doccontent_title'] . '</p></td>';
echo '<td align="left" valign="top"><p>' . $row['doccat_name'] . '</p></td>';
echo '<td align="left" valign="top"><p>' . $row['doccontent_dated'] . '</p></td>';
echo '<td align="left" valign="top"><p><a href="index.php?admin&page=documents_edit&doccontent_id=', urlencode($row['doccontent_id']), '"><i class="fas fa-edit"></i></a></p></td>';
echo '<td align="left" valign="top"><p><a href="index.php?admin&page=documents_delete&doccontent_id=', urlencode($row['doccontent_id']), '"><i class="fas fa-trash-alt"></i></a></p></td>';
echo "</tr>"; 
} 
echo "</table>";
}
?>
<?php
}
?>