<?
class DiffHelper extends Helper {
	public function contents($a, $b) {
		require_once VENDORS . 'inlinediff/inline_function.php';
		$contents = inline_diff($b, $a, '<br/> ');
		return($contents);
	}
}
?>
