  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
   	<a href="./" class="brand-link">
        <?php if($_SESSION['login_type'] == 1): ?>
        <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
        <?php else: ?>
        <h3 class="text-center p-0 m-0"><b>client</b></h3>
        <?php endif; ?>

    </a>
      
    </div>
    <div class="sidebar pb-4 mb-4">
      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>     
          <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_livreur">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Client
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_livreur" class="nav-link nav-new_livreur tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=Livreur_list" class="nav-link nav-Livreur_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_client">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Livreur
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_client" class="nav-link nav-new_client tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=client_list" class="nav-link nav-client_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_colis">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Colis
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_colis" class="nav-link nav-new_colis tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=colis_list" class="nav-link nav-colis_list nav-sall tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List All</p>
                </a>
              </li>
              <?php 
              $status_arr = array("Article accepte","Expédié","En-Transit","Delivered");
              foreach($status_arr as $k =>$v):
              ?>
              <li class="nav-item">
                <a href="./index.php?page=colis_list&s=<?php echo $k ?>" class="nav-link nav-colis_list_<?php echo $k ?> tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p><?php echo $v ?></p>
                </a>
              </li>
            <?php endforeach; ?>
            </ul>
          </li>
           <li class="nav-item dropdown">
            <a href="./index.php?page=track" class="nav-link nav-track">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Track Colis
              </p>
            </a>
          </li>  
           <li class="nav-item dropdown">
            <a href="./index.php?page=reports" class="nav-link nav-reports">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Reports
              </p>
            </a>
          </li>  
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>