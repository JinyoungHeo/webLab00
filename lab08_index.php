<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Simple Timeline</title>
        <link rel="stylesheet" href="timeline.css">
    </head>
    <body>
        <?php
            include "timeline.php";
            $timeline =new TimeLine();
        ?>
        <div>
            <a href="index.php"><h1>Simple Timeline</h1></a>
            <div class="search">
                <!-- Ex 3: Modify forms -->
                <form class="search-form" method="GET" action="index.php">
                    <input type="submit" value="search">
                    <input type="text" name="text" placeholder="Search">
                    <select name="select">
                        <option value="author">Author</option>
                        <option value="contents">Content</option>
                    </select>
                </form>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <!-- Ex 3: Modify forms -->
                    <form class="write-form" method="POST" action="add.php">
                        <input type="text" name="input_author" placeholder="Author">
                        <div>
                            <input type="text" name="input_contents" placeholder="Content">
                        </div>
                        <input type="submit" value="write">
                    </form>
                </div>
                <!-- Ex 3: Modify forms & Load tweets -->
                <?
                if (isset($_GET["select"]) && isset($_GET["text"])) {
                    $input_select =$_GET["select"];
                    $input_text =$_GET["text"];

                    $search_stmt =$timeline->searchTweets($input_select, $input_text);

                    if ($search_stmt !="") { 
                        foreach ($search_stmt as $search_s) { 
                            $str_date =strtotime($search_s["time"]);
                            $view_date =date('H:i:s d/m/Y', $str_date);
                        ?>

                            <div class="tweet">
                                <form class="delete-form" method="POST" action="delete.php">
                                    <input type="submit" value="delete">
                                    <input type="hidden" name="num" value=<?= $search_s["no"] ?>>
                                </form>
                                <div class="tweet-info">
                                    <span><?= $search_s["author"] ?></span>
                                    <span><?= $view_date ?></span>
                                </div>
                                <div class="tweet-content">
                                    <?= $search_s["contents"] ?>
                                </div>
                            </div>
                    <?                   
                        }
                    }
                    else {
                        header("Location:index.php");
                    }
                }
                else { 

                    $load_stmt =$timeline->loadTweets();
                    foreach ($load_stmt as $load_s) { 
                            $str_date =strtotime($load_s["time"]);
                            $view_date =date('H:i:s d/m/Y', $str_date);
                ?>
                        <div class="tweet">
                            <form class="delete-form" method="POST" action="delete.php">
                                <input type="submit" value="delete">
                                <input type="hidden" name="num" value=<?= $load_s["no"] ?>>
                            </form>
                            <div class="tweet-info">
                                <span><?= $load_s["author"] ?></span>
                                <span><?= $view_date ?></span>
                            </div>
                            <div class="tweet-content">
                                <?= $load_s["contents"] ?>
                            </div>
                        </div>
                <?
                    }
                }
                
                ?>
            </div>
        </div>
    </body>
</html>
