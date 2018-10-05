<?php

    // Did the browser send a cookie for the session?
    if(isset($_COOKIE[session_name()])) {
        // empty the cookie (1 day, for the entire site)
        setcookie(session_name(), '', time()-86400, '/');
    }

    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    echo "You have been logged out! See ya!<br>";

    echo "<p><a href='login.php'>Log back in</a></p>";
?>
