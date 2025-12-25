<?php
require_once('../connectDB.php');
$printrooms = <<< EOF
<html>
<head>
<link href="../css/pagination.css" rel="stylesheet" />
<head>
<body>
EOF;
echo $printrooms; 
class paginate_1
{
     private $db;
     function __construct($dbh)
     {
         $this->db = $dbh;
     }
     public function dataview($query)
     {
         $stmt = $this->db->prepare($query);
         $stmt->bindParam(':ID_user',$_SESSION['user_id'],PDO::PARAM_INT);
         $stmt->execute();
 
         if($stmt->rowCount()>0)
         {
                while($row=$stmt->fetch(PDO::FETCH_OBJ))
                {             
								$id=$row->ID;
                                $id_user=$row->ID_user;
                                $id_course=$row->ID_course;
                                $sql1="SELECT name,code FROM course WHERE ID=:id";
                                $stmt1 = $this->db->prepare($sql1);
                                $stmt1->bindParam(':id',$id_course,PDO::PARAM_INT);
                                $stmt1-> execute();
                                $row1= $stmt1 ->fetch(PDO::FETCH_OBJ);
                                $name=$row1->name;
                                $code=$row1->code;
$printrooms = <<< EOF
								<tr  class="table-row">
								<td style="text-align:center; word-break:break-all; width:300px;"> $name </td>
								<td style="text-align:center; word-break:break-all; width:300px;"> $code </td>
                                <td style="text-align:center; width:300px;">
                                    <span class="delete" id="$id" style="color:blue"><i class="fa fa-trash" style="font-size:20px;color:red;"></i></span>
                                </td>
                                <!--<a href="#delete$id"  data-toggle="modal"  class="btn btn-danger" >Διαγραφή </a>-->
                                <!-- Modal -->
                                <div id="delete$id" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-header">
                                <h3 id="myModalLabel">Διαγραφή</h3>
                                </div>
                                <div class="modal-body">
                                <p><div style="font-size:larger;" class="alert alert-danger">Είστε σίγουροι ότι θέλετε να διαγράψετε το μάθημα <b style="color:red;">$name</b>?</p>
                                </div>
                                <hr>
                                <div class="modal-footer">
                                <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Όχι</button>
                                <span id='$id' class="btn btn-danger">Ναι</span>
                                </div>
                                </div>	
								</tr> 
EOF;
echo $printrooms;
				}
         }
         else
         {
$printrooms = <<< EOF
                <tr>
                <td>Δεν υπάρχουν καταχωρησείς...</td>
                </tr>
EOF;
echo $printrooms; 
         }
 }
 public function paging($query,$data_per_Page)
 {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
             $starting_position=($_GET["page_no"]-1)*$data_per_Page;
        }
        $query2=$query." limit $starting_position,$data_per_Page";
        return $query2;
 }
 public function paginglink($query,$data_per_Page)
 {
        $self = $_SERVER['PHP_SELF'];
  
        $stmt = $this->db->prepare($query);
        $stmt->execute();
  
        $total_no_of_records = $stmt->rowCount();
 
        if($total_no_of_records > 0)
        {
            $whole_count_Of_Pages=ceil($total_no_of_records/$data_per_Page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
               $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
               $previous =$current_page-1;
               echo "<a href='".$self."?page_no=1'>Πρώτη</a>&nbsp;&nbsp;";
               echo "<a href='".$self."?page_no=".$previous."'>Προηγούμενη</a>&nbsp;&nbsp;";
            }
            for($i=1;$i<=$whole_count_Of_Pages;$i++)
            {
            if($i==$current_page)
            {
                echo "<strong><a href='".$self."?page_no=".$i."' style='color:red;text-decoration:none'>".$i."</a></strong>&nbsp;&nbsp;";
            }
            else
            {
                echo "<a href='".$self."?page_no=".$i."'>".$i."</a>&nbsp;&nbsp;";
            }
   }
   if($current_page!=$whole_count_Of_Pages)
   {
        $next=$current_page+1;
        echo "<a href='".$self."?page_no=".$next."'>Επόμενη</a>&nbsp;&nbsp;";
        echo "<a href='".$self."?page_no=".$whole_count_Of_Pages."'>Τελευταία</a>&nbsp;&nbsp;";
   }
$printrooms = <<< EOF
</body>
</html>
EOF;
echo $printrooms; 
  }
 }
}