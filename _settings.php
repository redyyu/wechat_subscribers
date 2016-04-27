<?php

/*
 * Settings Page, It's required by WPWSLSettings Class only.
 *
 */

$options = $this->options;

$fields = array('token', 'img_url_small');

foreach ($fields as $field) {
    if (!isset($options[$field])) {
        $options[$field] = '';
    }
}
$interface_url = isset($options['token']) && $options['token'] != '' ? home_url() . '/?' . $options['token'] : 'none';

$default_img_pic_small = WPWSL_PLUGIN_URL . '/img/sup_wechat_small.png';

$current_img_url_small = isset($options['sup_wechat_small']) && $options['sup_wechat_small'] != '' ? $options['sup_wechat_small'] : $default_img_pic_small;

$default_img_pic_big = WPWSL_PLUGIN_URL . '/img/sup_wechat_big.png';

$current_img_url_big = isset($options['sup_wechat_big']) && $options['sup_wechat_big'] != '' ? $options['sup_wechat_big'] : $default_img_pic_big;


//Load content
require_once('content.php');
?>
<!---->

<!---->
<link href="<?php echo WPWSL_PLUGIN_URL; ?>/css/style.css" rel="stylesheet">
<link href="<?php echo WPWSL_PLUGIN_URL; ?>/css/modal.css" rel="stylesheet">
<div class="wrap">
    <h2><?php _e('WeChat Subscribers Lite', 'WPWSL') ?></h2>
    <form action="options.php" method="POST">
        <?php settings_fields($this->option_group); ?>
        <?php do_settings_sections($this->page_slug); ?>
        <hr>
        <h4><?php _e('Account Settings', 'WPWSL') ?></h4>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label>Token</label></th>
                <td>
                    <input type="text" size="30" name="<?php echo $this->option_name; ?>[token]"
                           value="<?php echo $options['token']; ?>" class="regular-text"/>
                    <p class="description"><?php _e('Access verification for your WeChat public platform. Only Latin letter, number, dash and underscore. 30 character limited.', 'WPWSL') ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label>URL</label></th>
                <td>
                    <h4><?php echo $interface_url; ?></h4>
                    <p class="description"><?php _e('First input a TOKEN above and save the settings, then &quot;Copy&quot; and &quot;Bind&quot; this URL to WeChat Platform.', 'WPWSL') ?></p>
                </td>
            </tr>
            <!--            Big Image-->
            <tr valign="top">
                <th scope="row">
                    <label><?php _e('Pic URL', 'WPWSL'); ?></label>
                </th>
                <td>
                    <div class="preview-box large">
                        <img src="<?php echo $current_img_url_big; ?>"
                             data-default_pic="<?php echo $default_img_pic_big; ?>"/>
                        <a href="#" class="remove-pic-btn"><?php _e('Remove', 'WPWSL'); ?></a>
                    </div>
                    <input type="hidden" value="<?php echo $current_img_url_big; ?>"
                           name="<?php echo $this->option_name; ?>[sup_wechat_big]"
                           rel="img-input" class="img-input large-text"/>
                    <button
                        class='custom_media_upload button'><?php _e('Upload', 'WPWSL'); ?></button>
                </td>
            </tr>
<!--            Small Image-->
            <tr valign="top">
                <th scope="row">
                    <label><?php _e('Pic URL', 'WPWSL'); ?></label>
                </th>
                <td>
                    <div class="preview-box">
                        <img src="<?php echo $current_img_url_small; ?>"
                             data-default_pic="<?php echo $default_img_pic_small; ?>"/>
                        <a href="#" class="remove-pic-btn"><?php _e('Remove', 'WPWSL'); ?></a>
                    </div>
                    <input type="hidden" value="<?php echo $current_img_url_small; ?>"
                           name="<?php echo $this->option_name; ?>[sup_wechat_small]"
                           rel="img-input" class="img-input large-text"/>
                    <button
                        class='custom_media_upload button'><?php _e('Upload', 'WPWSL'); ?></button>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
    <hr>
    <?php echo $content['tips_content']; ?>
</div>
<script>
    var limit_phmsg = 9;
    var count_phmsg = 0;
    jQuery(document).ready(function ($) {
        var init_msg_type = function () {
            var val = $('#msg_type').val();
            switch (val) {
                case 'text':
                    $('#resp_msg').show();
                    $('#resp_phmsg').hide();
                    $('#resp_remsg').hide();
                    break;
                case 'news':
                    $('#resp_msg').hide();
                    $('#resp_phmsg').show();
                    $('#resp_remsg').hide();
                    break;
                case 'recent':
                    $('#resp_msg').hide();
                    $('#resp_phmsg').hide();
                    $('#resp_remsg').show();
                    $('.resp_remsg_recent').show();
                    $('.resp_remsg_random').hide();
                    $('.resp_remsg_search').hide();
                    break;
                case 'random':
                    $('#resp_msg').hide();
                    $('#resp_phmsg').hide();
                    $('#resp_remsg').show();
                    $('.resp_remsg_recent').hide();
                    $('.resp_remsg_random').show();
                    $('.resp_remsg_search').hide();
                    break;
                case 'search':
                    $('#resp_msg').hide();
                    $('#resp_phmsg').hide();
                    $('#resp_remsg').show();
                    $('.resp_remsg_recent').hide();
                    $('.resp_remsg_random').hide();
                    $('.resp_remsg_search').show();

                    $('.trigger-way').removeAttr("checked")
                        .attr("disabled", "disabled");

                    $("#trigger-way-default").attr("checked", "checked")
                        .removeAttr("disabled");

                    break;
            }
            if (val != 'search') {
                $('.trigger-way').removeAttr("disabled");
                $("#" + $cur_trigger_way).click();
            }
        }

        init_msg_type();

        var $cur_trigger_way = $(".trigger-way:checked").attr("id");
        ;
        if ($('#msg_type').length > 0) {
            $('#msg_type').change(function () {
                init_msg_type();
            });
        }

        $(".trigger-way").click(function () {
            $cur_trigger_way = $(this).attr('id');
        });

        $('.remove-pic-btn').click(function () {
            var input = $(this).parent().next('input[rel="img-input"]');

            input.val('');
            input.trigger("change");
            return false;
        });

        $('input[rel="img-input"]').each(function () {
            $(this).change(function () {
                var img = $($(this).parent().children('.preview-box').children('img'));
                if ($(this).val() == '') {
                    var pic_url = img.data('default_pic');
                    img.next('.remove-pic-btn').hide();
                } else {
                    var pic_url = $(this).val();
//				console.log(img.next('.remove-pic-btn'));
                    img.next('.remove-pic-btn').show();
                }
                img.attr('src', pic_url);
            });
        });

        $('#add-phmsg-btn').click(function () {
            add_phmsg_box();
            sort_phmsg_box();
            return false;
        });

        $('.remove-msg-box-btn').click(function () {
            remove_phmsg_box($(this).parent().parent());
            sort_phmsg_box();
            return false;
        });

        $('.up-msg-box-btn').click(function () {
            move_phmsg_box($(this).parent().parent(), true);
            sort_phmsg_box();
            return false;
        });

        $('.down-msg-box-btn').click(function () {
            move_phmsg_box($(this).parent().parent(), false);
            sort_phmsg_box();
            return false;
        });
        //create unquid   var id = new UUID();
        function UUID() {
            this.id = this.createUUID()
        }

        UUID.prototype.valueOf = function () {
            return this.id
        };
        UUID.prototype.toString = function () {
            return this.id
        };
        UUID.prototype.createUUID = function () {
            var c = new Date(1582, 10, 15, 0, 0, 0, 0);
            var f = new Date();
            var h = f.getTime() - c.getTime();
            var i = UUID.getIntegerBits(h, 0, 31);
            var g = UUID.getIntegerBits(h, 32, 47);
            var e = UUID.getIntegerBits(h, 48, 59) + "2";
            var b = UUID.getIntegerBits(UUID.rand(4095), 0, 7);
            var d = UUID.getIntegerBits(UUID.rand(4095), 0, 7);
            var a = UUID.getIntegerBits(UUID.rand(8191), 0, 7) + UUID.getIntegerBits(UUID.rand(8191), 8, 15) + UUID.getIntegerBits(UUID.rand(8191), 0, 7) + UUID.getIntegerBits(UUID.rand(8191), 8, 15) + UUID.getIntegerBits(UUID.rand(8191), 0, 15);
            return i + g + e + b + d + a
        };
        UUID.getIntegerBits = function (f, g, b) {
            var a = UUID.returnBase(f, 16);
            var d = new Array();
            var e = "";
            var c = 0;
            for (c = 0; c < a.length; c++) {
                d.push(a.substring(c, c + 1))
            }
            for (c = Math.floor(g / 4); c <= Math.floor(b / 4); c++) {
                if (!d[c] || d[c] == "") {
                    e += "0"
                } else {
                    e += d[c]
                }
            }
            return e
        };
        UUID.returnBase = function (c, d) {
            var e = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
            if (c < d) {
                var b = e[c]
            } else {
                var f = "" + Math.floor(c / d);
                var a = c - f * d;
                if (f >= d) {
                    var b = this.returnBase(f, d) + e[a]
                } else {
                    var b = e[f] + e[a]
                }
            }
            return b
        };
        UUID.rand = function (a) {
            return Math.floor(Math.random() * a)
        };
        //when DOM is  ready, create a new UUID() for $('#phmsg-base .msg-box')[0]
        var oneid = new UUID();
        var twoid = new UUID();
        $($('#phmsg-base .msg-box')[0]).find("button.alert_dialog_include_posts").attr("tid", oneid);
        $($('#phmsg-base .msg-box')[0]).find(".phmsg-base-input-url:first").attr("id", oneid);
        $($('#phmsg-base .msg-box')[0]).find(".insert_resp_phmsg:first").attr("tid", twoid);
        $($('#phmsg-base .msg-box')[0]).attr("id", twoid);
        function add_phmsg_box(title, pic, des, url) {
            var title = typeof title !== 'undefined' ? title : '';
            var pic = typeof pic !== 'undefined' ? pic : '';
            var des = typeof des !== 'undefined' ? des : '';
            var url = typeof url !== 'undefined' ? url : '';

            count_phmsg++;
            if (count_phmsg <= limit_phmsg && count_phmsg > 0) {
                var tpl = $($('#phmsg-base .msg-box')[0]);
                var clone = tpl.clone(true);
                var subtitle = clone.children('h3[rel="title"]').data('subtitle');
                clone.children('h3[rel="title"]').html(subtitle + '.' + count_phmsg);

                clone.find('.preview-box img').each(function () {
                    $(this).attr('src', '');
                });
                //set button id className is .alert_dialog_include_posts when clone
                var oneid = new UUID();
                var twoid = new UUID();
                clone.find("button.alert_dialog_include_posts").attr("tid", oneid);
                clone.find(".phmsg-base-input-url:first").attr("id", oneid);
                clone.find(".insert_resp_phmsg:first").attr("tid", twoid);
                clone.attr("id", twoid).attr("wechat-small", "yes");
                clone.find('input').each(function () {
                    if ($(this).attr('name') == 'title[]') {
                        $(this).val(title);
                    }
                    if ($(this).attr('name') == 'pic[]') {
                        $(this).val(pic);
                        $(this).trigger("change");
                    }
                    if ($(this).attr('name') == 'des[]') {
                        $(this).val(des);
                    }
                    if ($(this).attr('name') == 'url[]') {
                        $(this).val(url);
                    }
                });
                $('#phmsg-group').append(clone);
            }
            if (count_phmsg >= limit_phmsg) {
                $('#add-phmsg-btn').hide();
            }
        }

        function remove_phmsg_box(obj) {
            obj.remove();
            count_phmsg--;
        }

        function move_phmsg_box(obj, direct) {

            if (direct) {
                var prv = obj.prev('.msg-box');
                if (prv != '') {
                    prv.before(obj);
                }
            } else {
                var nex = obj.next('.msg-box');
                if (nex != '') {
                    nex.after(obj);
                }
            }
        }

        function sort_phmsg_box() {
            var length = $('#phmsg-group .msg-box').length;
            for (var i = 0; i < length; i++) {
                var cur = $($('#phmsg-group .msg-box')[i]);
                var subtitle = cur.children('h3[rel="title"]').data('subtitle');
                var id = cur.attr("id");
                cur.children('h3[rel="title"]').html(subtitle + '.' + (i + 1));
            }
        }

        <?php foreach($_phmsg_group as $item):?>
        add_phmsg_box('<?php echo $item->title;?>', '<?php echo $item->pic;?>', '<?php echo $item->des;?>', '<?php echo $item->url;?>');
        <?php endforeach;?>


//set ajax request
        $(".alert_dialog_include_posts").live("click", function (e) {
            var $this = $(this);
            var data = {
                action: 'add_foobar',
                tid: $this.attr("tid"),
                rtype: $this.attr('rtype')
            }
            var admin_url = <?php echo "'" . admin_url('admin-ajax.php') . "'";?>;
            $("#hide-modal").find(".hide-modal-body").html('<div id="dialog_content__container" style="width:inherit;margin:0px auto;border-radius:5px;"><table class="wp-list-table widefat fixed posts" style="min-height:100px;"><thead><tr><th style="text-align:center;height: 77px;">loading....</th></tr></thead></table></div>');
            $(this).attr("href", "#hide-modal");
            $.fn.custombox(this, {
                effect: 'fadein',
                overlaySpeed: "100"
            });

            jQuery.get(admin_url, data, function (d, s) {
                $("#dialog_content__container").html(d);
                $("#paginate_div").find(".page-numbers").live("click", function () {
                    var $this = $(this);
                    var cur = $this.attr("href") ? ($this.attr("href")).substr(1) : "";
                    cur = cur == "" ? 1 : cur;
                    var data = {
                        action: 'add_foobar',
                        tid: $("#hidden_post_tid").val(),
                        rtype: $("#hidden_post_type").val(),
                        ptype: $("#select_type_action").val(),
                        catid: $("#select_cate_action").val(),
                        key: $("#hidden_search_key").val(),
                        cur: cur
                    }
                    var admin_url = <?php echo "'" . admin_url('admin-ajax.php') . "'";?>;
                    $.get(admin_url, data, function (d, s) {
                        $("#dialog_content__container").html(d);
                        bindEvents();
                        return false;
                    });
                    return false;
                });

                bindEvents();
            });
            e.preventDefault();

        });
        $("#easydialog_close").live("click", function () {
            $.fn.custombox('close');
            return false;
        });
        //ajax to get content or url
        $(".insert_content_to_input").live("click", function () {
            var $this = $(this);
            var data = {
                action: 'get_insert_content',
                postid: $this.attr("postid"),
                rtype: $("#hidden_post_type").val()
            }
            var tid = $this.attr('tid');
            if ($("#" + tid).attr("wechat-small") == "yes") {
                data.imagesize = "small";
            }
            var admin_url = <?php echo "'" . admin_url('admin-ajax.php') . "'";?>;
            jQuery.get(admin_url, data, function (d, s) {
                try {
                    d = JSON.parse(d)
                } catch (err) {
                    d = false
                    throw "AJAX Sync Modal Load Json data faild";
                }
                if (d) {
                    if (d.status = "success") {
                        if (data.rtype == "phmsg") {
                            var $container = $("#" + tid);
                            if (d.data.pic && d.data.pic != "none") {
                                $container.find(".preview-box img").attr("src", d.data.pic);
                            }
                            $container.find("input[name='title[]']")
                                .val(d.data.post_title);

                            $container.find("input[name='pic[]']")
                                .val(d.data.pic);

                            $container.find("input[name='des[]']")
                                .val(d.data.post_content);

                            $container.find("input[name='url[]']").val(d.data.url);
                        } else {
                            $("#" + tid).val(d.data);
                        }
                        $.fn.custombox('close');
                    } else {
                        alert("Error:" + d.data);
                    }
                } else {
                    alert("Error:" + d);
                }
            });
        });
        $("#post-search-key").live("focus", function () {
            $(this).keypress(function (e) {
                if (e.which == 13) {
                    var key = $("#post-search-key").val();
                    if ($.trim(key) != "") {
                        $("#dialog_content__container").find("table:first").html("<thead><tr><th style='text-align:center;height: 77px;'>loading....</th></tr></thead>");
                        var data = {
                            action: 'add_foobar',
                            tid: $("#hidden_post_tid").val(),
                            rtype: $("#hidden_post_type").val(),
                            key: key
                        }
                        var admin_url = <?php echo "'" . admin_url('admin-ajax.php') . "'";?>;
                        $.get(admin_url, data, function (d, s) {
                            $("#dialog_content__container").html(d);
                            bindEvents();
                            $("#post-search-key").select();
                            return false;
                        });
                    }
                }
            });
        });
        //search posts
        $("#post-search-submit").live("click", function () {
            var key = $("#post-search-key").val();
            if ($.trim(key) != "") {
                $("#dialog_content__container").find("table:first").html("<thead><tr><th style='text-align:center;height: 77px;'>loading....</th></tr></thead>");
                var data = {
                    action: 'add_foobar',
                    tid: $("#hidden_post_tid").val(),
                    rtype: $("#hidden_post_type").val(),
                    key: key
                }
                var admin_url = <?php echo "'" . admin_url('admin-ajax.php') . "'";?>;
                $.get(admin_url, data, function (d, s) {
                    $("#dialog_content__container").html(d);
                    bindEvents();
                    $("#post-search-key").select();
                    return false;
                });
            }
        });
        /***************
         *message type : recent
         ***************/
        $("#re_type_select").change(function () {
            var val = $(this).attr("value");
            var $tr = $("#re_cate_tr");
            switch (val) {
                case "post":
                    $tr.show();
                    break;
                default    :
                    $tr.hide();
            }
        });
        /***************
         *message type : random
         ***************/
        $("#rand_type_select").change(function () {
            var val = $(this).attr("value");
            var $tr = $("#rand_cate_tr");
            switch (val) {
                case "post":
                    $tr.show();
                    break;
                default    :
                    $tr.hide();
            }
        });
        /***************
         *message type : search
         ***************/
        $("#sh_type_select").change(function () {
            var val = $(this).attr("value");
            var $tr = $("#sh_cate_tr");
            switch (val) {
                case "post":
                    $tr.show();
                    break;
                default    :
                    $tr.hide();
            }
        });
        /**********
         *
         **********/
        function bindEvents() {
            //set pagetype select option event
            $("#select_type_action").change(function () {
                $("#dialog_content__container").find("table:first").html("<thead><tr><th style='text-align:center;height: 77px;'>loading....</th></tr></thead>");
                var val = $(this).val();
                var data = {
                    action: 'add_foobar',
                    tid: $("#hidden_post_tid").val(),
                    rtype: $("#hidden_post_type").val(),
                    ptype: val
                }
                var admin_url = <?php echo "'" . admin_url('admin-ajax.php') . "'";?>;
                $.get(admin_url, data, function (d, s) {
                    $("#dialog_content__container").html(d);
                    bindEvents();
                    return false;
                });
            });

            //set cates select option event
            $("#select_cate_action").change(function () {
                $("#dialog_content__container").find("table:first").html("<thead><tr><th style='text-align:center;height: 77px;'>loading....</th></tr></thead>");
                var val = $(this).val();
                var data = {
                    action: 'add_foobar',
                    tid: $("#hidden_post_tid").val(),
                    rtype: $("#hidden_post_type").val(),
                    catid: val
                }
                var admin_url = <?php echo "'" . admin_url('admin-ajax.php') . "'";?>;
                $.get(admin_url, data, function (d, s) {
                    $("#dialog_content__container").html(d);
                    bindEvents();
                    return false;
                });
            });
        }

    });
</script>
