<?php include 'db_connect.php' ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Track</h1>
          </div>

        </div>
            <hr class="border-primary">
      </div>
    </div>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<div class="d-flex w-100 px-1 py-2 justify-content-center align-items-center">
				<label for="">Enter Tracking Number</label>
				<div class="input-group col-sm-5">
                    <input type="search" id="ref_no" class="form-control form-control-sm" placeholder="Type the tracking number here">
                    <div class="input-group-append">
                        <button type="button" id="track-btn" class="btn btn-sm btn-primary btn-gradient-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<div class="timeline" id="colis_history">
				
			</div>
		</div>
	</div>
</div>
<div id="clone_timeline-item" class="d-none">
	<div class="iitem">
	    <i class="fas fa-box bg-blue"></i>
	    <div class="timeline-item">
	      <span class="time"><i class="fas fa-clock"></i> <span class="dtime">12:05</span></span>
	      <div class="timeline-body">
	      	asdasd
	      </div>
	    </div>
	  </div>
</div>
<script>
	function track_now(){
		start_load()
		var tracking_num = $('#ref_no').val()
		if(tracking_num == ''){
			$('#colis_history').html('')
			end_load()
		}else{
			$.ajax({
				url:'ajax.php?action=get_colis_heistory',
				method:'POST',
				data:{ref_no:tracking_num},
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error')
					end_load()
				},
				success:function(resp){
					if(typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) === 'object'){
						resp = JSON.parse(resp)
						if(Object.keys(resp).length > 0){
							$('#colis_history').html('')
							Object.keys(resp).map(function(k){
								var tl = $('#clone_timeline-item .iitem').clone()
								tl.find('.dtime').text(resp[k].date_created)
								tl.find('.timeline-body').text(resp[k].status)
								$('#colis_history').append(tl)
							})
						}
					}else if(resp == 2){
						alert_toast('Unkown Tracking Number.',"error")
					}
				}
				,complete:function(){
					end_load()
				}
			})
		}
	}
	$('#track-btn').click(function(){
		track_now()
	})
	$('#ref_no').on('search',function(){
		track_now()
	})
    <?php  
    function get_colis_heistory(){
      extract($_POST);
      $data = array();
      $colis = $this->db->query("SELECT * FROM colis where reference_number = '$ref_no'");
      if($colis->num_rows <=0){
        return 2;
      }else{
        $colis = $colis->fetch_array();
        $data[] = array('status'=>'Item accepted by Courier','date_created'=>date("M d, Y h:i A",strtotime($colis['date_created'])));
        $history = $this->db->query("SELECT * FROM colis_tracks where colis_id = {$colis['id']}");
        $status_arr = array("Article accepte","Expédié","En-Transit","Delivered");
        while($row = $history->fetch_assoc()){
          $row['date_created'] = date("M d, Y h:i A",strtotime($row['date_created']));
          $row['status'] = $status_arr[$row['status']];
          $data[] = $row;
        }
        return json_encode($data);
      }
    }
    ?>
</script>












<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="dropdown">
    <a href="./" class="brand-link">
      <?php if($_SESSION['login_type'] == 1): ?>
        <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
      <?php else: ?>
        <h3 class="text-center p-0 m-0"><b>Livreur</b></h3>
      <?php endif; ?>
    </a>
  </div>
  
  <div class="sidebar pb-4 mb-4">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item dropdown">
          <a href="./" class="nav-link nav-home">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>     

        <?php if($_SESSION['login_type'] == 1): // Admin sections ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_livreur">
              <i class="nav-icon fas fa-building"></i>
              <p>Client<i class="right fas fa-angle-left"></i></p>
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
              <p>Livrer<i class="right fas fa-angle-left"></i></p>
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
          
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_colis">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Colis<i class="right fas fa-angle-left"></i></p>
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
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link nav-colis_status">
              <i class="nav-icon fas fa-box"></i>
              <p>Colis Status<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=colis_list" class="nav-link nav-colis_list_all tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List All</p>
                </a>
              </li>
              <?php 
              $status_arr = array("Article accepte", "Expédié", "En-Transit", "Delivered");
              foreach($status_arr as $k => $v): ?>
                <li class="nav-item">
                  <a href="./index.php?page=colis_list&s=<?php echo $k ?>" class="nav-link nav-colis_list_<?php echo $k ?> tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p><?php echo $v ?></p>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>

        <?php endif; // End Admin sections ?>

        <?php if($_SESSION['login_type'] == 2): // Livreur sections ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-colis_status">
              <i class="nav-icon fas fa-box"></i>
              <p>Colis Status<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=colis_list" class="nav-link nav-colis_list_all tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List All</p>
                </a>
              </li>
              <?php 
              $status_arr = array("Article accepte", "Expédié", "En-Transit", "Delivered");
              foreach($status_arr as $k => $v): ?>
                <li class="nav-item">
                  <a href="./index.php?page=colis_list&s=<?php echo $k ?>" class="nav-link nav-colis_list_<?php echo $k ?> tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p><?php echo $v ?></p>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endif; // End Livreur sections ?>
        <li class="nav-item dropdown">
          <a href="./index.php?page=track" class="nav-link nav-track">
            <i class="nav-icon fas fa-search"></i>
            <p>Track Colis</p>
          </a>
        </li>
        
        <li class="nav-item dropdown">
          <a href="./index.php?page=reports" class="nav-link nav-reports">
            <i class="nav-icon fas fa-file"></i>
            <p>Reports</p>
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
  if(s != '')
    page = page + '_' + s;
  if($('.nav-link.nav-' + page).length > 0){
    $('.nav-link.nav-' + page).addClass('active');
    if($('.nav-link.nav-' + page).hasClass('tree-item') == true){
      $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
      $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
    }
    if($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true){
      $('.nav-link.nav-' + page).parent().addClass('menu-open');
    }
  }
});
</script>
