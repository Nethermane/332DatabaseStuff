
<!DOCTYPE html> 
<html> 
    <link href="someStyling.css" type="text/css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php
        require_once('header.php');
    ?>
    <head> 
        <h2>
            Animal SPCA Records 
        </h2>
    </head> 
    <body> 
        <h6> 
            Below is a list of all animals that have gone directly from an SPCA branch to a shelter without
            the use of a rescue organization         
        </h6>
        <br>

        <?php
            # Assumption is that even animals who have been adopted from a shelter (but got there directly from an SPCA)
            # will be included in the list of all animals who went directly from a SPCA branch to a shelter 
            try {
                $dbhost = 'localhost';
                $dbname='animal_rescue_application';
                $dbuser = 'root';
                $dbpass = '';
                $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            } catch (PDOException $e) {
                echo "Error : " . $e->getMessage() . "<br/>";
                die();
            }
            # the leaving_destination of an animal will only be null if it is still in the SPCA or it has been adopted
            # directly from the SPCA. Thus it can be checked to see if an animal has left the SPCA to go to a shelter 
            # vs if it was adopted. Checking the driver trip table ensures it was not driven to a shelter 
            $rows = $dbh->query("SELECT animal_id, animal_type 
                                FROM spca_animal_record natural join animal 
                                where leaving_destination is not null and animal_id not in (select animal_id from driver_trip)
                                ORDER BY animal_id;");
            if ($rows->rowCount() == 0) {
                echo "<p> <i class='fa fa-paw'></i> No animals were moved from the SPCA 
                        directly to a shelter <i class='fa fa-paw'></i> </p>";
            }
            else {
                echo "<div class='m-2'><table class='table'>";
                echo "<tr><td> <b>Animal ID</b> </td><td> <b>Species</b> </td></tr>";
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>".$row[0]."</td><td>".$row[1]."</td>"; 
                    echo "</tr>";
                }
                echo "</table></div>";
                $numRows = $dbh->query("SELECT count(*) 
                                        FROM spca_animal_record 
                                        WHERE leaving_destination is not NULL and animal_id not in (SELECT animal_id
                                                                                                         FROM driver_trip);");
                 $count = $numRows -> fetch(); 
                 echo "<p><b>Total: </b>".$count[0]."</p>";
            }
        ?>
    </body>
</html>
