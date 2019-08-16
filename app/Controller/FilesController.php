<?php
App::uses('File', 'Utility');

class FilesController extends AppController {
    public $uses = array('SecureFile');
    public function view($path) {
        $fileinfo = $this->SecureFile->find('first', array(
            'conditions' => array(
                'SecureFile.path' => $path,
                'SecureFile.event_id' => $this->Wannabe->event->id,
                'SecureFile.expires >' => date('Y-m-d H:i:s')
             )
        ));
        if(is_array($fileinfo) and !empty($fileinfo)) {
            $file = new File(APP . 'Files' . DS . $this->Wannabe->event->id . DS . $fileinfo['SecureFile']['path'], false, 0777);
            if($file->exists()) {
                $this->response->file($file->path);
                return $this->response;
            } else {
                throw new NotFoundException();
            }
        } else {
            throw new NotFoundException();
        }
    }
}
