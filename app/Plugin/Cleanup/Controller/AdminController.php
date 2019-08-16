<?php

class AdminController extends CleanupAppController {

    public $uses = array('User', 'Crew', 'Badge', 'Cleanup.Cleanup', 'Cleanup.CleanupPosition', 'Cleanup.CleanupExemptCrew',);

    public function index() {
        $crews = $this->getCrewList();
        $member_count = 0;
        foreach($crews as $id => $name) {
            $member_count += $this->User->getMembers($id, true);
        }
        $this->set('member_count', $member_count);
        $this->set('cleanup_count', $this->CleanupPosition->find('count', array(
            'conditions' => array(
                'Cleanup.event_id' => $this->Wannabe->event->id
            )
        )));
        $this->set('cleanup_completed_count', $this->CleanupPosition->find('count', array(
            'conditions' => array(
                'Cleanup.event_id' => $this->Wannabe->event->id,
                'CleanupPosition.completed' => 1
            )
        )));
        $this->set('cleanups', $this->Cleanup->getCleanupsForEvent());
        $this->set('title_for_layout', __('Cleanup admin'));
    }

    public function add() {
        if($this->Acl->hasAccess('manage', $this->Wannabe->user)) {
            if ($this->request->is('post')) {

                $this->request->data['Cleanup']['event_id'] = $this->Wannabe->event->id;
                $this->request->data['Cleanup']['time'] =
                    $this->request->data['Cleanup']['time'] .
                    " " . $this->request->data['Cleanup']['hour'] .
                    ":" . $this->request->data['Cleanup']['min'] . ":00";


                if ($this->Cleanup->save($this->request->data)) {
                    $this->Flash->success(__("Added cleanup time."));
                    $this->redirectEvent('/Cleanup/Admin/');
                } else {
                    $this->Flash->error(__("Could not add cleanup time."));
                }
            }
            $start = strtotime(substr($this->Wannabe->event->start, 0, 10) . ' 00:00:00') - (86400*8);
            $end = strtotime(substr($this->Wannabe->event->end, 0, 10) . ' 00:00:00');
            $date = array();
            while ($start < $end && $start += 86400)
                $date[date('Y-m-d', $start)] = date('l, M j', $start);
            $this->set('dates', $date);
        } else {
            throw new ForbiddenException();
        }
    }

    public function edit($cleanup_id) {
        if($this->Acl->hasAccess('manage', $this->Wannabe->user)) {
            if ($this->request->is('post')) {
                $this->request->data['Cleanup']['time'] =
                    $this->request->data['Cleanup']['time'] .
                    " " . $this->request->data['Cleanup']['hour'] .
                    ":" . $this->request->data['Cleanup']['min'] . ":00";

                if ($this->Cleanup->save($this->request->data)) {
                    $this->Flash->success(__("Updated cleanup time."));
                    $this->redirectEvent('/Cleanup/Admin/');
                } else {
                    $this->Flash->error(__("Could not update cleanup time."));
                }
            }

            $cleanup = $this->Cleanup->getCleanup($cleanup_id);
            if (!$cleanup) {
                $this->Flash->error(__("No cleanup with id '" . $cleanup_id . "'."));
                $this->redirectEvent('/Cleanup/Admin/');
            }
            $time = $cleanup['Cleanup']['time'];
            $timepart = explode(" ", $time);
            $cleanup['Cleanup']['time'] = $timepart[0];
            $timepart = explode(":", $timepart[1]);
            $cleanup['Cleanup']['hour'] = $timepart[0];
            $cleanup['Cleanup']['min'] = $timepart[1];

            //die(var_dump($cleanup));

            $start = strtotime(substr($this->Wannabe->event->start, 0, 10) . ' 00:00:00') - (86400*8);
            $end = strtotime(substr($this->Wannabe->event->end, 0, 10) . ' 00:00:00');
            $date = array();
            while ($start < $end && $start += 86400)
                $date[date('Y-m-d', $start)] = date('l, M j', $start);
            $this->set('dates', $date);
            $this->set('cleanup', $cleanup);
            $this->set('title_for_layout', __('Edit cleanup'));
        } else {
            throw new ForbiddenException();
        }
    }

    public function assign() {
        if (!isset($this->params['named']['cleanup']) && !isset($this->params['named']['crew'])) {
            $this->Flash->error(__("Received no cleanup or crew ID."));
            $this->redirectEvent('/Cleanup/Admin');
        } elseif (!isset($this->params['named']['cleanup']) && isset($this->params['named']['crew'])) {
            $crew = $this->getCrew($this->params['named']['crew']);
            if(!$crew)
                throw new BadRequestException(__("Crew does not exist or is exempted"));
            $this->set('crew', $crew);
            $this->set('cleanups', $this->Cleanup->getCleanupsForEvent());
            $this->set('members', $this->getMembers($crew['Crew']['id']));
            $this->set('title_for_layout', __('Cleanups for %s', $crew['Crew']['name']));
            $this->render('crew-assign');
        } else {
            if (!isset($this->params['named']['crew'])) {
                if ($this->request->is('post')) {
                    if (isset($this->request->data['crew_id'])) {
                        $crew_id = $this->request->data['crew_id'];
                        $this->redirect($this->here . "/crew:" . $crew_id);
                    }
                }
            } else {
                $crew = $this->getCrew($this->params['named']['crew']);
                if(!$crew)
                    throw new BadRequestException(__("Crew does not exist or is exempted"));
                if ($this->request->is('post')) {
                    $canManage = $this->Acl->hasAccessToCrew($this->Wannabe->user, $crew) || $this->Acl->hasAccess('manage', $this->Wannabe->user);
                    if (!$canManage) throw new ForbiddenException(__("No access to crew"));
                    if (isset($this->request->data['user_id'])) {
                        $user_id = $this->request->data['user_id'];
                        $cleanup_id = $this->params['named']['cleanup'];
                        if (!$this->Cleanup->isFull($cleanup_id)) {
                            if (!$this->CleanupPosition->getPositionForUser($user_id)) {
                                $this->CleanupPosition->create();
                                $this->CleanupPosition->set('cleanup_id', $cleanup_id);
                                $this->CleanupPosition->set('user_id', $user_id);

                                if ($this->CleanupPosition->save()) {
                                    $this->Flash->success(__("User added"));
                                } else {
                                    $this->Flash->error(__("Failed to add user"));
                                }
                            } else {
                                $this->Flash->warning(__("User already added"));
                            }
                        } else {
                            $this->Flash->error(__("Cleanup is full"));
                        }

                    } elseif (isset($this->request->data['crew_id']) && $this->request->data['crew_id'] == $crew['Crew']['id']) {
                        $crew_id = $this->request->data['crew_id'];
                        $members = $this->User->getMembers($crew_id);
                        $cleanup_id = $this->params['named']['cleanup'];

                        $added = 0;
                        $ignored = 0;
                        $failed = 0;
                        if (!$this->Cleanup->isFull($cleanup_id)) {
                            $cleanup = $this->Cleanup->getCleanup($cleanup_id);
                            $maximum = ($cleanup['Cleanup']['maximum'] - $cleanup['Cleanup']['cleanup_positions_total']);
                            foreach ($members as $member) {
                                if ($maximum <= $added) {
                                    $failed++;
                                    continue;
                                }
                                if (!$this->CleanupPosition->getPositionForUser($member['User']['id'])) {
                                    $this->CleanupPosition->create();
                                    $this->CleanupPosition->set('cleanup_id', $cleanup_id);
                                    $this->CleanupPosition->set('user_id', $member['User']['id']);

                                    if ($this->CleanupPosition->save()) {
                                        $added++;
                                    } else {
                                        $failed++;
                                    }
                                }
                                else {
                                    $ignored++;
                                }
                            }
                            $this->Flash->success(sprintf(__('%d added, %d ignored and %d failed while adding crew.', $added, $ignored, $failed)));
                        } else {
                            $this->Flash->error(__("Cleanup is full"));
                        }
                    } else {
                        $this->Flash->error(__("Received no crew ID or user ID."));
                    }
                }
                $this->set('members', $this->getMembers($this->params['named']['crew']));
            }

            $this->set('crews', $this->getCrewList());

            if(isset($this->params['named']['cleanup'])) {
                $cleanup = $this->Cleanup->getCleanup($this->params['named']['cleanup']);
                $this->set('isFull', $this->Cleanup->isFull($this->params['named']['cleanup']));
                $this->set('title_for_layout', __("Register cleanup, %s", '<span class="moment format">' . $cleanup['Cleanup']['unixtime'] . '</span>'));
                $upcoming = $cleanup['Cleanup']['cleanup_positions_upcoming'];
                $completed = $cleanup['Cleanup']['cleanup_positions_completed'];
                $total = $cleanup['Cleanup']['cleanup_positions_total'];
                $maximum = $cleanup['Cleanup']['maximum'];
                $this->set('desc_for_layout', __("Maximum assigned: %s, total: %s, upcoming: %s, completed: %s", $maximum, $total, $upcoming, $completed));
            }
        }
    }

    public function remove() {
        if (isset($this->params['named']['user'])) {
            if($this->CleanupPosition->getPositionForUser($this->params['named']['user'])) {
                $user = $this->User->findById($this->params['named']['user']);
                if(empty($user))
                    throw new BadRequestException(__("User does not exist"));
                $accessToCrew = false;
                foreach($user['Crew'] as $crew) {
                    if($this->Acl->hasAccessToCrew($this->Wannabe->user, array('Crew' => $crew))) {
                        $accessToCrew = true;
                    }
                }
                $canManage = $this->Acl->hasAccess('manage', $this->Wannabe->user);
                $canRemove = $accessToCrew || $canManage;
                if($canRemove) {
                    if($this->CleanupPosition->removePositionForUser($user['User']['id']))
                        $this->Flash->info(__('Cleanup for %s removed', $user['User']['realname']));
                    else
                        $this->Flash->error(__('Error removing cleanup for  %s', $user['User']['realname']));
                } else {
                    throw new ForbiddenException(__("No access to crew"));
                }
            } else {
                $this->Flash->error(__("Nothing to remove"));
            }
        } elseif (isset($this->params['named']['exempt'])) {
            if($this->Acl->hasAccess('manage', $this->Wannabe->user)) {
                if($this->CleanupExemptCrew->removeExemptedCrew($this->params['named']['exempt']))
                    $this->Flash->info(__("Exemption removed"));
                else
                    $this->Flash->error(__("Error removing exemption"));
            } else {
                throw new ForbiddenException(__("No access to manage"));
            }
        } elseif (isset($this->params['named']['cleanup'])) {
            if($this->Acl->hasAccess('manage', $this->Wannabe->user)) {
                if($this->Cleanup->delete($this->params['named']['cleanup']))
                    $this->Flash->info(__("Exemption removed"));
                else
                    $this->Flash->error(__("Error removing exemption"));
            } else {
                throw new ForbiddenException(__("No access to manage"));
            }
        } else {
            $this->Flash->error(__("Received no user ID."));
        }
        $this->redirect($this->request->referer());
    }

    public function exempt() {
        if($this->Acl->hasAccess('manage', $this->Wannabe->user)) {
            if ($this->request->is('post')) {
                if (!isset($this->request->data['crew_id'])) {
                    $this->Flash->error(__("Received no crew ID."));
                } elseif ($this->CleanupExemptCrew->getExemptedCrew($this->request->data['crew_id'])) {
                    $this->Flash->error(__("This crew is already exempt from cleanup."));
                } else {
                    $crew_id = $this->request->data['crew_id'];
                    $event_id = $this->Wannabe->event->id;
                    $user_id = $this->Wannabe->user['User']['id'];

                    $data = array("CleanupExemptCrew" => array('crew_id' => $crew_id, 'event_id' => $event_id, 'exempted_by' => $user_id));
                    if ($this->CleanupExemptCrew->save($data)) {
                        $this->Flash->success(__("Crew exempted from cleanup"));
                        $this->redirectEvent('/Cleanup/Admin/exempt');
                    } else {
                        $this->Flash->error(__("Failed to add crew to exempt list for cleanup"));
                    }
                }
            }
            $this->set('exempted_crews', $this->CleanupExemptCrew->getExemptedCrewsForEvent());
            $this->set('crews', $this->Crew->getAllCrews(true, 0, true));
            $this->set('event', $this->Wannabe->event->name);

            $this->set('title_for_layout', __('Cleanup admin'));
        } else {
            throw new ForbiddenException();
        }
    }

    public function statistics() {
        if(!$this->Acl->hasAccess('manage', $this->Wannabe->user)) {
            throw new ForbiddenException();
        }

        $exempted_crews = $this->CleanupExemptCrew->getExemptedCrewsForEvent();
        $cleanups = $this->Cleanup->getCleanupsForEvent();
        $crews = $this->Crew->getAllCrews(true, 0, true);

        $exempted_crew_ids = array();
        foreach ($exempted_crews as $exempted_crew) {
            array_push($exempted_crew_ids, $exempted_crew['CleanupExemptCrew']['crew_id']);
        }

        $userids_with_cleanup = array();
        $userids_completed = array();
        foreach ($cleanups as $cleanup) {
            foreach ($cleanup['CleanupPosition'] as $pos) {
                array_push($userids_with_cleanup, $pos['user_id']);
                $userids_completed[$pos['user_id']] = $pos['completed'];
            }
        }

        $crew_stats = array();
        foreach ($crews as $id=>$crew_name) {
            if (!in_array($id, $exempted_crew_ids)) {
                $crew_stats[$crew_name] = array(
                    'total' => 0,
                    'assigned' => 0,
                    'completed' => 0
                );
                foreach ($this->User->getMembers($id) as $crew_member) {
                    $crew_stats[$crew_name]['total']++;
                    if (in_array($crew_member['User']['id'], $userids_with_cleanup)) {
                        $crew_stats[$crew_name]['assigned']++;
                        if(intval($userids_completed[$crew_member['User']['id']])) {
                          $crew_stats[$crew_name]['completed']++;
                        }
                    }
                }
            }
        }

        $this->set('cleanups', $this->Cleanup->getCleanupsForEvent());
        $this->set('crew_stats', $crew_stats);
        $this->set('title_for_layout', __('Cleanup statictics'));
    }

    public function search($term = null) {
      if(!$this->Acl->hasAccess('manage', $this->Wannabe->user)) {
        throw new ForbiddenException();
      }

      if($this->request->is('post')) {

        // If post with search, redirect with search url
        if(isset($this->request->data['search'])) {
          $this->redirect('/'.WB::$event->reference.'/Cleanup/Admin/Search/'.$this->request->data['term']);
        }

        // If post with search completed clicked, override term and enable complete
        if(isset($this->request->data['searchcomplete'])) {
          $term = $this->request->data['term'];
          $this->request->data['completed'] = true;
        }

      }

      // If term is empty, show empty view
      if(empty($term)) {
        return;
      }

      // Try to find badge with search term, if found override term
      $badge = $this->Badge->find('first', array('conditions' => array('Badge.event_id' => WB::$event->id, 'Badge.nfc_id' => $term)));
      if(!empty($badge)) {
        $term = $badge['User']['id'];
      }

      // If assign is clicked, assign
      if(isset($this->request->data['assign'])) {
        $cleanupId = $this->request->data['cleanup_id'];
        $newData = array(
          'CleanupPosition' => array(
            'cleanup_id' => $cleanupId,
            'user_id' => $term
          )
        );
        $this->CleanupPosition->save($newData);
        $cleanup = $this->Cleanup->getCleanup($cleanupId);

        // If cleanup is full, add a spot
        if($this->Cleanup->isFull($cleanupId)) {
          $newData = array(
            'Cleanup' => array(
              'id' => $cleanupId,
              'maximum' => intval($cleanup['Cleanup']['maximum']) + 1
            )
          );
          $this->Cleanup->save($newData);
          $this->Flash->success(__("Assigned."));
        }
      }

      // Try to find cleanup data
      $data = $this->CleanupPosition->getPositionForUser($term);
      if(empty($data)) {

        // If search complete clicked but not user found, redirect
        if(isset($this->request->data['searchcomplete'])) {
          $this->redirect('/'.WB::$event->reference.'/Cleanup/Admin/Search/'.$term);
        }

        // Try to get user, if not found return empty
        $data = $this->User->findById($term);
        if(empty($data)) {
          $this->Flash->error(__('No user with UID %s found.', $term));
          return;
        }

        // Override cleanup data
        $data['CleanupPosition']['id'] = 0;
        $data['CleanupPosition']['time'] = "Not assigned";
        $data['CleanupPosition']['completed'] = false;
        $this->Flash->error(__("User not assigned."));
      }

      // Handle completion clicks
      else if($this->request->is('post') && !isset($this->request->data['assign'])) {
        $completed = isset($this->request->data['completed']);
        $cleanupId = $data['CleanupPosition']['cleanup_id'];
        if($completed) {

          // Handle reasignment
          if(isset($this->request->data['cleanup_id']) && $this->request->data['cleanup_id'] != $cleanupId) {
            $cleanupId = $this->request->data['cleanup_id'];
            $cleanup = $this->Cleanup->getCleanup($cleanupId);

            // If cleanup is full, add a spot
            if($this->Cleanup->isFull($cleanupId)) {
              $newData = array(
                'Cleanup' => array(
                  'id' => $cleanupId,
                  'maximum' => intval($cleanup['Cleanup']['maximum']) + 1
                )
              );
              $this->Cleanup->save($newData);
            }
          }
        }
        $newData = array(
          'CleanupPosition' => array(
            'id' => $data['CleanupPosition']['id'],
            'cleanup_id' => $cleanupId,
            'completed' => $completed
          )
        );
        if($this->CleanupPosition->save($newData)) {
          $this->Flash->success(__("Paticipation updated."));

          // Get updated data
          $data = $this->CleanupPosition->getPositionForUser($term);
        }
        else {
          $this->Flash->error(__("Could not save."));
        }

        // If searchcomplete, redirect instead of showing
        $this->redirect('/'.WB::$event->reference.'/Cleanup/Admin/Search/'.$term);
      }

      // Set view data
      $this->set('data', $data);
      $this->set('cleanups', $this->Cleanup->getCleanupsForEvent());
      $this->set('title', __('Search'));
    }

}
