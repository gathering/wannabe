<link rel="stylesheet" type="text/css" href="/css/slideshow_edit.css">

<ul class="breadcrumb">
    <li><a href="<?= $this->Wb->eventUrl("/Slideshow/") ?>"><?= __('Slideshows') ?></a> <span class="divider"></span>
    </li>
    <li><a href="<?= $this->Wb->eventUrl("/Slideshow/Edit/" . $show_id) ?>"><?= __('Edit slideshow') ?></a> <span
            class="divider"></span></li>
    <li class="active"><?= __('URL') ?> <span class="divider"></span></li>
</ul>


<form method="post" class="form-inline" action="<?= $this->Wb->eventUrl("/Slideshow/SaveSlide/stream") ?>">

    <label><?= __('Name') ?></label>

    <div class="input">
        <input type="text" class="form-control" name="data[SlideshowsSlide][name]" value="<?= $name ?>">
    </div>

    <br>

    <label><?= __('Duration') ?></label>

    <div class="input">
        <input type="text" class="form-control" name="data[SlideshowsSlide][duration]" value="<?= $duration ?>">
    </div>

    <br>

    <label><?= __('URL') ?></label>

    <div class="input">
        <input type="text" class="form-control" name="data[SlideshowsSlide][url]" value="<?= $url ?>">
    </div>

    <?= $this->Form->hidden('SlideshowsSlide.id', array('class' => 'form-control')) ?>
    <?= $this->Form->hidden('SlideshowsSlide.show_id', array('value' => $show_id, 'class' => 'form-control')) ?>
    <?= $this->Form->hidden('SlideshowsSlide.type', array('value' => 'stream', 'class' => 'form-control')) ?>
    <br/>

    <?= $this->Form->input('SlideshowsSlide.date_from', array('value' => $date_from, 'class' => 'form-control', 'dateFormat' => 'D M Y',  'timeFormat' => 24, 'label' => false, 'minYear' => date("Y"))) ?>

    <?= $this->Form->input('SlideshowsSlide.date_to', array('value' => $date_to, 'class' => 'form-control', 'dateFormat' => 'D M Y', 'timeFormat'=> 24, 'label' => false, 'minYear' => date("Y"))) ?>

    <br/>

    <div class="actions">
        <?= $this->Form->submit($savebutton, array('class' => 'btn btn-success', 'name' => __("Save"))) ?>
    </div>
</form>
