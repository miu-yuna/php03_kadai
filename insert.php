<?php

// POSTデータ取得
$title = $_POST["title"];
$author = $_POST["author"];
$text = $_POST["text"];

// DB接続

try {
    // データベース名を正しいものに修正し、ホスト、ユーザー名、パスワードを適切に設定します。
    $pdo = new PDO('mysql:dbname=book_image;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    exit('DB_CONECT:'.$e->getMessage());
}


// データ登録SQL作成
$sql = "INSERT INTO gs_book(id,title,author,text,indate)VALUES(NULL,:title,:author,:text,sysdate())";
$stmt = $pdo->prepare($sql);

// バインド変数
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':author', $author, PDO::PARAM_STR);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
// 画像ファイルのパスを保存

// データ登録処理後
$status = $stmt->execute();

if($status==false){
    // SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
}else{
    // リダイレクト
    header("Location: index.php");
    exit();
}
?>
