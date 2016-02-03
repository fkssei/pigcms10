<div id="miniLogin" class="miniLogin" style="position: fixed; z-index: 200000; width: 400px; left: 591.5px; top: 179.5px; display: none;">
    <table class="box-shadow-sec">
    <tbody>
    <tr class="bs-header">
        <td class="bs-left">
        </td>
        <td class="bs-middle" style="text-align: center;">
            <div class="bs-middle-title">
                微店欢迎你
            </div>
        </td>
        <td class="bs-right">
            <div id="miniLogin-close" class="miniLogin-close">
                &nbsp;
            </div>
        </td>
    </tr>
    <tr class="bs-body">
        <td class="bs-left">
        </td>
        <td class="bs-main">
            <div class="v-login-form">
                <div id="loginPane" class="kd-login">
                    <div class="kd-login-wrapper">
                        <form id="login" action="<?php echo url('account:ajax_login') ?>" method="post">
                            <div class="kd-login-title">
                                <a href="<?php echo url('account:register');?>" class="v-login-register">注册&gt;&gt;</a>
                                <h6>登录</h6>
                            </div>
                            <div class="J_textboxPrompt input-phone">
                                <input cssErrorClass="error" id="phone" size="25" maxlength="11" tabindex="1" path="username" name="phone" autocomplete="off" htmlEscape="true" placeholder="手机号码"/>
                                <span class="icon"></span>
                            </div>
                            <div class="J_textboxPrompt input-pwd">
                                <input id="password" name="password" class="required" tabindex="2" accesskey="p" type="password" value="" size="25" autocomplete="off" placeholder="密码"/>
                                <span class="icon"></span>
                            </div>
                            <!-- <div class="auto-login">
                                 <span class="v-login-forget-pwd"><a data-piwik-spm='{"n":"&#x5FD8;&#x8BB0;&#x5BC6;&#x7801;"}' href="#" target="_blank">忘记密码了?</a></span>
                            </div> -->
                            <section class="row btn-row" style="height: 89px; position: relative;">
                                <input type="hidden" name="_eventId" value="submit" />
                                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>" />
                                <input id="J_Login" class="kd-form-btn orangeBtn large" name="submit" accesskey="l" value="登    录" tabindex="4" type="submit" style="position: absolute; top: 30px;"/>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </td>
        <td class="bs-right">
        </td>
    </tr>
    <tr class="bs-footer">
        <td class="bs-left">
        </td>
        <td class="bs-middle">
        </td>
        <td class="bs-right">
        </td>
    </tr>
    </tbody>
    </table>
</div>
<div id="miniLogin-overlay" class="miniLogin-overlay" style="display:none;border: 1px solid rgb(255, 255, 255); position: fixed; left: 0px; top: 0px; width: 1583px; height: 4734px; z-index: 10000; opacity: 0.5; background: rgb(0, 0, 0);">
</div>
<script>
    $(function(){
        $('.miniLogin-close,#miniLogin-overlay').click(function(){
            $('#miniLogin').hide();
            $('#miniLogin-overlay').hide();
        });
    });
</script>