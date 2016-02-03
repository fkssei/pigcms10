<div class="js-notifications notifications"></div>
<div style="position:absolute;top:0;height:5px;background:rgb(255,252,4);width:0%;z-index:100;"></div>
<?php $show_footer_link = isset($show_footer_link) ? $show_footer_link : true; ?>
<footer class="ui-footer">
    <?php if ($show_footer_link) { ?>
        <a href="<?php echo $config['site_url']; ?>" target="_blank">
            <i>©</i> <?php echo getUrlTopDomain($config['site_url']); ?>
        </a>
    <?php } else { ?>
        <i>©</i> <?php echo getUrlTopDomain($config['site_url']); ?>
    <?php } ?>
</footer>