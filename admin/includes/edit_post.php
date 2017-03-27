<?php

    if(isset($_GET['p_id'])){
        $the_post_id  = $_GET['p_id'];
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_posts = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
            $post_content = $row['post_content'];
        }

    }

    if(isset($_POST['update_post'])){
        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_category_id = $_POST['post_category_id'];
        $post_status = $_POST['post_status'];

        $post_image = $_FILES['image']['name'];
        $post_image_tmp = $_FILES['image']['tmp_name'];

        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        move_uploaded_file($post_image_tmp, "../images/$post_image");

        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
            $select_image = mysqli_query($connection, $query);

            confirmQuery($select_image);
            while($row = mysqli_fetch_assoc($select_image)) {

                $post_image = $row['post_image'];

            }
        }

        $query = "UPDATE posts SET ";
        $query .= "post_title = '{$post_title}', ";
        $query .= "post_category_id = '{$post_category_id}', ";
        $query .= "post_date = now(), ";
        $query .= "post_author = '{$post_author}', ";
        $query .= "post_status = '{$post_status}', ";
        $query .= "post_tags = '{$post_tags}', ";
        $query .= "post_content = '{$post_content}', ";
        $query .= "post_image = '{$post_image}' ";
        $query .= "WHERE post_id = {$the_post_id} ";

        $update_post = mysqli_query($connection, $query);

        confirmQuery($update_post);

    }


?>
<h3>Edit Posts</h3>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title?>">
    </div>

    <div class="form-group">
        <select name="post_category_id" id="">
            <?php
            $cat_id = $_GET['edit'];
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            //confirmQuery($select_categories);

            while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_title = $row["cat_title"];
                $cat_id = $row["cat_id"];
                echo " <option value='$cat_id'> $cat_title</option>";
            }
            ?>
        </select>

    </div>

    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author?>">
    </div>

    <div class="form-group">
        <select name="post_status" id="">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            <?php
                if($post_status == 'Published'){
                    echo " <option value='Draft'>Draft</option>";
                } else {
                    echo " <option value='Published'>Published</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" name="image">
        <br>
        <p>Current Image:</p>
        <img src="../images/<?php echo $post_image?>" width="300px" alt="" title="current">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10" ><?php echo $post_content?></textarea>
    </div>

    <div class="form-group">

        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>
