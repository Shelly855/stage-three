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
            include("../proposedSurgery/viewSurgerySql.php");

            $surgeries = getSurgeries();
            include("../includes/doctorHeader.php");
        ?>
        <main>
            <h1>Proposed Surgeries</h1>

            <form action="../proposedSurgery/createSurgery.php">
                <input type="submit" value="Create New Surgery" />
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Surgery Name</th>
                            <th>Eligible?</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($surgeries as $surgery): ?>
                            <tr>
                                <td><?php echo $surgery['first_name']; ?></td>
                                <td><?php echo $surgery['surname']; ?></td>
                                <td><?php echo $surgery['surgery_name']; ?></td>
                                <td><?php echo $surgery['eligible']; ?></td>
                                <td>
                                    <a href="../proposedSurgery/updateSurgery.php?sid=<?php echo $surgery['surgery_id']; ?>">Update</a> 
                                    <a href="../proposedSurgery/deleteSurgery.php?sid=<?php echo $surgery['surgery_id']; ?>">Delete</a>
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
