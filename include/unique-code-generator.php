<?php
    //unique random service id
    function randID($length) 
    { 
        $upper = str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ0123456789ABCDEFGHJKLMNPQRSTUVWXYZ'); 
        $idnumber = ''; 

        for ($i = 0; $i < $length; $i++) 
        { 
            $idnumber.= $upper[(rand() % strlen($upper))];  
        } 
         
        return $idnumber;
    }

    $randID = null;
    $is_unique = 0;

    while ($is_unique === 0) 
    { 
        try 
        { 
            $randID = randID(8);
            $query = "SELECT skn FROM products WHERE skn = :skn";
            $stmt = $conn->prepare($query);
            $stmt->bindparam(':skn', $randID, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->fetchColumn()) 
            { 
                $randID = randID(8);
            } 
            else 
            { 
                $is_unique = 1; 
            } 
        } 
        catch(PDOException $e) 
        { 
            error_log("Error generating or checking skn number: ".$e->getMessage());
            exit; 
        }

    }

?>