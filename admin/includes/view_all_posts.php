<?php

// include("delete_modal.php");

if(isset($_POST['checkBoxArray'])) {
foreach($_POST['checkBoxArray'] as $postValueId) {
$bulk_options = $_POST['bulk_options'];
switch($bulk_options) {

case 'Published':
$query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
$update_to_published_status = mysqli_query($connection, $query);
confirmQuery($update_to_published_status);
break;

case 'Draft':
$query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
$update_to_draft_status = mysqli_query($connection, $query);
confirmQuery($update_to_draft_status);
break;


case 'Deleted':
$query = "DELETE FROM posts WHERE post_id = {$postValueId}"; 
$update_to_deleted_status = mysqli_query($connection, $query);
confirmQuery($update_to_deleted_status);
break;

case 'Cloned':

$query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
$select_post_query = mysqli_query($connection, $query);

while($row = mysqli_fetch_array($select_post_query)) {
$post_title       = escape($row['post_title']);
$post_category_id = escape($row['post_category_id']);
$post_date        = escape($row['post_date']);
$post_author      = escape($row['post_author']);
$post_status      = escape($row['post_status']);
$post_image       = escape($row['post_image']);
$post_tags        = escape($row['post_tags']);
$post_content     = escape($row['post_content']);

$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
$query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
}
$copy_query = mysqli_query($connection, $query);
confirmQuery($copy_query);
break;

}
}
}
?>
                    
                    <form action="" method="post">
<div class="row">
<div id="bulkOptionContainer" class="col-xs-4">
<select class="form-control" name="bulk_options" id="">
<option value="">Select Options</option>
<option value="Published">Publish</option>
<option value="Draft">Draft</option>
<option value="Deleted">Delete</option>
<option value="Cloned">Clone</option>
</select>
</div>
<div class="col-xs-4">
<input type="submit" name="submit" class="btn btn-success" value="Apply"> <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
</div>
</div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th><input id="selectAllBoxes" type="checkbox"></th>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Tags</th>
                                <th>Comments</th>
                                <th>Date</th>
                                <th>View Post</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <!-- <th>Post Views</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                
<?php

$query = "SELECT * FROM posts ORDER BY post_id DESC"; 
$select_posts = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_posts)) {
$post_id            = escape($row['post_id']);
$post_author        = escape($row['post_author']);
$post_title         = escape($row['post_title']);
$post_category_id   = escape($row['post_category_id']);
$post_status        = escape($row['post_status']);
$post_image         = escape($row['post_image']);
$post_tags          = escape($row['post_tags']);
$post_comment_count = escape($row['post_comment_count']);
$post_date          = escape($row['post_date']);
// $post_views_count   = escape($row['post_views_count']);

echo "<tr>";
?>

<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>

<?php
echo "<td>{$post_id}</td>";
echo "<td>{$post_author}</td>";
echo "<td>{$post_title}</td>";

$query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
$select_categories_id = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_categories_id)) {
$cat_id = escape($row['cat_id']);
$cat_title = escape($row['cat_title']);

echo "<td>{$cat_title}</td>";

}

echo "<td>{$post_status}</td>";
echo "<td><img width='120' height='auto' src='../images/$post_image' alt='image'></td>";
echo "<td>{$post_tags}</td>";
echo "<td>{$post_comment_count}</td>";
echo "<td>{$post_date}</td>";
echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>";
echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
?>

<form method="post">
<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
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
                    </form>


<?php
if(isset($_POST['delete'])) {

$the_post_id = escape($_POST['post_id']); 
$stmt = mysqli_prepare($connection, "DELETE FROM posts WHERE post_id = ? ");
mysqli_stmt_bind_param($stmt, 's', $the_post_id);
mysqli_stmt_execute($stmt);
confirmQuery($stmt);
redirect("posts.php");
}


?>