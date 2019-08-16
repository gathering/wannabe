<link rel="stylesheet" type="text/css" href="/css/slideshow.css">
<link rel="stylesheet" type="text/css" href="/css/slideshow_edit.css">

<div id="maincontent">
    <div style="height:10%;"></div>
    <div id="titlecontent" onclick="this.contentEditable='true';">
        Click here to edit the title
    </div>
    <div style="height:5%;"></div>
    <div id="slidecontent" onclick="this.contentEditable='true';">
        Click here to edit the content
    </div>
</div>


<script type="text/javascript" language="JavaScript">
    function saveSlide() {
        var title = document.getElementById("titlecontent").innerHTML;
        var content = document.getElementById("slidecontent").innerHTML;
        document.getElementById("SlideshowsSlideTitle").value = title;
        document.getElementById("SlideshowsSlideContent").value = content;
        document.getElementById("SlideshowsSlideName").value = title;
        document.forms["derp"].submit();
        return true;
    }
    window.onload = function () {
        var title = document.getElementById("SlideshowsSlideTitle").value;
        var content = document.getElementById("SlideshowsSlideContent").value;
        if (title != "") document.getElementById("titlecontent").innerHTML = title;
        if (content != "") document.getElementById("slidecontent").innerHTML = content;
    }
</script>

<br />

<form id="derp" class="form-inline" method="post" action="<?= $this->Wb->eventUrl("/Slideshow/SaveSlide/text") ?>">
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <label><?= __('Duration') ?></label>
                <?= $this->Form->input('SlideshowsSlide.duration', array('value' => $duration, 'class' => 'form-control', 'min' => 0, 'label' => false)) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label><?=__("From")?></label>
                    <?= $this->Form->input('SlideshowsSlide.date_from', array('value' => $date_from, 'class' => 'form-control', 'dateFormat' => 'D M Y',  'timeFormat' => 24, 'label' => false, 'minYear' => date("Y"))) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label><?=__("To")?></label>
                    <?= $this->Form->input('SlideshowsSlide.date_to', array('value' => $date_to, 'class' => 'form-control', 'dateFormat' => 'D M Y', 'timeFormat'=> 24, 'label' => false, 'minYear' => date("Y"))) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->hidden('SlideshowsSlide.show_id', array('value' => $show_id)) ?>
        <?= $this->Form->hidden('SlideshowsSlide.id') ?>
        <?= $this->Form->hidden('SlideshowsSlide.name') ?>
        <?= $this->Form->hidden('SlideshowsSlide.title') ?>
        <?= $this->Form->hidden('SlideshowsSlide.content') ?>
        <?= $this->Form->hidden('SlideshowsSlide.type', array('value' => 'text')) ?>
        <?= $this->Form->hidden('SlideshowsSlide.bg_url', array('label' => 'Background URL')) ?>
    </fieldset>

</form>

<div id="editkontroller" class="actions">
    <button class="btn btn-success input" onclick="saveSlide();"><?=__("Save")?></button>
</div>
