<?php
$modal= <<<EOF
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

    <h3 id="myModalLabel">Προσθήκη Εξαμήνου</h3>
    </div>
    <div class="modal-body">
	
					<form method="post" action="add_semester.php"  enctype="multipart/form-data">
					<table class="table1">
						<tr>
							<td><label style="color:#3a87ad; font-size:18px;">Ονομασία εξαμήνου</label></td>
							<td width="30"></td>
							<td><input type="text" name="Semester" placeholder="Όνομα" required /></td>
						</tr>
					</table>
					
	
    </div>
    <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Κλείσιμο</button>
<button type="submit" name="Submit" class="btn btn-primary">Προσθήκη</button>
    </div>
	

					</form>
    </div>			
EOF;
echo $modal; 	
?>	