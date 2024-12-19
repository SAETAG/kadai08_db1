<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得
$name = $_POST['name'];
$email  = $_POST['email'];
$content = $_POST['content'];


$db_name = '';               // データベース名
$db_host = '';     // DBホスト
$db_id   = '';               // ユーザー名(さくらサーバはDB名と同一)
$db_pw   = '';                   // パスワード

try {
  $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
  $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
  // エラーだった場合の情報を返す処理
  // exitした時点でそれ以降の処理は行われません
  exit('DB Connection Error:' . $e->getMessage());
}


// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_an_table(id, name , email, content, date) VALUES(NULL , :name, :email, :content, now())");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
    header('Location: index.php');
}
?>
