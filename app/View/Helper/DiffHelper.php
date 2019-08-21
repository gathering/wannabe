<?

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

class DiffHelper extends Helper {
	public function contents($a, $b) {
		$differ = new Differ('', true);
		$raw_diff = $differ->diff($b, $a);
		return str_replace("\n", "</br>", $raw_diff);
	}
}
?>
