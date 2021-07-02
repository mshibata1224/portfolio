<?php
session_start();
require_once ('constants.php');
require_once ('function.php');
require_once ('db_function.php');
if (empty($_SESSION['auth'])) {
    header ('Location:login.php');
    exit;
}
if ($_GET['do'] == 'custom') {
    $do = '編集';
} elseif ($_GET['do'] == 'append') {
    $do = '新規登録';
} else {
    $do = '削除';
    $pdo =pdo();
    $stmt = $pdo->prepare('SELECT * FROM xxxx_aaaa WHERE xxxx_aaaa_no = ?');
    $stmt->execute([$_GET['aaaa_no']]);
    $_POST = (array)$_POST + (array)$stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>お客様の声管理<?= $do ?>確認</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php require_once ('navs.php'); ?>
<div id="main">
    <table class="data_check">
        <?= (($_GET['do'] == 'custom' || $_GET['do'] == 'delete') ? '<tr><td class="data_tag">No.</td><td class="input">'. $_GET['aaaa_no']. '</td></tr>' : '') ?>
    	<tr>
    		<td class="data_tag">AA</td>
    		<td class="input"><?= $_POST['xxxx_aaaa_AA'] ?></td>
    	</tr>
    	<tr>
    		<td class="data_tag">BB</td>
    		<td class="input"><?= $_POST['xxxx_aaaa_BB'] ?></td>
    	</tr>
    	<tr>
    		<td class="data_tag">CC</td>
    		<td class="input"><?= nl2br($_POST['xxxx_aaaa_CC']) ?></td>
    	</tr>
    	<tr>
    		<td class="data_tag">DD</td>
    		<td class="input"><?= $_POST['xxxx_aaaa_DD'] ?></td>
    	</tr>
    </table>
    <div id="submit">
    	<form action="voice_done.php?do=<?= $_GET['do'] ?>&aaaa_no=<?=(($_GET['do'] == 'custom' || $_GET['do'] == 'delete') ? $_GET['aaaa_no'] : '') ?>" method="post">
            <input type="hidden" name="AA" value="<?= $_POST['xxxx_aaaa_AA'] ?>">
            <input type="hidden" name="BB" value="<?= $_POST['xxxx_aaaa_BB'] ?>">
           	<input type="hidden" name="CC" value="<?= $_POST['xxxx_aaaa_CC'] ?>">
           	<input type="hidden" name="DD" value="<?= $_POST['xxxx_aaaa_DD'] ?>">
           	<input class="submit" type="submit" name="complete" value="<?= $do ?>完了">
    	</form>
	</div>
	<?php require_once ('footer.php'); ?>
</div>
</body>
</html>
