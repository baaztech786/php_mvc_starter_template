<?php
        require APPROOT . '/views/includes/head.php';
?>
<div class="navbar dark">
    <?php
        require APPROOT . '/views/includes/navigation.php';
    ?>
</div>
<div class="container">
    <?php if(isLoggedIn()):?>
        <a href="<?php echo URLROOT; ?>posts/create" class="btn green">Create</a>
    <?php endif; ?>
    <?php foreach($data['posts'] as $post):?>
        <div class="container-item">
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post->user_id): ?>
                <a href="<?php echo URLROOT. "posts/update/" . $post->post_id; ?>" class="btn orange">Update</a>

                <form action="<?php echo URLROOT. "posts/delete/" . $post->post_id;  ?>" method="POST">
                    <input type="submit" name="delete" value="Delete" class="btn red">
                </form>
            <?php endif; ?>
            <h2><?php echo $post->title; ?></h2>
            <h3><?php echo 'Created on:' .date('F j h:m', strtotime($post->created_at)); ?></h3>

            <p><?php echo $post->body; ?></p>
        </div>
    <?php endforeach; ?>
</div>