<?php
session_start();
require_once ('constants.php');
require_once ('function.php');
require_once ('db_function.php');
if (empty($_SESSION['auth'])) {
    header ('Location:login.php');
    exit;
}
if (!empty($_POST['complete'])) { //完了ボタン押下
    try{
        $pdo =pdo();
        $pdo->beginTransaction();
        if ($_GET['do'] == 'append') {
            $stmt = $pdo->prepare('INSERT INTO xxxx_aaaa( '
        		. ' xxxx_aaaa_AA '
        		. ', xxxx_aaaa_BB '
        		. ', xxxx_aaaa_CC '
        		. ', xxxx_aaaa_DD '
              . ')VALUES('
        		. '?'
        		. ',?'
        		. ',?'
        		. ',?'
        		. ')'
            );
            $stmt->execute([
                $_POST['AA'],
                $_POST['BB'],
                $_POST['CC'],
                $_POST['DD']
            ]);
            $do = '新規登録';
        } elseif ($_GET['do'] == 'custom') {
            $stmt = $pdo->prepare('UPDATE xxxx_aaaa SET '
        		. ' xxxx_aaaa_AA = ? '
        		. ', xxxx_aaaa_BB = ? '
        		. ', xxxx_aaaa_CC = ? '
        		. ', xxxx_aaaa_DD = ? '
        		. ', xxxx_aaaa_upd_ts = CURRENT_TIMESTAMP(6) '
        		. ' WHERE xxxx_aaaa_no = ? '
            );
            $stmt->execute([
                $_POST['AA'],
                $_POST['BB'],
                $_POST['CC'],
                $_POST['DD'],
                $_GET['aaaa_no']
            ]);
            $do = '編集';
        } elseif ($_GET['do'] == 'delete') {
            $stmt = $pdo->prepare('UPDATE xxxx_aaaa SET '
        		. ' xxxx_aaaa_status = FALSE '
        		. ' WHERE aaaa_no = ? '
        	);
            $stmt->execute([$_GET['aaaa_no']]);
            $do = '削除';
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $messege = 'エラーが発生しました。Error:'.$e->getMessage();
    }
    $pdo->commit();
    $messege = $do.'が完了しました。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
	<title>お客様の声管理<?= $do ?>完了</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php require_once ('navs.php'); ?>
<div id="done">
	<p class="middle"><?= $messege ?></p>
</div>
<?php require_once ('footer.php'); ?>
</body>
</html>
