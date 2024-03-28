<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Staff Profiles</title>
</head>
<body>
    <div class="container">
        <?php
            include("../adminStaffProfiles/viewStaffSql.php");

            $staff = getStaff();
            include("../includes/adminHeader.php");
        ?>
        <main>
            <h1>Staff Profiles</h1>

            <form action="../adminStaffProfiles/createStaff.php">
                <input type="submit" value="Create New Staff" />
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Role</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($staff as $staff): ?>
                            <tr>
                                <td><?php echo $staff['first_name']; ?></td>
                                <td><?php echo $staff['surname']; ?></td>
                                <td><?php echo $staff['role']; ?></td>
                                <td><?php echo $staff['username']; ?></td>
                                <td>
                                    <a href="../adminStaffProfiles/updateStaff.php?sid=<?php echo $staff['staff_id']; ?>">Update</a>
                                    <a href="../adminStaffProfiles/deleteStaff.php?sid=<?php echo $staff['staff_id']; ?>">Delete</a>
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