<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
<head>
  <meta charset="utf-8"/>
  <meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
  <meta name="description" content="<?php echo $config['seo_description'];?>" />
  <meta name="HandheldFriendly" content="true"/>
  <meta name="MobileOptimized" content="320"/>
  <meta name="format-detection" content="telephone=no"/>
  <meta http-equiv="cleartype" content="on"/>
  <link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
  <title>首页</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="stylesheet" href="<?php echo TPL_URL;?>css/main.css"/>
  <link rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css"/>
  <script src="<?php echo $config['site_url'];?>/static/js/fastclick.js"></script>
  <script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
  <script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
  <script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
  <script>var noCart=true;</script>
  <script src="<?php echo TPL_URL;?>js/TouchSlide.1.1.js"></script>
  <script src="<?php echo TPL_URL;?>js/base.js"></script>
  <script src="<?php echo TPL_URL;?>index_style/js/index.js"></script>
</head>
<body>
    <div id="J_TmMobilePage" class="tm-mobile-page">
      <div id="J_TmMobileHeader" class="tm-mobile-header mui-flex">
        <div class="category-menu cell fixed">
          <a href="category.php" target="_self" id="J_CategoryTrigger" class="category-trigger">????</a>
        </div>
        <div id="J_MobileSearch" class="mobile-search cell">
          <form id="J_SearchForm" action="" method="post" onsubmit="return false;">
            <div class="s-combobox-input-wrap">
              <input placeholder="搜索商品" name="q" value="" class="search-input" type="search" accesskey="s" autocomplete="off">
            </div>
            <input type="submit" class="search-button">
          </form>
        </div>
        <div class="my-info cell fixed">
          <?php if(empty($wap_user)){?>
          <a href="login.php" target="_self"  class="my-info-trigger">登录</a>
          <?php }else{?>
          <a href="my.php" target="_self"  class="category-my">???</a>
          <?php }?>
        </div>
      </div>

      <div id="J_TMMobileContent" class="tm-mobile-content">
        <div id="focus" class="focus">
          <div class="hd">
            <ul></ul>
          </div>
          <div class="bd">
            <ul>
              <?php if($slide){ foreach($slide as $value){?>
                  <li><a href="<?php echo $value['link'];?>"><img src="<?php echo $value['pic'];?>" alt="<?php echo $value['name'];?>" /></a></li>
              <?php } } ?>
            </ul>
          </div>
        </div>
        <script type="text/javascript">
          TouchSlide({ 
            slideCell:"#focus",
            titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
            mainCell:".bd ul", 
            effect:"left", 
            autoPlay:true,//自动播放
            autoPage:true, //自动分页
            switchLoad:"_src" //切换加载，真实图片路径为"_src" 
          });
        </script>
        <p class="shortcut-operation mui-flex" data-spm="20000003">
          <?php if($slider_nav){ foreach($slider_nav as $key=>$value){?>
            <a class="shortcut-item cell " href="<?php echo $value['url'];?>">
              <img src="<?php echo $value['pic'];?>" alt="<?php echo $value['name'];?>">
              <?php echo $value['name'];?>
            </a>
          <?php } } ?>
        </p> 
        <div class="blank"></div>
        <?php if(!empty($brand) && !empty($hot_brand_slide)){ ?>
        <div id="J_HotBrand" class="hot-brand">
          <h2 class="modules-title">
            推荐店铺
          </h2>
          <div class="modules-content">
            <?php if($brand){ ?>
            <div class="brand-slider">
              <div id="J_BrandList" class="slider-scroller">
                <ul class="slider-item mui-flex align-center justify-center">
                  <?php foreach($brand as $key=>$value){ ?>
                    <li class="brand-item cell">
                      <a href="<?php echo $value['url'];?>">
                        <img width="80" height="80" src="<?php echo $value['logo'];?>"
                        alt="<?php echo $value['name'];?>" />
                      </a>
                    </li>
                    <?php if(($key+1)%4 == 0){echo '</ul><ul class="slider-item mui-flex align-center justify-center">';}?>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php }?>
            <div class="brand-chn mui-flex">
              <?php if($hot_brand_slide){ foreach($hot_brand_slide as $key=>$value){?>
                <p class="chn-block cell tm-mobile-loading">
                  <a href="<?php echo $value['url'];?>">
                    <img src="<?php echo $value['pic'];?>"
                    alt="<?php echo $value['name'];?>" width="100%" />
                  </a>
                </p>
              <?php } } ?>
              </p>
            </div>
          </div>
        </div>
        <?php } ?>
        <div class="market-floor" id="J_MarketFloor">
          <h3 class="modules-title">
            热门分类
          </h3>
          <div class="modules-content market-list">
            <ul class="mui-flex">
              <?php if($cat){ foreach($cat as $key=>$value){?>
                <li class="region-block cell">
                  <a href="./category.php?keyword=<?php echo $value['cat_name'];?>&id=<?php echo $value['cat_id'];?>">
                    <em class="main-title">
                      <?php echo $value['cat_name'];?>
                    </em>
                    <span class="sub-title">
                      <?php echo $value['desc'];?>
                    </span>
                    <img class="market-pic" src="<?php echo $value['cat_pic'];?>"
                    width="50" height="50" />
                  </a>
                </li>
                <?php if(($key+1)%2 == 0){echo '</ul><ul class="mui-flex">';}?>
              <?php } } ?>
            </ul>
<!-- 
            <ul class="mui-flex">
              <li class="region-block cell">
                <a href="http://nvzhuang.tmall.com/?acm=tt-1282499-40537.1003.8.260405&amp;aldid=AiABWhyD&amp;scm=1003.8.tt-1282499-40537.OTHER_1429541142968_260405&amp;pos=1">
                  <em class="main-title">
                    女装
                  </em>
                  <span class="sub-title">
                    一周搭配
                  </span>
                  <img class="market-pic" src="http://img04.taobaocdn.com/imgextra/i4/1063206862/TB1nvonGVXXXXcFaXXXNx3t4VXX-120-120.jpg_q60.jpg"
                  width="50" height="50" />
                </a>
              </li>
              <li class="region-block cell">
                <a href="http://3c.m.tmall.com/?acm=tt-1282499-40537.1003.8.260405&amp;aldid=AiABWhyD&amp;scm=1003.8.tt-1282499-40537.OTHER_1429134560159_260405&amp;pos=2">
                  <em class="main-title">
                    电器城
                  </em>
                  <span class="sub-title">
                    抢稀缺手机
                  </span>
                  <img class="market-pic" src="http://img04.taobaocdn.com/imgextra/i4/1063206862/TB1IlAYGVXXXXaUXXXX_LUHNVXX-367-430.jpg_q60.jpg"
                  width="50" height="50" />
                </a>
              </li>
            </ul> -->
          </div>
        </div>
         <?php if($goods){ ?>
        <div id="J_MoreWonderful" class="more-wonderful" data-spm="20000008">
          <h3 class="modules-title">
            精品推荐
          </h3>
          <div class="modules-content item-list">
            <ul class="mui-flex">
              <?php foreach($goods as $key=>$value){ ?>
                <li class="rec-item cell">
                  <a href="./good.php?id=<?php echo $value['product_id'];?>">
                    <img src="<?php echo $value['image'];?>"
                    width="100%" alt="" />
                    <em class="item-name" title="<?php echo $value['name'];?>">
                      <?php echo $value['name'];?>
                    </em>
                    <span class="item-price">
                      <span class="yen">
                        &yen;
                      </span>
                      <?php echo $value['price'];?>
                    </span>
                  </a>
                </li>
                <?php if(($key+1)%2 == 0){echo '</ul><ul class="mui-flex">';}?>
              <?php } ?>
            </ul>
          </div>
        </div>
        <?php } ?>
        <div class="clearfix" style="height:50px;"></div>
      </div>
    </div>

    <?php include display('public_search');?>
    <?php include display('public_menu');?>
    <?php echo $shareData;?>
  </body>
</html>