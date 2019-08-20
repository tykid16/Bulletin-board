<?php
$num = 1;
$count = 0;
$a = "";
$b = "";
$b2 ="";
$b3 ="";
$dsn='データベース';
$user ='ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$date = date("Y/m/d H:i:s");

// 編集フォーム(フォームに表示させる)
if(isset($_POST["hen"])) {
  if(!empty($_POST["hensyuu"]) && !empty($_POST["pass3"])) {
    $id = $_POST["hensyuu"];
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) {  
         if( $row['id'] == $id) {
            if( $row[4] == $_POST["pass3"]) {
                $a = $row[1];
                $b = $row[2];
                $b2 = $row[0];
                $b3 = $row[4];
            }
         }
      }
   }
}
?>

<html>
<head>
  <meta name="viewport" content="width=320, height=480, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <meta charset="utf-8">
    <title>5-1</title>
</head>
<body>
<form method="POST" action="YAMA_mission_5-1.php">
    <input type ="text" name="name" placeholder="名前" value = "<?php echo $a; ?>"><br>
    <input type ="text" name="comment" placeholder="コメント" value = "<?php echo $b; ?>"><br>
    <input type ="text" name="pass" placeholder="パスワード" value = "<?php echo $b3; ?>">
    <input type="submit" name = "sou" value="送信"><br>
    <input type ="hidden" name="kieru"  value = "<?php echo $b2; ?>"><br>
    <input type ="text" name="delete" placeholder="削除対象番号"><br>
    <input type ="text" name="pass2" placeholder="パスワード">
    <input type="submit" name = "del" value="削除"><br>
    <br>
    <input type ="text" name="hensyuu" placeholder="編集指定番号"><br>
    <input type ="text" name="pass3" placeholder="パスワード">
    <input type="submit" name = "hen" value="編集" ><br>
    <hr>
<?php
// 送信フォーム
if(isset($_POST["sou"]))
{
  if (!empty($_POST["kieru"])) // 編集か判断
  {
    $id = $_POST["kieru"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $pass = $_POST["pass"];
    $sql = 'update tbtest set name=:name,comment=:comment, pass=:pass where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
  else {
   if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])) 
   {
    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $date = $date;
    $pass = $_POST["pass"];
    $sql -> execute();
    }
   }
 }
   
 if(isset($_POST["del"]))
{
   if (!empty($_POST["delete"])&& !empty($_POST["pass2"])) 
   {
     $id = $_POST["delete"];
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
       foreach ($results as $row)
       {
        if( $row['id'] == $id)
        {
        if( $row[4] == $_POST["pass2"])
        {
            $id = $_POST["delete"];
            $sql = 'delete from tbtest where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        }
       }
  }
}

    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
        echo "<hr>";
    }
?>
</form>
</body>
</html>