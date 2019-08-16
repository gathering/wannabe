<?php
App::uses('WbSanitize', 'Lib');
class ProfileController extends AppController {

    public $uses = array('User', 'Phonetype','Improtocol', 'Image', 'Country', 'Crew',
                'Import', 'Userhistory', 'Ircchannelkey', 'ApplicationDocument',
                'ApplicationField', 'ApplicationChoice',
                'EnrollSetting', 'EnrollMail', 'EnrollMailfield', 'PictureRule', 'PictureApproval');

    public $helpers = array('Wb');

    // Bricking a lot with this..
    var $layout = "responsive-default";

    /**
     * Default profile page, simply used to redirect user to official profile page
     */
    public function index() {
        //Visiting our own profile, redirect to correct page
        $this->view($this->Wannabe->user['User']['id']);
        $this->render('view');
    }

    /**
     * Edit user`s profile picture
     */
    public function Picture() {

        $rules = $this->PictureRule->find('list');

        $this->set('title_for_layout', __("Change picture"));
        $this->set('rules', $rules);

        if($this->Wannabe->user['PictureApproval']['picture_rule_id']) {
            $this->Flash->info(__("Your previous picture was denied: %s", $rules[$this->Wannabe->user['PictureApproval']['picture_rule_id']]));
            $this->set('denied_id', $this->Wannabe->user['PictureApproval']['picture_rule_id']);
        }
        else if($this->Wannabe->user['PictureApproval']['custom_denied_reason'] != '') {
            $this->Flash->info(__("Your previous picture was denied: %s", $this->Wannabe->user['PictureApproval']['custom_denied_reason']));
        }
        else if($this->Wannabe->user['PictureApproval']['approved']) {
            $this->set('title_for_layout', __("Picture accepted"));
            $this->render('picture-accepted');
        }


        if(isset($_GET['act'])) {
            $act = $_GET['act'];
        }
        else {
            $act = null;
        }

        $webPath = "files/".date('Y-m')."/{$this->Wannabe->user['User']['id']}/";
        $appPath = APP.DS.WEBROOT_DIR.DS;
        $path 	 = $appPath.$webPath;
        $image 	 = $this->Wannabe->user['User']['image'];
        $factor  = 1;

        if($image) {
            $imageSize = getimagesize($appPath.$image."_original.png");
            $this->set('size', $imageSize);
            $factor = (float) 600 / (float) $imageSize[0];

            if($factor >= (float) 1) {
                $factor = 1;
                $this->set('factor', (float)1);
            }
            else {
                $this->set('factor', $factor);
            }
        }

        $this->set('image', $image);

        if(CakeSession::check('pictureTab')) {
            $tab = CakeSession::read('pictureTab');
            CakeSession::delete('pictureTab');
        }
        else {
            $tab = 'current';
        }

        if($act == 'upload') {
            $user = $this->Wannabe->user['User'];
            //Upload new picture
            if(is_dir($path) === false) {
                if(mkdir($path, 0777, true) === false) {
                    $this->Flash->error(__("Could not create upload dir %s", $path));
                }
            }

            $validFormats = array("jpg", "png", "gif", "jpeg");
            $name = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];

            if(strlen($name)) {

                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if(in_array($ext, $validFormats) && ($size > 512 && $size < 20000000)) {
                    $actualName = "orig.{$ext}";
                    $tmp = $_FILES['photoimg']['tmp_name'];

                    if(move_uploaded_file($tmp, $path.$actualName)) {
                        $originalImage = getimagesize($path.$actualName);
                        $imageHash = rand(0, 10000);

                        //Convert original to png
                        $src;
                        switch($ext) {
                          case 'png':
                            $src = imagecreatefrompng($path.$actualName);
                            break;
                          case 'jpg':
                          case 'jpeg':
                            $src = imagecreatefromjpeg($path.$actualName);
                            break;
                          case 'gif':
                            $src = imagecreatefromgif($path.$actualName);
                            break;
                        }
                        $newImage = imagecreatetruecolor($originalImage[0], $originalImage[1]);

                        imagecopyresampled($newImage, $src, 0,0,0,0, $originalImage[0], $originalImage[1], $originalImage[0], $originalImage[1]);

                        // If jpeg, check if metadata has rotation, if so rotate
                        if(in_array($ext, array("jpg", "jpeg"))) {
                          $exif = exif_read_data($path.$actualName);
                          if($exif && isset($exif['Orientation'])) {
                            $degrees = array(0, 0, 0, 180, 0, 0, -90, 0, 90);
                            $newImage = imagerotate($newImage, $degrees[$exif['Orientation']], 0);
                          }
                        }

                        imagepng($newImage, $path."wb4img_{$imageHash}_original.png");
                        unlink($path.$actualName);

                        //Generate thumbs
                        $this->makeThumbs($path,"wb4img_{$imageHash}","_original.png");

                        //Store info about picture
                        $user['image'] = $webPath."wb4img_{$imageHash}";

                        $this->User->set($user);
                        $this->User->save($user, false);

                        $approval_id = $this->PictureApproval->find('first', array(
                            'conditions' => array(
                                'user_id' => $user['id']
                            )
                        ));

                        $save = array(
                            'user_id' => $user['id'],
                            'approved' => false,
                            'picture_rule_id' => 0,
                            'custom_denied_reason' => ''
                        );

                        $this->PictureApproval->id = $approval_id['PictureApproval']['id'];
                        $this->PictureApproval->save($save);

                        $this->Auth->reloadUserLogin($this->Wannabe->user['User']['id']);
                        $crews = $this->getCrewsForUser($this->Wannabe->user, 0);

                        if(!empty($crews)) {
                            foreach($crews as $crew) {
                                $this->User->clearMemberCache($crew);
                            }
                        }

                        CakeSession::write('pictureTab', 'crop');
                        $this->Flash->success(__("Picture uploaded successfully. You may now crop you picture if needed."));
                        $this->redirectEvent('/Profile/Picture');
                    }
                    else {
                        $this->Flash->error(__('Could not move the uploaded file, poke the tech guys about it!'));
                        $tab = 'upload';
                    }
                }
                else {
                    $this->Flash->error(__("Image too big or in not allowed format"));
                    $tab = 'upload';
                }
            }
            else {
                $this->Flash->error(__('Nothing uploaded, try again'));
                $tab = 'upload';
            }
        }
        else if ($act == 'resize') {
            $w 	= (int)$_POST['width'];
            $h 	= (int)$_POST['height'];
            $x	= (int)$_POST['x'];
            $y	= (int)$_POST['y'];

            $newImage = imagecreatetruecolor($w, $h);
            $src = imagecreatefrompng($appPath.$image."_original.png");
            $originalImage = getimagesize($appPath.$image."_original.png");

            imagecopy($newImage, $src, 0, 0, $x, $y, $w, $h);
            imagepng($newImage, $appPath.$image."_cropped.png");

            $this->makeThumbs($appPath,$image, "_cropped.png");
            CakeSession::write('pictureTab', 'current');
            $this->Flash->success(__("Picture cropped successfully."));
            $this->redirectEvent('/Profile/Picture');
        }
        $this->set('tab', $tab);
    }

    private function makeThumbs($path, $image, $org) {

        $widths = array( 50, 100, 150, 200, 210, 256, 320);

        foreach($widths as $width) {

            $originalImage = getimagesize($path.$image.$org);
            $factor = (float) $width / (float) $originalImage[0];
            $height = $factor * $originalImage[1];

            // Get the original image
            $sourceImage = imagecreatefrompng($path.$image.$org);
            imagealphablending($sourceImage, false);
            imagesavealpha($sourceImage, true);

            // Create white background
            $imageCopy = imagecreatetruecolor($width, $height);
            imagealphablending($imageCopy, true);
            imagefilledrectangle($imageCopy, 0, 0, $width, $height, imagecolorallocate($imageCopy, 255, 255, 255));

            // Copy image from source image over to the image with white background
            imagecopyresampled($imageCopy, $sourceImage, 0, 0, 0, 0, $width, $height, $originalImage[0], $originalImage[1]);

            $resizedImagePath = $path.$image."_{$width}.png";
            imagepng($imageCopy, $resizedImagePath);
        }
    }

    public function view($id=0) {



        // No ID set, setting to the logged in users
        if($id == 0) {
            $id = $this->Wannabe->user['User']['id'];
        }

        //Fake user ID, go away
        if(!is_numeric($id)) {
             throw new BadRequestException(__('Missing user ID'));
        }

        //Load user data or redirect if this user does not exist OR does not have anything with this event to do
        //NOTE: The profile must be viewable if not linket to event – or else noone would can view an application
        try {
            $user = $this->User->findById($id);
        }catch(Exception $e) {
            throw $e;
        }

        if(!$user) {
            throw new BadRequestException(__('User does not exist'));
        }

        if (isset($this->params['requested'])) {
            return $user;
        } else {
            //Is this my profile?
            $myProfile = true;
            if($id != $this->Wannabe->user['User']['id']) {
                $myProfile = false;
            } else {
                $box_into_header = array();
                $box_into_header['Header'] = __("Edit profile");
                $box_into_header['Link'] = array();
                $box_into_header['Link'][] = array('class' => 'btn btn-default primary', 'href' => '/Profile/Edit', 'title' => __("Edit your profile"));
                $this->set('box_into_header', $box_into_header);
            }
            if(!$myProfile && $this->Acl->hasAccess('superuser', null, '/'.WB::$event->reference.'/admin/sudo')) {
                $box_into_header = array();
                $box_into_header['Header'] = __("Administrate");
                $box_into_header['Link'] = array();
                $box_into_header['Link'][] = array('class' => 'btn btn-info primary', 'href' => '/Admin/Sudo/user:'.$user['User']['id'], 'title' => __("Be user"));
                $this->set('box_into_header', $box_into_header);
            }

            $sharesCrewAndAllowsCrew = false;
            // If you are viewing someone elses profile and they have enabled sharing of information with their crew
            if(!$myProfile && isset($user['UserPrivacy']) && $user['UserPrivacy']['allow_crew']) {
                foreach ($user['Crew'] as $crew) {
                    if ($this->Acl->hasMembershipToCrew($this->Wannabe->user, $crew['crew_id']))
                        $sharesCrewAndAllowsCrew = true;
                }
            }

            $this->set('isMyProfile', $myProfile);
            $this->set('application', $this->ApplicationDocument->findDocumentNotDraft($id));
            $this->set('canAccessEnroll', $this->Acl->hasAccess('read', $this->Wannabe->user, '/'.WB::$event->reference.'/Enroll'));
            $this->set('user', $user);
            $this->set('improtocols', $this->Improtocol->find('list'));
            $this->set('phonetypes', $this->Phonetype->find('list'));
            $this->set('title_for_layout', WbSanitize::clean($user['User']['realname']));
            $this->set('desc_for_layout', __('aka')." ".WbSanitize::clean($user['User']['nickname']));
            $this->set('userAge', $this->calculateAge($user['User']['birth']));
            $this->set('canViewDetailedInfo', $this->Acl->hasAccessToDetailedUserInfo($this->Wannabe->user));
            $this->set('canViewPhone',   $sharesCrewAndAllowsCrew || $this->Acl->hasAccessToViewUserDetail('phone', $user));
            $this->set('canViewAddress', $sharesCrewAndAllowsCrew || $this->Acl->hasAccessToViewUserDetail('address', $user));
            $this->set('canViewEmail',   $sharesCrewAndAllowsCrew || $this->Acl->hasAccessToViewUserDetail('email',$user));
            $this->set('canViewBirth',   $sharesCrewAndAllowsCrew || $this->Acl->hasAccessToViewUserDetail('birth',$user));
            $this->set('canSudo', $this->Acl->hasAccess('superuser', null, '/'.WB::$event->reference.'/admin/sudo'));
            $this->set('canResetPicture', $this->Acl->hasAccess('manage', null, '/'.WB::$event->reference.'/PictureApproval/resetPicture'));
        }
    }

    public function edit() {
        if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_REQUEST['save']) == true) {
            $data = $this->data;
            /**
             * Validate phone numbers.
             */
            if (isset($data['Userphone']) == false) {
                $this->User->invalidate('Userphone.0.number', __("You must enter at least one phone number"));
            } else {
                if (sizeof($data['Userphone']) == 1 && ($data['Userphone'][0]['phonetype_id'] == "" && $data['Userphone'][0]['number'] == "")) {
                    $this->User->invalidate('Userphone.0.number', __("You must enter at least one phone number"));
                } else {
                    foreach ($data['Userphone'] as $index => $phone) {
                        if($phone['phonetype_id'] == "" && $phone['number'] != "") {
                            $this->User->invalidate('Userphone.'.$index.'.number', __("Phone type must be chosen"));
                        }
                        $phone = $phone['number'];
                        $phone = trim($phone);
                        if(substr($phone, 0, 1) == '+') {
                            $phone = preg_replace("/\D/","",$phone);
                            if(strlen($phone) < 10) {
                                $this->User->invalidate('Userphone.'.$index.'.number', __("Not a valid phone number"));
                            }
                            $phone = '+'.$phone;
                        } else {
                            if(strlen($phone != 0)) {
                                $phone = preg_replace("/\D/","",$phone);
                                if(strlen($phone) < 8) {
                                    $this->User->invalidate('Userphone.'.$index.'.number', __("Not a valid phone number"));
                                }
                                $phone = '+47'.$phone;
                            }
                        }
                        $data['Userphone'][$index]['number'] = $phone;
                    }
                }
            }
            /**
             * Validate ims
             */
            if(isset($data['Userim']) && sizeof($data['Userim'] != 0)) {
                foreach($data['Userim'] as $index => $im) {
                    if($im['improtocol_id'] == "" && $im['address'] != "") {
                        $this->User->invalidate('Userim.'.$index.'.improtocol_id');
                    }
                }
            }

            $user_id = $this->Wannabe->user['User']['id'];
            $this->User->set($data);
            if($this->User->validates()) {
                $data['User']['id'] = $user_id;
                $data['User']['updated'] = date('Y-m-d H:i:s');
                $registration = false;
                if($this->Wannabe->user['User']['registered'] == 'done') {
                    $this->Flash->success(__("Your profile has been saved."));
                } else {
                    $registration = true;
                    $data['User']['registered'] = 'done';
                    $this->Flash->success(__("Registration complete. You may now apply for crew."));
                }
                $this->User->save($data, false);
                $this->User->savePhoneNumbers($user_id, $data['Userphone']);
                $this->User->saveImAccounts($user_id, $data['Userim']);
                $crews = $this->getCrewsForUser($this->Wannabe->user, 0);
                if(!empty($crews)) {
                    foreach($crews as $crew) {
                        $this->User->clearMemberCache($crew);
                    }
                }
                $this->Auth->reloadUserLogin($user_id);
                if($registration) {
                    $this->redirectEvent('/');
                }
            } else {
                $this->set('validateErrors', $this->User->invalidFields());
                $this->validateErrors($this->User);
                $this->Flash->error(__("You have field errors. Please correct them and continue."));
            }
        }

        if(isset($data['User'])) {
            foreach($data['Userphone'] as $index => $phone) {
                if(empty($phone['number'])) {
                    unset($data['Userphone'][$index]);
                }
            }
            foreach($data['Userim'] as $index => $im) {
                if(empty($im['address'])) {
                    unset($data['Userim'][$index]);
                }
            }
            $this->set('data', $data);
            $this->set('user', $data);
        } else {
            $user = $this->Wannabe->user;
            if($user['User']['birth']) {
                $birth = $user['User']['birth'];
                $user['User']['birth'] = array();
                $user['User']['birth']['day'] = date('d', strtotime($birth));
                $user['User']['birth']['month'] = date('m', strtotime($birth));
                $user['User']['birth']['year'] = date('Y', strtotime($birth));
            } else {
                $user['User']['birth'] = array();
                $user['User']['birth']['day'] = "0";
                $user['User']['birth']['month'] = "0";
                $user['User']['birth']['year'] = "0";
            }
            $this->set('user', $user);
        }
        $this->set('sexes', array('male'=>__('male'),'female'=>__('female')));
        $this->set('countrycodes', $this->Country->find('list'));
        $this->set('phonetypes', $this->Phonetype->find('list'));
        $this->set('improtocols', $this->Improtocol->find('list'));
        if($this->Wannabe->user['User']['registered'] == 'edit') {
            $this->set('savebutton', __("Complete registration"));
            $this->set('title_for_layout', __("Create profile"));
            $this->render('register');
        } else {
            $this->set('title_for_layout', __("Edit profile"));
            $this->set('savebutton', __("Save profile"));
        }
    }
    public function password() {
        if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_REQUEST['save']) == true) {
            $data = $this->data;
            $this->User->set($data);
            if($this->Wannabe->user['User']['registered'] != 'password') {
                if(md5($data['User']['password']) != $this->Wannabe->user['User']['password']) {
                    $this->User->invalidate('password', __("Password incorrect"));
                }
                if(
                    md5($data['User']['password']) == md5($data['User']['newpassword1']) &&
                    md5($data['User']['newpassword1']) == md5($data['User']['newpassword2']) &&
                    md5($data['User']['newpassword2']) == $this->Wannabe->user['User']['password']
                ) {
                    $this->User->invalidate('newpassword1', __("New password cannot be the same as your current password"));
                }
            }
            if($this->User->validates()) {
                $user = array();
                $user['User']['id'] = $this->Wannabe->user['User']['id'];
                $user['User']['password'] = md5($data['User']['newpassword1']);
                $registration = false;
                if($this->Wannabe->user['User']['registered'] == 'password') {
                    $registration = true;
                    $user['User']['registered'] = 'edit';
                    $this->Flash->success(__("Password created. Complete the registration by creating your profile"));
                } else {
                    $this->Flash->success(__("Password updated"));
                }
                $this->User->save($user, false);
                $this->Auth->reloadUserLogin($user['User']['id']);
                $cookie = $this->Cookie->read('Auth.user');
                if(!is_null($cookie)) {
                    $this->Cookie->delete('Auth.user');
                }
                if($registration) {
                    $this->redirectEvent('/');
                }
            } else {
                $this->validateErrors($this->User);
                if($this->Wannabe->user['User']['registered'] != 'password') {
                    if(md5($data['User']['password']) != $this->Wannabe->user['User']['password']) {
                        $this->User->invalidate('password', __("Password incorrect"));
                    }
                    if(
                        md5($data['User']['password']) == md5($data['User']['newpassword1']) &&
                        md5($data['User']['newpassword1']) == md5($data['User']['newpassword2']) &&
                        md5($data['User']['newpassword2']) == $this->Wannabe->user['User']['password']
                    ) {
                        $this->User->invalidate('newpassword1', __("New password cannot be the same as your current password"));
                    }
                }
                $this->Flash->error(__("You have field errors. Please correct them and continue."));
            }
        }
        if($this->Wannabe->user['User']['registered'] == 'password') {
            $this->set('savebutton', __("Create password"));
            $this->set('title_for_layout', __("Create password"));
            $this->render('password-register');
        } else {
            $this->set('title_for_layout', __("Update password"));
            $this->set('savebutton', __("Update password"));
        }
    }
    public function email($email=null) {
        $layout = 'email';
        $waiting = false;
        if($this->Wannabe->user['User']['registered'] != 'done' && substr($this->Wannabe->user['User']['registered'], 6) == $email) {
            $waiting = true;
        }
        $this->set('title_for_layout', __("Change email address"));
        if($this->request->is('post') && isset($_REQUEST['change']) == true) {
            if(Validation::email($this->data['User']['email'])) {
                if($this->changeEmail($this->data['User']['email'])) {
                     $this->redirectEvent('/Profile/email/'.$this->data['User']['email']);
                }
            } else {
                $this->User->invalidate('email', __("Please enter a valid email address"));
            }
        }
        if($this->request->is('post') && isset($_REQUEST['cancel']) == true) {
            $this->changeEmail('cancel');
            $this->Flash->info(__("Email change canceled. Please disregard sent email."));
            $this->redirectEvent('/Profile/email');
        }
        if($waiting) {
            $layout = 'email-verify';
            $this->set('desc_for_layout', __("Waiting for verification"));
        }
        $data = array();
        if(isset($this->data['User']['email'])) {
            $data = $this->data;
        } else {
            $data['User']['email'] = $email;
        }
        $this->set('data', $data);
        $this->render($layout);
    }

    private function changeEmail($email) {
        if($email == 'cancel') {
            $validationCode = md5($email."-".microtime());
            $user['User']['id'] = $this->Wannabe->user['User']['id'];
            $user['User']['verificationcode'] = $validationCode;
            $user['User']['registered'] = 'done';
            if($this->User->save($user, false)) {
                $userGoingIn = $this->User->findById($this->Wannabe->user['User']['id']);
                CakeSession::write('loggedInUser',$userGoingIn);
                $this->Wannabe->user = CakeSession::read('loggedInUser');
                WB::$user = $this->Wannabe->user;
                $cookie = $this->Cookie->read('Auth.user');
                if(!is_null($cookie)) {
                    $this->Cookie->delete('Auth.user');
                }
            }
        } else {
            $emailexists = $this->User->findByEmail($email);
            if($emailexists) {
                if($email == $this->Wannabe->user['User']['email']) {
                    $this->User->invalidate('email', __("This is already your email address"));
                } else {
                    $this->User->invalidate('email', __("This email address is already registered with another user"));
                }
                return false;
            }
            $validationCode = md5($email."-".microtime());
            $user['User']['id'] = $this->Wannabe->user['User']['id'];
            $user['User']['verificationcode'] = $validationCode;
            $user['User']['registered'] = 'email/'.$email;
            if($this->User->save($user, false)) {
                $changeEmail = new CakeEmail('default');
                $changeEmail->viewVars(array('validation' => $validationCode, 'wannabe' => $this->Wannabe));
                $changeEmail->template('change-email-'.$this->Wannabe->lang, 'plain')->emailFormat('text')->subject(__("Wannabe: Change email"))->to($email)->send();
                $this->Auth->reloadUserLogin($this->Wannabe->user['User']['id']);
                $this->Flash->success(__('An email has been sent to “%s”. Click the link in the email to verify your new email address.', $email));
                return true;
            } else {
                $this->Flash->error(__('An error has occured while trying to save your user. Please try again. If the problem persists please contact %s', '<a href="mailto:wannabe@gathering.org">Core:Systems</a>'));
                return false;
            }
        }
    }
}
