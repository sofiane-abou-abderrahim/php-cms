<?php

function escape($string) {
global $connection;
return mysqli_real_escape_string($connection, trim($string));
}

function redirect($location) {
header("Location: " . $location);
exit; 
}

function confirmQuery($result) {
global $connection;    
if(!$result) {  
die("QUERY FAILED. " . mysqli_error($connection));          
}
}

function imagePlaceholder($image='') {
if(!$image) {
return 'image_1.webp';
} else {
return $image;  
}
}

function imageAlt($post_title='') {
if(!$post_title) {
return $post_title;
} else {
return $post_title;  
}
}


function insert_categories() {
global $connection;
if(isset($_POST['submit'])) {
$cat_title = escape($_POST['cat_title']);
if($cat_title == "" || empty($cat_title)) {
echo "<h4 class='btn-warning text-center'>This field should not be empty</h4>";
} else {
$stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");
mysqli_stmt_bind_param($stmt, 's', $cat_title);
mysqli_stmt_execute($stmt);
confirmQuery($stmt);
redirect("categories.php");
}
// mysqli_stmt_close($stmt);
}
}


function findAllCategories() {
global $connection;
$query = "SELECT * FROM categories";
$select_categories = mysqli_query($connection, $query);
confirmQuery($select_categories);
while($row = mysqli_fetch_assoc($select_categories)) {
$cat_title = escape($row['cat_title']);
$cat_id    = escape($row['cat_id']);
$category = <<<DELIMETER
<tr>
<td>{$cat_id}</td>
<td>{$cat_title}</td>
<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>
<td><a onClick="javascript: return confirm('Are you sure you want to delete?');" href='categories.php?delete={$cat_id}'>Delete</a></td>
</tr>
DELIMETER;
echo $category;
}
}


function deleteCategories() {
global $connection;
if(isset($_GET['delete'])) {
$the_cat_id = escape($_GET['delete']);
// $query = "DELETE FROM categories WHERE cat_id = '{$the_cat_id}'";
// $delete_query = mysqli_query($connection, $query);
$stmt = mysqli_prepare($connection, "DELETE FROM categories WHERE cat_id = ? ");
mysqli_stmt_bind_param($stmt, 's', $the_cat_id);
mysqli_stmt_execute($stmt);
confirmQuery($stmt);
redirect("categories.php");
}
}


?>