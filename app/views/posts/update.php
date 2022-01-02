<?php
        require APPROOT . '/views/includes/head.php';
?>
<div class="navbar dark">
    <?php
        require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container center">
    <h1>Update Post</h1>
    <form action="<?php echo URLROOT."posts/update/" .$data['post']->post_id; ?>" method="POST">
        <div class="form-item">
            <input type="text" name="title" value="<?php echo $data['post']->title; ?>">
            <br>
            <span class="invalidFeedback">
                <?php echo $data['titleError']; ?>
            </span>
        </div>

        <div class="form-item">
            <textarea name="body" placeholder="Enter your post" ><?php echo $data['post']->body; ?></textarea>
            <br>
            <span class="invalidFeedback">
                <?php echo $data['bodyError']; ?>
            </span>
        </div>

        <button class="btn green" type="submit" name="submit">Submit</button>
    </form>
</div>