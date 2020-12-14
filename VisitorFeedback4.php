<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>View Files</title>
<script src="modernizr.custom.65897.js"></script>
</head>
    <body>
        <h2>Visitor Feedback4</h2>
        <hr>
        <?php
            $dir ="./comments";
            if (is_dir($dir)) {
                $commentFiles = scandir($dir);
                foreach ($commentFiles as $fileName) {
                    if ($fileName !== "." && $fileName !== "..") {
                        echo "From <strong>$fileName</strong><br>";
                        $fileHandle = fopen($dir . "/" . $fileName, "rb");
                        if ($fileHandle === false) {
                            echo "There was an error reading file \"$fileName\".<br>\n";
                        }
                        else {
                            $from = fgets($fileHandle);
                            echo "From: " . htmlentities($from) . "<br>\n";
                            $email = fgets($fileHandle);
                            echo "Email Address: " . htmlentities($email) . "<br>\n";
                            $date = fgets($fileHandle);
                            echo "Date: " . htmlentities($date) . "<br>\n";
                            $comment = "";
                            while (!feof($fileHandle)) {
                                $comment .= fgets($fileHandle);
                            }
                            echo htmlentities($comment) . "<br>\n";
                            echo "<hr>\n";
                            fclose($fileHandle);
                        }

                    }
                }
            }
        ?>
        <h2>Visitor Comments</h2>
        <form action="VisitorComments.php" method="post">
        Your name: <input type="text" name="name">
        <br>
        Your email: <input type="email" name="email">
        <br>
        <textarea name="comment" rows="6" cols="100"></textarea>
        <br>
        <input type="submit" name="save" value="Submit your comment">
        <br>
        </form>
    </body>
</html>