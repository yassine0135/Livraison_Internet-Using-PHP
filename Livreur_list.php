<?php include'db_connect.php' ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">List client</h1>
          </div>

        </div>
            <hr class="border-primary">
      </div>
    </div>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_livreur"><i class="fa fa-plus"></i> Add New</a>
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
						<th>livreur Code</th>
						<th>Nom</th>
						<th>Prenom</th>
						<th>Adresse</th>
						<th>Telephone</th>
						<th>Email</th>
						<th>Password</th>
						<th>Action</th>  
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM livreur order by street asc,city asc, state asc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><b><?php echo $row['livreur_code'] ?></b></td>
						<td><b><?php echo ucwords($row['street']) ?></b></td>
						<td><b><?php echo ucwords($row['city']) ?></b></td>
						<td><b><?php echo ucwords($row['state']) ?></b></td>
						<td><b><?php echo ucwords($row['zip_code']) ?></b></td>
						<td><b><?php echo ucwords($row['country']) ?></b></td>
						<td><b><?php echo $row['contact'] ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="index.php?page=edit_livreur&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_livreur" data-id="<?php echo $row['id'] ?>">
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
		$('.view_livreur').click(function(){
			uni_modal("livreur's Details","view_livreur.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_livreur').click(function(){
	_conf("Are you sure to delete this livreur?","delete_livreur",[$(this).attr('data-id')])
	})
	})
	function delete_livreur($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_livreur',
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