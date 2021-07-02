<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
function getPage() {
    $url = basename($_SERVER['SCRIPT_NAME'], '.php');
    $category = explode('_', $url);
    $phase = array_pop($category);
    $category = implode('_', $category);
    $title = array(
        'voice' => 'お客様の声',
    );
    $execution = array(
        'append' => '新規登録',
        'custom' => '編集',
        'delete' => '削除',
    );
    $subtitle = array(
        'conf' => '確認',
        'done' => '完了',
    );

    if (isset($title[$category])) {
        $pagetitle = $title[$category].'管理';
        if (!empty($_GET['do'])) {
            $pagetitle .= $execution[$_GET['do']];
        } else {
            $pagetitle .= 'リスト';
        }
        if (isset($subtitle[$phase])) {
            $pagetitle .= $subtitle[$phase];
        }
        echo '<button class="title">'. $pagetitle. '</button>';
    }
}