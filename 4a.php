<?php
// creare variabile cu nume scurte
$caractere=$_POST['caractere'];
$caractere= trim($caractere);
if (!$caractere)
{
echo 'Nu ati completat toate campurile. Va rog sa incercati din nou.';
exit;
}
if (!get_magic_quotes_gpc())
{
$caractere = addslashes($caractere);
}

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
$query = "SELECT *
FROM Angajati JOIN Certificare ON angajati.idan=certificare.idan
	      JOIN Aeronave ON certificare.idav=aeronave.idav
WHERE aeronave.numeav LIKE '".$caractere."%' AND angajati.functie='pilot'";
$result = mysqli_query($dsn, $query);
// verifică dacă rezultatul este în regulă
if (!$result)
{
    die('Interogare gresita :'.mysqli_error($dsn));
}
echo ' <Table style = "width:60%">
<tr>
 <th>numean</th>
  <th>functie</th>

</tr>'; 
$num_results = mysqli_num_rows($result);
for ($i=0; $i < $num_results; $i++)
{
    echo '<tr>';
    $row = mysqli_fetch_assoc($result);
    echo '<td align="center">'.htmlspecialchars(stripslashes($row['numean'])).'</td>';
    echo '<td align="center">'.stripslashes($row['functie']).'</td>';
    
    echo '</tr>';

}
// deconectarea de la BD
//$db->disconnect();
mysqli_close($dsn);
?>