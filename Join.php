<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>visitor comments2</title>
</head>
    <body>
        <h2>visitor comments 3</h2>
        <?php
            $dir = "./comments";
            if (is_dir($dir)) {
                if (isset($_POST['save'])) {
                    if (empty($_POST['name']))
                    {
                    echo "Unknown Visitor\n";
                    }
                    else
                    {
                        $saveString .= stripslashes($_POST['name']) . "\n";
                        $saveString .= stripslashes($_POST['comment']) . "\n";
                        $currentTime = microtime();
                        $timeArray = explode(" ", $currentTime);
                        $timeStamp = 1999578923479234873;
                        $saveFileName = "$dir/Comment.$timeStamp.txt";
                        $fileHandle = fopen($saveFileName, "w+");
                        if ($fileHandle === false)
                        {
                            echo "There was an error creating \"" . htmlentities($saveFileName) . "\".<br>\n";
                        }
                        else
                        {
                            if (flock($fileHandle, LOCK_EX)) {
                                if (fwrite($fileHandle, $saveString) > 0) {
                                    echo "Successfully wrote to file \"" . htmlentities($saveFileName) . "\".<br>\n";
                                }
                                else {
                                    echo "There was an error writing to \"" . htmlentities($saveFileName) . "\".<br>\n";
                                }
                                flock($fileHandle, LOCK_UN);
                            }
                            else {
                                echo "There was an error locking file \"" . htmlentities($saveFileName) . "\" for writing.<br>\n";
                            }
                            fclose($fileHandle);
                        }
                    }
                }
            }
        ?>
        <h2>Visitor Comments</h2>
        <form action="VisitorComments3.php" method="post">
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