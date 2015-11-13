<?php      
    include "timeline.php";
    $timeline =new TimeLine();
    # Ex 4 : Write a tweet
    try {
        $author =$_POST["input_author"];
        $contents =htmlspecialchars($_POST["input_contents"]);

        if ((preg_match("/^[a-zA-Z]+((\s{1}|\-{1}){1}[a-zA-Z]+)*$/", $author)) && (1 <=strlen($author)) && (strlen($author) <=20)) { //validate author & content
            if ($contents !="") { 
                $input_tweet =array($author, $contents);
                $timeline->add($input_tweet);
                header("Location:index.php");
            }

            else {
                header("Location:error.php"); //contents에 아무것도 입력하지 않았을 때에는 error
            }                
        } else {
            header("Location:error.php");
        }
    } catch(Exception $e) {
        header("Location:error.php");
    }
?>
