<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';
if(isset($_POST['h_search'])){

   $h_location = $_POST['h_location'];
   $h_location = filter_var($h_location, FILTER_SANITIZE_STRING);
   $h_type = $_POST['h_type'];
   $h_type = filter_var($h_type, FILTER_SANITIZE_STRING);
   $h_offer = $_POST['h_offer'];
   $h_offer = filter_var($h_offer, FILTER_SANITIZE_STRING);
   $h_min = $_POST['h_min'];
   $h_min = filter_var($h_min, FILTER_SANITIZE_STRING);
   $h_max = $_POST['h_max'];
   $h_max = filter_var($h_max, FILTER_SANITIZE_STRING);

   $h_min = (float) str_replace(array('.', ','), '', $h_min);
   $h_max = (float) str_replace(array('.', ','), '', $h_max);
  

   $select_properties = $conn->prepare("SELECT * FROM `property` WHERE address LIKE '{$h_location}%' AND type LIKE '{$h_type}' AND offer LIKE '{$h_offer}' AND price BETWEEN $h_min AND $h_max ORDER BY date DESC");
   $select_properties->execute();

}elseif(isset($_POST['filter_search'])){
   $location = $_POST['location'];
   $location = filter_var($location, FILTER_SANITIZE_STRING);
   $type = $_POST['type'];
   $type = filter_var($type, FILTER_SANITIZE_STRING);
   $offer = $_POST['offer'];
   $offer = filter_var($offer, FILTER_SANITIZE_STRING);
   $min = $_POST['min'];
   $min = filter_var($min, FILTER_SANITIZE_STRING);
   $max = $_POST['max'];
   $max = filter_var($max, FILTER_SANITIZE_STRING);
   $furnished = $_POST['furnished'];
   $furnished = filter_var($furnished, FILTER_SANITIZE_STRING);
   

   $min = (int) str_replace(array('.', ','), '', $min);
   $max = (int) str_replace(array('.', ','), '', $max);
   
   $select_properties = $conn->prepare("SELECT * FROM `property` WHERE address LIKE '{$location}%' AND type LIKE '{$type}' AND offer LIKE '{$offer}' AND price BETWEEN $min AND $max ORDER BY date DESC");
   $select_properties->execute();

}elseif(isset($_POST['r_filter_search'])){

   $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
   $select_properties->execute();
}else{
   $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
   $select_properties->execute();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Procurar - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>


<section class="filters" style="padding-bottom: 0;">

   <form action="" method="post">
      <div id="close-filter"><i class="fas fa-times"></i></div>
      <h3>Filtre sua pesquisa</h3>
         
         <div class="flex">
            <div class="box">
               <p>Digite a cidade <span>*</span></p>
               <input type="text" name="location" required maxlength="100" placeholder="Digite o nome da cidade" class="input">
            </div>
            <div class="box">
               <p>Tipo de oferta <span>*</span></p>
               <select name="offer" required class="input">
                  <option value="Venda">Venda</option>
                  <option value="Re-venda">Re-venda</option>
                  <option value="Aluguel">Aluguel</option>
               </select>
            </div>
            <div class="box">
               <p>Tipo de propriedade <span>*</span></p>
               <select name="type" required class="input">
                     <option value="Apartamento">Apartamento</option>
                     <option value="Casa">Casa</option>
               </select>
            </div>
            <div class="box">
               <p>Orçamento minimo <span>*</span></p>
            <input type="text" name="min" required maxlength="100" placeholder="Orçamento minimo" class="input" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
               
            </div>
            <div class="box">
               <p>Orçamento maximo <span>*</span></p>
               <input type="text" name="max" required maxlength="100" placeholder="Orçamento maximo" class="input" onKeyPress="return(MascaraMoeda(this,'.',',',event))"> 
            </div>
         <div class="box">
            <p>Status de mobilia</p>
            <select name="furnished" class="input">
               <option value="Mobilhada">Mobilhada</option>
               <option value="Semi-mobilhada">Semi-mobilhada</option>
               <option value="Sem mobilha">Sem mobilha</option>
            </select>
         </div>
         </div>
         <div class="flex-btn">
         <input type="submit" value="Procurar propriedades" name="filter_search" class="btn" style = "width: 49.5%">


   </form>
   <form action="" method="post" style = "padding: 0">
         <input type="submit" value="Excluir filtros" name="r_filter_search" class="btn" style = "width: 100%; margin-right: 37.5rem">
         </form>
         
</div>
</section>


<div id="filter-btn" class="fas fa-filter"></div>

<?php


   
?>


<section class="listings">

   <?php 
      if(isset($_POST['h_search']) or isset($_POST['filter_search'])){
         echo '<h1 class="heading">Resultado</h1>';
      }else{
         echo '<h1 class="heading">Ultimas postagens</h1>';
      }
   ?>

   <div class="box-container">
      <?php
         $total_images = 0;
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_user->execute([$fetch_property['user_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            if(!empty($fetch_property['image_02'])){
               $image_coutn_02 = 1;
            }else{
               $image_coutn_02 = 0;
            }
            if(!empty($fetch_property['image_03'])){
               $image_coutn_03 = 1;
            }else{
               $image_coutn_03 = 0;
            }
            if(!empty($fetch_property['image_04'])){
               $image_coutn_04 = 1;
            }else{
               $image_coutn_04 = 0;
            }
            if(!empty($fetch_property['image_05'])){
               $image_coutn_05 = 1;
            }else{
               $image_coutn_05 = 0;
            }

            $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

            $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
            $select_saved->execute([$fetch_property['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>Remover de salvos</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>Salvar</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><span>R$ <?= number_format($fetch_property['price'] ,2,",",".");?></span></div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
               <p><i class="fa fa-cutlery" aria-hidden="true"></i><span><?= $fetch_property['bhk']; ?></span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
               
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">Ver propriedade</a>
               <input type="submit" value="Enviar requisição" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">Nenhum resultado encontrado!</p>';
      }
      ?>
      
   </div>

</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

document.querySelector('#filter-btn').onclick = () =>{
   document.querySelector('.filters').classList.add('active');
}

document.querySelector('#close-filter').onclick = () =>{
   document.querySelector('.filters').classList.remove('active');
}

</script>

</body>
</html>