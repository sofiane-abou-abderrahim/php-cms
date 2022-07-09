<?php
if(isset($_POST['create_post'])) {
$post_title       = escape($_POST['post_title']);
$post_author      = escape($_POST['post_author']);
$post_category_id = escape($_POST['post_category']);
$post_status      = escape($_POST['post_status']);

$post_image       = $_FILES['image'] ['name'];
$post_image_temp  = $_FILES['image'] ['tmp_name'];

$post_tags        = escape($_POST['post_tags']);
$post_content     = escape($_POST['post_content']);
$post_date        = escape(date('d-m-y'));

move_uploaded_file($post_image_temp, "../images/$post_image");

$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
$query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
$create_post_query = mysqli_query($connection, $query);
confirmQuery($create_post_query);

$the_post_id = mysqli_insert_id($connection);

echo "<h4 class='bg-success text-center'>Post Created: <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>View All Posts</a></h4>";

}
?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
<label for="title">Post Title</label>
<input type="text" class="form-control" name="post_title">
</div>

<div class="form-group">
<label for="category">Categories</label>
<select name="post_category" id="post_category">

<?php

$query = "SELECT * FROM categories";
$select_categories = mysqli_query($connection, $query);

confirmQuery($select_categories);
    
while($row = mysqli_fetch_assoc($select_categories)) {
$cat_id    = escape($row['cat_id']);
$cat_title = escape($row['cat_title']);
echo "<option value='{$cat_id}'>{$cat_title}</option>";
}
?>

</select>
</div>

<!-- <div class="form-group">
<label for="users">Users</label>
<select name="post_user" id="post_user">
</select>
</div> -->
    
<div class="form-group">
<label for="title">Post Author</label>
<input type="text" class="form-control" name="post_author">
</div>

<div class="form-group">
<select name="post_status" id="post_status">
<option value="Draft">Post Status</option>
<option value="Published">Published</option>
<option value="Draft">Draft</option>
</select>
</div>

<div class="form-group">
<label for="post_image">Post Image</label>
<input type="file" name="image">
</div>

<div class="form-group">
<label for="post_tags">Post Tags</label>
<input type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
<label for="summernote">Post Content</label>
<textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
</div>

<div class="form-group">
<input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
</div>

</form>