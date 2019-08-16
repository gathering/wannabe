<h2><?=__("Logistics")?></h2>

<p><?=__("Choose storage location")?></p>

<p><ul>
<? foreach ($locations as $location) : ?>
        <li>
        	<a href="<?=$this->Wb->eventUrl('/logistic/Location/setLocation/'.$location['LogisticLocation']['id'])?>">
        		<?=$location['LogisticLocation']['name']?>
        	</a>
        </li>
<? endforeach; ?>
</ul></p>

<p><a class="btn primary" href="<?=$this->Wb->eventUrl('/logistic/Location/create')?>#"><?=__("Create new location")?></a></p>

