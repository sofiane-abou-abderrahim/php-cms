<?php include "db.php"; ?>
<?php session_start(); ?>
<?php include '../admin/functions.php'; ?>

<?php

if(isset($_POST['login'])) {

$username = $_POST['username'];
$password = $_POST['password'];

$username = mysqli_real_escape_string($connection, $username);
$password = mysqli_real_escape_string($connection, $password);

$query = "SELECT * FROM users WHERE username = '{$username}' ";
$select_user_query = mysqli_query($connection, $query);
confirmQuery($select_user_query);

while($row = mysqli_fetch_array($select_user_query)) {

$db_id             = escape($row['user_id']);
$db_username       = escape($row['username']);
$db_user_password  = escape($row['user_password']);
$db_user_firstname = escape($row['user_first_name']);
$db_user_lastname  = escape($row['user_lastname']);
$db_user_role      = escape($row['user_role']);

}

// $password = crypt($password, $db_user_password);

$salt = '$2y$10$iusesomecrazystrings22';
$password = crypt($password, $salt);

if($username === $db_username && $password === $db_user_password) {

$_SESSION['username']  = $db_username;
$_SESSION['firstname'] = $db_user_firstname;
$_SESSION['lastname']  = $db_user_lastname;
$_SESSION['user_role'] = $db_user_role;

redirect("../admin");

} else {

redirect("../");

}


}



?>