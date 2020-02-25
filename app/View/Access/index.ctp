<div class="col-md-12">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Access control list</a></li>
        <li role="presentation"><a  href="/<?=$wannabe->event->reference?>/Access/Object">Manage ACL objects</a></li>
        <li role="presentation"><a href="/<?=$wannabe->event->reference?>/Access/Role">Manage ACL roles</a></li>
    </ul>
    <div class="tab-content clearfix">
        <div class="col-md-5">
            <h4><?=('Access control list objects')?></h4>
            <ul>
                <?php
                    foreach ($acl_list as $l)
                    {
                        echo '<li><a href="/'.$wannabe->event->reference.'/Access/View/'.$l['Aclobject']['id'].'">' . $l['Aclobject']['path'] . '</a></li>'."\n";
                    }
                ?>
            </ul>
        </div>
        <div class="col-md-3">
            <h1><?=__('Access control')?></h1>
        </div>
    </div>
</div>
