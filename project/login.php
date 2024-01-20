<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){



   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING); 
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

   
   

   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_users->execute([$email, $pass]);
   $row = $select_users->fetch(PDO::FETCH_ASSOC);

   if($select_users->rowCount() > 0){
      setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
      if ($email == "admins@admins.com" && $pass == "f865b53623b121fd34ee5426c792e5c33af8c227") {
         header('location:admin/login.php');
      } else {
         header('location:index.php');
      }
   }else{
         $warning_msg[] = 'Senha ou nome de usuario incorreto!';
   }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>


<section class="form-container">

   <form action="" method="post">
      <h3>Bem vindo de novo</h3>
      <input type="email" name="email" required maxlength="50" placeholder="Digite seu email" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="Digite sua senha" class="box">
      <p>Não tem uma conta? <a href="register.php">registre-se aqui</a></p>
      <input type="submit" value="Entrar" name="submit" class="btn">
   </form>

</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>