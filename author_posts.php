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
$the_post_author = escape($_GET['author']);
}

$query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}'";
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
                    All Posts by <?php echo $post_author; ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>

<?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>