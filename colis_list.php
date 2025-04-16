<?php include'db_connect.php' ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List Colis</h1>
          </div>

        </div>
            <hr class="border-primary">
      </div>
    </div>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_colis"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Reference Number</th>
						<th>Expéditeur Nom</th>
						<th>Distinataire Nom</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				
<?php
$i = 1;
$where = "";
if(isset($_GET['s'])){
    $where = " where c.status = {$_GET['s']} ";
}
if($_SESSION['login_type'] != 1 ){
    if(empty($where))
        $where = " where ";
    else
        $where .= " and ";
    $where .= " (c.from_livreur_id = {$_SESSION['login_livreur_id']} or c.to_livreur_id = {$_SESSION['login_livreur_id']}) ";
}
$qry = $conn->query("SELECT c.*, l.street, l.city, l.state, l.zip_code, l.country 
                    FROM colis c 
                    LEFT JOIN livreur l ON c.from_livreur_id = l.id 
                    $where 
                    order by  unix_timestamp(c.date_created) desc ");
while($row= $qry->fetch_assoc()):
?>

<tr>
    <td class="text-center"><?php echo $i++ ?></td>
    <td><b><?php echo ($row['reference_number']) ?></b></td>
    <td><b><?php echo $row['street']. ', '. $row['city']. ', '. $row['state']. ', '. $row['zip_code']. ', '. $row['country'] ?></b></td>
    <td><b><?php echo ucwords($row['recipient_name']) ?></b></td>
    <td class="text-center">
        <?php 
        switch ($row['status']) {
            case '1':
                
                echo "<span class='badge badge-pill badge-info'> Expédie</span>";
                break;
            case '2':
                echo "<span class='badge badge-pill badge-primary'> En-Transit</span>";
                break;
            case '3';
                echo "<span class='badge badge-pill badge-success'>Delivered</span>";
                break;
            default:
                echo "<span class='badge badge-pill badge-info'> Article accepté</span>";
                
                break;
        }

        ?>
    </td>
    <td class="text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-flat view_colis" data-id="<?php echo $row['id'] ?>">
              <i class="fas fa-eye"></i>
            </button>
            <a href="index.php?page=edit_colis&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
              <i class="fas fa-edit"></i>
            </a>
            <button type="button" class="btn btn-danger btn-flat delete_colis" data-id="<?php echo $row['id'] ?>">
              <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>    
<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_colis').click(function(){
			uni_modal("colis's Details","view_colis.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_colis').click(function(){
	_conf("Are you sure to delete this colis?","delete_colis",[$(this).attr('data-id')])
	})
	})
	function delete_colis($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_colis',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>