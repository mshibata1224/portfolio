<?php
session_start();
require_once ('constants.php');
require_once ('function.php');
require_once ('db_function.php');
if (empty($_SESSION['auth'])) {
    header ('Location:login.php');
    exit;
}
if ($_GET['do'] == 'append') {
    $do = '新規登録';
}
if ($_GET['do'] == 'custom') {
    $do = '編集';
}
$pdo =pdo();
if ($_GET['do'] == 'custom') {
    $stmt = $pdo->prepare('SELECT * FROM xxxx_aaaa WHERE xxxx_aaaa_no = ?');
    $stmt->execute([$_GET['aaaa_no']]);
    $xxxx_aaaa = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>お客様の声管理<?= $do ?></title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php require_once ('navs.php'); ?>
<div id="main">
    <form action="voice_conf.php?do=<?= $_GET['do']?>&aaaa_no=<? ($_GET['do'] == 'custom' ? $_GET['aaaa_no'] : '') ?>" method="post">
        <table class="data_check">
        	<?php if ($_GET['do'] == 'custom'): ?>
            	<tr>
            		<td class="data_tag">No.</td>
            		<td class="input"><?= (!empty($aaaa) ? $aaaa['aaaa_no'] : '') ?></td>
            	</tr>
        	<?php endif; ?>
        	<tr>
        		<td class="data_tag">AA</td>
        		<td class="input"><input class="input" type="text" name="aaaa_AA" value="<?= (!empty($aaaa) ? $aaaa['aaaa_AA'] : '') ?>" placeholder="○○市／××区"></td>
        	</tr>
        	<tr>
        		<td class="data_tag">BB</td>
        		<td class="input"><input class="input" type="text" name="aaaa_BB" value="<?= (!empty($aaaa) ? $aaaa['aaaa_BB'] : '') ?>" placeholder="A"></td>
        	</tr>
        	<tr>
        		<td class="data_tag">CC</td>
        		<td class="input"><textarea class="input" wrap="hard" cols="60" rows="5" name="aaaa_CC"><?= (!empty($aaaa) ? $aaaa['aaaa_CC'] : '') ?></textarea></td>
        	</tr>
        	<tr>
        		<td class="data_tag">DD</td>
        		<td class="input"><input class="input inline" type="text" name="aaaa_DD" value="<?= (!empty($aaaa) ? $aaaa['aaaa_DD'] : '') ?>"><p class="alert">1以上の整数を入力して下さい</p></td>
        	</tr>
        </table>
        <div id="submit">
        	<input class="submit" type="submit" name="<?= $_GET['do'] ?>" value="確認画面へ">
        </div>
    </form>
	<?php require_once ('footer.php'); ?>
</div>
</body>
</html>
