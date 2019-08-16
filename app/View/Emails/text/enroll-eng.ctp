As the application process is currently only available in Norwegian, the following content is also just available in Norwegian.

For assistance, contact co@gathering.org

<?
foreach($enrollmail['EnrollMailfield'] as $field) {
	if($field['name_as_header']) {
		print("=== ".$field['name']." ===\n\n");
	}
	echo eval("?>" . $field['content'] . "<?");
	print "\n\n";
}
?>
