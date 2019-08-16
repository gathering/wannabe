<?php
class TermController extends AppController {
    var $layout = "responsive-default";
    var $uses = array('Term', 'UserTerm', 'Wikipage');
    public function index() {
        if ($this->request->is('post') || $this->request->is('put')) {
            if($this->request->data['accepted']) {
                $terms = $this->Term->getTerms();
                if($this->UserTerm->acceptTerms($this->Wannabe->user['User']['id'], $terms['Term']['id'])) {
                    $this->Flash->success(__("Terms has been accepted. You can now continue to use the site."));
                    $this->Auth->reloadUserLogin($this->Wannabe->user['User']['id']);
                    $redirect = CakeSession::read('afterTermsRedirect');
                    if($redirect) {
                        CakeSession::delete('afterTermsRedirect');
                        $this->redirect($redirect);
                    } else {
                        $this->redirectEvent('/');
                    }
                } else {
                    $this->Flash->error(__("Something went wrong. Please try again."));
                }
            } else {
                $this->Term->invalidate('Term.accepted', __("You must accept terms"));
                $this->set('validateErrors', $this->Term->invalidFields());
                $this->validateErrors($this->Term);
                $this->Flash->error(__("You must accept the terms to continue. Please read the terms and click accept."));
            }
        }
        $this->set('title_for_layout', __("Terms & Conditions"));
        $term = $this->Term->getTerms();
        $format = array('Wikipage' => array('content' => $term['Term']['content']));
        $format = $this->Wikipage->format($format, $this);
        $term['Term']['content'] = $format['Wikipage']['content'];
        $this->set('term', $term);
    }
}
