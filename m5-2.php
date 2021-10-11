<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>

<body>




<?php
//date表示できない

//投稿機能
    
        
       
        
    //データベースへの接続
    $dsn = "データベース名";
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    
    //CREATE文：データベース内にテーブルを作成 
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"//テーブル名は「tbtest」
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"//id ・自動で登録されていうナンバリング。
    . "name char(32),"//name ・名前を入れる。文字列、半角英数で32文字。
    . "comment TEXT,"//comment ・コメントを入れる。文字列、長めの文章も入る。
    . "date DATETIME"//date
    .");";//コンマ注意
    
    $stmt = $pdo->query($sql);
    
    
   
    
    //INSERT文：データを入力（データレコードの挿入）
    if(!empty($_POST["name"])&& !empty($_POST["comment"])&& empty($_POST["str"])){
    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment,date) VALUES (:name, :comment,:date)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $date = date("Y-m-d H:i:s");
    $sql -> execute();
    }
    else{
        
    }
    
    
    
    
    
//削除機能
    if(!empty($_POST["delete"])){
        $delete = $_POST["delete"];// 削除対象番号を受信、受信した削除対象番号を変数に代入
    //DELETE文：入力したデータレコードを削除
    $sql = 'delete from tbtest where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
    $stmt->execute();
    }else{
        
    }



//編集選択機能
    if(!empty($_POST["edit"])){
    $edit = $_POST["edit"];
    $sql='SELECT * FROM tbtest where id=:id'; 
        $stmt=$pdo->prepare($sql); 
        $stmt->bindParam(':id',$edit,PDO::PARAM_INT); 
        $stmt->execute();
        $results=$stmt->fetchAll(); 
        foreach($results as $row){
    
                 $editnumber=$row['id'];
                 $editname=$row['name'];
                 $editcomment=$row['comment'];
        }
    }
    
//編集機能 
    if(!empty($_POST["str"])){
    $editnum = $_POST["str"]; 
    $editname2 = $_POST["name"];
    $editcomment2 = $_POST["comment"];
    $date = date("Y-m-d H:i:s");
    
    $sql = 'UPDATE tbtest SET name=:name,comment=:comment, date=:date WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $editname2, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $editcomment2, PDO::PARAM_STR);
    $stmt->bindParam(':id', $editnum, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);//STRかINTか
    $stmt->execute();
    }else{
        
    }
?>

<form action="" method="post">
        <input type="text" name="name" value = "<?php echo @$editname;?>"placeholder=名前><br>
        <input type="text" name="comment"  value = "<?php echo @$editcomment;?>"placeholder=コメント>
        <input type="hidden" name="str" value = "<?php echo @$editnumber;?>">
        <input type="submit" name="submit" ></p>
        <input type="text" name="delete" placeholder=削除対象番号>
        <input type="submit" name="submit"value="削除"></p>
        <input type="text" name="edit" placeholder=編集対象番号>
         <input type="submit" name="submit"value="編集">
       
</form>
    

<?php    
//表示機能
    //SELECT文：入力したデータレコードを抽出し、表示する
    //$rowの添字（[ ]内）は、4-2で作成したカラムの名称に併せる必要があります。
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    echo "<hr>";
    }
    
     
        
        
    
    
    ?>

    
