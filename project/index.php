<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home - Casas Aqui</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>


<div class="home">

   <section class="center">

      <form action="search.php" method="POST">
         <h3>ache sua casa perfeita</h3>
         <div class="box">
            <p>Digite a cidade <span>*</span></p>
            <input type="text" name="h_location" required maxlength="100" placeholder="Digite o nome da cidade" class="input">
         </div>
         <div class="flex">
            <div class="box">
               <p>Tipo de propriedade <span>*</span></p>
               <select name="h_type" class="input" required>
                  <option value="Apartamento">Apartamento</option>
                  <option value="Casa">Casa</option>
               </select>
            </div>
            <div class="box">
               <p>Tipo de oferta <span>*</span></p>
               <select name="h_offer" class="input" required>
                  <option value="Venda">Venda</option>
                  <option value="Re-venda">Re-venda</option>
                  <option value="Aluguel">Aluguel</option>
               </select>
            </div>
            <div class="box">
               <p>Orçamento minimo <span>*</span></p>
            <input type="text" name="h_min" required maxlength="100" placeholder="Orçamento minimo" class="input" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
               
            </div>
            <div class="box">
               <p>Orçamento maximo <span>*</span></p>
               <input type="text" name="h_max" required maxlength="100" placeholder="Orçamento maximo" class="input" onKeyPress="return(MascaraMoeda(this,'.',',',event))"> 
            </div>
         </div>
         <input type="submit" value="Procurar propriedades" name="h_search" class="btn">
      </form>

   </section>

</div>


<section class="listings">

   <h1 class="heading">Ultimas listagens</h1>

   <div class="box-container">
      <?php
         $total_images = 0;
         $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
         $select_properties->execute();
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
         <div class="price"><span style = "color: var(--main-color);">R$ </span><span><?= number_format($fetch_property['price'] ,2,",",".");?></span></div>
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
               <input type="submit" value="Enviar proposta" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">Nenhuma propriedade listada ainda! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">Adicionar nova</a></p>';
      }
      ?>
      
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="listings.php" class="inline-btn">Ver tudo</a>
   </div>

</section>










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

   let range = document.querySelector("#range");
   range.oninput = () =>{
      document.querySelector('#output').innerHTML = range.value;
   }

</script>

</body>
</html>