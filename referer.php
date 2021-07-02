<?php
require_once ('constants.php');
require_once ('function.php');
require_once ('db_function.php');


$pdo = pdo();

$stmt = $pdo->prepare('SELECT COUNT(xxxx_referer_no) AS count FROM xxxx_referer WHERE
SUBSTRING_INDEX(xxxx_referer_url, "/", 3) like "%google%"');
$stmt->execute();
$xxxx_referer_google = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT domain, COUNT(domain) AS count FROM xxxx_referer
    WHERE SUBSTRING_INDEX(xxxx_referer_url, "/", 3) not like "%google%" AS domain GROUP BY count DESC');
$stmt->execute();
$xxxx_referer = $stmt->fetchAll(PDO::FETCH_ASSOC);

$xxxx_referer_other = array_slice($xxxx_referer, 3);
$xxxx_referer_other_sum = array_sum(array_column($xxxx_referer_other, 'count'));
//$xxxx_referer_other_sum = array_sum($xxxx_referer_other[1]);
$xxxx_referer = json_encode($xxxx_referer, JSON_UNESCAPED_UNICODE);
$xxxx_referer_other = json_encode($xxxx_referer_other, JSON_UNESCAPED_UNICODE);
$xxxx_referer_other_sum = json_encode($xxxx_referer_other_sum, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" href="admin.css">
  <meta charset="utf-8">
	<title>グラフ</title>
</head>
<body>
<?php require_once ('navs.php'); ?>
<div id="wrapper">
    <canvas id="myPieChart"></canvas>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script>
    var xxxx_referer = <?php echo $xxxx_referer; ?>;
    var xxxx_referer_other = <?php echo $xxxx_referer_other; ?>;
    var xxxx_referer_other_sum = <?php echo $xxxx_referer_other_sum; ?>;
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['google', xxxx_referer[0][0], xxxx_referer[0][1], xxxx_referer[0][2],'その他'],
        datasets: [{
			backgroundColor: [
                '#BB5179',
                '#FAFF67',
                '#58A27C',
                '#4169e1',
                '#9932cc'
            ],
            data: [xxxx_referer_google, xxxx_referer[1][0], xxxx_referer[1][1], xxxx_referer[1][2], xxxx_referer_other_sum]
        }]
    },
    options: {
        title: {
            display: true,
            text: 'ドメイン別 リファラ割合'
        }
    }
    });
    </script>
    <?php require_once ('footer.php'); ?>
</div>
</body>
</html>