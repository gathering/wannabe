<?php
/*
 * About Controller
 *
 * Output info about wannabe
 */

class AboutController extends AppController {

    var $requireLogin = false;
    var $layout = 'responsive-default';

    public function index() {
        $output = array();
        chdir(APP);
        exec("git log --decorate -n 1",$output);
        $history = array(
            'tag' => '',
            'commit' => '',
            'author' => '',
            'date' => '',
            'message' => ''
        );
        foreach($output as $line) {
            if($line == '')
                continue;
            if(strpos($line, 'commit')===0) {
                if($history['commit'] != '')
                    break;
                $history['commit'] = substr($line, strlen('commit'));
                if(preg_match('/\(.+tag:\s([\d\-]+v\d{1,9}).+\)$/', $history['commit'], $tag)) {
                    $history['tag'] = $tag[1];
                    $history['commit'] = preg_replace('/\s+\(.+\)$/', '', $history['commit']);
                }
            }
            else if(strpos($line, 'Author')===0)
                $history['author'] = substr($line, strlen('Author:'));
            else if(strpos($line, 'Date')===0)
                $history['date']   = substr($line, strlen('Date:'));
            else
                $history['message'] .= $line;
        }
        $this->set('history', $history);
        $this->set('title_for_layout', __("About wannabe"));
        if(!isset($this->Wannabe->user))
            $this->layout = 'front-generic';
    }
}
