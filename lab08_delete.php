<?php
    include "timeline.php";
    $timeline =new TimeLine();
	# Ex 5 : Delete a tweet
	try {
		$input_no =$_POST["num"];
	    $timeline->delete($input_no);
	    header("Location:index.php");
	} catch(Exception $e) {
		header("Location:error.php"); 
	}
?>
