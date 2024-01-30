<?php if(!empty($config['title'])) {?><h4 class="popup-alert-header-title"><?php echo $config['title'];?></h4><?php } ?>
<?php echo $config['description'];?>
<style>
    .popup-alert .modal-content {
        border-radius: 0; border:0;
        background: <?php echo $config['backgroup_color'];?> url('<?php echo get_img_link($config['backgroup_image']);?>');
        background-size: cover;
        padding:30px;
    }
    .popup-alert .modal-content .popup-alert-header-title {
        color: <?php echo $config['title_color'];?>;
        font-weight: bold;
    }
</style>
