<?php
$modal= <<<EOF
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-center">
			<div class="modal-header">
				<div class="modal-dialog .modal-align-center">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Προσθήκη Εξοπλισμού
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only"></span>
								</button></h4>
						</div>
						<div class="modal-body">
							<form method="post" action="add_equipment.php"  enctype="multipart/form-data">
								<table class="table1">
								<tr>
									<td><label style="color:#3a87ad; font-size:18px;">Ονομασία Εξοπλισμού</label></td>
									<td width="30"></td>
									<td><input type="text" name="Name" placeholder="Όνομα" required /></td>
								</tr>
								</table>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
							<button type="submit" name="Submit" class="btn btn-primary">Προσθήκη</button>
						</div>
					</form>
			 </div>
		</div>
	</div>
 </div>			
 </div>	
EOF;
echo $modal; 	
?>	