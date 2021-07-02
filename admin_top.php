<?php
session_start();
require_once ('function.php');
if (empty($_SESSION['auth'])) {
    header ('Location:login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php require_once ('navs.php'); ?>
 <div id="wrapper">
	<?php require_once ('footer.php'); ?>
</div>
</body>
</html>
