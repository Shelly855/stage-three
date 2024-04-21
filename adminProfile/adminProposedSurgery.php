<?php
include '../includes/dbConnection.php';

function isQuestionnaireAssigned($db, $sid) {
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM POA_questionnaire WHERE surgery_id = :sid AND assigned = 1");
    if (!$stmt) {
        die("Error in preparing the statement: " . $db->lastErrorMsg());
    }

    $stmt->bindValue(':sid', $sid, SQLITE3_INTEGER);
    if (!$stmt) {
        die("Error in binding parameters: " . $db->lastErrorMsg());
    }

    $result = $stmt->execute();
    if (!$result) {
        die("Error in executing the query: " . $db->lastErrorMsg());
    }

    $row = $result->fetchArray();
    if ($row === false) {
        die("Error in fetching the result: " . $db->lastErrorMsg());
    }

    return ($row['count'] > 0);
}

include("../proposedSurgery/viewSurgerySql.php");
$surgeries = getSurgeries();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Proposed Surgery</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/adminHeader.php");
        ?>
        <main>
            <h1>Proposed Surgeries</h1>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Surgery Name</th>
                            <th>Eligible?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($surgeries as $surgery): ?>
                            <tr>
                                <td><?php echo $surgery['first_name']; ?></td>
                                <td><?php echo $surgery['surname']; ?></td>
                                <td><?php echo $surgery['surgery_name']; ?></td>
                                <td>
                                    <?php 
                                        if ($surgery['eligible'] === 1) {
                                            echo 'Yes';
                                        } elseif ($surgery['eligible'] === 0) {
                                            echo 'No';
                                        } elseif (is_null($surgery['eligible'])) {
                                            echo 'Unknown';
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>   
            </div> 
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
