<?php 
include 'db_connect.php';
$ids = $_GET['ids'] ;
$colis = $conn->query("SELECT * FROM colis where id in ($ids) ");
$livreur = array();
 $livreur = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM livreur where id in (SELECT from_livreur_id FROM colis where id in ($ids) ) or id in (SELECT to_livreur_id FROM colis where id in ($ids) ) ");
    while($row = $livreur->fetch_assoc()):
    	$livreur[$row['id']] = $row['address'];
	endwhile;

while($row = $colis->fetch_assoc()):
?>
<table width="100%">
	<tr>
		<td colspan="3">Tracking Number : <b><?php echo $row['reference_number'] ?></b></td>
	</tr>
	<tr>
		<td width="33.33%">
			<p><b>Sender: <?php echo ucwords($row['sender_name']); ?></b></p>
		</td>
		<td width="33.33%">
			<p><b>Recipient: <?php echo ucwords($row['recipient_name']); ?></b></p>
		</td>
		<td width="33.33%"></td>
	</tr>
</table>
<?php endwhile; ?>

