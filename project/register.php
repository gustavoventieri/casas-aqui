<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   

   $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_users->execute([$email]);

   if($select_users->rowCount() > 0){
      $warning_msg[] = 'Email ja foi usado!';
   }else{
      if($pass != $c_pass){
         $warning_msg[] = 'Senhas não correspondentes';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, number, email, password) VALUES(?,?,?,?,?)");
         $insert_user->execute([$id, $name, $number, $email, $c_pass]);
         
         if($insert_user){
            $verify_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
            $verify_users->execute([$email, $pass]);
            $row = $verify_users->fetch(PDO::FETCH_ASSOC);
         
            if($verify_users->rowCount() > 0){
               setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
               header('location:index.php');
            }else{
               $error_msg[] = 'Erro em alguma coisae';
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registro - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>


<section class="form-container">

   <form name = "registro" action="" method="post">
      <h3>Criar uma conta!</h3>
      <input type="tel" name="name" required maxlength="50" placeholder="Digite seu username" class="box">
      <input type="email" name="email" required maxlength="50" placeholder="Digite seu email" class="box">
      <input type="text" name="number" required min="0" max="99999999999999" maxlength="19" placeholder="Digite seu numero" class="box" onkeypress = "return MascaraTel(window.event.keyCode);">
      <input type="password" name="pass" required maxlength="20" placeholder="Digite sua senha" class="box">
      <input type="password" name="c_pass" required maxlength="20" placeholder="Confirme sua senha" class="box">
      <p>Já tem uma conta? <a href="login.php">Entrar</a></p>
      <input type="submit" value="Regristre-se" name="submit" class="btn">
   </form>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>