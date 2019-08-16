<?php
App::import('Sanitize');

class WbSanitize {

	public static function clean($data, $options = array()) {
		$options = array_merge(array(
			'encode' => true,
			'escape' => true,
            'encoding' => 'UTF-8'
		), $options);
		if (empty($data)) {
			return $data;
		}

		if (is_array($data)) {
			foreach ($data as $key => $val) {
				$data[$key] = WbSanitize::clean($val, $options);
			}
			return $data;
		}

		$data = preg_replace("/[\x{0340}-\x{0341}\x{17A3}\x{17D3}\x{2028}-\x{2029}\x{202A}-\x{202E}\x{206A}-\x{206B}\x{206C}-\x{206D}\x{206E}-\x{206F}\x{FFF9}-\x{FFFB}\x{FEFF}\x{FFFC}\x{1D173}-\x{1D17A}]+/u", "", $data);
        $data = htmlentities($data, ENT_QUOTES | ENT_HTML5, $options['encoding']);
        return $data;
    }
}
