# up-image
كود مركز رفع صور لاستخدامه بأي مشروع

شرح الكود 

كود بدأ الجلسه بالسيشن 
<?php
ob_start();
session_start();
==============================================
كود عنوان الصفحه
$pageTitle = 'مركز رفع الملفات';
الفانكشن الخاص به
<?php
	 // تحديد التيتل للصفحه ويستدعا بالكود
	 // ($pageTitle = 'Login';)&(<?php getTitle())
	 function getTitle(){
	 	global $pageTitle;
	 	if (isset($pageTitle)) {
	 		echo $pageTitle;
	 	} else {
	 		echo 'Default';
	 	}
	 }
?>
==============================================
متغير الجلسهوالتحقق من وجودها
if (isset($_SESSION['Username'])) {
استدعاء ملف الانتشلايز الذي محتواه
الهيدر + الفانكشن +المتغيرات
include 'init.php';
===================================================
متغير وشرط اليورل الرابط للصفحه
$pe = isset($_GET['pe']) ? $_GET['pe'] : 'Addimg';
if ($pe == 'Addimg') {
===================================================
الفورم الخاص رفع الصوره
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
----------
نوع الفورم = بوست
method="POST"
الاكشن = رابط الصفحهالتي بها التحقق والشروط
action="?pe=Showimg"
صيغة ونوع الفورم = داتا
enctype="multipart/form-data"
اسم الاينبوت = name="uploaded_file"
نوعه = type="file"
===================================================
كود شرط الصفحه وعنوانها
} elseif ($pe == 'Showimg'){
التحقق بأن القادم الي الصفحه من نوع بوست
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
=========================================================================
متغيرات الشروط وتعريفها
$fileName = $_FILES["uploaded_file"]["name"]; // أسم الملف
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // مجلد الرفع
$fileType = $_FILES["uploaded_file"]["type"]; // نوع وصيغة الملف المرفوع
$fileSize = $_FILES["uploaded_file"]["size"]; // حجم الملف بالبايت
$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // التحقق من وجود اخطاء او لا
$fileName = preg_replace('/[^a-z0-9\-\.]/i', '',$fileName); // ازالة اسم الملف المرفوع
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension
$fileName = "user". date("ymdhis").".".$fileExt;
