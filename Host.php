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
                $tempGameDir ="./data/gameStates";
                //checks to see if the dir is real
                if (is_dir($gamedir)) {
                    $testFiles = scandir($gamedir);
                    foreach ($testFiles as $fileName) {
                        //checks to see if the file is the right one
                        if ($fileName == $testFile.".txt") {
                            //prints file name
                            echo "From <strong>$fileName</strong><br>";
                            //opens file reader
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
                            //error handler
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\".<br>\n";
                            }
                            else {
                                //prepares variables
                                $questionNumber = fgets($fileHandle);
                                $notEnd = true;
                                //loops untill all of the questions are looped through
                                while($notEnd)
                                {
                                    //this prints out the question segments
                                    for ($x = 0; $x <= 5; $x++)
                                    {
                                        $line = fgets($fileHandle);
                                        if ($line == "") {
                                            $notEnd = false;
                                        break;
                                        }
                                        if($x == 0)
                                        {
                                            echo "Question: " . htmlentities($line) . "<br>\n";
                                        }
                                        else if($x <= 4)
                                        {
                                            echo htmlentities($line) . "<br>\n";
                                        }
                                        else if($x == 5)
                                        {
                                            echo "The Answer is " . htmlentities($line) . "<br>\n";
                                        }
                                        if ($line == "") {
                                            echo "true";
                                        }
                                    }
                                    //this removes the extra hr at the bottom when done
                                    if (!$notEnd) {
                                        break;
                                    }
                                    //puts an hr after each question
                                    echo "<hr>\n";
                                }
                            }
                            //closes the file reader
                            fclose($fileHandle);
                        }
                    }
                }
                //this writes to a file
                if (is_dir($tempGameDir)) {
                    $questionNumber = 0;
                    $saveFileName = "$tempGameDir.$testFile.txt";
                    $fileHandle = fopen($saveFileName, "wb");
                    if ($fileHandle === false) {
                        echo "There was an error creating \"" .
                        htmlentities($saveFileName) . "\".<br>\n";
                    } else {
                        if (flock($fileHandle, LOCK_EX)) {    
                            if (fwrite($fileHandle, $questionNumber) > 0){
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