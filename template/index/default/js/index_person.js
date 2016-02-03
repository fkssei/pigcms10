// JavaScript Document
//滚动图片插件
$(function() {
    var component_slider_timer = null;
    function component_slider_play() {
        component_slider_timer = window.setInterval(function() {
            var slider_index = $('.component-index-slider .mt-slider-trigger-container li.mt-slider-current-trigger').index();
            if (slider_index == $('.component-index-slider .mt-slider-trigger-container li').size() - 1) {
                slider_index = 0;
            } else {
                slider_index++;
            }
            $('.component-index-slider .content li').eq(slider_index).css({
                'opacity': '0',
                'display': 'block'
            }).animate({
                opacity: 1
            }, 600).siblings().hide();
            $('.component-index-slider .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
			
			            var slider_index = $('.component-index-slider .mt-slider-trigger-container li.mt-slider-current-trigger').index();
            if (slider_index == $('.component-index-slider .mt-slider-trigger-container li').size() - 1) {
                slider_index = 0;
            } else {
                slider_index++;
            }
            $('.component-index-slider .content li').eq(slider_index).css({
                'opacity': '0',
                'display': 'block'
            }).animate({
                opacity: 1
            }, 600).siblings().hide();
            $('.component-index-slider .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');

        }, 3400);
    }
    component_slider_play();
    $('.component-index-slider').hover(function() {
        window.clearInterval(component_slider_timer);
        $('.banner_content_main .component-index-slider .mt-slider-previous,.banner_content_main  .component-index-slider .mt-slider-next').css({
            'opacity': '0.4'
        }).show();
    }, function() {
        window.clearInterval(component_slider_timer);
        component_slider_play();
        $('.banner_content_main .component-index-slider .mt-slider-previous,.banner_content_main  .component-index-slider .mt-slider-next').css({
            'opacity': '0'
        }).hide();
    });
    $('.banner_content_main .component-index-slider .mt-slider-previous,.banner_content_main .component-index-slider .mt-slider-next').hover(function() {
        $(this).css({
            'opacity': '0.7'
        });
    });
    $('.component-index-slider .mt-slider-trigger-container li').click(function() {
        if ($(this).hasClass('mt-slider-current-trigger')) {
            return false;
        }
        var slider_index = $(this).index();
        $('.component-index-slider .content li').eq(slider_index).show().siblings().hide();
        $(this).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
    });
    $('.component-index-slider .mt-slider-previous').click(function() {
        var slider_index = $('.component-index-slider .mt-slider-trigger-container li.mt-slider-current-trigger').index() - 1;
        if (slider_index < 0) {
            slider_index = $('.component-index-slider .mt-slider-trigger-container li').size() - 1;
        }
        $('.component-index-slider .content li').eq(slider_index).show().siblings().hide();
        $('.component-index-slider .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
    });
    $('.component-index-slider .mt-slider-next').click(function() {
        var slider_index = $('.component-index-slider .mt-slider-trigger-container li.mt-slider-current-trigger').index() + 1;
        if (slider_index == $('.component-index-slider .mt-slider-trigger-container li').size()) {
            slider_index = 0;
        }
        $('.component-index-slider .content li').eq(slider_index).show().siblings().hide();
        $('.component-index-slider .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
    });
});

$(function() {
    $(".tankuang_button").click(function() {
        $(".chenpage").addClass("tankuang_button_xianshi");
        $("body").removeClass("cheng_xianshi")
    });
});

$(function() {
    $(".content_commodity_title_content li").click(function() {
        $(this).addClass("content_curn").siblings().removeClass("content_curn")
    });
});
$(function() {
    $(".cata_table_li").click(function() {
        $(this).addClass("cata_curnt").siblings().removeClass("cata_curnt")
    });
});

$(function() {
    $(".page_list dd").click(function() {
        $(this).addClass("page_curn").siblings().removeClass("page_curn")
    });
});
$(function() {
    $("ul.biaoqian li").click(function() {
        $(this).toggleClass("biaoqian_curn");

    });
});

//侧栏滚动
function goTop() {
    //window.location.href = "#nav1";
    $("html,body").animate({
        scrollTop: $("#nav1").offset().top
    }, 500);
}

function scrollToId(targetId) {
    $("html,body").animate({
        scrollTop: $(targetId).offset().top - 0
    }, 500);
}
//弹窗
function popup(mudi) {
    //var thistop=$(this).offset().top;//获取当前位置的top
    //var maskHeight = $(document).height();//文档的总高度
    var maskWidth = $(window).width(); //窗口的宽度       
    var maskHeight = $(window).height(); //窗口高度      
    var popTop = (maskHeight / 2) - ($('#pop_box').height() / 2);
    var popLeft = (maskWidth / 2) - ($('#pop_box').width() / 2);
    $('#pop_box').css({
        top: popTop,
        left: popLeft
    }).slideDown(400);
    $("#mudi").val(mudi);
}

//弹窗
function popup2() {

    var maskWidth = $(window).width();
    var maskHeight = $(window).height();
    var popTop = (maskHeight / 2) - ($('#pop_box2').height() / 2);
    var popLeft = (maskWidth / 2) - ($('#pop_box2').width() / 2);
    $('#pop_box2').css({
        top: popTop,
        left: popLeft
    }).slideDown(400);
}
$(document).ready(function() {
    if ($('.gd_box').size() > 0) {
        var navH = $(".gd_box").offset().top - 0;
        $(window).scroll(function() {
            var scroH = $(this).scrollTop();
            if (scroH >= navH) {
                $(".gd_box").css({
                    "position": "fixed",
                    "top": "19%"
                });
                $(".content_rihgt").css({
                    "position": "fixed",
                    "top": "40%"
                });

            } else if (scroH < navH) {
                $(".gd_box").css({
                    "position": "absolute",
                    "top": "0"
                });
                $(".content_rihgt").css({
                    "position": "absolute",
                    "top": "100%"
                });
            }
        })
    }
})
$(function() {
    $('#nav').onePageNav();
});

//评价切换
$(function() {
    $(".zzsc .tab a").mouseover(function() {
        $(this).addClass('on').siblings().removeClass('on');
        var index = $(this).index();
        number = index;
        $('.zzsc .content_tab li').hide();
        $('.zzsc .content_tab li:eq(' + index + ')').show();
    });

    var auto = 1; //等于1则自动切换，其他任意数字则不自动切换
    if (auto == 1) {
        var number = 0;
        var maxNumber = $('.zzsc .tab a').length;

        function autotab() {
            number++;
            number == maxNumber ? number = 0 : number;
            $('.zzsc .tab a:eq(' + number + ')').addClass('on').siblings().removeClass('on');
            $('.zzsc .content_tab ul li:eq(' + number + ')').show().siblings().hide();
        }
        var tabChange = setInterval(autotab, 3000000);
        //鼠标悬停暂停切换
        $('.zzsc').mouseover(function() {
            clearInterval(tabChange);
        });
        $('.zzsc').mouseout(function() {
            tabChange = setInterval(autotab, 3000000);
        });
    }
});


$(function() {
    /*
     *该效果遇到的一个难点在ie6下的布局,由于图片大小全自适应,div.show-btn没办法获取到高度
     *所以大的左右点击按钮就没办法通过css来实现上下居中了
     *解决办法是：_height:expression;//ie所特有css属性.
     *当然如果利用js来控制也就不存在这个问题。主要是考虑到js通常是等页面加载完才执行，
     *所以第用户一眼可能看到的位置是没有居中的，所以想通过css来实现.
     *仅供学习.
     */
    var oSlider = $('#slider'),
        oShowBox = oSlider.find('.show-box'),
        oShowPrev = oSlider.find('.show-prev'),
        oShowNext = oSlider.find('.show-next'),
        oMinPrev = oSlider.find('.min-prev'),
        oMinNext = oSlider.find('.min-next'),
        oMinBoxList = oSlider.find('.min-box-list'),
        aShowBoxLi = oShowBox.find('li'),
        aMinBoxLi = oMinBoxList.find('li'),
        iMinLiWidth = aMinBoxLi.first().outerWidth(),
        iNum = aMinBoxLi.length,
        iNow = 0; //这里初始值为4的原因是 当前显示的图片下标为4

    //根据小图片的多少来计算出父容器的宽度,让其显示成一行
    iMinLiWidth = iMinLiWidth + 5;
    oMinBoxList.css('width', iNum * iMinLiWidth + 'px');

    //由于ie6 不支持max-width 所以设置图片的最大显示宽度 注意ie6下的css图片设置的宽度为100%,所以这里设置li即可
    var isIE6 = !-[1, ] && !window.XMLHttpRequest;
    if (isIE6) {
        for (var i = 0; i < iNum; i++) {
            var o = aShowBoxLi.eq(i)
            o.css({
                width: o.outerWidth() > 643 ? 643 : o.outerWidth(),
                float: 'none',
                margin: '0 auto'
            })
        }
    }

    oShowPrev.hover(function() {
        //采用链式操作减少dom操作.
        $(this).css({
            backgroundColor: '#F5F5F5'
        }).find('span')
    }, function() {
        $(this).css({
            backgroundColor: '#fff'
        }).find('span')
    })
    oShowNext.hover(function() {
        $(this).css({
            backgroundColor: '#F5F5F5'
        }).find('span')
    }, function() {
        $(this).css({
            backgroundColor: '#fff'
        }).find('span').css({
            backgroundPosition: '-70px 0px'
        })
    })

    //键盘左右方向箭控制图片显示  (这里采用原生js)
    document.onkeyup = function(ev) {
        var o = window.event || ev; //获取事件对象
        if (o.keyCode == 37) {
            changePrev()
        } else if (o.keyCode == 39) {
            changeNext()
        }
    }

    //小图片列表添加点击事件
    aMinBoxLi.click(function() {
        var index = $(this).index();
        iNow = index;
        setLayout(); //回调样式及动画函数
    })

    //左右按钮添加点击  回调
    oMinPrev.click(changePrev);
    oMinNext.click(changeNext);
    oShowPrev.click(changePrev);
    oShowNext.click(changeNext);

    function changePrev() { //iNow相当于下标索引，固下标索引不能小于0
        if (iNow <= 0) {
            return;
        }
        iNow--;
        setLayout()
    }

    function changeNext() {
        if (iNow >= iNum - 1) {
            return;
        }
        iNow++;
        setLayout();
    }

    //设置显示样式及动画
    function setLayout() {
        var oCurLi = aShowBoxLi.eq(iNow);
        aShowBoxLi.hide().eq(iNow).fadeIn('slow');
        aMinBoxLi.removeClass('cur').eq(iNow).addClass('cur');

        //限制图片运动距离，以免出现空白.
        if (iNow >= 4 && iNow < iNum - 4) {
            oMinBoxList.animate({
                left: -iMinLiWidth * (iNow - 4)
            }, 100)
        }
    }

})



//切换选项卡
function setTab(name, cursel) {
    cursel_0 = cursel;
    for (var i = 1; i <= links_len; i++) {
        var menu = document.getElementById(name + i);
        var menudiv = document.getElementById("con_" + name + "_" + i);
        if (i == cursel) {
            menu.className = "off";
            menudiv.style.display = "block";
        } else {
            menu.className = "";
            menudiv.style.display = "none";
        }
    }
}

function Next() {
    cursel_0++;
    if (cursel_0 > links_len) cursel_0 = 1
    setTab(name_0, cursel_0);
}
var name_0 = 'one';
var cursel_0 = 1;
var ScrollTime = 300000; //循环周期（毫秒）
var links_len, iIntervalId;
onload = function() {
    if ($('#tab1').size() > 0) {
        var links = document.getElementById("tab1").getElementsByTagName('li')
        links_len = links.length;
        for (var i = 0; i < links_len; i++) {
            links[i].onmouseover = function() {
                clearInterval(iIntervalId);
                this.onmouseout = function() {
                    iIntervalId = setInterval(Next, ScrollTime);;
                }
            }
        }

        /*document.getElementById("con_" + name_0 + "_" + links_len).parentNode.onmouseover = function() {
            clearInterval(iIntervalId);
            this.onmouseout = function() {
                iIntervalId = setInterval(Next, ScrollTime);;
            }
        }
        setTab(name_0, cursel_0);
        iIntervalId = setInterval(Next, ScrollTime);*/
    }
}