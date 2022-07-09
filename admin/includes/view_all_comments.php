<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>In Response to</th>
                                <th>Date</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                                <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                
<?php

$query = "SELECT * FROM comments";
$select_comments = mysqli_query($connection, $query);
confirmQuery($select_comments);

while($row = mysqli_fetch_assoc($select_comments)) {
$comment_id      = escape($row['comment_id']);
$comment_post_id = escape($row['comment_post_id']);
$comment_author  = escape($row['comment_author']);
$comment_content = escape(substr($row['comment_content'],0,100));
$comment_email   = escape($row['comment_email']);
$comment_status  = escape($row['comment_status']);
$comment_date    = escape($row['comment_date']);

echo "<tr>";
echo "<td>$comment_id</td>";
echo "<td>$comment_author</td>";
echo "<td>$comment_content</td>";

// $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
// $select_categories_id = mysqli_query($connection, $query);
    
// while($row = mysqli_fetch_assoc($select_categories_id)) {
// $cat_id = escape($row['cat_id']);
// $cat_title = escape($row['cat_title']);

// echo "<td>{$cat_title}</td>";

// }

echo "<td>$comment_email</td>";
echo "<td>$comment_status</td>";

$query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
$select_post_id_query = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_post_id_query)) {
$post_id    = escape($row['post_id']);
$post_title = escape($row['post_title']);
echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
}

echo "<td>$comment_date</td>";
echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='comments.php?delete=$comment_id'>Delete</a></td>";
echo "</tr>";

}

?>
                        
                            </tbody>
                        </table>

<?php

if(isset($_GET['approve'])) {
$the_comment_id = escape($_GET['approve']);
$query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $the_comment_id";
$approved_comment_query = mysqli_query($connection, $query);

// New functionality increase post_comment_count only when approved
$query = "SELECT * FROM comments WHERE comment_id = $the_comment_id";
$select_comments = mysqli_query($connection, $query);
confirmQuery($select_comments);
$row = mysqli_fetch_assoc($select_comments);
$comment_id      = escape($row['comment_id']);
$comment_post_id = escape($row['comment_post_id']);
$comment_author  = escape($row['comment_author']);
$comment_content = escape(substr($row['comment_content'],0,100));
$comment_email   = escape($row['comment_email']);
$comment_status  = escape($row['comment_status']);
$comment_date    = escape($row['comment_date']);
     
$query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
$query .= "WHERE post_id = $comment_post_id ";
$update_comment_count = mysqli_query($connection, $query);
confirmQuery($update_comment_count);
redirect('comments.php');
}

if(isset($_GET['unapprove'])) {
$the_comment_id = escape($_GET['unapprove']);
$query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $the_comment_id";
$unapproved_comment_query = mysqli_query($connection, $query);
redirect("comments.php");
}

if(isset($_GET['delete'])) {
$the_comment_id = escape($_GET['delete']);
// $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
// $delete_query = mysqli_query($connection, $query);
$stmt = mysqli_prepare($connection, "DELETE FROM comments WHERE comment_id = ? ");
mysqli_stmt_bind_param($stmt, 's', $the_comment_id);
mysqli_stmt_execute($stmt);
confirmQuery($stmt);

// New functionality decrease post_comment_count when deleted     
$query = "UPDATE posts SET post_comment_count = post_comment_count - 1 ";
$query .= "WHERE post_id = $comment_post_id ";
$update_comment_count = mysqli_query($connection, $query);
confirmQuery($update_comment_count);

redirect("comments.php");
}

?>