<!--顶部 bar start-->

<!--顶部 bar end-->
<style>
.headerbar {
    background-color: #efefef;
    border-bottom: 1px solid #c1c1c1;
}

.headerbar .headerbar-wrap {
    position: relative;
    width: 1200px;
    margin: 0 auto;
    text-align: center;
}
.headerbar .headerbar-preview {
    padding: 6px;
}
.headerbar ul, .headerbar li {
    display: inline-block;
    margin: 0;
    padding: 0;
    list-style: none;
}

.headerbar .headerbar-reedit {
    position: absolute;
    top: 0;
    right: 250px;
    padding: 5px 11px 5px 0;
}
.headerbar .headerbar-reedit a {
    background: #fff;
    color: #414141;
    border: 1px solid #ccc;
    padding: 0 20px;
}
.headerbar .headerbar-reedit a:hover{
    background: #e6e6e6;
}
.headerbar a {
    display: block;
    line-height: 28px;
    text-align: center;
    padding: 0 12px;
    border-radius: 2px;
}

.headerbar a.active {
    color: #fff;
    background: #798499;
}

</style>

<?php if(!$is_mobile && $_SESSION['user']){ ?>

<?php
    if(MODULE_NAME  == 'store'){
        $url    = "/wap/home.php?id={$store['store_id']}";
        $editUrl    = url('user:store:wei_page',array(),true).'#edit/'.$homePage['page_id'];
    }else{
        $url    = "/wap/good.php?id={$product['product_id']}";
        $editUrl    = url('user:goods:edit',array('id' => $product['product_id']), true);
    }
?>
<div class="headerbar">
    <div class="headerbar-wrap clearfix">
        <div class="headerbar-preview">
            <span>预览：</span>
            <ul>
                <li>
                   <a href="<?php echo $url;?>&ps=320" class="js-no-follow">iPhone版</a>
                </li>
                <li>
                   <a href="<?php echo $url;?>&ps=540" class="js-no-follow">三星Note3版</a>
                </li>
                <li>
                   <a href="<?php echo url('goods:index', array('id' => $product['product_id'], 'is_preview' => 1)) ?>" class="js-no-follow active">PC版</a>
                </li>
            </ul>
        </div>
        <div class="headerbar-reedit">
            <a href="<?php echo  $editUrl;?>" target="_blank" class="js-no-follow">重新编辑</a>
        </div>
    </div>
</div>
<?php } ?>

<!--head-->