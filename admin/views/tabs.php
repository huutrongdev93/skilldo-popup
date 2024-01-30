<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-content" style="padding:20px 10px;">
                <div class="float-start">
                    <?php foreach ($tabs as $key => $tab): ?>
                    <a href="<?php echo Url::admin('system/popup?view='.$key);?>" class="btn <?php echo ($key == $view) ? 'btn-blue' : 'btn-white';?> btn-icon">
                        <?php echo (isset($tab['icon'])) ? $tab['icon'] : '<i class="fal fa-layer-plus"></i>';?>
                        <?php echo $tab['label'];?>
                    </a>
                    <?php endforeach ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="key" id="popup_module" class="form-control" value="<?php echo $view;?>" required>