<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['post'])){

   $id = create_unique_id();
   $property_name = $_POST['property_name'];
   $property_name = filter_var($property_name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $price = (float) str_replace(array('.', ','), '', $price);
   $deposite = $_POST['deposite'];
   $deposite = filter_var($deposite, FILTER_SANITIZE_STRING);
   $deposite = (float) str_replace(array('.', ','), '', $deposite);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $offer = $_POST['offer'];
   $offer = filter_var($offer, FILTER_SANITIZE_STRING);
   $type = $_POST['type'];
   $type = filter_var($type, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $furnished = $_POST['furnished'];
   $furnished = filter_var($furnished, FILTER_SANITIZE_STRING);
   $bhk = $_POST['bhk'];
   $bhk = filter_var($bhk, FILTER_SANITIZE_STRING);
   $bedroom = $_POST['bedroom'];
   $bedroom = filter_var($bedroom, FILTER_SANITIZE_STRING);
   $bathroom = $_POST['bathroom'];
   $bathroom = filter_var($bathroom, FILTER_SANITIZE_STRING);
   $age = $_POST['age'];
   $age = filter_var($age, FILTER_SANITIZE_STRING);
   $total_floors = $_POST['total_floors'];
   $total_floors = filter_var($total_floors, FILTER_SANITIZE_STRING);
   $room_floor = $_POST['room_floor'];
   $room_floor = filter_var($room_floor, FILTER_SANITIZE_STRING);
   $loan = $_POST['loan'];
   $loan = filter_var($loan, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);

   

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
   $rename_image_02 = create_unique_id().'.'.$image_02_ext;
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_size = $_FILES['image_02']['size'];
   $image_02_folder = 'uploaded_files/'.$rename_image_02;

   if(!empty($image_02)){
      if($image_02_size > 2000000){
         $warning_msg[] = 'image 02 é muito grande!';
      }else{
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
      }
   }else{
      $rename_image_02 = '';
   }

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
   $rename_image_03 = create_unique_id().'.'.$image_03_ext;
   $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
   $image_03_size = $_FILES['image_03']['size'];
   $image_03_folder = 'uploaded_files/'.$rename_image_03;

   if(!empty($image_03)){
      if($image_03_size > 2000000){
         $warning_msg[] = 'image 03 é muito grande!';
      }else{
         move_uploaded_file($image_03_tmp_name, $image_03_folder);
      }
   }else{
      $rename_image_03 = '';
   }

   $image_04 = $_FILES['image_04']['name'];
   $image_04 = filter_var($image_04, FILTER_SANITIZE_STRING);
   $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
   $rename_image_04 = create_unique_id().'.'.$image_04_ext;
   $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
   $image_04_size = $_FILES['image_04']['size'];
   $image_04_folder = 'uploaded_files/'.$rename_image_04;

   if(!empty($image_04)){
      if($image_04_size > 2000000){
         $warning_msg[] = 'image 04 é muito grande!';
      }else{
         move_uploaded_file($image_04_tmp_name, $image_04_folder);
      }
   }else{
      $rename_image_04 = '';
   }

   $image_05 = $_FILES['image_05']['name'];
   $image_05 = filter_var($image_05, FILTER_SANITIZE_STRING);
   $image_05_ext = pathinfo($image_05, PATHINFO_EXTENSION);
   $rename_image_05 = create_unique_id().'.'.$image_05_ext;
   $image_05_tmp_name = $_FILES['image_05']['tmp_name'];
   $image_05_size = $_FILES['image_05']['size'];
   $image_05_folder = 'uploaded_files/'.$rename_image_05;

   if(!empty($image_05)){
      if($image_05_size > 2000000){
         $warning_msg[] = 'image 05 é muito grande!';
      }else{
         move_uploaded_file($image_05_tmp_name, $image_05_folder);
      }
   }else{
      $rename_image_05 = '';
   }

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = 'uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'image 01 é muito grande!!';
   }else{
      $insert_property = $conn->prepare("INSERT INTO `property`(id, user_id, property_name, address, price, type, offer, status, furnished, bhk, deposite, bedroom, bathroom, age, total_floors, room_floor, loan, image_01, image_02, image_03, image_04, image_05, description) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_property->execute([$id, $user_id, $property_name, $address, $price, $type, $offer, $status, $furnished, $bhk, $deposite, $bedroom, $bathroom, $age, $total_floors, $room_floor, $loan, $rename_image_01, $rename_image_02, $rename_image_03, $rename_image_04, $rename_image_05, $description]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'Propriedade postada com sucesso';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Postar propriedade - Casas Aqui</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="property-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Detalhes da propriedade</h3>
      <div class="box">
         <p>Nome da propriedade <span>*</span></p>
         <input type="text" name="property_name" required maxlength="50" placeholder="Digite o nome da propriedade" class="input">
      </div>
      <div class="flex">
         <div class="box">
            <p>Preço da propriedade<span>*</span></p>
            <input type="text" name="price" required min="0" max="9999999999" maxlength="10" placeholder="Digite o preço da propriedade" class="input" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
         </div>
         <div class="box">
            <p>Deposito minimo <span>*</span></p>
            <input type="text" name="deposite" required min="0" max="9999999999" maxlength="10"  placeholder="Digite o preço do deposito minimo" class="input" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
         </div>
         <div class="box">
            <p>Cidade da propriedade <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="Digite a cidade da propriedade"class="input">
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
            <p>Status da propriedade<span>*</span></p>
            <select name="status" required class="input">
               <option value="Pronta para se mudar">Pronta para se mudar</option>
               <option value="Em construção">Em construção</option>
            </select>
         </div>
         <div class="box">
            <p>Status de mobilia <span>*</span></p>
            <select name="furnished" required class="input">
               <option value="Mobilhada">Mobilhada</option>
               <option value="Semi-mobilhada">Semi-mobilhada</option>
               <option value="Sem mobilha">Sem mobilha</option>
            </select>
         </div>
         <div class="box">
            <p>Quantidade de cozinhas <span>*</span></p>
            <input type="text" name="bhk" required maxlength="100" placeholder="Digite quantas cozinhas há" class="input">
         </div>
         <div class="box">
            <p>Quantidade de quartos <span>*</span></p>
            <input type="text" name="bedroom" required maxlength="100" placeholder="Digite quantos quartos há" class="input">
         </div>
         <div class="box">
            <p>Quantidade de banheiros <span>*</span></p>
            <input type="text" name="bathroom" required maxlength="100" placeholder="Digite quantos banheiros há" class="input">
         </div>
         <div class="box">
            <p>Idade da Propriedade <span>*</span></p>
            <input type="number" name="age" required min="0" max="99" maxlength="2" placeholder="Digite a idade da propriedade" class="input">
         </div>
         <div class="box">
            <p>Quantidade total de comodos <span>*</span></p>
            <input type="number" name="total_floors" required min="0" max="99" maxlength="2" placeholder="Digite a quantidade de quartos" class="input">
         </div>
         <div class="box">
            <p>Quantidade de andares <span>*</span></p>
            <input type="number" name="room_floor" required min="0" max="99" maxlength="2" placeholder="Digite a quantidade de andares" class="input">
         </div>
         <div class="box">
            <p>Status <span>*</span></p>
            <select name="loan" required class="input">
               <option value="Disponivel">Disponivel</option>
               <option value="Não disponivel">Não disponivel</option>
            </select>
         </div>
      </div>
      <div class="box">
         <p>Descrição da propriedade <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="Escreva sobre a propriedade..."></textarea>
      </div>
      <div class="box">
         <p>imagem 01 <span>*</span></p>
         <input type="file" name="image_01" class="input" accept="image/*" required>
      </div>
      <div class="flex"> 
         <div class="box">
            <p>imagem 02</p>
            <input type="file" name="image_02" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>imagem 03</p>
            <input type="file" name="image_03" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>imagem 04</p>
            <input type="file" name="image_04" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>imagem 05</p>
            <input type="file" name="image_05" class="input" accept="image/*">
         </div>   
      </div>
      <input type="submit" value="Posta propriedade" class="btn" name="post">
   </form>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>