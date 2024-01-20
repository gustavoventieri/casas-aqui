<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Painel - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">Painel de Controle</h1>

   <div class="box-container">

      <div class="box">
      <?php
         $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
         $select_profile->execute([$user_id]);
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <h3>Bem vindo!</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update.php" class="btn">Atualizar perfil</a>
      </div>

      <div class="box">
         <h3>Procurar por filtro</h3>
         <p>Procure sua propriedade dos sonhos</p>
         <a href="search.php" class="btn">Procuar agora</a>
      </div>

      <div class="box">
      <?php
        $count_properties = $conn->prepare("SELECT * FROM `property` WHERE user_id = ?");
        $count_properties->execute([$user_id]);
        $total_properties = $count_properties->rowCount();
      ?>
      <h3><?= $total_properties; ?></h3>
      <p>Propriedades listadas</p>
      <a href="my_listings.php" class="btn">Ver todas listagens</a>
      </div>

      <div class="box">
      <?php
        $count_requests_received = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
        $count_requests_received->execute([$user_id]);
        $total_requests_received = $count_requests_received->rowCount();
      ?>
      <h3><?= $total_requests_received; ?></h3>
      <p>Requisições recebidas</p>
      <a href="requests.php" class="btn">Ver todas requisições</a>
      </div>

      <div class="box">
      <?php
        $count_requests_sent = $conn->prepare("SELECT * FROM `requests` WHERE sender = ?");
        $count_requests_sent->execute([$user_id]);
        $total_requests_sent = $count_requests_sent->rowCount();
      ?>
      <h3><?= $total_requests_sent; ?></h3>
      <p>Requisições enviadas</p>
      <a href="requests.php" class="btn">Ver propostas enviadas</a>
      </div>

      <div class="box">
      <?php
        $count_saved_properties = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
        $count_saved_properties->execute([$user_id]);
        $total_saved_properties = $count_saved_properties->rowCount();
      ?>
      <h3><?= $total_saved_properties; ?></h3>
      <p>Propriedades salvas</p>
      <a href="saved.php" class="btn">Ver propriedades salvas</a>
      </div>

   </div>

</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>