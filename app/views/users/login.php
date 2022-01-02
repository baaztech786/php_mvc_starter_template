<?php
    require APPROOT . '/views/includes/head.php';
?>
<?php
    if(isLoggedIn())
    {
        header('Location:' . URLROOT . 'pages/index');
    }
?>
<div class="navbar">
    <?php
        require APPROOT . '/views/includes/navigation.php';
    ?>
</div><br>



<div class="container-login">
    <div class="wrapper-login">
        <h2>Sign in</h2>
        <form action="<?php echo URLROOT; ?>/users/login" method="POST">
        <input type="text" placeholder="Username *" name="username" value="<?php echo $data['username']; ?>">
        <span class="invalidFeedback">
            <?php echo $data['usernameError']; ?>
        </span>
        <input type="password" placeholder="Password *" name="password">
        <span class="invalidFeedback">
            <?php echo $data['passwordError']; ?>
        </span><br>

        <button id="submit" type="submit" value="submit">Submit</button>

        <p class="options">Not registered yet? <a href="<?php echo URLROOT; ?>users/register">Create an account!</a></p>
    </form>
    </div>
</div>