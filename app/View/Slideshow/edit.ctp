<ul class="breadcrumb">
    <li><a href="<?= $this->Wb->eventUrl("/Slideshow/") ?>"><?= __('Slideshows') ?></a> <span class="divider"></span>
    </li>
    <li class="active"><?= __('Edit slideshow') ?></li>
</ul>

<div class="row">

    <div class="col-md-8">

        <h4><?= __('Slides for: ') . $show['Slideshow']['name'] ?></h4>

        <ul>
            <?php
            foreach ($slides as $slide) {
                if ($slide['SlideshowsSlide']['date_from'] != null && $slide['SlideshowsSlide']['date_from'] > date("Y-m-d H:i:s")) continue;
                if ($slide['SlideshowsSlide']['date_to'] != null && $slide['SlideshowsSlide']['date_to'] < date("Y-m-d H:i:s")) continue;

                $slidename = $slide['SlideshowsSlide']['name'] == "" ? '(' . __('no name') . ')' : $slide['SlideshowsSlide']['name'];

                if ($slide['SlideshowsSlide']['type'] == 'text') {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/text/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                } else if ($slide['SlideshowsSlide']['type'] == 'schedule') {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/scheduleitem/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                } else if ($slide['SlideshowsSlide']['type'] == 'url') {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/url/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                } else if ($slide['SlideshowsSlide']['type'] == 'stream') {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/stream/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                }
            }
            ?>
        </ul>

        <h4>Inaktive slides</h4>

        <ul>
            <?php
            foreach ($slides as $slide) {
                if ($slide['SlideshowsSlide']['date_from'] != null && $slide['SlideshowsSlide']['date_from'] < date("Y-m-d H:i:s") &&
                    $slide['SlideshowsSlide']['date_to'] != null && $slide['SlideshowsSlide']['date_to'] > date("Y-m-d H:i:s")
                ) continue;

                $slidename = $slide['SlideshowsSlide']['name'] == "" ? '(' . __('no name') . ')' : $slide['SlideshowsSlide']['name'];

                if ($slide['SlideshowsSlide']['type'] == "text") {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/text/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                } else if ($slide['SlideshowsSlide']['type'] == 'schedule') {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/scheduleitem/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                } else if ($slide['SlideshowsSlide']['type'] == 'url') {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/url/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                } else if ($slide['SlideshowsSlide']['type'] == 'stream') {
                    echo '<li><a href="/' . WB::$event->reference . '/Slideshow/stream/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . $slidename . '</a> - (<a href="/' . WB::$event->reference . '/Slideshow/DeleteSlide/' . $show['Slideshow']['id'] . '/' . $slide['SlideshowsSlide']['id'] . '">' . __('Delete') . '</a>)</li>';
                }
            }
            ?>
        </ul>

    </div>

    <div class="col-md-4">

        <h4><?= __('Add new') ?></h4>

        <ul>
            <li><a href="/<?= WB::$event->reference ?>/Slideshow/text/<?= $show_id ?>">Text slide</a></li>
            <li><a href="/<?= WB::$event->reference ?>/Slideshow/scheduleitem/<?= $show_id ?>">Schedule item slide</a>
            </li>
            <li><a href="/<?= WB::$event->reference ?>/Slideshow/url/<?= $show_id ?>">URL slide</a></li>
            <li><a href="/<?= WB::$event->reference ?>/Slideshow/stream/<?= $show_id ?>">Stream slide</a></li>
        </ul>


        <form method="post" action="<?= $this->Wb->eventUrl("/Slideshow/SaveMaster") ?>">
          <h4><?=__('Set master') ?></h4>
          <p><?=__('A master is a slideshow that will be shown first, before the slides defined here.')?>
          <?= $this->Form->input('Slideshow.master',array('value' => $show['Slideshow']['master'], 'type'=>'select','empty' => __('Set master'),'options'=>$masters)); ?>
          <?= $this->Form->hidden('Slideshow.id', array('value' => $show_id)) ?>
          <?= $this->Form->submit($savebutton, array('class' => 'btn btn-success', 'name' => 'save')) ?>
          <?php if($show['Slideshow']['master'] != 0 && $show['Slideshow']['master'] != null && $show['Slideshow']['master'] != "0") {
            ?><br><a href="<?= $this->Wb->eventUrl("/Slideshow/Edit/") . $show['Slideshow']['master'] ?>" class="btn btn-info"><?=__('Edit master')?></a><?
          } ?>
        </form>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="actions">
            <a class="btn btn-primary"
               href="/<?= WB::$event->reference ?>/Slideshow/RunSlideshow/<?= $show['Slideshow']['id'] ?>">Run slideshow
                1080</a>
            <a class="btn btn-primary"
               href="/<?= WB::$event->reference ?>/Slideshow/RunSlideshowLoFi/<?= $show['Slideshow']['id'] ?>">Run
                slideshow
                1080 (LoFi)</a>
        </div>
    </div>
</div>
