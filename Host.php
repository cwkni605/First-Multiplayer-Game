<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>View Files</title>
</head>
    <body>
        <h2>Kaboop Hosting</h2>
        <hr>
        <?php
            $testFolder = $_POST['testCode'];
            if(is_string($testFolder))
            {
                $gamedir ="./data/tests";
                if (is_dir($gamedir)) {
                    $testFiles = scandir($gamedir);
                    foreach ($testFiles as $fileName) {
                        if ($fileName == $testFolder.".txt") {
                            echo "From <strong>$fileName</strong><br>";
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
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
            }
            else
            {
                $gamedir ="./data/tests";
                if (is_dir($gamedir)) {
                    $testFiles = scandir($gamedir);
                    foreach ($testFiles as $fileName) {
                        if ($fileName !== "." && $fileName !== "..") {
                            echo "From <strong>$fileName</strong><br>";
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
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
                echo '<h2>Kaboop Hosting</h2><form action="Host.php" method="post">Your test: <input type="text" name="testCode"><br></form>';
            }
        ?>
        
    </body>
</html>