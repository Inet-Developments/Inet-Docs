<?php
if($_SESSION['signed_in'] == false | $_SESSION['admin_level'] != 'Admin' &&  $_SESSION['admin_level'] != 'Staff')
{
echo("<script>location.href = 'index.php?admin&page=login';</script>");
}
else
{ 
?>
<div class="heading_box">
<h3><i class="fas fa-upload"></i> <b><?php echo $settings['site_app'] ?> Updates & Changelogs</b></h3></div>
<p>From here you can check for latest Updates and Changelogs.</p>
<?php
include 'includes/database/database_connect.php';
include 'includes/database/database_settings.php';
define('REMOTE_VERSION', 'https://updates.inet-developments.org/inetdocs/version.php');
define('VERSION', 'includes/version/version.php');
$script = file_get_contents(REMOTE_VERSION);
$version = file_get_contents(VERSION);
if($version == $script) {
echo "<p><span style='color:green;'><i class='fa fa-check-circle'></i> You are currently using the latest ".$settings['site_app']." Release Version:$version";
} else {
echo "<p><span style='color:green;'><i class='fa fa-check-circle'></i> Update Check: Current Version:".$version."</p>

<p><span style='color:red;'><i class='fa fa-info-circle'></i> There is an ".$settings['site_app']." update available to version:".$script."</p>";
?>
<?php
if(isset($_POST['update_file'])){ 
function remoteFileExists($url) {
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_NOBODY, true);
$result = curl_exec($curl);
$ret = false;
if ($result !== false) {
$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
if ($statusCode == 200) {
$ret = true;   
}
}
curl_close($curl);
return $ret;
}
$exists = remoteFileExists('https://updates.inet-developments.org/inetdocs/update.zip');
if ($exists) {
} else {
echo 'Update file does not exist, no new updates.';
exit;   
}
$remote_file_url = 'https://updates.inet-developments.org/inetdocs/update.zip';
$local_file =''.$_SERVER['DOCUMENT_ROOT'].'/update.zip';
$copy = copy($remote_file_url, $local_file );
if( !$copy ) {
echo "Failed to Update $file...\n"; }
else{
echo "Copied $file successfully and the Update has succeeded.\n"; }
$file = 'update.zip';
$path = pathinfo( realpath( $file ), PATHINFO_DIRNAME );
$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
$zip->extractTo( $path );
$zip->close();
echo "$file extracted to $path"; }
else {
echo "Couldn't open $file";           
}
}
?>
<p>If Auto Update fails please download the <a href="https://updates.inet-developments.org/inetdocs/update.zip">Update</a> manually.</p>
<?php if( !$copy ) { ?>
<form id="form1" name="form1" method="post">
<input type="submit" name="update_file" id="update_file" value="Auto Update">
</form>
<?php 
}
else
{ 
?>
Update Versioning before continuing.
<?php
}
}
?>
<div class="heading_box">
<h3><i class="fas fa-upload"></i> <b><?php echo $settings['site_app'] ?> Changelogs</b></h3></div>
<p>To view all <?php echo $settings['site_app']; ?> changelogs please visit the project page:<a href="https://www.inet-developments.org/index.php?page=projects&project_name=Inet%20Docs"><?php echo $settings['site_app']; ?></a></p>
<?php
}
?>