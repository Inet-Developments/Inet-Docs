<?php
// If signed in and admin level is Admin
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
<?php
$doccontent_id = $_GET['doccontent_id'];
$result = mysqli_query($conn, "SELECT * FROM docs_content WHERE doccontent_id = $doccontent_id")
or die(mysqli_error($conn)); 
$row = mysqli_fetch_array($result);
{
?>
<h3><i class="fas fa-edit"></i> <b>Edit Document <?php echo $row['doccontent_title'] ?></b></h3></div>
<?php
if (isset($_POST['update_doc'])) {

if(!empty($_POST['doccontent_title'])
&&
!empty($_POST['doccontent_content']))	

$doccontent_title = $_POST['doccontent_title'];
$doccontent_content = $_POST['doccontent_content'];
$doccontent_updated = date("d/m/Y H:i:s A");

mysqli_query($conn, "Update docs_content
SET 
doccontent_title = '$doccontent_title',
doccontent_content = '$doccontent_content',
doccontent_updated = '$doccontent_updated'

WHERE 
doccontent_id = '$doccontent_id'");

echo '<div class="success-msg">
<p><i class="fa fa-check-circle"></i>
Document '. $_POST['doccontent_title'] .' has been updated on '. $doccontent_updated .'. <a href="index.php?admin&page=documents">Return to Documents.</a>
</div>';
}
}
?>

<form name="form1" method="post" action="">
<table width="100%" border="0">
<tr>
<td width="20%"><h3>Edit Document Title</h3></td>
</tr>
<tr>
<td>
<label for="doccontent_title"></label>
<input name="doccontent_title" type="text" id="doccontent_title" value="<?php echo $row['doccontent_title']; ?>" /></td>
</tr>
<tr>
<td><h3>Edit Document Content</h3></td>
</tr>
<tr>
<td><label for="doccontent_content"></label>
<textarea name="doccontent_content" id="doccontent_content" cols="45" rows="5"><?php echo $row['doccontent_content'] ?></textarea></td>
</tr>
<tr>
<td><input type="submit" name="update_doc" id="update_doc" value="Update Document" /></td>
</tr>
</table>
</form>
<?php
}
?>