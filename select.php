<?php
//1.  DB接続します

include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_book";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:" . $error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
?>



<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>表示</title>

<style>div{padding: 10px;font-size:16px;}
td{padding-top: 10px; 
}

header{
  background-color: #135D66;
  color: #E3FEF7;
}
.book{
  margin-bottom: 30px;
  background-color: #77B0AA;
  border: #E3FEF7;
  height: 60px;
  width: 60px;
  font-size: 30px;}

  .book-nav-items a, .book-nav-items, .book-nav-items::before, .book-nav-items:hover a span {
  transition: all .4s;
}

/* 本体の装飾 */
.book-nav {
  font-size: 16px;
  display: -webkit-flex;
  display:         flex;
  margin: 0;
  padding: 5px 0 1px 0;
  border: 10px solid #967848;
  background-color: #564934;
  box-shadow: 0 -1px 0 0 #bfb19c, 0 5px 2px 0 rgba(0,0,0,.4),0 1px 0 0 #443721,0 -1px 0 0 #bfb19c inset;
}
.book-nav-items {
  position: relative;
  list-style: none;
  flex-basis: 32px;
}
.book-nav-items:nth-of-type(1) {
  border-top: 1px solid #f28279;
  border-right: 2px solid #ba3c32;
  border-bottom: 1px solid #ba3c32;
  border-left: 2px solid #f28279;
  background-color: #ea5549;
}
.book-nav-items:nth-of-type(2) {
  border-top: 1px solid #e5a77b;
  border-right: 2px solid #c45e17;
  border-bottom: 1px solid #c45e17;
  border-left: 2px solid #e5a77b;
  background-color: #e17b34;
}
.book-nav-items:nth-of-type(3) {
  border-top: 1px solid #f2df93;
  border-right: 2px solid #997b00;
  border-bottom: 1px solid #997b00;
  border-left: 2px solid #f2df93;
  background-color: #e9bc00;
}
.book-nav-items:nth-of-type(4) {
  border-top: 1px solid #50ce9d;
  border-right: 2px solid #02663f;
  border-bottom: 1px solid #02663f;
  border-left: 2px solid #50ce9d;
  background-color: #00a497
}
.book-nav-items:nth-of-type(5) {
  border-top: 1px solid #5acec5;
  border-right: 2px solid #015952;
  border-bottom: 1px solid #015952;
  border-left: 2px solid #5acec5;
  background-color: #00a497;
}
.book-nav-items:nth-of-type(6) {
  border-top: 1px solid #3d84ba;
  border-right: 2px solid #024272;
  border-bottom: 1px solid #024272;
  border-left: 2px solid #3d84ba;
  background-color: #0068b7;
}
.book-nav-items:nth-of-type(7) {
  border-top: 1px solid #3d84ba;
  border-right: 2px solid #024272;
  border-bottom: 1px solid #024272;
  border-left: 2px solid #3d84ba;
  background-color: #50ce9d;
}

.book-nav-items:nth-of-type(8) {
  border-top: 1px solid #3d84ba;
  border-right: 2px solid #024272;
  border-bottom: 1px solid #024272;
  border-left: 2px solid #3d84ba;
  background-color: #3d84ba
}

.book-nav-items::before {
  position: absolute;
  z-index: -1;
  top: 0;
  left: -2px;
  display: block;
  width: 100%;
  height: 0;
  content: '';
  background-color: #e8e6dc;
}
.book-nav-items:nth-of-type(1)::before {
  border-right: 2px solid #ba3c32;
  border-left: 2px solid #f28279;
}
.book-nav-items:nth-of-type(2)::before {
  border-right: 2px solid #c45e17;
  border-left: 2px solid #e5a77b;
}
.book-nav-items:nth-of-type(3)::before {
  border-right: 2px solid #997b00;
  border-left: 2px solid #f2df93;
}
.book-nav-items:nth-of-type(4)::before {
  border-right: 2px solid #02663f;
  border-left: 2px solid #50ce9d;
}
.book-nav-items:nth-of-type(5)::before {
  border-right: 2px solid #015952;
  border-left: 2px solid #5acec5;
}
.book-nav-items:nth-of-type(6)::before {
  border-right: 2px solid #024272;
  border-left: 2px solid #3d84ba;
}

.book-nav-items a {
  display: block;
  height: 150px;
  padding: 10px 3px 0 3px;
  transition: all .4s ;
  text-decoration: none;
}
.book-nav-items a span {
  display: inline-block;
  padding: 5px 1px;
  -ms-writing-mode: tb-rl;
  -webkit-writing-mode: vertical-rl;
  writing-mode: vertical-rl;
  background-color: #e8e6dc;
}

/* hover時の挙動 */
.book-nav-items:hover {
  transform: translateY(5px) scale(1,.95);
  transform-origin: center bottom 0;
  box-shadow: 0 20px 2px 0 rgba(0,0,0,.4);
  border-left-color: rgba(0,0,0,.2);
}
.book-nav-items:hover::before {
  top: -10px;
  height: 11px;
}
.book-nav-items:hover a {
  background-color: rgba(0,0,0,.3);
}
.book-nav-items:hover a span {
  background-color: #bcbaaf;
}


</style>



</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">積読表示</a>
      </div>
    </div>
  </nav>

</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    


  <ul class="book-nav">
<?php foreach($values as $value) { ?>
  
  <li class="book-nav-items"><a href=""><span><?=$value["title"]?></span></a></li>
  <li type="hidden" name="id" value="<?=$v["id"]?>"></li>
    <?php } ?>


</ul>
 

<div class="container jumbotron"></div>
  <?php foreach($values as $value) { ?>
  <table>
  <tr>
    <td><?=$value["id"]?></td>
    <td><?=$value["title"]?></td>
    <td><?=$value["author"]?></td>
    <td><?=$value["text"]?></td>
    <td><?=$value["indate"]?></td>
    
    <td><a href="detail.php?id=<?=$value["id"]?>">[更新]</a></td>
          <td><a href="delete.php?id=<?=$value["id"]?>">[削除]</a></td>
    </tr>
    </table>
    <?php } ?>
  </div>

<!-- Main[End] -->


<script>
  //JSON受け取り
  //$a = '<?=$json?>';
//const obj = JSON.prase($a);
//console.log(obj);


</script>
</body>
</html>
