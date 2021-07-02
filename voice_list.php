<?php
session_start();
require_once ('constants.php');
require_once ('function.php');
require_once ('db_function.php');
if (empty($_SESSION['auth'])) {
    header ('Location:login.php');
    exit;
}
if (!empty($_GET['column']) && !empty($_GET['vector'])) {
    $sort = ' ORDER BY '.$_GET['column']. ' '. $_GET['vector'];
}
$xxxx_aaaa_sort_type = array('1' => 'ランダム', '2' => '昇順');
$pdo = pdo();
$stmt = $pdo->prepare('SELECT * FROM xxxx_aaaa WHERE xxxx_aaaa_status = TRUE'. (!empty($sort) ? $sort : '')) ;
$stmt->execute();
$xxxx_aaaa = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM xxxx_config');
$stmt->execute();
$xxxx_config = $stmt->fetch(PDO::FETCH_ASSOC);
if (!empty($_POST['output_sort'])) {
    if ($_POST['aaaa_output_answers'] >= 0) {
        $messege = $xxxx_aaaa_sort_type[$_POST['aaaa_output_type']]. $_POST['aaaa_output_answers']. '件に変更しました。';
        if (!$xxxx_config) {
            $stmt = $pdo->prepare('INSERT INTO xxxx_config( '
                . ' xxxx_aaaa_output_type '
                . ', xxxx_aaaa_output_answers '
              . ')VALUES('
                . '?'
                . ',?'
                . ')'
            );
            $stmt->execute([
                $_POST['aaaa_output_type'],
                $_POST['aaaa_output_answers']
            ]);
        } else {
            $stmt = $pdo->prepare('UPDATE xxxx_config SET '
                . ' xxxx_aaaa_output_type = ? '
                . ', xxxx_aaaa_output_answers = ? '
            );
            $stmt->execute([
                $_POST['aaaa_output_type'],
                $_POST['aaaa_output_answers']
            ]);
        }
    } else {
        $messege = '表示件数は0以上の整数を入力して下さい';
    }
} else {
    $_POST = (array)$_POST + (array)$xxxx_config;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>お客様の声管理リスト</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php require_once ('navs.php'); ?>
<?= (!empty($_POST['output_sort']) ? $messege : '') ?>
<div id="main">
	<form action="" method="post">
    	<table class="data_list" style="width:60%;">
    		<tr>
    			<td>
                	ユーザーページ内表示
                </td>
                <td>
                	<select name="aaaa_output_type">
                    	<?php foreach ($aaaa_sort_type as $key => $value): ?>
                    		<option value="<?= $key ?>"<?php if(!empty($_POST['aaaa_output_type']) && $key == $_POST['aaaa_output_type']): ?>selected<?php endif;?>><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
    			</td>
    			<td>
                    <input type="number" style="width:50px;" name="aaaa_output_answers" value="<?php if (!empty($_POST['aaaa_output_answers'])): ?><?= $_POST['aaaa_output_answers'] ?><?php endif; ?>">件
    			</td>
    			<td>
    				<input class="intable" type="submit" name="output_sort" value="変更">
    			</td>
    		</tr>
    	</table>
	</form>
    <table class="data_list">
    	<tr>
    		<td class="data_tag">
                <a class="sort" href="voice_list?column=xxxx_aaaa_no&vector=ASC">
                ▲
                </a><br>
        		No.<br>
        		<a class="sort" href="voice_list?column=xxxx_aaaa_no&vector=DESC">
                ▼
                </a>
	    	</td>
    		<td class="data_tag">
                <a class="sort" href="voice_list?column=xxxx_aaaa_AA&vector=ASC">
                ▲
                </a><br>
        		AA<br>
        		<a class="sort" href="voice_list?column=xxxx_aaaa_AA&vector=DESC">
                ▼
                </a>
    		</td>
    		<td class="data_tag">BB</td>
    		<td class="data_tag imprsssion">CC</td>
    		<td class="data_tag">
                <a class="sort" href="voice_list?column=xxxx_aaaa_DD&vector=ASC">
                ▲
                </a><br>
        		DD<br>
        		<a class="sort" href="voice_list?column=xxxx_aaaa_DD&vector=DESC">
                ▼
                </a>
    		</td>
    		<td><button class="intable" onclick="location.href='./voice_edit.php?do=append'">新規登録</button></td>
    	</tr>
    	<?php foreach ($aaaa as $value): ?>
    		<tr>
    			<td><?= $value['aaaa_no'] ?></td>
        		<td><?= $value['aaaa_AA'] ?></td>
        		<td><?= $value['aaaa_BB'] ?></td>
        		<td class="impression"><?= $value['aaaa_CC'] ?></td>
        		<td><?= $value['aaaa_DD'] ?></td>
        		<td>
        			<button type="button" class="intable" onclick="location.href='./voice_edit.php?do=custom&aaaa_no=<?= $value['aaaa_no'] ?>'">編集</button>
        			<button type="button" class="intable" onclick="location.href='./voice_conf.php?do=delete&aaaa_no=<?= $value['aaaa_no'] ?>'">削除</button>
        		</td>
        	</tr>
    	<?php endforeach;?>
    </table>
	<?php require_once ('footer.php'); ?>
</div>
</body>
</html>
