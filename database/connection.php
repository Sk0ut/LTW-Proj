<?php
// Directory database
try {
    $db = new PDO('sqlite:../database/events.db');
    return 0;
} catch(PDOException $e) {
}

// Document is in root
try {
    $db = new PDO('sqlite:database/events.db');
    return 0;
} catch(PDOException $e) {
}

// Same directory
try {
    $db = new PDO('sqlite:events.db');
    return 0;
} catch(PDOException $e) {
    echo $e;
    return -1;
}
?>
