<?php
ini_set('max_execution_time', 102400);
$conn = get_new_connection();
$result = mysql_query("select tt.term_id,tt.term_taxonomy_id from wp_terms as t
inner join wp_term_taxonomy as tt on
tt.term_id = t.term_id
where tt.taxonomy='post_tag';");
echo '<pre>';
	$dt = array();
	$dtt = array();
	while($result_data = mysql_fetch_assoc($result))
	{
		$dt[] = $result_data['term_id'];
		$dtt[] = $result_data['term_taxonomy_id'];
	}
	$del_t = implode(',',$dt);
	$del_tt = implode(',',$dtt);
	$r1 = mysql_query("delete from wp_term_relationships where term_taxonomy_id in (". $del_tt .")") or die('wp_term_relationships '.mysql_error());
	$r2 = mysql_query("delete from wp_term_taxonomy where term_id in (". $del_t .")") or die('wp_term_taxonomy '.mysql_error());
	$r3 = mysql_query("delete from wp_terms where term_id in (". $del_t .")") or die('wp_terms '.mysql_error());
	echo 'Tags Deletion Completed !';
echo '</pre>';
close_current_connection($conn);

function get_new_connection()
{
	$conn = mysql_connect("localhost", "database_username", "database_password") or die(mysql_error());
	mysql_select_db("database_name") or die(mysql_error());
	return $conn;
}

function close_current_connection($connection)
{
	mysql_close($connection);
}

?>
