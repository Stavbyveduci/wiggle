<?php

// print_r($_GET);

$get_skolskyRok = $_GET['skolsky_rok'];
$get_semester = $_GET['semester'];
$get_kategoria = $_GET['kategoria'];

// echo $get_skolskyRok;

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

// SELECT skoly.id, skoly.nazov, skoly.mk, studenti.meno, studenti.priezvisko, studenti.priorita_1 FROM skoly, studenti WHERE skoly.id = studenti.priorita_1 AND skoly.md = 1;
// $sql = "SELECT skoly.id, skoly.nazov, skoly.mk, studenti.meno, studenti.priezvisko, studenti.priorita_1 FROM skoly, studenti WHERE skoly.id = studenti.priorita_1, skoly.mk = 1 ORDER BY nazov";

// SELECT sk.id, COUNT(st.priorita_1) as stCount FROM skoly sk
// LEFT JOIN studenti st ON sk.id = st.priorita_1
// WHERE sk.md = 1 AND st.kategoria = 'MD' AND st.semester = 'ZS' AND st.skolsky_rok = 2223
// GROUP BY sk.id
// ORDER BY stCount DESC;

// INSERT INTO tmp_studenti (id_student, id_vyber)
// SELECT studenti.id as id_student, if(studenti.vybrana_skola IS NULL, studenti.priorita_1, studenti.vybrana_skola) as id_vyber
// FROM studenti
// WHERE studenti.skolsky_rok = 2223 AND studenti.semester = 'ZS' AND studenti.kategoria = 'MD'

function clearTable($pdo) {
	$sql = "DELETE FROM tmp_studenti";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
};

function filterStudents($pdo, $get_skolskyRok, $get_semester, $get_kategoria) {
	$sql = "INSERT INTO tmp_studenti (id_student, id_vyber)
					SELECT studenti.id as id_student, if(studenti.vybrana_skola IS NULL, studenti.priorita_1, studenti.vybrana_skola) as id_vyber
					FROM studenti
					WHERE studenti.skolsky_rok = :skolsky_rok AND studenti.semester = :semester AND studenti.kategoria = :kategoria";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['skolsky_rok' => $get_skolskyRok, 'semester' => $get_semester, 'kategoria' => $get_kategoria]);
};

function getStudentList($pdo, $skola_id, $get_skolskyRok, $get_semester, $get_kategoria) {
	$sql = "SELECT id, kod, meno, priezvisko, anglictina, priorita_1, priorita_2, priorita_3, anglictina, priemer, poznamky, if(vybrana_skola IS NULL, priorita_1, vybrana_skola) as id_vyber
					FROM studenti
					WHERE kategoria = :kategoria AND skolsky_rok = :skolsky_rok AND semester = :semester
					HAVING id_vyber = :id_skola
					ORDER BY anglictina DESC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['id_skola' => $skola_id, 'skolsky_rok' => $get_skolskyRok, 'semester' => $get_semester, 'kategoria' => $get_kategoria]);

	$res = $stmt->fetchAll();
	
	foreach($res as $student) {
		?>

		<p>
			<strong><?php echo $student['kod'] . ', ' . $student['meno'] . ' ' . $student['priezvisko'] ?></strong><br>
			Priority: <?php echo $student['priorita_1'] . ', ' . $student['priorita_2'] . ', ' . $student['priorita_3'] ?><br>
			Angličtina: <span style="color: orange"><strong><?php echo $student['anglictina'] ?></strong></span><br>
			Priemer: <?php echo $student['priemer'] ?><br>
			Poznámky: <?php echo $student['poznamky'] ?>
		</p>

		<?php
	}
}

// SELECT id, priezvisko, if(vybrana_skola IS NULL, priorita_1, vybrana_skola) as id_vyber
// FROM studenti
// HAVING id_vyber = 4;

function getSchools($pdo, $get_skolskyRok, $get_semester, $get_kategoria) {
	$sql = "SELECT sk.id, COUNT(st.id_vyber) as stCount, sk.nazov  
					FROM skoly sk
					LEFT JOIN tmp_studenti st ON sk.id = st.id_vyber
					GROUP BY sk.id
					ORDER BY stCount DESC";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$res = $stmt->fetchAll();

	foreach($res as $skola) {
		?> 

		<h4 style='color: blue'><strong><?php echo $skola['nazov'] ?></strong></h4>

		<?php

		$skola_id = $skola['id'];
		getStudentList($pdo, $skola_id, $get_skolskyRok, $get_semester, $get_kategoria);
	}
}

// ---> Poradie funkcií

clearTable($pdo);
filterStudents($pdo, $get_skolskyRok, $get_semester, $get_kategoria);
getSchools($pdo, $get_skolskyRok, $get_semester, $get_kategoria);

// 	$sql = "SELECT * FROM skoly WHERE mk = 1";
// 	$stmt = $pdo->prepare($sql);
// 	$stmt->execute();
// 	$res = $stmt->fetchAll();

// 	print_r($res);

// if($get_kategoria == 'mk') {
// 	$sql = "SELECT * FROM skoly WHERE mk = 1";
// } elseif ($get_kategoria == 'av') {
// 	$sql = "SELECT * FROM skoly WHERE av = 1";
// } elseif ($get_kategoria == 'md') {
// 	$sql = "SELECT * FROM skoly WHERE md = 1";
// }