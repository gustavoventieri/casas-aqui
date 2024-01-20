<?php

include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:dashboard.php');
}

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $select_images = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)){
         $image_01 = $fetch_images['image_01'];
         $image_02 = $fetch_images['image_02'];
         $image_03 = $fetch_images['image_03'];
         $image_04 = $fetch_images['image_04'];
         $image_05 = $fetch_images['image_05'];
         unlink('../uploaded_files/'.$image_01);
         if(!empty($image_02)){
            unlink('../uploaded_files/'.$image_02);
         }
         if(!empty($image_03)){
            unlink('../uploaded_files/'.$image_03);
         }
         if(!empty($image_04)){
            unlink('../uploaded_files/'.$image_04);
         }
         if(!empty($image_05)){
            unlink('../uploaded_files/'.$image_05);
         }
      }
      $delete_listings = $conn->prepare("DELETE FROM `property` WHERE id = ?");
      $delete_listings->execute([$delete_id]);
      $success_msg[] = 'Listing deleted!';
   }else{
      $warning_msg[] = 'Listing deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Detalhes da Propriedade - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php include '../components/admin_header.php'; ?>

<section class="view-property">

   <h1 class="heading">Detalhes da Propriedade</h1>

   <?php
      $select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_properties->execute([$get_id]);
      if($select_properties->rowCount() > 0){
         while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){

         $property_id = $fetch_property['id'];

         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_user->execute([$fetch_property['user_id']]);
         $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

   ?>
   <div class="details">
     <div class="swiper images-container">
         <div class="swiper-wrapper">
            <img src="../uploaded_files/<?= $fetch_property['image_01']; ?>" alt="" class="swiper-slide">
            <?php if(!empty($fetch_property['image_02'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_02']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_property['image_03'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_03']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_property['image_04'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_04']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_property['image_05'])){ ?>
            <img src="../uploaded_files/<?= $fetch_property['image_05']; ?>" alt="" class="swiper-slide">
            <?php } ?>
         </div>
         <div class="swiper-pagination"></div>
     </div>
      <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
      <div class="info">
         <p><span style = "color: var(--main-color);">R$ </span><span><?=number_format($fetch_property['price'] ,2,",","."); ?></span></p>
         <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
         <p><i class="fas fa-phone"></i><a href="tel:<?= $fetch_user['number']; ?>"><?= $fetch_user['number']; ?></a></p>
         <p><i class="fas fa-building"></i><span><?= $fetch_property['type']; ?></span></p>
         <p><i class="fas fa-house"></i><span><?= $fetch_property['offer']; ?></span></p>
         <p><i class="fas fa-calendar"></i><span><?= $fetch_property['date']; ?></span></p>
      </div>
      <h3 class="title">Detalhes</h3>
      <div class="flex">
         <div class="box">
            <p><i>Cozinha :</i><span><?= $fetch_property['bhk']; ?> </span></p>
            <p><i>Deposito : </i><span style = "color: var(--main-color);">R$ </span><span><?=number_format($fetch_property['deposite'] ,2,",","."); ?></span></p>
            <p><i>Status :</i><span><?= $fetch_property['status']; ?></span></p>
            <p><i>Quartos :</i><span><?= $fetch_property['bedroom']; ?></span></p>
            <p><i>Banheiros :</i><span><?= $fetch_property['bathroom']; ?></span></p>
         </div>
         <div class="box">
            <p><i>Idade da propriedade :</i><span><?= $fetch_property['age'];  ?> Ano/Anos</span></p>
            <p><i>Comodos totais  :</i><span><?= $fetch_property['total_floors']; ?></span></p>
            <p><i>Andares :</i><span><?= $fetch_property['room_floor']; ?></span></p>
            <p><i>Mobilhada :</i><span><?= $fetch_property['furnished']; ?></span></p>
            <p><i>Status :</i><span><?= $fetch_property['loan']; ?></span></p>
         </div>
      </div>
      <h3 class="title">Descrição</h3>
      <p class="description"><?= $fetch_property['description']; ?></p>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="delete_id" value="<?= $property_id; ?>">
         <input type="submit" value="Apagar propriedade" name="delete" class="delete-btn" onclick="return confirm('Apagar esta listagem?');">
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Propriedade não encontrada<a href="listings.php" style="margin-top:1.5rem;" class="option-btn">Ir para listagens</a></p>';
   }
   ?>

</section>


















<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

<script>

var swiper = new Swiper(".images-container", {
   effect: "coverflow",
   grabCursor: true,
   centeredSlides: true,
   slidesPerView: "auto",
   loop:true,
   coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 200,
      modifier: 3,
      slideShadows: true,
   },
   pagination: {
      el: ".swiper-pagination",
   },
});

</script>

</body>
</html>