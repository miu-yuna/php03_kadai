<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更


//３．データ登録SQL作成


// POSTデータ取得
$title = $_POST["title"];
$author = $_POST["author"];
$text = $_POST["text"];
$id = $_POST["id"];


// DB接続

include("funcs.php");
$pdo = db_conn();


// データ登録SQL作成
$sql = "UPDATE gs_book SET title=:title, author=:author, text=:text WHERE id=:id"; // カンマの位置を修正
$stmt = $pdo->prepare($sql);

// バインド変数
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':author', $author, PDO::PARAM_STR);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':id',  $id,    PDO::PARAM_INT); 

// データ登録処理後
$status = $stmt->execute();

if($status==false){
    // SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
}else{
    // リダイレクト
    header("Location: select.php");
    exit();
}

?>
