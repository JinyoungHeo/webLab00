<!DOCTYPE html>
<html>
	<head>
		<title>Fruit Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		

		<h1>Thanks!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->
		<?php
			$name = isset($_POST['name']) ? $_POST['name'] : '';
			$memnum = isset($_POST['memnum']) ? $_POST['memnum'] : '';
			$options = isset($_POST['options']) ? $_POST['options'] : '';
			$selfruit = isset($_POST['selfruit']) ? $_POST['selfruit'] : '';
			$selquantity = isset($_POST['selquantity']) ? $_POST['selquantity'] : '';
			$credit = isset($_POST['credit']) ? $_POST['credit'] : '';
			$cc = isset($_POST['cc']) ? $_POST['cc'] : '';
		?>
		<ul> 
			<li>Name: <?= $name ?></li>
			<li>Membership Number: <?= $memnum ?></li>
			<li>Options: <?= $options ?></li>
			<li>Fruits: <?= $selfruit ?> - <?= $selquantity ?></li>
			<li>Credit <?= $credit ?>(<?= $cc ?>)</li>
		</ul>
		
		<!-- Ex 3 : -->
		<p>This is the sold fruits count list:</p>
		
		<?php
			$filename = "customers.txt";
			/* Ex 3: 
			 * Save the submitted data to the file 'customers.txt' in the format of : "name;membershipnumber;fruit;number".
			 * For example, "Scott Lee;20110115238;apple;3"
			 */
			file_put_contents($filename, $name.';'.$memnum.';'.$selfruit.';'.$selquantity.';'.$cc."\n", FILE_APPEND);
		?>
		
		<!-- Ex 3: list the number of fruit sold in a file "customers.txt".
			Create unordered list to show the number of fruit sold -->
		<pre><?= file_get_contents($filename) ?></pre>

<!--		<ul>
			<?php 
			$fruitcounts = soldFruitCount($filename);
			foreach ($fruitcounts as $count) { 
			?>
			
			<li><?= $count ?></li>
			
			<?php
			} ?>
		</ul>
-->		
<!--		<?php
		}
		?>
-->
		<?php
			/* Ex 3 
			* Get the fruits species and the number from "customers.txt"
			* 
			* The function parses the content in the file, find the species of fruits and count them.
			* The return value should be an key-value array
			* For example, array("Melon"=>2, "Apple"=>10, "Orange" => 21, "Strawberry" => 8)
			*/
			function soldFruitCount($filename) {
				$courses = '';
				foreach ($names as $course) {
					$courses = $courses.','.$course;
				}
				$courses = substr($courses, 1);
				return $courses;
			}
			}
		?>
	</body>
</html>
