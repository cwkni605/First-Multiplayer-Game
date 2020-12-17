<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Host</title>
</head>
    <body>
        <h2>Kaboop Hosting</h2>
        <hr>
        <?php
            $testFile = $_POST['testCode'];
            //if the $_POST has the needed data then run the hoster if not run test selector
            if(is_string($testFile))
            {
                $questionNumber = 1;
                //sets uniform directorys
                $gamedir ="./data/tests";
                $tempGameDir ="./data/gameStates/$testFile";
                //finds and retreives the question count
                if (is_dir($gamedir)) {
                    $testFiles = scandir($gamedir);
                    foreach ($testFiles as $fileName) {
                        if ($fileName == $testFile.".txt") {
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\".<br>\n";
                            }
                            else {
                                $number = fgets($fileHandle);
                                $questionNumber = htmlentities($number);
                                fclose($fileHandle);
                            }
                        }
                    }
                }
                //checks to see if the dir is real
                if (is_dir($tempGameDir)) {
                    $testFiles = scandir($tempGameDir);
                    foreach ($testFiles as $fileName) {
                        //checks to see if the file is the right one
                        if ($fileName != $testFile.".txt" && $fileName != "." && $fileName != "..") {
                            //prints file name
                            echo "<strong>".explode(".", $fileName)[0]."</strong> Joined the KaBoop<br>";
                            //opens file reader
                            $fileHandle = fopen($tempGameDir . "/" . $fileName, "rb");
                            //error handler
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\".<br>\n";
                            }
                            else {
                                //prepares variables
                                $userquestionNumber = fgets($fileHandle);
                                $notEnd = true;
                                //reads the the user data and sees if they are finished
                                $line = fgets($fileHandle);
                                //if()
                                
                            }
                            //closes the file reader
                            fclose($fileHandle);
                        }
                    }
                }
                //this writes to the temp game file
                if (is_dir($tempGameDir)) {
                    $saveFileName = "$tempGameDir/$testFile.txt";
                    $tempGameFileString .= $questionNumber."\n"."";
                    $fileHandle = fopen($saveFileName, "wb");
                    if ($fileHandle === false) {
                        echo "There was an error creating \"" .
                        htmlentities($saveFileName) . "\".<br>\n";
                    } else {
                        if (flock($fileHandle, LOCK_EX)) {    
                            if (fwrite($fileHandle, $tempGameFileString) > 0){
                                //echo "Successfully wrote to file \"" . htmlentities($saveFileName) . "\".<br>\n";
                            } else {
                                echo "There was an error writing to \"" .
                                htmlentities($saveFileName) . "\".<br>\n";
                            }
                            flock($fileHandle, LOCK_UN);
                        } else {
                            echo "There was an error locking file \"" .
                            htmlentities($saveFileName) . "\" for writing.<br>\n";
                        }
                        fclose($fileHandle);
                    }
                }
                echo '<script>setTimeout(function(){ location.replace(Host.php); }, 100);</script>';
            }
            else
            {
                //this reads the files the displays them
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
                                echo "questions: " . htmlentities($from) . "<br>\n";
                                fclose($fileHandle);
                            }
                        }
                    }
                }
                //prints out a form so you can start hosting
                echo '<h2>Kaboop Hosting</h2><form action="Host.php" method="post">Your test: <input type="text" name="testCode"><br></form>';
            }
        ?>
    </body>
</html>