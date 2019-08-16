<p>This site is developed and managed by <a href='mailto:wannabe@gathering.orgSPAM'>Core:Systems</a>. Operation of web server and email system is kindly provided by <a href='mailto:drift@gathering.orgSPAM'>driftsgruppen</a>.</p>
<p>Bugs should be reported by email to <a href='mailto:wannabe@gathering.orgSPAM'>Core:Systems</a>, and <em>only</em> there. Issues regarding mailing lists should be reported to <a href='mailto:drift@gathering.orgSPAM'>driftsgruppen</a>. For all other technical issues regarding any other site developed or managed by any parts of The Gathering, please contact <a href='mailto:webmaster@gathering.orgSPAM'>webmaster</a>.</p>
<p>Any and all information provided beyond the point of login on this site should be considered confidential and stricly unoffical, unless stated otherwise on <a href="http://www.gathering.org/">gathering.org</a>. Most of the content is user generated and not strictly moderated.</p>
<h4>Current version</h4>
<?php if(isset($history['tag'])): ?>
<p>Currently running version <strong><?=$history['tag']?></strong>, tagged by <em><?=h($history['author'])?></em> on <?=date("jS F, Y, H:i", strtotime($history['date']))?>.<br />Message for commit was:<br /><?=$history['message']?>.</p>
<?php else: ?>
<p>Currently running revision <strong><?=$history['commit']?></strong>, committed by <em><?=h($history['author'])?></em> on <?=date("jS F, Y, H:i", strtotime($history['date']))?>.<br />Message for commit was:<br /><?=$history['message']?>.</p>
<?php endif; ?>
