<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>
<?php
if(isset($_GET['edit'])) {
$cat_id = escape($_GET['edit']);
$query = "SELECT * FROM categories WHERE cat_id = $cat_id";
$select_categories_id = mysqli_query($connection, $query);
confirmQuery($select_categories_id);
while($row = mysqli_fetch_assoc($select_categories_id)) {
$cat_title = escape($row['cat_title']);
$cat_id    = escape($row['cat_id']);
?>
<input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" class="form-control" type="text" name="cat_title">
<?php } } ?>

<?php // UPDATE QUERY
if(isset($_POST['update_category'])) {
$the_cat_title = escape($_POST['cat_title']);
$stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
mysqli_stmt_bind_param($stmt, "si", $the_cat_title, $cat_id);
mysqli_stmt_execute($stmt);
redirect("categories.php");
confirmQuery($stmt);
mysqli_stmt_close($stmt);
}
?>
    </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
        </div>
</form>