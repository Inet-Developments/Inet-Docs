<div class="heading_box"><h3><b><i class="fas fa-book"></i> Docs / <a href="index.php?page=docs&cat=<?php echo ''.$_GET["cat"].'' ?>"><?php echo ''.$_GET["cat"].'' ?></a></b></h3></div>
<style>
.collapsible {
background-color: #ececec;
color: #000;
cursor: pointer;
width: 100%;
border:none;
text-align: left;
outline: none;
font-size: 11px;
padding: 5px;
margin: 5px auto;
}

.active, .collapsible:hover {
background-color: #ececec;
}

.content {
padding: 0 0px;
display: none;
overflow: hidden;
background-color: #ffffff;
}
</style>
<?php
$doccat_name = $_GET['cat'];
$sqldb =
$result = mysqli_query($conn, "SELECT * FROM docs_content WHERE doccat_name = '".$_GET["cat"]."'");
$num_rows = mysqli_num_rows($result);
if($num_rows > 0)
{
?>
<?php
$doccat_name = $_GET['cat'];
$data = mysqli_query($conn, "SELECT * FROM docs_content WHERE doccat_name = '".$_GET["cat"]."'")
or die(mysqli_error());
while($row = mysqli_fetch_array( $data ))
{ 
?>
<button type="button" class="collapsible"><i class="fas fa-caret-down"></i> <?php echo $row['doccontent_title']; ?> | Updated:<?php echo $row['doccontent_updated']; ?></button>
<div class="content">
<p><?php echo $row['doccontent_content']; ?></p>
</div>
<?php
}
?>
<?php
}
else
{
echo "<p><div class='warning-msg'>
<p><i class='fa fa-warning'></i> No docs for ".$_GET["cat"]." added yet.</p></div>";
}
?>
<script>
var coll = document.getElementsByClassName("collapsible");
var i;
for (i = 0; i < coll.length; i++) {
coll[i].addEventListener("click", function() {
this.classList.toggle("active");
var content = this.nextElementSibling;
if (content.style.display === "block") {
content.style.display = "none";
} else {
content.style.display = "block";
}
});
}
</script>