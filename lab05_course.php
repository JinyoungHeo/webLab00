<!DOCTYPE html>
<html>
<head>
    <title>Course list</title>
    <meta charset="utf-8" />
    <link href="courses.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">
    <h1>Courses at CSE</h1>
<!-- Ex. 1: File of Courses -->
    <p>
    <?php
        $filename = file("courses.tsv");
       // $lines = array($filename);
    ?>
        Course list has <?= count($filename) ?> total courses
        and
        size of <?= filesize("courses.tsv") ?> bytes.
    </p>
</div>
<div class="article">
    <div class="section">
        <h2>Today's Courses</h2>
<!-- Ex. 2: Today’s Courses & Ex 6: Query Parameters -->
        <?php
            $numberOfCourses = $_GET["number_of_courses"];
            
            function getCoursesByNumber($listOfCourses, $numberOfCourses){
                $resultArray = array();
                shuffle($listOfCourses);
                $resultArray = array_slice($listOfCourses, 9-$numberOfCourses);
                shuffle($resultArray);
                return $resultArray;
            }
        ?>
        <ol>
            <?php
                $todaysCourses = getCoursesByNumber($filename,$numberOfCourses);
                foreach ($todaysCourses as $getCourse) { ?>
                    <li> <?= $getCourse ?></li>
            <?php
                } ?>
        </ol>
    </div>
    <div class="section">
        <h2>Searching Courses</h2>
<!-- Ex. 3: Searching Courses & Ex 6: Query Parameters -->
        <?php
            $startCharacter = "A";
            function getCoursesByCharacter($listOfCourses, $startCharacter){
                $resultArray = array();
                for ($i=0; $i < count($listOfCourses); $i++) { 
                    $sub = substr($listOfCourses[$i], 0, 1);
                    if ($sub == $startCharacter) {
                        array_push($resultArray, $listOfCourses[$i]);
                    }
                }
                return $resultArray;
            }
        ?>
        <p>
            Courses that started by <strong>'<?= $startCharacter ?>'</strong> are followings :
        </p>
        <ol>
            <?php
                $searchedCourses = getCoursesByCharacter($filename, $startCharacter);
                foreach ($searchedCourses as $getCourse) { 
                    $getCourse2 = explode("\t", $getCourse);
                    $getCourse3 = implode("-", $getCourse2);
                    ?>
                    <li> <?= $getCourse3 ?></li>
            <?php
                } ?>
        </ol>
    </div>
    <div class="section">
        <h2>List of Courses</h2>
<!-- Ex. 4: List of Courses & Ex 6: Query Parameters -->
        <?php
            $orderby = 0;
            function getCoursesByOrder($listOfCourses, $orderby){
                $resultArray = $listOfCourses;
                if ($orderby == 0) {
                    sort($resultArray);
                }
                elseif ($orderby == 1) {
                    rsort($resultArray);
                }
                return $resultArray;
            }
        ?>
        <p>
            All of courses ordered by <strong>alphabetical order</strong> are followings :
        </p>
        <ol>
            <?php
                $orderedCourses = getCoursesByOrder($filename, $orderby);
                foreach ($orderedCourses as $getCourse) { 
                    $getCourse2 = explode("\t", $getCourse);
                    $getCourse3 = implode("-", $getCourse2);
                    ?>
                    <li> <?= $getCourse3 ?></li>
            <?php
                } ?>
        </ol>
    </div>
    <div class="section">
        <h2>Adding Courses</h2>
<!-- Ex. 5: Adding Courses & Ex 6: Query Parameters -->
        <p>
        <?php 
            $newCourse;
            $codeOfCourse;
            if (!isset($newCourse) || !isset($codeOfCourse)) { ?>
                Input course or code of the course doesn't exist.
        <?php    
            } 
            else { 
                $addCourse = $newCourse . " " . $codeOfCourse;
                print($addCourse);
                file_put_contents($filename, $addCourse); ?>
                Adding a course is success!
        <?php
            } ?>
        
        </p>
    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>
