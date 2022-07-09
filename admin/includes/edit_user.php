<?php

if (isset($_GET['edit_user'])) {
$the_user_id = escape($_GET['edit_user']);
$query = "SELECT * FROM users WHERE user_id = $the_user_id";
$select_users_query = mysqli_query($connection, $query);
confirmQuery($select_users_query);
while ($row = mysqli_fetch_assoc($select_users_query)) {
$user_id          = escape($row['user_id']);
$username         = escape($row['username']);
$user_password_db = escape($row['user_password']);
$user_firstname   = escape($row['user_firstname']);
$user_lastname    = escape($row['user_lastname']);
$user_email       = escape($row['user_email']);
$user_image       = escape($row['user_image']);
$user_role        = escape($row['user_role']);
}
}

if(isset($_POST['edit_user'])) {
$user_firstname = escape($_POST['user_firstname']);
$user_lastname  = escape($_POST['user_lastname']);
$user_role      = escape($_POST['user_role']);
$username       = escape($_POST['username']);
$user_email     = escape($_POST['user_email']);
$user_password  = escape($_POST['user_password']);

// $query = "SELECT randSalt FROM users";
// $select_randsalt_query = mysqli_query($connection, $query);
// confirmQuery($select_randsalt_query);
// $row = mysqli_fetch_array($select_randsalt_query);
// $salt = $row['randSalt'];
// $hashed_password = crypt($user_password, $salt);

if ($user_password !== $user_password_db) { // If password from the form and the one from the database don't match
    $salt = '$2y$10$iusesomecrazystrings22';
    $hashed_password = crypt($user_password, $salt);
} else { // else if they match just override
    $hashed_password = $user_password;
}

$query = "UPDATE users SET ";
$query .= "user_firstname = '{$user_firstname}', ";
$query .= "user_lastname = '{$user_lastname}', ";
$query .= "user_role = '{$user_role}', ";
$query .= "username = '{$username}', ";
$query .= "user_email = '{$user_email}', ";
$query .= "user_password = '{$hashed_password}' ";
$query .= "WHERE user_id = {$the_user_id} ";
$edit_user_query = mysqli_query($connection, $query);
confirmQuery($edit_user_query);
echo "<h4>User Updated: " . " " . "<a href='users.php'>View Users</a></h4>";

}
?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
<label for="title">Firstname</label>
<input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
</div>

<div class="form-group">
<label for="post_status">Lastname</label>
<input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
</div>

<div class="form-group">
<select name="user_role" id="user_role">
<option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
<?php
if ($user_role == 'Admin') {
echo "<option value='Subscriber'>Subscriber</option>";
} else {
echo "<option value='Admin'>Admin</option>";
}
?>
</select>
</div>

<div class="form-group">
<label for="post_tags">Username</label>
<input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
</div>

<div class="form-group">
<label for="post_content">Email</label>
<input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
</div>

<div class="form-group">
<label for="post_content">Password</label>
<input autocomplete="off" type="password" class="form-control" name="user_password" value="<?php echo $user_password_db; ?>">
</div>

<div class="form-group">
<input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
</div>

</form>