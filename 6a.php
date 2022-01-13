<?php
// creare variabile cu nume scurte



// se precizează că se foloseşte PEAR DB
require_once('PEAR.php');
$user = 'student';
$pass = 'student123';
$host = 'localhost';
$db_name = 'colocviu_final_s11';
// se stabileşte şirul pentru conexiune universală sau DSN
$dsn= new mysqli( $host, $user, $pass, $db_name);
// se verifică dacă a funcţionat conectarea
if ($dsn->connect_error)
{
    die('Eroare la conectare:'. $dsn->connect_error);
}
// se emite interogarea
$query = " SELECT AVG(angajati.salariu), aeronave.numeav
FROM Angajati JOIN Certificare ON angajati.idan = certificare.idan
              JOIN Aeronave ON certificare.idav = aeronave.idav
WHERE angajati.functie = 'pilot'
GROUP BY aeronave.numeav";
$result = mysqli_query($dsn, $query);
// verifică dacă rezultatul este în regulă
if (!$result)
{
    die('Interogare gresita :'.mysqli_error($dsn));
}
echo ' <Table style = "width:60%">
<tr>
  <th>media</th>
  <th>numeav</th>

</tr>'; 
$num_results = mysqli_num_rows($result);
for ($i=0; $i < $num_results; $i++)
{
    echo '<tr>';
    $row = mysqli_fetch_assoc($result);
    echo '<td align="center">'.htmlspecialchars(stripslashes($row['AVG(angajati.salariu)'])).'</td>';
    echo '<td align="center">'.stripslashes($row['numeav']).'</td>';
    
    echo '</tr>';

}
// deconectarea de la BD
//$db->disconnect();
mysqli_close($dsn);
?>