<!DOCTYPE HTML>
<html lang="fr">
<body>

<?php

    ob_start();
    require("header.php");
    require("content.php");
    require("footer.php");
    $content = ob_get_contents();
      ob_end_clean();
      print str_replace("\n", "\n    ", $content) . "\r\n";
?>
</body>
</html>