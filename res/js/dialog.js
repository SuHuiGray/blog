(function($, win){
    var options = {
            url : '',
            ok : null,
            okVal : '确定',
            cancel : null,
            canVal : '取消',
            width : 300,
            height: 300,
            title : '提示',
            cont : '',
        },
        body = $("body"),
        w = $(win);
    var showMask = function(){
        body.append("<div id='mask'></div>");
        $("#mask").css({"width":w.width(), "height":w.height(), "z-index":"10"});
    };

    var cancel = function(obj){
        obj.on("click", function(){
            $("#dlg,#mask").remove();
        })
    }
    $.extend({
        login : function(arg){
            showMask();
            var args = $.extend({}, options, arg);

            var login_str = '<div id="layer" ><p id="layer-text" >登录</p><p id="close"></p><input id="usn" type="text" placeholder="username" id="login-input"><input id="psd" type="password" placeholder="password" id="login-input"><span id="login-btn">'+args.okVal+'</span></div>';
            body.append(login_str);
            var login_top = (w.height()-$("#layer").height())/2,
                login_left = (w.width()-$("#layer").width())/2;
            $("#layer").css({"top":login_top, "left":login_left});

            //关闭登录界面
            $("#close").on("click", function(){
                $("#layer,#mask").remove();
            });

            //登录
            $("#login-btn").on("click", args.ok);
        },

        alert : function(arg){
            showMask();
            var args = $.extend({}, options, arg);
            var alert_str = '<div id="layer" ><p id="layer-text" >'+args.title+'</p><span>'+args.cont+'</span><span id="login-btn">'+args.okVal+'</span></div>';
        },

        confirm : function(arg){
            showMask();
            var args = $.extend({}, options, arg);
            var alert_str = '<div id="dlg"><p id="dlg-cfm-title">'+args.title+'</p><p id="dlg-cfm-cont">'+args.cont+'</p><span id="dlg-cfm-ok">'+args.okVal+'</span><span id="dlg-cfm-cancel">'+args.canVal+'</span></div>';
            body.append(alert_str);
            var login_top = (w.height()-args.height)/2,
                login_left = (w.width()-args.width)/2;

            $("#dlg").css({"height":args.height, "width":args.width, "top":login_top, "left":login_left});

            cancel($("#dlg-cfm-cancel"));
        }
    });
})(jQuery, window)
