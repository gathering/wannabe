<?php
class PictureController extends ApiAppController {
    public $uses = array('User', 'Api.ApiKey', 'Api.ApiApplication', 'Crew', 'User', 'Team', 'PictureApproval', 'Phonetype', 'Improtocol');
    public function view($id) {
        if(isset($this->request->query['width']))
            $width = $this->request->query['width'];
        else
            $width = 320;
        $widths = array( 50, 100, 150, 200, 210, 256, 320);
        if(!in_array($width, $widths))
            $this->throwError("Incorrect with parameter. Widths may be: ".implode(", ", $widths), "400");
        $user = $this->User->findById($id);
        if(is_array($user) && !empty($user) && $this->Acl->hasMembershipToEvent($user)) {
            if($user['User']['image']) {
                $file = new File(WWW_ROOT . $user['User']['image'] . "_" . $width . ".png", false, 0777);
                if($file->exists()) {
                    $file = base64_encode($file->read());
                    $picture = array(
                        'user_id' => $user['User']['id'],
                        'url' => 'http://'.$_SERVER['SERVER_NAME'].'/'.$user['User']['image'].'_'.$width.'.png',
                        'base64' => $file
                    );
                    $this->set(compact('picture'));
                    $this->set('_serialize', array('picture'));
                } else {
                    $this->throwError("Could not get picture", '500');
                }
            } else {
                $this->throwError("User has no picture", '404');
            }
        } else {
            $this->throwError("No such user", '404');
        }
    }
}
