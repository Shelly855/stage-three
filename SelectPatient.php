<?php 

    function verifyPatients () {

        if (!isset($_POST['username']) or !isset($_POST['password'])) {
            return;  // <-- return null;  
        }

        $db = new SQLite3("stage_3");
        $stmt = $db->prepare("SELECT username FROM patients WHERE username=:username AND password=:password");
        $stmt->bindParam(':username', $_POST['username'], SQLITE3_TEXT);
        $stmt->bindParam(':password', $_POST['password'], SQLITE3_TEXT);

        $result = $stmt->execute();

        $rows_array = [];
        while ($row=$result->fetchArray())
        {
            $rows_array[]=$row;
        }
        return $rows_array;
    }
