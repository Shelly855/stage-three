<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Users</title>
</head>
<body>
    <div class="container">
        <?php
            include("../adminUsers/viewUserSql.php");

            $users = getUsers();
            include("../includes/adminHeader.php");
        ?>
        <main>
            <h1>Users</h1>

            <form action="../adminUsers/createUser.php">
                <input type="submit" value="Create New User" />
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
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['first_name']; ?></td>
                                <td><?php echo $user['surname']; ?></td>
                                <td><?php echo $user['role']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td>
                                    <a href="../adminUsers/updateUser.php?uid=<?php echo $user['user_id']; ?>">Update</a>
                                    <a href="../adminUsers/deleteUser.php?uid=<?php echo $user['user_id']; ?>">Delete</a>
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
