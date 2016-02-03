<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="renderer" content="webkit">
    <title id="js-meta-title">协议 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <link rel="icon" href="./favicon.ico" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
</head>
<body>
<div id="hd" class="wrap rel">
    <div class="wrap_1000 clearfix">
        <h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
            <a href="<?php dourl('store:select');?>">
				<img src="<?php echo $config['site_logo'];?>" width="86" height="35" alt="<?php echo $config['site_name'];?>"/>
			</a>
        </h1>
        <h2 class="tc hd_title"><?php echo $readme_title; ?></h2>
    </div>
</div>
<div class="container wrap_800" style="margin-top:60px;">
    <div class="content">
        <div class="app">
            <div class="app-init-container">
                <div class="team">
                <div class="wrapper-app">
                    <div id="content" class="team-readme"><div><br>
                            <pre>
                                <?php echo $readme_content; ?>
                            </pre>
                            <div style="text-align:center;margin: 30px 0 20px;">
                                <button class="btn btn-primary btn-large js-close-readme" onClick="window.close();">阅读完毕，关闭当前页面</button>
                            </div>
                        </div></div>
                    <div id="content-addition"></div>
                </div>
                    <?php $show_footer_link = false; include display('public:footer');?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>