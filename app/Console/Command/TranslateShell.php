<?php
class TranslateShell extends AppShell {
    var $url = 'https://api.getlocalization.com/wannabe/api/translations/file';
    var $master_file = 'app/Locale/default.pot';
    var $username = 'gatheringorg';
    var $password = 'barstol99';
    public function export() {
        $this->out("Extracting i18n-files. Please press enter.");
        $this->dispatchShell('i18n extract -q --merge yes --paths '.ROOT.DS.APP_DIR.DS.' --overwrite --extract-core no');
        $this->out("Committing language update!");
        system("sh ".ROOT.DS."scripts".DS."commit-translation-files.sh ".ROOT.DS.APP_DIR.DS);
    }

    public function import() {
        $this->out('Downloading translations from http://www.getlocalization.com/wannabe');
        $data = array(
            'language' => 'no'
        );
        $nb = $this->send_request($data);
        file_put_contents(ROOT.DS.APP_DIR.DS.'Locale'.DS.'nob'.DS.'LC_MESSAGES'.DS.'default.po', $nb);
        $data = array(
            'language' => 'en'
        );
        $en = $this->send_request($data);
        file_put_contents(ROOT.DS.APP_DIR.DS.'Locale'.DS.'eng'.DS.'LC_MESSAGES'.DS.'default.po', $en);
        $this->out("Files loaded and saved successfully!");
        $tmp_files = glob(ROOT.DS.APP_DIR.DS.'tmp'.DS.'cache'.DS.'persistent'.DS.'*');
        foreach($tmp_files as $tmp_file){
            if(is_file($tmp_file))
                unlink($tmp_file);
        }
        $this->out("Language cache for app cleared!");
        $this->out("Committing language update!");
        system("sh ".ROOT.DS."scripts".DS."commit-translations.sh ".ROOT.DS.APP_DIR.DS);
        $this->out("Import completed!");
    }

    private function send_request($data = array()) {
        $this->out('Getting “'.$data['language'].'” (please wait, will be slow)');
        $url = $this->url.DS.$this->master_file.DS.$data['language'].DS;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        if($info['http_code'] != '200')
            $this->error("Request failed", "Sending file-request to getlocalization.com failed: ".$info['http_code']);
        $this->out("Downloaded ".$this->formatBytes($info['size_download'])." of translation “".$data['language']."” in ".round($info['total_time'], 1)." seconds(".$this->formatBytes($info['speed_download'])."/s)");
        return $result;
    }

    private function formatBytes($bytes, $precision = 2) {
        $units = array('B','kB','MB','GB','TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(2014, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
