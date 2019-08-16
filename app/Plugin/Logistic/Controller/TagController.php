<?php
class TagController extends LogisticAppController {
    public $uses = array('Logistic.LogisticLocation','Logistic.LogisticStorage','Logistic.LogisticTag');
    var $layout = 'responsive-default';

    public function index() {
        $tags =  $this->LogisticTag->find('all');
        if($this->request->is('post')) {
            if(!$this->Acl->hasAccess('manage')) {
                throw new ForbiddenException(__("You have no access to manage this"));
            }
            $taglist = array();
            foreach($tags as $item) {
                array_push($taglist, $item['LogisticTag']['name']);
            }
            $all_saved = true;
            $new = array();
            if(isset($this->request->data['LogisticTag']['new'])) {
                $new['LogisticTag'] = $this->request->data['LogisticTag']['new'];
                unset($this->request->data['LogisticTag']['new']);
            }
            if(is_array($new) && !empty($new)) {
                foreach($new as $tag) {
                    if($tag['create']) {
                        $name = preg_replace('/(\s+)/i','_', trim($tag['name']));
                        $path = explode('/', $name);
                        $length = count($path);
                        $p = $path[0];
                        $chk_existence = true;
                        $tag_exists = false;
                        for($i = 1; $i < $length; $i++){
                            if($chk_existence)
                                $tag_exists = in_array($p, $taglist);
                            if(!$tag_exists) {
                                $newtag = array();
                                $newtag['LogisticTag'] = array(
                                    'name' => $p,
                                    'comment' => "",
                                );
                                $this->LogisticTag->create();
                                $this->LogisticTag->save($newtag);
                                $check_existence = false;
                            }
                            $p .= "/".$path[$i];
                        }
                        if(in_array($name, $taglist)) {
                            $all_saved = false;
                            $this->Flash->error(__("Could not create “%s” as it already exists.", $name));
                        } else {
                            $newtag = array();
                            $newtag['LogisticTag'] = array(
                                'name' => $name,
                                'comment' => $tag['comment'],
                            );
                            $this->LogisticTag->create();
                            $this->LogisticTag->save($newtag);
                        }
                    }
                }
            }
            $temp_tags = array();
            foreach($tags as $tag) {
                $temp_tags[$tag['LogisticTag']['id']] = $tag['LogisticTag'];
            }
            $changed = array();
            foreach($this->request->data['LogisticTag'] as $index => $tag) {
                $diff = array_diff($tag, $temp_tags[$index]);
                if(isset($diff['name']) || isset($diff['comment']))
                    $changed[] = array('LogisticTag' => $tag);
            }
            if(is_array($changed) && !empty($changed)) {
                foreach($changed as $tag) {
                    $tag['LogisticTag']['name'] = preg_replace('/(\s+)/i','_', trim($tag['LogisticTag']['name']));;
                    $this->LogisticTag->save($tag);
                }
            }
            $delete = array();
            foreach($this->request->data['LogisticTag'] as $tag)
                if($tag['delete'])
                    $delete[] = array('LogisticTag' => $tag);
            if(is_array($delete) && !empty($delete)) {
                $inUse = array();
                foreach($delete as $tag) {
                    $tagitems = $this->LogisticTag->query('SELECT * FROM wb4_logistic_items_logistic_tags where logistic_tag_id='.$tag['LogisticTag']['id']);
                    if($tagitems) {
                        $inUse[] =  $tag['LogisticTag']['name'];
                    } else {
                        $this->LogisticTag->delete($tag['LogisticTag']['id']);
                    }
                }
                if(count($inUse) > 0){
                    $all_saved = false;
                    $this->Flash->error(__("The following tags are in use, and cannot be deleted: %s", join(', ', $inUse)));
                }
            }
            if($all_saved) {
                $this->Flash->success(__("All tags updated"));
            }
            $this->redirectEvent('/logistic/tag');
        }
        $this->set('title_for_layout', __('Tags'));
        $this->set('tags', $tags);
    }
}
