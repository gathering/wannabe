<?
App::uses('WbSanitize', 'Lib');

class WbHelper extends HtmlHelper
{
	var $helpers = array('Form');
	public function eventUrl($url)
	{
		if (WB::$event && WB::$event->reference && WB::$event->urlmode == 'path')
			$url = '/'.WB::$event->reference.$url;
		return $this->url($url);
	}

	public function eventLink($title, $url, $options = array(), $confirmMessage = false)
	{
		$options = array_merge(array(
			'escape' => false
		), $options);
		return $this->link($title, $this->eventUrl($url), $options, $confirmMessage);
	}

	public function userLink($user)
	{
		// If not a user array, check if it was the id.
		if(!is_array($user)) {
			App::import("Model", "User");
			$model = new User();
			$user_id = (int)$user;
			$user = $model->find('first', array(
				'conditions' => array(
					'User.id' => $user_id)));
		}
		$displayname = $this->userDisplayName($user);
		$output = $this->eventLink($this->userDisplayName($user), '/Profile/View/'.$user['User']['id'], array());
		return $output ? $output : $displayname;
	}

	public function profilePictureUrl($user, $width) {
		$path = '/'.$user['User']['image'].'_'.$width.'.png';
		return $this->signFilePath($path);
	}

	public function signFilePath($path) {
		$path = str_replace('//', '/', '/'.$path);
		$secret = Configure::read('UrlSignSecret');
		// Each link lasts for 1 days
		$expires = time() + (1 * 24 * 60 * 60);
		// This is the pattern that has to match between nginx and wannabe
		$plaintext = $expires.$path.' '.$secret;
		// This is encoding details to get it to url in a state nginx expects
		$md5 = rtrim(strtr(base64_encode(md5($plaintext, true)), '+/', '-_'), '=');
		return $path."?md5=$md5&expires=$expires";
	}

	public function crewLink($crew)
	{
		return $this->eventLink($this->crewDisplayName($crew), '/Crew/View/'.$crew['Crew']['name']);
	}

	public function crewLink2($crew)
	{
		return $this->eventLink($crew, '/Crew/View/'.$crew);
	}

	public function userDisplayName($user)
	{
		return WbSanitize::clean($user['User']['realname']) . (!empty($user['User']['nickname']) ? ' aka '.WbSanitize::clean($user['User']['nickname']) : null);
	}

	public function crewDisplayName($crew)
	{
		return WbSanitize::clean($crew['Crew']['name']);
	}

    public function lastActive($user) {
        return date("H:i:s", strtotime($user['User']['lastactive']));
    }

	private function getExtendedFormTag($fieldName)
	{
		return split('[.]', $fieldName);
	}

	private function tagExtendedValue($fieldName)
	{
		list($model, $index, $field) = $this->getExtendedFormTag($fieldName);

		if (isset($this->params['data'][$model][$index][$field]))
			return $this->params['data'][$model][$index][$field];
		elseif (isset($this->data[$model][$index][$field]))
			return $this->data[$model][$index][$field];

		return false;
	}

	public function useBootstrapForms() {
		$this->Form->inputDefaults([
			'class' => 'form-control',
			'error' => [
				'attributes' => [
					'class' => 'help-block',
				],
			],
			'div' => [
				'class' => 'form-group',
				'errorClass' => 'has-error',
			],
		]);
	}

	public function textarea($fieldName, $htmlAttributes=array(), $return=false, $value=false)
	{
		$fields = split('[.]', $fieldName);
		if (count($fields) <= 2)
			return $this->Form->textarea($fieldName, $htmlAttributes, $return);

		list($model, $index, $field) = $fields;
		if(!$value) $value = $this->tagExtendedValue($fieldName);

		return $this->output(sprintf('<textarea name="data[%s][%s][%s]" %s>%s</textarea>', $model, $index, $field, $this->_parseAttributes($htmlAttributes, null, ' '), $value), $return);
	}

	public function hidden($fieldName, $htmlAttributes=array(), $return=false, $value=false)
	{
		$fields = split('[.]', $fieldName);
		if (count($fields) <= 2)
			return $this->Form($fieldName, $htmlAttributes, $return);

		list($model, $index, $field) = $fields;
		if(!$value) $value = $this->tagExtendedValue($fieldName);

		return $this->output(sprintf('<input type="hidden" name="data[%s][%s][%s]" %s value="%s" />', $model, $index, $field, $this->_parseAttributes($htmlAttributes, null, ' '), $value), $return);
	}

	public function makeQrContact($data)
	{
		$apibase = "<img src='https://chart.apis.google.com/chart?cht=qr&chs=320x320&choe=UTF-8&chl=";
		$apiend = "' />";
		$entities = array('%26Agrave%3B', '%26agrave%3B', '%26Aacute%3B', '%26aacute%3B', '%26Acirc%3B', '%26acirc%3B', '%26Atilde%3B', '%26atilde%3B', '%26Auml%3B', '%26auml%3B', '%26Aring%3B', '%26aring%3B', '%26AElig%3B', '%26aelig%3B', '%26Ccedil%3B', '%26ccedil%3B', '%26ETH%3B', '%26eth%3B', '%26Egrave%3B', '%26egrave%3B', '%26Eacute%3B', '%26eacute%3B', '%26Ecirc%3B', '%26ecirc%3B', '%26Euml%3B', '%26euml%3B', '%26Igrave%3B', '%26igrave%3B', '%26Iacute%3B', '%26iacute%3B', '%26Icirc%3B', '%26icirc%3B', '%26Iuml%3B', '%26iuml%3B', '%26Ntilde%3B', '%26ntilde%3B', '%26Ograve%3B', '%26ograve%3B', '%26Oacute%3B', '%26oacute%3B', '%26Ocirc%3B', '%26ocirc%3B', '%26Otilde%3B', '%26otilde%3B', '%26Ouml%3B', '%26ouml%3B', '%26Oslash%3B', '%26oslash%3B', '%26OElig%3B', '%26oelig%3B', '%26szlig%3B', '%26THORN%3B', '%26thorn%3B', '%26Ugrave%3B', '%26ugrave%3B', '%26Uacute%3B', '%26uacute%3B', '%26Ucirc%3B', '%26ucirc%3B', '%26Uuml%3B', '%26uuml%3B', '%26Yacute%3B', '%26yacute%3B', '%26Yuml%3B', '%26yuml%3B');
		$replacements = array('À', 'à', 'Á', 'á', 'Â', 'â', 'Ã', 'ã', 'Ä', 'ä', 'Å', 'å', 'Æ', 'æ', 'Ç', 'ç', 'Ð', 'ð', 'È', 'è', 'É', 'é', 'Ê', 'ê', 'Ë', 'ë', 'Ì', 'ì', 'Í', 'í', 'Î', 'î', 'Ï', 'ï', 'Ñ', 'ñ', 'Ò', 'ò', 'Ó', 'ó', 'Ô', 'ô', 'Õ', 'õ', 'Ö', 'ö', 'Ø', 'ø', 'Œ', 'œ', 'ß', 'Þ', 'þ', 'Ù', 'ù', 'Ú', 'ú', 'Û', 'û', 'Ü', 'ü', 'Ý', 'ý', 'Ÿ', 'ÿ');
		$string =  'MECARD:';
		$string.= 'N:'.WbSanitize::clean($data['name']).';';
		if(isset($data['address'])) $string.= 'ADR:'.WbSanitize::clean($data['address']).';';
        if(isset($data['phone'])) {
            if(!preg_match('/^0|\+/', $data['phone']))
                $data['phone'] = '+47'.$data['phone'];
            $string.= 'TEL:'.WbSanitize::clean($data['phone']).';';
        }
		if(isset($data['mail'])) $string.= 'EMAIL:'.WbSanitize::clean($data['mail']).';';
		$string.= 'URL:'.$data['url'].';';
		$string.= 'NOTE:Wannabe ID '.$data['id'].';';
		$string.= ";";

		return $apibase.str_replace($entities, $replacements, urlencode($string)).$apiend;

	}

	/**
	 * Checks if we are past a date in mysql-form.
	 *
	 * @param string $date
	 * @return boolean
	 */
	public function isPastDue($date)
	{
	return( $date and strtotime($date) <= time() and ( $date != '0000-00-00 00:00:00' ) );
	}

	public function getUsertitleForCrew($user, $crew_id)
	{
		$crew = array();
		foreach($user['Crew'] as $cur) {
			if(isset($cur['CrewsUser'])) {
				$cur = $cur['CrewsUser'];
				if($crew_id == $cur['crew_id']) {
					$crew = $cur;
				}
			}
		}
		if(isset($user['CrewsUser'])) {
			$crew = $user['CrewsUser'];
		}
		if (isset($crew['title']) && !empty($crew['title']))
			return $crew['title'];
		if (isset($crew['leader'])) {
			$usertitles = array(__("Member"), __("Shiftleader"), __("Co-Chief"), __("Chief"), __("Organizer"));
			if (isset($usertitles[$crew['leader']])) {
				return $usertitles[$crew['leader']];
			}
			else {
				return $usertitles[0];
			}
		}
		return null;
	}

	public function calculateAge($date)
	{
		list($year, $month, $day) = explode('-', $date);

		$year_diff = date('Y') - $year;
		$month_diff = date('m') - $month;
		$day_diff = date('d') - $day;

		if ($month_diff < 0 || (($month_diff == 0) && ($day_diff < 0)))
			$year_diff --;

		return $year_diff;
	}

	public function hasMembershipToEvent($user) {
	foreach ( $user['Crew'] as $crew )
		if ($crew['event_id'] == WB::$event->id)
		return(true);
	return false;
	}

	public function hasMembershipToCrew($user, $crew_id) {
	foreach ( $user['Crew'] as $crew )
		if ($crew['id'] == $crew_id)
			return true;
	return false;
	}

	public function hasMembershipToTeam($user, $crew_id, $team_id) {
	foreach ( $user['Crew'] as $crew )
		if ($crew['id'] == $crew_id && $crew['CrewsUser']['team_id'] == $team_id)
			return true;
	return false;
	}

}
?>
