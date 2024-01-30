<?php
$styles = popup_salebanner::style();
$active = Option::get('popup_salebanner_active');
?>
<div class="popup_salebanner-box">
    <div class="row">
        <div class="col-md-8">
            <div class="popup_salebanner__select_box">
                <label for="">Chọn mẫu</label>
                <hr style="margin: 5px 0;">
                <div class="clearfix"> </div>
                <?php foreach ($styles as $item_key => $item): ?>
                    <label class="popup_salebanner__select <?php echo ($active == $item_key) ? 'active' : '';?>" data-tab="#tab-<?php echo $item_key;?>">
                        <?php $item_key::admin_demo();?>
                        <input type="radio" value="<?php echo $item_key;?>" name="popup_style" <?php echo ($active == $item_key) ? 'checked' : '';?>>
                    </label>
                <?php endforeach ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="popup_salebanner__select_box">
                <label for="">Cấu hình</label>
                <hr style="margin: 5px 0;">
                <div class="clearfix"> </div>
                <?php foreach ($styles as $item_key => $item): ?>
                    <div class="tabs-option <?php echo ($active == $item_key) ? 'active' : '';?>" id="tab-<?php echo $item_key;?>">
                        <div class="row"><?php $item_key::admin_config();?></div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<style>
    .popup_salebanner__select_box { background-color: #fff; padding:10px; overflow:hidden;}
    .popup_salebanner__select {
        position: relative; overflow: hidden; height: auto; width:32%;
        border:2px solid #E3E7FB; border-radius: 5px;
    }
    .popup_salebanner__select img {
        width: 100%;
    }
    .popup_salebanner__select.active {
        border:2px solid #263A53;
    }
    .tabs-option { display: none; }
    .tabs-option.active { display: block; }
</style>
<script type="text/javascript">
    $(function() {
        let id = $('.popup_salebanner__select.active').attr('data-tab');
        $('.popup_salebanner__select').click( function () {
            id = $(this).attr('data-tab');
            $('.popup_salebanner__select.active').removeClass('active');
            $(this).addClass('active');
            $('.tabs-option.active').removeClass('active');
            $(id).addClass('active');
        });
    });
</script>
