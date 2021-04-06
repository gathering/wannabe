<?

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

class DiffHelper extends Helper {
	public function contents($a, $b) {
		$differ = new Differ('', true);
		$raw_diff = htmlspecialchars($differ->diff($b, $a), ENT_QUOTES, 'UTF-8');
		return str_replace("\n", "</br>", $raw_diff);
	}
}
?>
