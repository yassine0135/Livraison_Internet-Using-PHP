<style>
  textarea{
    resize: none;
  }
</style>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New Colis</h1>
          </div>

        </div>
            <hr class="border-primary">
      </div>
    </div>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-colis">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class=""></div>
        <div class="row">
          <div class="col-md-6">
              <b>Destinataire</b>
              <div class="form-group">
                <label for="" class="control-label">Nom</label>
                <input type="text" name="recipient_name" id="" class="form-control form-control-sm" value="<?php echo isset($recipient_name) ? $recipient_name : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Address</label>
                <input type="text" name="recipient_address" id="" class="form-control form-control-sm" value="<?php echo isset($recipient_address) ? $recipient_address : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Telephone</label>
                <input type="text" name="recipient_contact" id="" class="form-control form-control-sm" value="<?php echo isset($recipient_contact) ? $recipient_contact : '' ?>" required>
              </div>
          </div><div class="row">
          <div class="col-md-6" id=""  <?php echo isset($type) && $type == 1 ? 'style="display: none"' : '' ?>>
            <?php if($_SESSION['login_livreur_id'] <= 0): ?>
              <div class="form-group" id="fbi-field">
                <label for="" class="control-label">Client Processed</label>
              <select name="from_livreur_id" id="from_livreur_id" class="form-control select2" required="">
                <option value=""></option>
                <?php 
                  $livreur = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM livreur");
                    while($row = $livreur->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($from_livreur_id) && $from_livreur_id == $row['id'] ? "selected":'' ?>><?php echo $row['livreur_code']. ' | '.(ucwords($row['address'])) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="from_livreur_id" value="<?php echo $_SESSION['login_livreur_id'] ?>">
            <?php endif; ?>  
          </div>
        </div>
        </div>
        
        <b>Colis Information</b>
        <table class="table table-bordered" id="colis-items">
          <thead>
            <tr>
              <th>poids</th>
              <th>Hauteur</th>
              <th>Longer</th>
              <th>Largeur</th>
              <th>Prix</th>
              <?php if(!isset($id)): ?>
              <th></th>
            <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" name='weight[]' value="<?php echo isset($weight) ? $weight :'' ?>" required></td>
              <td><input type="text" name='height[]' value="<?php echo isset($height) ? $height :'' ?>" required></td>
              <td><input type="text" name='length[]' value="<?php echo isset($length) ? $length :'' ?>" required></td>
              <td><input type="text" name='width[]' value="<?php echo isset($width) ? $width :'' ?>" required></td>
              <td><input type="text" class="text-right number" name='price[]' value="<?php echo isset($price) ? $price :'' ?>" required></td>
              <?php if(!isset($id)): ?>
              <td><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove() && calc()"><i class="fa fa-times"></i></button></td>
              <?php endif; ?>
            </tr>
          </tbody>
              <?php if(!isset($id)): ?>
          <tfoot>
            <th colspan="4" class="text-right">Total</th>
            <th class="text-right" id="tAmount">0.00</th>
            <th></th>
          </tfoot>
              <?php endif; ?>
        </table>
              <?php if(!isset($id)): ?>
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end">
            <button  class="btn btn-sm btn-primary bg-gradient-primary" type="button" id="new_colis"><i class="fa fa-item"></i> Add Item</button>
          </div>
        </div>
              <?php endif; ?>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-colis">Enrejistrer</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=colis_list">Annuler</a>
  		</div>
  	</div>
	</div>
</div>
<div id="ptr_clone" class="d-none">
  <table>
    <tr>
        <td><input type="text" name='weight[]' required></td>
        <td><input type="text" name='height[]' required></td>
        <td><input type="text" name='length[]' required></td>
        <td><input type="text" name='width[]' required></td>
        <td><input type="text" class="text-right number" name='price[]' required></td>
        <td><button class="btn btn-sm btn-danger" type="button" onclick="$(this).closest('tr').remove() && calc()"><i class="fa fa-times"></i></button></td>
      </tr>
  </table>
</div>
<script>
  $('#dtype').change(function(){
      if($(this).prop('checked') == true){
        $('#tbi-field').hide()
      }else{
        $('#tbi-field').show()
      }
  })
    $('[name="price[]"]').keyup(function(){
      calc()
    })
  $('#new_colis').click(function(){
    var tr = $('#ptr_clone tr').clone()
    $('#colis-items tbody').append(tr)
    $('[name="price[]"]').keyup(function(){
      calc()
    })
    $('.number').on('input keyup keypress',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9]/, '');
        val = val.replace(/,/g, '');
        val = val > 0 ? parseFloat(val).toLocaleString("en-US") : 0;
        $(this).val(val)
    })

  })
	$('#manage-colis').submit(function(e){
		e.preventDefault()
		start_load()
    if($('#colis-items tbody tr').length <= 0){
      alert_toast("Please add atleast 1 colis information.","error")
      end_load()
      return false;
    }
		$.ajax({
			url:'ajax.php?action=save_colis',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
			// if(resp){
      //       resp = JSON.parse(resp)
      //       if(resp.status == 1){
      //         alert_toast('Data successfully saved',"success");
      //         end_load()
      //         var nw = window.open('print_pdets.php?ids='+resp.ids,"_blank","height=700,width=900")
      //       }
			// }
        if(resp == 1){
            alert_toast('Data successfully saved',"success");
            setTimeout(function(){
              location.href = 'index.php?page=colis_list';
            },2000)

        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
  function calc(){

        var total = 0 ;
         $('#colis-items [name="price[]"]').each(function(){
          var p = $(this).val();
              p =  p.replace(/,/g,'')
              p = p > 0 ? p : 0;
            total = parseFloat(p) + parseFloat(total)
         })
         if($('#tAmount').length > 0)
         $('#tAmount').text(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
  }
</script>