<?php
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    try{
		include "../connectDB.php";
        // Set the PDO error mode to exception
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		} catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }
    // Attempt search query execution
    try{
        if(isset($_REQUEST['term'])){
            // create prepared statement
            $sql = "SELECT * FROM course WHERE name LIKE :term LIMIT 2";
            $stmt = $dbh->prepare($sql);
            $term = $_REQUEST['term'] . '%';
            // bind parameters to statement
            $stmt->bindParam(':term', $term);
            // execute the prepared statement
            $stmt->execute();
            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch(PDO::FETCH_OBJ)){
					$name=$row->name;
                    echo "<p>".$name. "</p>";
                }
            } else{
                echo "<p>No matches found</p>";
            }
        }  
    } catch(PDOException $e){
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }
     
    // Close statement
    unset($stmt);
     
    // Close connection
    unset($dbh);
    ?>
	
	