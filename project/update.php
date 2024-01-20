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

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); 
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
      $success_msg[] = 'Nome atualizado!';
   }

   if(!empty($email)){
      $verify_email = $conn->prepare("SELECT email FROM `users` WHERE email = ?");
      $verify_email->execute([$email]);
      if($verify_email->rowCount() > 0){
         $warning_msg[] = 'Email já cadastrado!';
      }else{
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $user_id]);
         $success_msg[] = 'Email atualizado!';
      }
   }

   if(!empty($number)){
      $verify_number = $conn->prepare("SELECT number FROM `users` WHERE number = ?");
      $verify_number->execute([$number]);
      if($verify_number->rowCount() > 0){
         $warning_msg[] = 'Numero já cadastrado';
      }else{
         $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
         $update_number->execute([$number, $user_id]);
         $success_msg[] = 'Numero atualizado!';
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $fetch_user['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $warning_msg[] = 'Senha antiga incorreta';
      }elseif($new_pass != $c_pass){
         $warning_msg[] = 'A senhas não correspondem';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass->execute([$c_pass, $user_id]);
            $success_msg[] = 'Senha atualizada com sucesso!';
         }else{
            $warning_msg[] = 'Por favor, digite a nova senha!';
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
   <title>Atualizar sua Conta - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form name = "registro" action="" method="POST">
      <h3>Atualize sua conta</h3>
      <input type="tel" name="name" maxlength="50" placeholder="Digite o novo nome" class="box">
      <input type="email" name="email" maxlength="50" placeholder="Digite o email novo" class="box">
      <input type="text" name="number" min="0" max="99999999999999999999" maxlength="19" placeholder="Digite o novo numero" class="box" onkeypress = "return MascaraTel(window.event.keyCode);">
      <input type="password" name="old_pass" maxlength="20" placeholder="Digite a senha antiga" class="box">
      <input type="password" name="new_pass" maxlength="20" placeholder="Digite a senha nova" class="box">
      <input type="password" name="c_pass" maxlength="20" placeholder="Confirme a senha nova" class="box">
      <input type="submit" value="Atualizar conta" name="submit" class="btn">
   </form>

</section>






<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/footer.php'; ?>



<?php include 'components/message.php'; ?>
</body>
</html>