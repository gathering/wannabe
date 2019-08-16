<?
foreach($enrollmail['EnrollMailfield'] as $field) {
	if($field['name_as_header']) {
		print("=== ".$field['name']." ===\n\n");
	}
	echo eval("?>" . $field['content'] . "<?");
	print "\n\n";
}
?>
