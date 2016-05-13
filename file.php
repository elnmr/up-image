<?php
ob_start();
session_start();
$pageTitle = 'مركز رفع الملفات';
if (isset($_SESSION['Username'])) {
include 'init.php';
$pe = isset($_GET['pe']) ? $_GET['pe'] : 'Addimg';
if ($pe == 'Addimg') {
?>
<div class="row">
<form class="form-inline col-md-6 col-md-offset-3" enctype="multipart/form-data" method="POST" action="?pe=Showimg">
<div class="form-group">
<input name="uploaded_file" type="file" class="form-control" placeholder="File">
</div>
<input class="btn btn-default" type="submit" value="رفع الملف"/>
<p class="help-block">Max M Size : [150]KB</p>
</form>
</div>
<?php
} elseif ($pe == 'Showimg'){
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Access the $_FILES global variable for this specific file being uploaded
// and create local PHP variables from the $_FILES array of information
$fileName = $_FILES["uploaded_file"]["name"]; // The file name
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
$fileName = preg_replace('/[^a-z0-9\-\.]/i', '',$fileName);
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension
$fileName = "user". date("ymdhis").".".$fileExt;
// START PHP Image Upload Error Handling --------------------------------------------------
if (!$fileTmpLoc) { // if file not chosen
echo "<p class='mconf col-md-4 alert alert-danger' role='alert'>خطأ : الرجاء أختيار ملف أولا</p>";
redirectHome($theMsg, 'الصفحه السابقه',2);
exit();
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) {
// This condition is only if you wish to allow uploading of specific file types 
$theMsg = "<p class='mconf col-md-4 alert alert-danger' role='alert'>خطأ : يرجي أختيار نوع ملف من الصيغ الاتيه .gif, .jpg, or .png.</p>";
unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
redirectHome($theMsg, 'الصفحه السابقه',2);
exit();
} else if($fileSize > 150000) { // if file size is larger than 150 kbytes
$theMsg = "<p class='mconf col-md-4 alert alert-danger' role='alert'>خطأ : الملف المراد رفعه حجمه أكبر من [150]KB</p>";
unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
redirectHome($theMsg, 'الصفحه السابقه',2);
exit();
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
$theMsg = "<p class='mconf col-md-4 alert alert-danger' role='alert'>خطأ : حدث خطأ أثناء رفع الملف . الرجاء حاول ثانية.</p>";
redirectHome($theMsg, 'الصفحه السابقه',2);
exit();
}
// END PHP Image Upload Error Handling ----------------------------------------------------
// Place it into your "uploads" folder mow using the move_uploaded_file() function
$moveResult = move_uploaded_file($fileTmpLoc, "image/user/$fileName");
// Check to make sure the move result is true before continuing
if ($moveResult != true) {
$theMsg = "<p class='mconf col-md-4 alert alert-danger' role='alert'>ERROR: File not uploaded. Try again.</p>";
redirectHome($theMsg, 'الصفحه السابقه',2);
exit();
}
// Display things to the page so you can see what is happening for testing purposes
?>
<div class="mconf alert alert-success col-md-4">
<table class="table table-responsive">
<strong>تم رفع الملف بنجاح.</strong>
<tbody class="thumbnail">
<tr>
<td><img src="image/user/<?php echo $fileName ?>" class="img-rounded" alt="Responsive image"/></td>
</tr>
<tr>
<td style="width: 70px;">أسم الملف</td>
<td style="width: 200px;"><strong><?php echo $fileName ?></strong></td>
</tr>
<tr>
<td style="width: 70px;">حجم الملف </td>
<td style="width: 200px;"> بايت <strong><?php echo $fileSize ?></strong></td>
</tr>
<tr>
<td style="width: 70px;">نوع الملف</td>
<td style="width: 200px;"><strong><?php echo $fileType ?></strong></td>
</tr>
<tr>
<td style="width: 70px;">صيغة الملف</td>
<td style="width: 200px;"><strong><?php echo $fileExt ?></strong></td>
</tr>
<tr>
<td style="width: 70px;">الاخطاء</td>
<td style="width: 200px;"><?php echo $fileErrorMsg ?></td>
</tr>
<?php redirectHome($theMsg, 'الصفحه السابقه',5); ?>
</tbody>
</table>
</div>
<?php
} else {
$theMsg = '<p class="mconf alert alert-danger" role="alert"><span>هناك خطأ : </span>لا يمكنك الولوج لهذه الصفحه مباشرتاً</p>';
redirectHome($theMsg, 'الصفحه السابقه',2);
}
}
include $tpls . 'footer.php';
ob_end_flush();
} else {
header('Location: index.php');
exit();
}
?>
