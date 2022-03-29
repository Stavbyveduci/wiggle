<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'mysql80.r1.websupport.sk';
$db   = 'erasmusfmk'; // Sem zadajte login
$user = '5fa7c9mj'; // Sem zadajte login
$pass = 'Hd56<dym&H'; // Sem zadajte heslo
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
	$pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
	throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sql = "SELECT skolsky_rok FROM editovanie GROUP BY skolsky_rok ORDER BY skolsky_rok DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll();

// print_r($res);

// ZOBRAZENIE ZOZNAMU ŠKôL
?> 

<form action="/kategoria.php" method='GET'>

	<!-- Školský rok -->
	<select name="skolsky_rok">

	<?php

	foreach($res as $school) {
		?> 
		
		<option value="<?php echo $school['skolsky_rok'] ?>" >
			<?php echo $school['skolsky_rok']?>
		</option>
		
		<?php
	};

	?> 
	</select>

	<!-- Semester -->
	<select name="semester">
		<option value="ZS">ZS</option>
		<option value="LS">LS</option>
	</select><br>

	<button name="kategoria" value="mk" type='submit'>Marketingové komunikace</button>
	<button name="kategoria" value="av" type='submit'>Audiovízia</button>
	<button name="kategoria" value="md" type='submit'>Multimédiá a design</button>
</form>
