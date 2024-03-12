<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <script src="javascript/main.js" defer></script>
    <title>User Profiles</title>
</head>
<body>
    <div class="container">
        <?php
            include("viewUserSql.php");

            $user = getUsers();
            include("includes/header.php");
        ?>
        <main>
            <h1>User Profiles</h1>
            <form action="createUser.php">
                <input type="submit" value="Create New User" />
            </form>
            <form action="searchForUser.php">
                <input type="submit" value="Search Profiles" />
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>DOB</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $user): ?>
                        <tr>
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['first_name']; ?></td>
                            <td><?php echo $user['surname']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['mobile_number']; ?></td>
                            <td><?php echo $user['date_of_birth']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><a href="updateUser.php?uid=<?php echo $user['user_id']; ?>">Update</a> 
                            <a href="deleteUser.php?uid=<?php echo $user['user_id']; ?>">Delete</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>   
            </div> 
        </main>
        <?php
            include("includes/footer.php");
        ?>
    </div>
</body>
</html>