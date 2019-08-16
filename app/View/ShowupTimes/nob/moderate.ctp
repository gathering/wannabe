<div class="row">
    <div class="span16">
    <form method="post">
        <?php foreach($showups as $index => $crew) { ?>
        <h3><?=$index?></h3>
        <table>
            <thead>
                <th><?=__("Name")?></th>
                <th><?=__("Nickname")?></th>
                <th><?=__("Showup time")?></th>
                <th><?=__("Comment")?></th>
                <th><?=__("Approved")?></th>
            </thead>
            <tbody>
            <?php foreach($crew as $member) { ?>
            <tr>
            <?php
                $index = $member['User']['id'];

                // Adjust presentation of date
                (isset($member['ShowupTime']['date']) ?
                    $member['ShowupTime']['date'] = date("l, M j", strtotime($member['ShowupTime']['date'])) : '');
            ?>
                <td><a href="<?=$this->Wb->eventUrl('/Profile/View/'.$member['User']['id'])?>"><?=h($member['User']['realname'])?></a></td> 
                <td><?=h($member['User']['nickname'])?></td>
                <td><?=(isset($member['ShowupTime']) ?
                    $member['ShowupTime']['date'].' '.$member['ShowupTime']['hour'].'.00' :
                    "<div class=\"red\">".__("Not set")."</div>")?></td>
                <td class="showup-comment"><?=(isset($member['ShowupTime']['comment']) ? h($member['ShowupTime']['comment']) : '')?></td>
                <td>
                <?php
                    if(isset($member['ShowupTime'])) {
                        if($member['ShowupTime']['approved'] == 0) {?>
                            <ul class="inputs-list">
                            <li><label for="ShowupTimeApproved2_<?=$index?>"><?=__("Approve")?>
                            <input type="radio" name="data[ShowupTime][<?=$index?>][approved]" id="<?=$index?>_approve" value="2" />
                            </label></li>
                            <li><label for="ShowupTimeApproved0_<?=$index?>"><?=__("Do nothing")?>
                            <input type="radio" name="data[ShowupTime][<?=$index?>][approved]" id="<?=$index?>_nothing" value="" />
                            </label></li>
                            <li><label for="ShowupTimeApproved1_<?=$index?>"><?=__("Decline with reason:")?>
                            <input type="radio" name="data[ShowupTime][<?=$index?>][approved]" id="<?=$index?>_decline" value="1" />
                            <input type="text" name="data[ShowupTime][<?=$index?>][message]" id="<?=$index?>_message" />
                            </label></li>
                            </ul>
                        <?php }
                        else if($member['ShowupTime']['approved'] == 1){
                            echo "<p class=\"yellow\">".__("Declined")."</p>";
                        
                        }else{
                            echo "<p class=\"green\">".__("Approved")."</p>";
                        }
                    }else{
                        echo "<p class=\"red\">".__("Not set")."</p>";
                    }
                ?>
                </td>
            </tr>
            <?php }  ?>
            </tbody>
        </table>
        <?php } ?>
        <div class="actions">
            <?=$this->Form->submit(__('Moderate'), array('class' => 'btn success','name'=>'save'))?>
        </div>
    </form>
    </div>
</div>
