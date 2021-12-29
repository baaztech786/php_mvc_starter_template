<?php
    foreach ($data['users'] as $user) {
        echo "information: " . $user->user_name . ' '. $user->user_email;
        echo "<br>";
    }
?>