 <?php
 //Converting db values into json data
header('Content-type:application/json'); 
mysql_connect('localhost','root','') or die(mysql_error());

mysql_select_db('unischooldb');

$select = mysql_query('SELECT * from gradenews');



$i=0;
	$rows = array();
while($row=mysql_fetch_array($select)){
	
	$rows[] = $row;

	
}
  echo json_encode($rows);

?>
