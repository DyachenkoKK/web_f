<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET')	
{
  if (!empty($_GET['save']))
 {
    print('Спасибо, результаты сохранены.');
  }
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['name']))
{
  print('Заполните имя.<br/>');
  $errors = TRUE;
}
if (empty($_POST['mail']))
{
  print('Введите почту.<br/>');
  $errors = TRUE;
}
if (empty($_POST['date']))
{
  print('Заполните дату.<br/>');
  $errors = TRUE;
}

if ($errors)
{
  print('hi error');
  exit();
}
  
$user = 'u47592';
$pass = '8750191';
$db = new PDO('mysql:host=localhost;dbname=u47592', $user, $pass, array(PDO::ATTR_PERSISTENT => true));



try {
  $stmt = $db->prepare("INSERT INTO project4 (name, email, birth, pol, konechnosti, biography, date) VALUES (:name, :email, :birth, :pol, :konechnosti, :biography, :date)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':birth', $birth);
  $stmt->bindParam(':pol', $pol);
  $stmt->bindParam(':konechnosti', $konechnosti);
  $stmt->bindParam(':biography', $biography);
  $stmt->bindParam(':date', $date);
  $name = $_POST['name'];
  $email = $_POST['email'];
  $birth = $_POST['birth'];
  $pol =$_POST['pol'];
  $konechnosti = $_POST['konechnosti'];
  $biography = $_POST['biography'];
  $date = date('Y-m-d');;
  $stmt->execute();
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
try{
  $stmt = $db->prepare("SELECT id FROM project4 WHERE name = :name AND email = :email AND birth = :birth AND pol = :pol AND konechnosti = :konechnosti AND biography = :biography AND date = :date");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':birth', $birth);
  $stmt->bindParam(':pol', $pol);
  $stmt->bindParam(':konechnosti', $konechnosti);
  $stmt->bindParam(':biography', $biography);
  $stmt->bindParam(':date', $date);
  $stmt->execute();
  $personID=$stmt->fetchColumn();
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
foreach($_POST['powers'] as $power){
  try{
    if($power=='1')
      $power_name="immortal";
        if($power=='2')
      $power_name="passing through walls";
        if($power=='3')
      $power_name="levitation";
    $stmt = $db->prepare("INSERT INTO project4_powers (personID, power) VALUES (:personID, :power)");
    $stmt->bindParam(':personID', $personID);
    $stmt->bindParam(':power', $power_name);
    $stmt->execute();
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }
}

header('Location: ?save=1');
