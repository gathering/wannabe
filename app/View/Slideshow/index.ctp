<div class="row">
    <div class="col-md-6">
        <form id="Aclobject" method="post">
            <div class="clearfix">
                <h4><?= __('Add new slideshow') ?></h4>
                <label for="normalSelect"><?= __('Name') ?></label>
                <div class="row">
                  <div class="col-md-10">
                    <input class="form-control" name="data[Slideshow][name]" type="text" id="newmemberId" style="width: 100%;" required>
                  </div>
                  <div class="col-md-2">
                    <?= $this->Form->submit($savebutton, array('class' => 'btn btn-success', 'name' => 'save')) ?>
                  </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-6">
        <h4><?= __('Slideshows') ?></h4>

        <table class="table table-striped">
            <thead>
            <th><?= __('ID') ?></th>
            <th><?= __('Name') ?></th>
            <th><?= __('Action') ?></th>
            </thead>
            <tbody>
            <?php foreach ($slideshows as $slideshow) { ?>
                <tr>
                    <td><?= $slideshow['Slideshow']['id'] ?></td>
                    <td>
                        <a href="<?= $this->Wb->eventUrl("/Slideshow/Edit/") . $slideshow['Slideshow']['id'] ?>"><?= $slideshow['Slideshow']['name'] ?></a>
                    </td>
                    <td>
                        <a href="<?= $this->Wb->eventUrl("/Slideshow/DeleteShow/") . $slideshow['Slideshow']['id'] ?>"><?= __('Delete') ?></a>
                    </td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
</div>
