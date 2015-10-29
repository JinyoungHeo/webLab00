<!DOCTYPE html>
<html>
<head>
	<title>DB query</title>
</head>
<body>
	<form action="RDB.php" method="post">
		<div>
		<input type="text" name="db_name"/>
		<textarea rows="4" cols="100" name="query"></textarea>
		<input type="submit" name="submit"/>
		</div>
	</form>

		<?php
			$db_name = $_POST["db_name"];
			$db_query = $_POST["query"];
				$db = new PDO("mysql:dbname=$db_name","root","root");
				$rows = $db->query($db_query); ?>
				<ul>
				<?php
				if (!empty($rows)) {
					foreach ($rows as $r) { ?>
						<li><?= key($r) ?></li>
				<?php	
					}
				} ?>

</body>
</html>
