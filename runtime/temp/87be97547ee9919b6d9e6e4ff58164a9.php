<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:98:"/usr/local/var/www/dsmall/public/../application/home/view/default/member/memberevaluate/index.html";i:1574757822;s:77:"/usr/local/var/www/dsmall/application/home/view/default/base/base_member.html";i:1574757822;s:74:"/usr/local/var/www/dsmall/application/home/view/default/base/mall_top.html";i:1574757822;s:79:"/usr/local/var/www/dsmall/application/home/view/default/base/member_header.html";i:1574757822;s:77:"/usr/local/var/www/dsmall/application/home/view/default/base/member_left.html";i:1574757822;s:78:"/usr/local/var/www/dsmall/application/home/view/default/base/member_items.html";i:1574757822;s:77:"/usr/local/var/www/dsmall/application/home/view/default/base/mall_server.html";i:1574757822;s:77:"/usr/local/var/www/dsmall/application/home/view/default/base/mall_footer.html";i:1574757822;}*/ ?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo (isset($html_title) && ($html_title !== '')?$html_title:\think\Config::get('site_name')); ?></title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand" />
        <meta name="keywords" content="<?php echo (isset($seo_keywords) && ($seo_keywords !== '')?$seo_keywords:''); ?>" />
        <meta name="description" content="<?php echo (isset($seo_description) && ($seo_description !== '')?$seo_description:''); ?>" />
        <link rel="stylesheet" href="<?php echo HOME_SITE_ROOT; ?>/css/common.css">
        <link rel="stylesheet" href="<?php echo HOME_SITE_ROOT; ?>/css/home_header.css">
        <script>
            var BASESITEROOT = "<?php echo BASE_SITE_ROOT; ?>";
            var HOMESITEROOT = "<?php echo HOME_SITE_ROOT; ?>";
            var BASESITEURL = "<?php echo BASE_SITE_URL; ?>";
            var HOMESITEURL = "<?php echo HOME_SITE_URL; ?>";
            var TIMESTAMP = "<?php echo TIMESTAMP; ?>";
        </script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/jquery-2.1.4.min.js"></script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/common.js"></script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/js/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/js/jquery-ui/jquery.ui.datepicker-zh-CN.js"></script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/jquery.validate.min.js"></script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/additional-methods.min.js"></script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/layer/layer.js"></script>
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
    </head>
    <body>
        <div id="append_parent"></div>
        <div id="ajaxwaitid"></div>
        <?php if(\think\Request::instance()->action() == 'index' && \think\Request::instance()->controller() == 'Index'): $ap_id =21;$ad_position = db("advposition")->cache(3600)->column("ap_id,ap_name,ap_width,ap_height","ap_id");$result = db("adv")->where("ap_id=$ap_id  and adv_enabled = 1 and adv_startdate < 1586833200 and adv_enddate > 1586833200 ")->order("adv_sort desc")->cache(3600)->limit("1")->select();
if(!in_array($ap_id,array_keys($ad_position)) && $ap_id)
{
  db("advposition")->insert(array(
         "ap_id"=>$ap_id,
         "ap_name"=>request()->module()."/".request()->controller()."/".request()->action()."页面自动增加广告位 $ap_id ",
  ));
  $ad_position[$ap_id]=array();
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && input("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "adv_id" => 0,
          "adv_code" => "/public/images/not_adv.jpg",
          "adv_link" => ADMIN_SITE_URL."/Adv/adv_add/ap_id/$ap_id.html",
          "adv_title"   =>"暂无广告图片",
          "not_adv" => 1,
          "adv_target" => "_self",
          "ap_id"   =>$ap_id,
      );  
    }
}

foreach($result as $key=>$v):       

    $v["position"] = $ad_position[$v["ap_id"]]; 
    $v["adv_link"] = HOME_SITE_URL."/Advclick/Advclick/adv_id/".$v["adv_id"].".html";
    $v["adv_target"] = "_blank"; 
    if(input("get.edit_ad") && !isset($v["not_adv"]) )
    {
        
        $v["style"] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v["adv_link"] = ADMIN_SITE_URL."/Adv/adv_edit/adv_id/".$v['adv_id'].".html";
        $v["adv_title"] = $ad_position[$v["ap_id"]]["ap_name"]."===".$v["adv_title"];
        $v["adv_target"] = "_self";
        $v["adv_style"] = "filter:alpha(opacity=30); -moz-opacity:0.3; -khtml-opacity: 0.3; opacity: 0.3";
    }
    ?>
        <div style="background:<?php echo (isset($v['adv_bgcolor']) && ($v['adv_bgcolor'] !== '')?$v['adv_bgcolor']:''); ?>;">
            <div class="w1200">
                <a href="<?php echo $v['adv_link']; ?>" target="<?php echo $v['adv_target']; ?>" title="<?php echo $v['adv_title']; ?>"><img src="<?php echo UPLOAD_SITE_URL; ?>/<?php echo ATTACH_ADV; ?>/<?php echo $v['adv_code']; ?>" width="1200"/></a>
            </div>
        </div>
        <?php endforeach; endif; ?>
        <div class="public-top">
            <div class="w1200">
                <span class="top-link">
                    <?php echo \think\Lang::get('welcome_to'); ?> <em><?php echo \think\Config::get('site_name'); ?></em>
                </span>
                <ul class="login-regin">
                    <?php if(\think\Session::get('member_id')): ?>
                    <li class="line"> <a href="<?php echo url('Member/index'); ?>"><?php echo \think\Session::get('member_name'); ?></a></li>
                    <li> <a href="<?php echo url('Login/Logout'); ?>"><?php echo \think\Lang::get('exit'); ?></a></li>
                    <?php else: ?>
                    <li class="line"> <a href="<?php echo url('Login/login'); ?>"><?php echo \think\Lang::get('please_log'); ?></a></li>
                    <li> <a href="<?php echo url('Login/register'); ?>"><?php echo \think\Lang::get('free_registration'); ?></a></li>
                    <?php endif; ?>
                </ul>
                <span class="top-link">
                    <strong style="margin-left:30px;"><?php echo \think\Lang::get('ds_attention'); ?><a href="http://www.csdeshang.com" target="_blank">www.csdeshang.com</a> <?php echo \think\Lang::get('ds_continuous_update'); ?></strong>&nbsp;
                    <?php echo \think\Lang::get('ds_purchase_authorization'); ?>：<a target="_blank" href="<?php echo HTTP_TYPE; ?>wpa.qq.com/msgrd?v=3&uin=858761000&site=qq&menu=yes"><img border="0" src="<?php echo HTTP_TYPE; ?>wpa.qq.com/pa?p=2:858761000:51" alt="<?php echo \think\Lang::get('click_here_send_message'); ?>" title="<?php echo \think\Lang::get('click_here_send_message'); ?>"/></a>
                </span>
                <ul class="quick_list">
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="<?php echo url('Member/index'); ?>"><?php echo \think\Lang::get('ds_user_center'); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <li><a href="<?php echo url('Memberorder/index'); ?>"><?php echo \think\Lang::get('ds_buying_goods'); ?></a></li>
                                <li><a href="<?php echo url('Memberfavorites/fglist'); ?>"><?php echo \think\Lang::get('ds_care_about'); ?></a></li>
                                <li><a href="<?php echo url('Memberfavorites/fslist'); ?>"><?php echo \think\Lang::get('ds_the_shop'); ?></a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="<?php echo url('Seller/index'); ?>"><?php echo \think\Lang::get('business_center'); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <?php if(\think\Session::get('seller_id')): ?>
                                <li><a href="<?php echo url('Seller/index'); ?>"><?php echo \think\Lang::get('ds_shop_overview'); ?></a></li>
                                <li><a href="<?php echo url('Sellerorder/index'); ?>"><?php echo \think\Lang::get('ds_member_path_store_order'); ?></a></li>
                                <li><a href="<?php echo url('Sellergoodsonline/index'); ?>"><?php echo \think\Lang::get('promotion_goods_manage'); ?></a></li>
                                <?php else: ?>
                                <li><a href="<?php echo url('Showjoinin/index'); ?>"><?php echo \think\Lang::get('tenants'); ?></a></li>
                                <li><a href="<?php echo url('Sellerlogin/login'); ?>"><?php echo \think\Lang::get('merchant_login'); ?></a></li>
                                <?php endif; ?>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="<?php echo url('Memberfavorites/fglist'); ?>"><?php echo \think\Lang::get('ds_favorites'); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <li><a href="<?php echo url('Memberfavorites/fglist'); ?>"><?php echo \think\Lang::get('ds_merchandise_collection'); ?></a></li>
                                <li><a href="<?php echo url('Memberfavorites/fslist'); ?>"><?php echo \think\Lang::get('ds_store_collect'); ?></a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="javascript:void(0)"><?php echo \think\Lang::get('ds_customer_center'); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <li><a href="<?php echo url('Article/index',['ac_id'=>2]); ?>"><?php echo \think\Lang::get('ds_help_center'); ?></a></li>
                                <li><a href="<?php echo url('Article/index',['ac_id'=>5]); ?>"><?php echo \think\Lang::get('ds_after_sales_service'); ?></a></li>
                                <li><a href="<?php echo url('Article/index',['ac_id'=>6]); ?>"><?php echo \think\Lang::get('ds_complaint_center'); ?></a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="javascript:void(0)"><?php echo \think\Lang::get('ds_fast_nav'); ?><b></b></a>
                        <div class="dropdown-menu">
                            <ol>
                                <?php foreach($navs['header'] as $nav): ?>
                                <li>
                                    <a href="<?php echo $nav['nav_url']; ?>" <?php if($nav['nav_new_open'] == 1): ?>target="_blank"<?php endif; ?>><?php echo $nav['nav_title']; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </li>
                    <li class="moblie-qrcode">
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="javascript:void(0)"><?php echo \think\Lang::get('wechat_end'); ?></a>
                        <div class="dropdown-menu">
                            <img src="<?php echo UPLOAD_SITE_URL; ?>/<?php echo ATTACH_COMMON; ?>/<?php echo \think\Config::get('site_logowx'); ?>" width="90" height="90" />
                        </div>
                    </li>
                    <!--
                    <li class="app-qrcode">
                        <span class="outline"></span>
                        <span class="blank"></span>
                        <a href="javascript:void(0)">APP</a>
                        <div class="dropdown-menu">
                            <img width="90" height="90" src="<?php echo UPLOAD_SITE_URL; ?>/<?php echo ATTACH_COMMON; ?>/<?php echo \think\Config::get('site_logowx'); ?>" />
                            <h3>扫描二维码</h3>
                            <p>下载手机客户端</p>
                        </div>
                    </li>
                    -->
                </ul>
            </div>
        </div>
        
        
        
        <!--左侧导航栏-->
<div class="ds-appbar">
    <div class="ds-appbar-tabs" id="appBarTabs">
        <?php if(\think\Session::get('is_login')): ?>
        <div class="user" dstype="a-barUserInfo">
            <div class="avatar"><img src="<?php echo get_member_avatar(\think\Session::get('avatar')); ?>?<?php echo TIMESTAMP; ?>"/></div>
            <p><?php echo \think\Lang::get('sns_me'); ?></p>
        </div>
        <div class="user-info" dstype="barUserInfo" style="display:none;"><i class="arrow"></i>
            <div class="avatar"><img src="<?php echo get_member_avatar(\think\Session::get('avatar')); ?>?<?php echo TIMESTAMP; ?>"/></div>
            <dl>
                <dt>Hi, <?php echo \think\Session::get('member_name'); ?></dt>
                <dd><?php echo \think\Lang::get('ds_current_level'); ?>：<strong dstype="barMemberGrade"><?php echo \think\Session::get('level_name'); ?></strong></dd>
                <dd><?php echo \think\Lang::get('ds_current_experience'); ?>：<strong dstype="barMemberExp"><?php echo \think\Session::get('member_exppoints'); ?></strong></dd>
            </dl>
        </div>
       <?php else: ?>
        <div class="user TA_delay" dstype="a-barLoginBox">
            <div class="avatar TA"><img src="<?php echo get_member_avatar(\think\Session::get('avatar')); ?>?<?php echo TIMESTAMP; ?>"/></div>
            <p class="TA"><?php echo \think\Lang::get('login_notlogged'); ?></p>
        </div>
        <?php endif; ?>
        <ul class="tools">
            <?php if(\think\Config::get('node_site_use') == '1'): ?>
            <li><a href="javascript:void(0);" id="chat_show_user" class="chat TA_delay"><span class="iconfont">&#xe71b;</span><span class="tit"><?php echo \think\Lang::get('ds_chat'); ?></span><i id="new_msg" class="new_msg" style="display:none;"></i></a></li>
            <?php endif; ?>
            <li><a href="javascript:void(0);" onclick="toglle_bar('rtoolbar_cart')" id="rtoolbar_cart" class="cart TA_delay"><span class="iconfont">&#xe69a;</span><span class="tit"><?php echo \think\Lang::get('ds_cart'); ?></span><i id="rtoobar_cart_count" class="new_msg" style="display:none;"></i></a></li>
            <li><a href="javascript:void(0);" onclick="toglle_bar('compare')" id="compare" class="compare TA_delay"><span class="iconfont">&#xe74a;</span><span class="tit"><?php echo \think\Lang::get('ds_comparison'); ?></span></a></li>
            <li>
                <a href="javascript:void(0);" id="qrcode" class="qrcode TA_delay"><span class="iconfont">&#xe72d;</span>
                    <span class="tit-box">
                        <?php echo \think\Lang::get('ds_mobile_shopping_better'); ?><br>
                        <img src="<?php echo HOME_SITE_URL; ?>/qrcode?url=<?php echo \think\Config::get('h5_site_url'); ?>" width="110" height="110" />
                        <em class="tips_arrow"></em>
                    </span>
                </a>
            </li>
            <li><a href="javascript:void(0);" onclick="$('html,body').animate({scrollTop: '0px'}, 500)" id="gotop" class="gotop TA_delay" style="position: fixed;bottom: 0"><span class="iconfont">&#xe724;</span><span class="tit"><?php echo \think\Lang::get('ds_top'); ?></span></a></li>
        </ul>
        <div class="content-box" id="content-compare">
            <div class="top">
                <h3><?php echo \think\Lang::get('ds_comparison'); ?></h3>
                <a href="javascript:void(0);" class="close iconfont" title="<?php echo \think\Lang::get('ds_hidden'); ?>">&#xe73d;</a></div>
            <div id="comparelist"></div>
        </div>
        <div class="content-box" id="content-cart">
            <div class="top">
                <h3><?php echo \think\Lang::get('ds_my_shopping_cart'); ?></h3>
                <a href="javascript:void(0);" class="close iconfont" title="<?php echo \think\Lang::get('ds_hidden'); ?>">&#xe73d;</a></div>
            <div id="rtoolbar_cartlist"></div>
        </div>
    </div>
</div>
        
<script type="text/javascript">

    //动画显示边条内容区域
    $(function() {
        $(".close").click(function(){
            close_bar();
        });
        // 右侧bar用户信息
        $('div[dstype="a-barUserInfo"]').click(function(){
            $('div[dstype="barUserInfo"]').toggle();
        });
        // 右侧bar登录
        $('div[dstype="a-barLoginBox"]').click(function(){
            login_dialog();
        });

        <?php if($cart_goods_num > 0): ?>
            $('#rtoobar_cart_count').html(<?php echo $cart_goods_num; ?>).show();
        <?php endif; ?>
    });
    function toglle_bar(item){
        //判断侧边栏是否已拉出
        if(parseInt($('.ds-appbar').css('width')) == 36){
            $('.ds-appbar').css('width','306px');
        }
        //判断选中项是否已显示
        if(!$("#"+item).hasClass('active')){
            $('.tools li > a').removeClass('active');
            $("#"+item).addClass('active');
            $('.content-box').removeClass('active');
            
            switch(item){
                case 'rtoolbar_cart':
                    $("#rtoolbar_cartlist").load("<?php echo url('Cart/ajax_load','type=html'); ?>");
                    $("#content-cart").addClass('active');
                    break;
                case 'compare':   
                    loadCompare(false);
                    $("#content-compare").addClass('active');
                    break;
            }
        }else{
            //关闭
            close_bar();
            $(".chat-list").css("display",'none');
        }
        
    }
    function close_bar(){
        $('.tools li > a').removeClass('active');
        $('.content-box').removeClass('active');
        $('.ds-appbar').css('width','36px');
    }
</script> 

<link rel="stylesheet" href="<?php echo HOME_SITE_ROOT; ?>/css/member.css">
<script src="<?php echo HOME_SITE_ROOT; ?>/js/member.js"></script>
<link rel="stylesheet" href="<?php echo PLUGINS_SITE_ROOT; ?>/js/jquery-ui/jquery-ui.min.css">
<div class="header clearfix">
    <div class="w1200">
        <div class="logo">
            <a href="<?php echo HOME_SITE_URL; ?>"><img src="<?php echo UPLOAD_SITE_URL; ?>/<?php echo ATTACH_COMMON; ?>/<?php echo \think\Config::get('site_logo'); ?>"/></a>
        </div>
        <div class="top_search">
            <div class="top_search_box">
                <div id="search">
                    <ul class="tab" dstype="<?php echo \think\Request::instance()->controller(); ?>">
                        <li class="current"><span><?php echo \think\Lang::get('site_search_goods'); ?></span><i class="arrow"></i></li>
                        <li style="display: none;"><span><?php echo \think\Lang::get('site_search_store'); ?></span></li>
                    </ul>
                </div>
                <div class="form_fields">
                    <form class="search-form" id="search-form" method="get" action="<?php echo url('Search/goods'); ?>">
                        <input placeholder="<?php echo \think\Lang::get('search_merchandise_keywords'); ?>" name="keyword" id="keyword" type="text" class="keyword" value="<?php echo \think\Request::instance()->param('keyword'); ?>" maxlength="60" />
                        <input type="submit" id="button" value="<?php echo \think\Lang::get('ds_common_search'); ?>" class="submit">
                    </form>
                </div>
            </div>
            <ul class="top_search_keywords">
                <?php if(is_array($hot_search) || $hot_search instanceof \think\Collection || $hot_search instanceof \think\Paginator): if( count($hot_search)==0 ) : echo "" ;else: foreach($hot_search as $hot_k=>$hot_keyword): ?>
                <li <?php if($hot_k==0): ?>class="first"<?php endif; ?>><a href="<?php echo HOME_SITE_URL; ?>/Search/index.html?keyword=<?php echo $hot_keyword; ?>"><?php echo $hot_keyword; ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="user_menu">
            <dl class="my-mall">
                <dt><span class="ico iconfont">&#xe702;</span><?php echo \think\Lang::get('ds_user_center'); ?><i class="arrow"></i></dt>
                <dd>
                    <div class="sub-title">
                        <h4></h4>
                        <a href="<?php echo url('Member/index'); ?>" class="arrow"><?php echo \think\Lang::get('ds_my_user_center'); ?><i></i></a>
                    </div>
                    <div class="user-centent-menu">
                        <ul>
                            <li><a href="<?php echo url('Membermessage/message'); ?>"><?php echo \think\Lang::get('ds_message'); ?>(<span><?php echo $message_num; ?></span>)</a></li>
                            <li><a href="<?php echo url('Memberorder/index'); ?>" class="arrow"><?php echo \think\Lang::get('ds_my_order'); ?><i></i></a></li>
                            <li><a href="<?php echo url('Memberconsult/index'); ?>"><?php echo \think\Lang::get('ds_consulting_reply'); ?>(<span id="member_consult">0</span>)</a></li>
                            <li><a href="<?php echo url('Memberfavorites/fglist'); ?>" class="arrow"><?php echo \think\Lang::get('ds_vouchers'); ?><i></i></a></li>
                            <li><a href="<?php echo url('Membervoucher/index'); ?>"><?php echo \think\Lang::get('ds_favorites'); ?>(<span id="member_voucher">0</span>)</a></li>
                            <li><a href="<?php echo url('Memberpoints/index'); ?>" class="arrow"><?php echo \think\Lang::get('ds_my_points'); ?><i></i></a></li>
                        </ul>
                    </div>
                    <div class="browse-history">
                        <div class="part-title">
                            <h4><?php echo \think\Lang::get('ds_recently_browsed_items'); ?></h4>
                            <span style="float:right;"><a href="<?php echo url('Membergoodsbrowse/listinfo'); ?>"><?php echo \think\Lang::get('ds_full_history'); ?></a></span>
                        </div>
                        <ul>
                            <li class="no-goods"><img class="loading" src="<?php echo HOME_SITE_ROOT; ?>/images/loading.gif"></li>
                        </ul>
                    </div>
                </dd>
            </dl>
            <dl class="my-cart">
                <dt><span class="ico iconfont">&#xe69a;</span><?php echo \think\Lang::get('ds_shopping_cart_settlement'); ?><i class="arrow"></i></dt>
                <dd>
                    <div class="sub-title">
                        <h4><?php echo \think\Lang::get('ds_latest_additions'); ?></h4>
                    </div>
                    <div class="incart-goods-box">
                        <div class="incart-goods"><div class="no-order"><span><?php echo \think\Lang::get('ds_shopping_cart_empty'); ?></span></div></div>
                    </div>
                    <div class="checkout"> <span class="total-price"></span><a href="<?php echo url('Cart/index'); ?>" class="btn-cart"><?php echo \think\Lang::get('ds_checkout_cart'); ?></a> </div>
                </dd>
                <div class="addcart-goods-num"><?php echo $cart_goods_num; ?></div>
            </dl>
        </div>
    </div>
</div>


<div class="mall_nav">
    <div class="w1200">
        <div class="all_categorys">
            <div class="mt">
                <i></i>
                <h3><a href="<?php echo url('Category/goods'); ?>"><?php echo \think\Lang::get('ds_all_commodity_classes'); ?></a></h3>
            </div>
            <div class="mc">
                <ul class="menu">
                    <?php if(!(empty($header_categories) || (($header_categories instanceof \think\Collection || $header_categories instanceof \think\Paginator ) && $header_categories->isEmpty()))): $i = 0; if(is_array($header_categories) || $header_categories instanceof \think\Collection || $header_categories instanceof \think\Paginator): if( count($header_categories)==0 ) : echo "" ;else: foreach($header_categories as $key=>$val): $i++; ?>
                    <li cat_id="<?php echo $val['gc_id']; ?>" <?php if($i>11): ?>style="display:none;"<?php endif; ?>>
                        <div class="class">
                            <span class="arrow"></span>
                            <?php if(!(empty($val['pic']) || (($val['pic'] instanceof \think\Collection || $val['pic'] instanceof \think\Paginator ) && $val['pic']->isEmpty()))): ?>
                            <span class="ico"><img src="<?php echo $val['pic']; ?>"></span>
                            <?php else: ?>
                            <span class="iconfont category-ico-<?php echo $i; ?>"></span>
                            <?php endif; ?>
                            <h4><a href="<?php echo url('Search/index',['cate_id'=>$val['gc_id']]); ?>"><?php echo $val['gc_name']; ?></a></h4>
                        </div>
                        <div class="sub-class" cat_menu_id="<?php echo $val['gc_id']; ?>">
                            <div class="sub-class-content">
                                <div class="recommend-class">
                                    <?php if(!(empty($val['cn_classs']) || (($val['cn_classs'] instanceof \think\Collection || $val['cn_classs'] instanceof \think\Paginator ) && $val['cn_classs']->isEmpty()))): if(is_array($val['cn_classs']) || $val['cn_classs'] instanceof \think\Collection || $val['cn_classs'] instanceof \think\Paginator): if( count($val['cn_classs'])==0 ) : echo "" ;else: foreach($val['cn_classs'] as $k=>$v): ?>
                                    <span><a href="<?php echo url('Search/index',['cate_id'=>$v['gc_id']]); ?>" title="<?php echo $v['gc_name']; ?>"><?php echo $v['gc_name']; ?></a></span>
                                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                </div>
                                <?php if(!(empty($val['class2']) || (($val['class2'] instanceof \think\Collection || $val['class2'] instanceof \think\Paginator ) && $val['class2']->isEmpty()))): if(is_array($val['class2']) || $val['class2'] instanceof \think\Collection || $val['class2'] instanceof \think\Paginator): if( count($val['class2'])==0 ) : echo "" ;else: foreach($val['class2'] as $k=>$v): ?>
                                <dl>
                                    <dt>
                                    <h3><a href="<?php echo url('Search/index',['cate_id'=>$v['gc_id']]); ?>"><?php echo $v['gc_name']; ?></a></h3>
                                    </dt>
                                    <dd class="goods-class">
                                        <?php if(!(empty($v['class3']) || (($v['class3'] instanceof \think\Collection || $v['class3'] instanceof \think\Paginator ) && $v['class3']->isEmpty()))): if(is_array($v['class3']) || $v['class3'] instanceof \think\Collection || $v['class3'] instanceof \think\Paginator): if( count($v['class3'])==0 ) : echo "" ;else: foreach($v['class3'] as $k3=>$v3): ?>
                                        <a href="<?php echo url('Search/index',['cate_id'=>$v3['gc_id']]); ?>"><?php echo $v3['gc_name']; ?></a>
                                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                    </dd>
                                </dl>
                                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </div>
                            <div class="sub-class-right">
                                <?php if(!(empty($val['cn_brands']) || (($val['cn_brands'] instanceof \think\Collection || $val['cn_brands'] instanceof \think\Paginator ) && $val['cn_brands']->isEmpty()))): ?>
                                <div class="brands-list">
                                    <ul>
                                        <?php if(is_array($val['cn_brands']) || $val['cn_brands'] instanceof \think\Collection || $val['cn_brands'] instanceof \think\Paginator): if( count($val['cn_brands'])==0 ) : echo "" ;else: foreach($val['cn_brands'] as $key=>$brand): ?>
                                        <li>
                                            <a href="<?php echo url('Brand/brand_goods',['brand_id'=>$brand['brand_id']]); ?>" title="<?php echo $brand['brand_name']; ?>"><?php if(($brand['brand_pic'] != '')): ?><img src="<?php echo brand_image($brand['brand_pic']); ?>"/><?php endif; ?>
                                                <span><?php echo $brand['brand_name']; ?></span>
                                            </a>
                                        </li>
                                       <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                <div class="adv-promotions">
                                    <?php if(isset($val['goodscn_adv1']) && $val['goodscn_adv1'] != ''): ?>
                                    <a <?php if($val['goodscn_adv1_link'] == ''): ?>href="javascript:;"<?php else: ?>target="_blank" href="<?php echo $val['goodscn_adv1_link']; endif; ?>><img src="<?php echo $val['goodscn_adv1']; ?>" data-url="<?php echo $val['goodscn_adv1']; ?>" class="scrollLoading" /></a>
                                    <?php endif; if(isset($val['goodscn_adv2']) && $val['goodscn_adv2'] != ''): ?>
                                    <a <?php if($val['goodscn_adv2_link'] == ''): ?>href="javascript:;"<?php else: ?>target="_blank" href="<?php echo $val['goodscn_adv2_link']; endif; ?>><img src="<?php echo $val['goodscn_adv2']; ?>" data-url="<?php echo $val['goodscn_adv2']; ?>" class="scrollLoading" /></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                </ul>
            </div>
        </div>
        <div class="nav_list">
            <ul class="site_menu">
                <li><a href="<?php echo url('Index/index'); ?>" class="current"><?php echo \think\Lang::get('homepage'); ?></a></li>
                <?php foreach($navs['middle'] as $nav): ?>
                <li><a href="<?php echo $nav['nav_url']; ?>" <?php if($nav['nav_new_open'] == 1): ?>target="_blank"<?php endif; ?>><?php echo $nav['nav_title']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>





<!--面包屑导航 BEGIN-->
<?php if(!(empty($nav_link_list) || (($nav_link_list instanceof \think\Collection || $nav_link_list instanceof \think\Paginator ) && $nav_link_list->isEmpty()))): ?>
<div class="dsh-breadcrumb-layout">
    <div class="dsh-breadcrumb w1200"><i class="iconfont">&#xe6ff;</i>
        <?php foreach($nav_link_list as $nav_link): if(empty($nav_link['link']) || (($nav_link['link'] instanceof \think\Collection || $nav_link['link'] instanceof \think\Paginator ) && $nav_link['link']->isEmpty())): ?>
        <span><?php echo $nav_link['title']; ?></span>
        <?php else: ?>
        <span><a href="<?php echo $nav_link['link']; ?>"><?php echo $nav_link['title']; ?></a></span><span class="arrow">></span>
        <?php endif; endforeach; ?>
    </div>
</div>
<?php endif; ?>
<!--面包屑导航 END-->


<script>
    $(function() {
	//首页左侧分类菜单
	$(".all_categorys ul.menu").find("li").each(
		function() {
			$(this).hover(
				function() {
				    var cat_id = $(this).attr("cat_id");
					var menu = $(this).find("div[cat_menu_id='"+cat_id+"']");
					menu.show();
					$(this).addClass("hover");					
					var menu_height = menu.height();
					if (menu_height < 60) menu.height(80);
					menu_height = menu.height();
					var li_top = $(this).position().top;
					$(menu).css("top",-li_top + 40);
				},
				function() {
					$(this).removeClass("hover");
				    var cat_id = $(this).attr("cat_id");
					$(this).find("div[cat_menu_id='"+cat_id+"']").hide();
				}
			);
		}
	);

        $(".user_menu dl").hover(function() {
            $(this).addClass("hover");
        }, function() {
            $(this).removeClass("hover");
        });
        $('.user_menu .my-mall').mouseover(function() {
            // 最近浏览的商品
            load_history_information();
            $(this).unbind('mouseover');
        });
        $('.user_menu .my-cart').mouseover(function() {
            // 运行加载购物车
            load_cart_information();
            $(this).unbind('mouseover');
        });
    });
    
</script>

<div class="member_center_back">
<div class="dsm-container">
    <div class="left-layout">
    <div class="dsm-sidebar">
        <?php if(is_array($member_menu) || $member_menu instanceof \think\Collection || $member_menu instanceof \think\Paginator): if( count($member_menu)==0 ) : echo "" ;else: foreach($member_menu as $key=>$menu): ?>
        <div class="dl">
            <div class="dt">
                <h3 key="<?php echo $menu['name']; ?>"><i class="iconfont"><?php echo $menu['ico']; ?></i><?php echo $menu['text']; ?></h3>
            </div>
            <div class="dd">
                <ul>
                    <?php if(is_array($menu['submenu']) || $menu['submenu'] instanceof \think\Collection || $menu['submenu'] instanceof \think\Paginator): if( count($menu['submenu'])==0 ) : echo "" ;else: foreach($menu['submenu'] as $key=>$submenu): ?>
                    <li <?php if($submenu['name'] == $cursubmenu): ?>class="selected"<?php endif; ?>><a href="<?php echo $submenu['url']; ?>"><?php echo $submenu['text']; ?></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
    <div class="right-layout">
        <div class="tabmenu">
            <?php if($member_item): ?>
<ul class="tab pngFix">
    <?php if(is_array($member_item) || $member_item instanceof \think\Collection || $member_item instanceof \think\Paginator): if( count($member_item)==0 ) : echo "" ;else: foreach($member_item as $key=>$item): ?>
    <li <?php if($item['name'] == $curitem): ?>class="active"<?php endif; ?>><a href="<?php echo $item['url']; ?>"><?php echo $item['text']; ?></a></li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php endif; ?>
            
        </div>
        
<form id="goodsevalform" method="get" class="tc">
    <input type="hidden" name="type" value="<?php echo \think\Request::instance()->get('type'); ?>"/>
    <?php if($goodsevallist): ?>
    <div class="dsm-evaluation-list">
        <?php if(is_array($goodsevallist) || $goodsevallist instanceof \think\Collection || $goodsevallist instanceof \think\Paginator): if( count($goodsevallist)==0 ) : echo "" ;else: foreach($goodsevallist as $key=>$list): ?>
        <div class="dsm-evaluation-timeline">
            <div class="date"><?php echo date("Y-m-d H:i:s",$list['geval_addtime']); ?></div>
            <div class="goods-thumb"><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$list['geval_goodsid']]); ?>">
                    <img src="<?php echo goods_cthumb($list['geval_goodsimage']); ?>"> </a></div>
            <dl class="detail">
                <dt><a target="_blank" href="<?php echo url('Goods/index',['goods_id'=>$list['geval_goodsid']]); ?>"><?php echo $list['geval_goodsname']; ?></a> </dt>
                <dd><?php echo \think\Lang::get('commodity_rating'); ?>：
                    <div class="raty" style="display:inline-block;" data-score="<?php echo $list['geval_scores']; ?>"></div>
                </dd>
                <dd><?php echo \think\Lang::get('member_evaluation_my_evaluation'); ?>：<?php echo $list['geval_content']; ?> </dd>
                <dd>
                    <?php if($list['geval_image']== ''): ?>
                    <a href="<?php echo url('Memberevaluate/add_image',['geval_id'=>$list['geval_id']]); ?>" class="dsm-btn dsm-btn-orange"><?php echo \think\Lang::get('my_printout'); ?></a>
                    <?php endif; if($list['geval_image'] !=''): ?>
                    <?php echo \think\Lang::get('print_picture'); ?>：
                    <ul class="photos-thumb">
                        <?php $image_array = explode(',', $list['geval_image']); if(is_array($image_array) || $image_array instanceof \think\Collection || $image_array instanceof \think\Paginator): if( count($image_array)==0 ) : echo "" ;else: foreach($image_array as $key=>$value): ?>
                        <li> <a data-lightbox="lightbox-image" href="<?php echo sns_thumb($value); ?>"><img src="<?php echo sns_thumb($value); ?>"></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <?php endif; ?>

                </dd>
                <?php if($list['geval_explain']): ?>
                <dd>
                    <p style="color:#996600;padding:5px 0px;">[<?php echo \think\Lang::get('member_evaluation_explain'); ?>]<?php echo $list['geval_explain']; ?></p>
                </dd>
                <?php endif; ?>
            </dl>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="pagination mt30"><?php echo $show_page; ?></div>
    <?php else: ?>
    <div class="norecord">
        <div class="warning-option"><i></i><span><?php echo \think\Lang::get('no_record'); ?></span></div>
    </div>
    <?php endif; ?>
</form>
<link rel="stylesheet" href="<?php echo PLUGINS_SITE_ROOT; ?>/js/jquery.lightbox/css/lightbox.min.css">
<script src="<?php echo PLUGINS_SITE_ROOT; ?>/js/jquery.lightbox/js/lightbox.min.js"></script>

<script src="<?php echo PLUGINS_SITE_ROOT; ?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.raty').raty({
            path: "<?php echo PLUGINS_SITE_ROOT; ?>/js/jquery.raty/img",
            readOnly: true,
            score: function() {
                return $(this).attr('data-score');
            }
        });
    })
</script>




    </div>
    <div class="clear"></div>
</div>
</div>
<div class="server">
    <div class="ensure">
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
        <a href="#"></a>
    </div>
    <div class="mall_desc">
        <?php if(!(empty($article_list) || (($article_list instanceof \think\Collection || $article_list instanceof \think\Paginator ) && $article_list->isEmpty()))): if(is_array($article_list) || $article_list instanceof \think\Collection || $article_list instanceof \think\Paginator): $_5e952c436e477 = is_array($article_list) ? array_slice($article_list,0,4, true) : $article_list->slice(0,4, true); if( count($_5e952c436e477)==0 ) : echo "" ;else: foreach($_5e952c436e477 as $key=>$art): ?>
        <dl> 
            <dt><?php echo $art['ac_name']; ?></dt>
            <dd>
                <?php if(!(empty($art['list']) || (($art['list'] instanceof \think\Collection || $art['list'] instanceof \think\Paginator ) && $art['list']->isEmpty()))): if(is_array($art['list']) || $art['list'] instanceof \think\Collection || $art['list'] instanceof \think\Paginator): if( count($art['list'])==0 ) : echo "" ;else: foreach($art['list'] as $key=>$list): ?>
                <a href="<?php if($list['article_url'] !=''): ?><?php echo $list['article_url']; else: ?><?php echo url('Article/show',['article_id'=>$list['article_id']]); endif; ?>"><?php echo $list['article_title']; ?></a>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </dd>
        </dl>
        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        <dl class="mall_mobile">
            <dt><?php echo \think\Lang::get('ds_mobile_mall'); ?></dt>
            <dd>
                <a href="#" class="join">
                    <img src="<?php echo HOME_SITE_URL; ?>/qrcode?url=<?php echo \think\Config::get('h5_site_url'); ?>" width="105" height="105" >
                </a>
            </dd> 
        </dl>
    </div>
</div>






<?php if(\think\Config::get('node_site_use') == '1' && !isset($wait) && request()->controller() != 'Payment' && request()->controller() != 'Showgroupbuy'): ?>
<?php echo get_chat(); endif; ?>
<script src="<?php echo PLUGINS_SITE_ROOT; ?>/jquery.cookie.js"></script>
<script src="<?php echo HOME_SITE_ROOT; ?>/js/compare.js"></script>
<link rel="stylesheet" href="<?php echo PLUGINS_SITE_ROOT; ?>/perfect-scrollbar.min.css">
<script src="<?php echo PLUGINS_SITE_ROOT; ?>/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo PLUGINS_SITE_ROOT; ?>/js/qtip/jquery.qtip.min.js"></script>
<link href="<?php echo PLUGINS_SITE_ROOT; ?>/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo PLUGINS_SITE_ROOT; ?>/jquery.lazyload.min.js"></script>
<script>
    //懒加载
    $("img.lazyload").lazyload({
//        placeholder : "<?php echo HOME_SITE_ROOT; ?>/images/loading.gif",
        effect: "fadeIn",
        skip_invisible : false,
        threshold : 200,
    });
</script>
<div class="footer-info">
    <div class="links w1200">
        <?php foreach($navs['footer'] as $nav): ?>
        <a href="<?php echo $nav['nav_url']; ?>" <?php if($nav['nav_new_open'] == 1): ?>target="_blank"<?php endif; ?>><?php echo $nav['nav_title']; ?></a>|
        <?php endforeach; ?>
    </div>
    <p class="copyright"><?php echo \think\Config::get('flow_static_code'); ?></p>
</div>

