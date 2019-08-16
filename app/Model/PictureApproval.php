<?php
App::uses('AppModel', 'Model');
/**
 * PictureApproval Model
 *
 */
class PictureApproval extends AppModel {
    public function setFetched($user_id) {
        $approval = $this->find('first', array(
            'conditions' => array(
                'PictureApproval.user_id' => $user_id,
                'PictureApproval.approved' => true
            )
        ));
        if(is_array($approval) && !empty($approval)) {
            $save = array('PictureApprovalStatus' => array(
                'picture_approval_id' => $approval['PictureApproval']['id'],
                'event_id' => WB::$event->id,
                'fetched' => date("Y-m-d H:i:s"),
                'printed' => '0000-00-00 00:00:00'
            ));
            App::import('Model', 'PictureApprovalStatus');
            $pictureApprovalStatusModel = new PictureApprovalStatus();
            $check = $pictureApprovalStatusModel->find('first', array(
                'conditions' => array(
                    'PictureApprovalStatus.picture_approval_id' => $approval['PictureApproval']['id'],
                    'PictureApprovalStatus.event_id' => WB::$event->id
                )
            ));
            if(is_array($check) and !empty($check)) {
                $pictureApprovalStatusModel->id = $check['PictureApprovalStatus']['id'];
            }
            if($pictureApprovalStatusModel->save($save))
                return true;
        }
        return false;
    }
    public function setPrinted($user_id) {
        $approval = $this->find('first', array(
            'conditions' => array(
                'PictureApproval.user_id' => $user_id,
                'PictureApproval.approved' => true
            )
        ));
        if(is_array($approval) && !empty($approval)) {
            $save = array('PictureApprovalStatus' => array(
                'picture_approval_id' => $approval['PictureApproval']['id'],
                'event_id' => WB::$event->id,
                'printed' => date("Y-m-d H:i:s")
            ));
            App::import('Model', 'PictureApprovalStatus');
            $pictureApprovalStatusModel = new PictureApprovalStatus();
            $check = $pictureApprovalStatusModel->find('first', array(
                'conditions' => array(
                    'PictureApprovalStatus.picture_approval_id' => $approval['PictureApproval']['id'],
                    'PictureApprovalStatus.event_id' => WB::$event->id
                )
            ));
            if(is_array($check) and !empty($check)) {
                $pictureApprovalStatusModel->id = $check['PictureApprovalStatus']['id'];
            }
            if($pictureApprovalStatusModel->save($save))
                return true;
        }
        return false;
    }
}
