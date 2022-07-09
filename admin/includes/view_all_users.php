<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                
<?php

$query = "SELECT * FROM users";
$select_users = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_users)) {
$user_id        = escape($row['user_id']);
$username       = escape($row['username']);
$user_password  = escape($row['user_password']);
$user_firstname = escape($row['user_firstname']);
$user_lastname  = escape($row['user_lastname']);
$user_email     = escape($row['user_email']);
$user_image     = escape($row['user_image']);
$user_role      = escape($row['user_role']);

echo "<tr>";
echo "<td>$user_id</td>";
echo "<td>$username</td>";
echo "<td>$user_firstname</td>";
echo "<td>$user_lastname</td>";
echo "<td>$user_email</td>";
echo "<td>$user_role</td>";

echo "<td><a class='btn btn-primary' href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
echo "<td><a class='btn btn-success' href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
echo "<td><a class='btn btn-info' href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
// echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='users.php?delete={$user_id}'>Delete</a></td>";

?>
<form method="post">
<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
<?php
echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete' onClick=\"javascript: return confirm('Are you sure you want to delete?');\"></td>";
?>
</form>
<?php
echo "</tr>";
}
?>
                        
                            </tbody>
                        </table>

<?php

if(isset($_GET['change_to_admin'])) {
$the_user_id = $_GET['change_to_admin'];
$query = "UPDATE users SET user_role = 'Admin' WHERE user_id = $the_user_id";
$change_to_admin_query = mysqli_query($connection, $query);
redirect("users.php");
}

if(isset($_GET['change_to_sub'])) {
$the_user_id = escape($_GET['change_to_sub']);
$query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = $the_user_id";
$change_to_sub_query = mysqli_query($connection, $query);
redirect("users.php");
}




if(isset($_POST['delete'])) {

$the_user_id = escape($_POST['user_id']); 
// $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
// $delete_query = mysqli_query($connection, $query);
$stmt = mysqli_prepare($connection, "DELETE FROM users WHERE user_id = ? ");
mysqli_stmt_bind_param($stmt, 's', $the_user_id);
mysqli_stmt_execute($stmt);
confirmQuery($stmt);
redirect("users.php");
}




?>