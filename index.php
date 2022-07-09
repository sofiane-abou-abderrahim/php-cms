<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

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
$query = "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_id DESC"; // WHERE post_status = 'Published' added
$select_all_posts_query = mysqli_query($connection, $query);
confirmQuery($select_all_posts_query);
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
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt="<?php echo imageAlt($post_title); ?>" width="900" height="300">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
<?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>