<?php
// creare variabile cu nume scurte
$caracter=$_POST['caracter'];

$caracter= trim($caracter);


if (!$caracter  )
{
echo 'Nu ati completat toate campurile. Va rog sa incercati din nou.';
exit;
}
if (!get_magic_quotes_gpc())
{
$caracter = addslashes($caracter);


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
$query = "SELECT MAX(distanta),de_la,la
FROM Zboruri
WHERE de_la ='".$caracter."'";
$result = mysqli_query($dsn, $query);
// verifică dacă rezultatul este în regulă
if (!$result)
{
    die('Interogare gresita :'.mysqli_error($dsn));
}
echo ' <Table style = "width:60%">
<tr>
  <th>distanta</th>
  <th>de_la</th>
  <th>la</th>

</tr>'; 
$num_results = mysqli_num_rows($result);
for ($i=0; $i < $num_results; $i++)
{
    echo '<tr>';
    $row = mysqli_fetch_assoc($result);
    echo '<td align="center">'.htmlspecialchars(stripslashes($row['MAX(distanta)'])).'</td>';
	  echo '<td align="center">'.stripslashes($row['de_la']).'</td>';
	    echo '<td align="center">'.stripslashes($row['la']).'</td>';
   
    
    echo '</tr>';

}
// deconectarea de la BD
//$db->disconnect();
mysqli_close($dsn);
?>