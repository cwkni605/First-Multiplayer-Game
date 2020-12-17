<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Join</title>
</head>
    <body>
        <h2>Finished Kaboop</h2>
        <?php
        $testFile = $_POST['testCode'];
        $username = $_POST['username'];
        $testData = $_POST;
        $questionsCorrect = 0;
        $testAnswers = [];
            if(is_string($testFile))
            {
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
                            echo "Test code: <strong>".explode('.', $fileName)[0]."</strong><br>";
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
                                $formquestionNumber = 0;
                                //loops untill all of the questions are looped through
                                while($notEnd)
                                {
                                    //this assembles the answers
                                    for ($x = 0; $x <= 5; $x++)
                                    {
                                        $line = fgets($fileHandle);
                                        if ($line == "")
                                        {
                                            $notEnd = false;
                                        break;
                                        }
                                        else if($x == 5)
                                        {
                                            array_push($testAnswers, htmlentities($line));
                                        }
                                    }
                                    //this removes extra code when done
                                    if (!$notEnd) {
                                        break;
                                    }
                                }
                            }
                            //closes the file reader
                            fclose($fileHandle);
                        }
                    }
                }
                //this writes to a file
                for ($i=0; $i < (count($_POST)-2); $i++) { 
                    $out = $_POST[$i];
                    if ($out == $testAnswers[$i]) {
                        $questionsCorrect++;
                    }
                }
                if (is_dir($tempGameDir)) {
                    $userdata = $questionsCorrect;
                    $saveFileName = "$tempGameDir/$testFile/$username.txt";
                    //echo $saveFileName."<br>";
                    $fileHandle = fopen($saveFileName, "wb");
                    if ($fileHandle === false) {
                        echo "There was an error creating \"" . htmlentities($saveFileName) . "\".<br>\n";
                    } else {
                        if (flock($fileHandle, LOCK_EX)) {    
                            if (fwrite($fileHandle, $userdata) > 0){
                                echo "Successfully saved your test";
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
        ?>
    </body>
</html>