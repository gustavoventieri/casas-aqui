
<header class="header">

   <nav class="navbar nav-1">
      <section class="flex">
         <a href="index.php" class="logo"><i class="fas fa-house"></i>Casas Aqui</a>

         <ul>
            <li><a href="post_property.php">Postar Propriedade<i class="fas fa-paper-plane"></i></a></li>
         </ul>
      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
            <?php  if($user_id != ''){ ?>
               <li><a href="#">Listagens<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="dashboard.php">Painel</a></li>
                     <li><a href="post_property.php">Postar</a></li>
                     <li><a href="my_listings.php">Minhas Listagens</a></li>
                  </ul>
               </li>
               <li><a href="#">Opções<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="search.php">Procurar</a></li>
                     <li><a href="listings.php">Propriedades</a></li>
                  </ul>
               </li>
               <li><a href="#">Ajuda<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="contact.php">Contate-nos</a></i></li>
                  </ul>
               </li>
            </ul>
         </div>

         <ul>
            <li><a href="saved.php">Salvos<i class="far fa-heart"></i></a></li>
            <li><a href="#">Conta<i class="fas fa-angle-down"></i></a>
               <ul>
                  <li><a href="profile.php">Perfil</a></li>
                  <li><a href="components/user_logout.php" onclick="return confirm('Sair deste site?');">Sair</a>
                  <?php }else{ ?>
                     <li><a href="#">Conta<i class="fas fa-angle-down"></i></a>
                        <ul>
                           <li><a href="login.php">Entrar</a></li>
                           <li><a href="register.php">Registre-se</a></li>
                        </ul>
                  </li>
                  <li><a href="#">Opções<i class="fas fa-angle-down"></i></a>
                     <ul>
                     <li><a href="search.php">Procurar por filtro</a></li>
                     <li><a href="listings.php">Todas propriedade</a></li>
                     </ul>
                  </li>
                  <?php } ?>
                  </li>
               </ul>
            </li>
         </ul>
      </section>
   </nav>

</header>
