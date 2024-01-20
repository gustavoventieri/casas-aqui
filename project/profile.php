<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['sair'])){
    header("location:components/user_logout.php");
}
elseif(isset($_POST['atl'])){
    header("location:update.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Perfil - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'components/user_header.php'; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<section class="form-container">

   <form action="" method="post">
      <h3>Perfil</h3>
      <input type="email" name="email" maxlength="50" disabled placeholder="Email:                  <?= $fetch_user['email']; ?>" class="box" style = "border: none; background: white;">
      <input type="tel" name="name" maxlength="50" disabled  placeholder="Nome:                  <?= $fetch_user['name']; ?>" class="box" style = "border: none; background: white;">
      <input type="number" name="number" min="0" max="9999999999" disabled maxlength="10" placeholder="Numero:             <?= $fetch_user['number']; ?>" class="box" style = "border: none; background: white;">
      <div class="flex-btn">
      <button type="submit" name="atl" class="btn">Atualizar perfil</button>
      <button type="submit" name="sair" class="btn" style = "background: red;" onclick="return confirm('Sair deste site?');">Sair</button>
    </div>
   </form>

</section>
<script src="js/script.js"></script>

<?php include 'components/footer.php'; ?>

<?php include 'components/message.php'; ?>
</body>
</html>