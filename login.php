<?php
session_start();
require_once ('constants.php');
require_once ('function.php');
require_once ('db_function.php');
if (!empty($_POST['send'])) {
    if (!empty($_POST['ID'] && $_POST['password'])) {
        try {
            $pdo =pdo();
            $stmt = $pdo->prepare('SELECT xxxx_admin_login_member_id,
                xxxx_admin_login_member_pass FROM xxxx_admin_login_member
                WHERE xxxx_admin_login_member_id = ? AND xxxx_admin_login_member_pass = ?'
                );
            $stmt->execute([$_POST['ID'], $_POST['password']]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['auth'] = 1;
                header ('Location:admin_top.php');
                exit;
            } else {
                $error =  'IDかパスワードが間違っています';
            }
        } catch (Exception $e) {
        }
    } else {
        $error =  'IDかパスワードが間違っています';
    }
} else {
    unset($_SESSION['auth']);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<h1>管理システム　管理画面ログイン</h1>
<div id="wrapper">
	<p class="login error_mes"><?= (!empty($error) ? $error : '') ?></p><br>
    <form action="" method="post">
    	<p class="login">ログインID</p><input class="auther" type="text" name="ID" value="<?= (!empty($_POST['ID']) ? h($_POST['ID']) : '') ?>"><br>
    	<p class="login pass">パスワード</p><input class="auther" type="password" name="password"><br>
    	<input class="auth" type="submit" name="send" value="認証">
    </form>
	<?php require_once ('footer.php'); ?>
</div>
</body>
</html>
