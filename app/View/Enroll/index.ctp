<div class="row">
	<div class="span12">
		<h2><?=__("Viewing applications")?></h2>
		<p><?=__("Below is a list of all currently not handled applications.")?></p>
		<p><?=__("The ones you have access to handle will be hilighted in: %s, if you can both accept or deny this applicant's application now; %s, if the application must be handeled by another chief before you can accept it (you will be able to deny it, regardless); or %s, if you so not have access.", '<span class="green">'.__("green").'</span>', '<span class="yellow">'.__("yellow").'</span>', '<span class="red">'.__("red").'</span>')?></p>
        <p><?=__("Choices in %s indicate they have been placed on wait list.", '<span class="blue">'.__("blue").'</span>')?></p>
<?php if(!$enrollsetting['EnrollSetting']['enrollaccept']) { ?>
		<p><?=__("Currently accepting and denying applications is disabled.")?></p>
<?php } ?>
<?php
foreach($documents as $document) {
    foreach($document['ApplicationChoice'] as $choice) {
        if($choice['accepted']) {
            $count--;
        }
    }
}
?>
		<p><?=__('Current number of applicants matching your filter is %s', $count)?></p>
	</div>
	<div class="span4">
		<form method="get" class="form-stacked" action="<?=$this->Wb->eventUrl('/Enroll/filter')?>">
			<fieldset>
				<legend><?=__("Filter")?></legend>
				<div class="clearfix">
					<label><?=__("Crew")?></label>
					<div class="input">
						<select class="span3" name="crew_id" id="CrewID">
						<option value=""><?=__("All crews")?></option>
							<? foreach ($crews as $crew_id => $name): ?>
								<option value="<?=$crew_id?>" <?=isset($_REQUEST['crew_id']) && $crew_id == $_REQUEST['crew_id'] ? 'selected="selected"' : null?>><?=$name?></option>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<? if ($tags) : ?>
					<div class="clearfix">
						<label><?=__("Tag")?></label>
						<div class="input">
							<select class="span3" name="tag">
							<option value=""><?=__("All tags")?></option>
								<? foreach ($tags as $tag) : ?>
									<option value="<?=$tag['ApplicationTag']['tag']?>" <?=isset($_REQUEST['tag']) && $tag['ApplicationTag']['tag'] == $_REQUEST['tag'] ? 'selected' : null?>><?=$tag['ApplicationTag']['tag']?></option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
				<? endif; ?>
                <div class="clearfix" style="display: none;" id="DW">
                    <div class="input">
                        <label><input type="checkbox" name="waiting" value="waiting" <?=isset($_REQUEST['waiting']) && $_REQUEST['waiting'] == "waiting" ? 'checked="checked"' : null?> id="ShowWaiting"> <?=__("Show waiting")?></label>
                        <label><input type="checkbox" name="denied" value="denied" <?=isset($_REQUEST['denied']) && $_REQUEST['denied'] == "denied" ? 'checked="checked"' : null?> id="ShowDenied"> <?=__("Show denied")?></label>
                    </div>
                </div>
			</fieldset>
			<input type="submit" value="<?=__("Update")?>" class="btn primary" />
		</form>
	</div>
</div>
<div class="row">
	<div class="span16">
		<h2><?=__("Applications")?></h2>
		<table class="bordered-table zebra-striped" id="sortTable">
			<thead>
				<tr>
					<th id="name" class="yellow"><?=__('Name')?></th>
					<th id="age" class="blue"><?=__('Age')?></th>
					<th id="crew" class="green"><?=__('Applying for')?></th>
					<th id="date" class="red"><?=__("Last updated")?></th>
					<th id="priority" class="black"><?=__("Priority")?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($documents as $document) { ?>
				<tr>
					<td><?=$this->Html->link($document['User']['realname'].(!empty($document['User']['nickname']) ? ' aka ' . $document['User']['nickname'] : null), $this->Wb->eventUrl('/Enroll/view/'.$document['User']['id']))?></td>
					<td><?=$document['User']['age']?></td>
					<td>
						<?php foreach($document['ApplicationChoice'] as $choice) { 
						   
							if(isset($_REQUEST['denied']) && $_REQUEST['denied'] && $choice['denied'] && $choice['crew_id'] == $_REQUEST['crew_id']) {
								echo $this->Html->link($crews[$choice['crew_id']], $this->Wb->eventUrl('/Enroll/filter?crew_id='.$choice['crew_id']), array('class'=>'red'));
							}

							if ($choice['crew_id'] != 0 && !$choice['accepted'] && !$choice['denied'] && !$choice['disabled']) {
								$acceptable = $choice['acceptable']; 
								$class = 'red';
								if($manageable_crews[$choice['crew_id']]) $class = 'yellow';
								if($acceptable && $enrollsetting['EnrollSetting']['enrollactive']) $class = 'green';
								if($acceptable && $choice['waiting'] && $enrollsetting['EnrollSetting']['enrollactive']) $class = 'blue';
								?>
								<?=$this->Html->link($crews[$choice['crew_id']], $this->Wb->eventUrl('/Enroll/filter?crew_id='.$choice['crew_id']), array('class'=>$class))?>
							<?php } ?>
						<?php } ?>
					</td>
					<?php /*<td title="<?=strftime(__("%Y%m%d"), strtotime($document['ApplicationDocument']['updated']))?>"><?=strftime(__("%b %e %G, %H:%M"), strtotime($document['ApplicationDocument']['updated']))?></td> */ ?>
					<td><?=date("M j, Y G:i", strtotime($document['ApplicationDocument']['updated']))?></td>
					<td><?=$document['ApplicationDocument']['priority']?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
$('#CrewID').change(function() {
    if(this.selectedIndex) {
        $('#DW').show()
    }
});
$(document).ready(function(){
    if($('#CrewID option').filter(":selected").val()) {
        $('#DW').show()
    }
	$.tablesorter.addWidget({ 
		id: "addHash", 
		format: function(table) { 
			$("thead th",table).each(function() { 
				if($(this).hasClass('headerSortDown')) {
					var hash = $(this).attr('id');
					location.hash = hash + 'Asc';
				}
				if($(this).hasClass('headerSortUp')) {
					var hash = $(this).attr('id');
					location.hash = hash + 'Desc';
				}
			});
		} 
	});
    $.tablesorter.addParser({
        id: 'dateParser',
        is: function(s) {
            return false
        },
        format: function(s) {
            return Date.parse(s.replace())
        },
        type: 'Numeric'
    })
	// table sort
	$("#sortTable").tablesorter({ 
		//sortList: [[ 0, 0 ]],
        //dateFormat: 'uk',
		sortInitialOrder: 'desc',
        widgets: ['addHash'],
        headers: {
            3: {
                sorter: 'dateParser'
            }
        }
	});
	if(location.hash.substr(1) == "nameAsc") {
		var sorting = [[0,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "nameDesc") {
		var sorting = [[0,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "ageAsc") {
		var sorting = [[1,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "ageDesc") {
		var sorting = [[1,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "crewAsc") {
		var sorting = [[2,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "crewDesc") {
		var sorting = [[2,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "dateAsc") {
		var sorting = [[3,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "dateDesc") {
		var sorting = [[3,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "priorityAsc") {
		var sorting = [[4,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "priorityDesc") {
		var sorting = [[4,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "") {
		var sorting = [[0,0]];
		$("#sortTable").trigger("sorton",[sorting]);
	}
});
$(window).bind('hashchange', function() {
	if(location.hash.substr(1) == "nameAsc") {
		var sorting = [[0,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "nameDesc") {
		var sorting = [[0,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "ageAsc") {
		var sorting = [[1,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "ageDesc") {
		var sorting = [[1,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "crewAsc") {
		var sorting = [[2,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "crewDesc") {
		var sorting = [[2,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "dateAsc") {
		var sorting = [[3,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "dateDesc") {
		var sorting = [[3,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "priorityAsc") {
		var sorting = [[4,0]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
	if(location.hash.substr(1) == "priorityDesc") {
		var sorting = [[4,1]];
		$("#sortTable").trigger("sorton",[sorting]); 
	}
});
</script>
