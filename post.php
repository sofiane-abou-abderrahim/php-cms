<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php session_start(); ?>

    <!-- Navigation -->

<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

<?php

if(isset($_GET['p_id'])) {
$the_post_id = escape($_GET['p_id']);
}

$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_all_posts_query = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_all_posts_query)) {
$post_id      = escape($row['post_id']);
$post_title   = escape($row['post_title']);
$post_author  = escape($row['post_author']);
$post_date    = escape($row['post_date']);
$post_image   = escape($row['post_image']);
$post_content = escape(substr($row['post_content'],0,100));
$post_status  = escape($row['post_status']);
?>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

<?php } ?>

                <!-- Blog Comments -->

<?php


if(isset($_POST['create_comment'])) {

$the_post_id = escape($_GET['p_id']);
$comment_author  = escape($_POST['comment_author']);
$comment_email   = escape($_POST['comment_email']);
$comment_content = escape($_POST['comment_content']);
if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
$query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
$query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())";
$create_comment_query = mysqli_query($connection, $query); 
confirmQuery($create_comment_query);

// See new functionality on view_all_comments - increase comments only when approved
// $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
// $query .= "WHERE post_id = $the_post_id ";
// $update_comment_count = mysqli_query($connection, $query);
// confirmQuery($update_comment_count);
} else {
echo "<script>alert('Fields cannot be empty')</script>";
}

}

?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">

                        <div class="form-group">
                        <label for="Author">Author</label>
                            <input type="text" class="form-control" name="comment_author" id="comment_author">
                        </div>

                        <div class="form-group">
                        <label for="Email">Email</label>
                            <input type="email" class="form-control" name="comment_email" id="comment_email">
                        </div>

                        <div class="form-group">
                            <label for="Comment">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

<?php
$query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
$query .= "AND comment_status = 'Approved' ";
$query .= "ORDER BY comment_id DESC ";
$select_comment_query = mysqli_query($connection, $query);
confirmQuery($select_comment_query);
while($row = mysqli_fetch_array($select_comment_query)) {
$comment_date    = escape($row['comment_date']);
$comment_content = escape($row['comment_content']);
$comment_author  = escape($row['comment_author']);
?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

<?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>