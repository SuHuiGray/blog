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
            time : false,
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

            var login_str = '<div id="layer" ><p id="layer-text" >登录</p><p id="close"></p><input id="usn" type="text" placeholder="username" class="login-input"><input id="psd" type="password" placeholder="password" class="login-input"><span id="login-btn">'+args.okVal+'</span></div>';
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
            $("#usn, #psd").on("keypress", function(event){
                // alert(event.keyCode);
                if(event.keyCode == "13"){
                    args.ok();
                }
            });
        },

        alert : function(arg){
            showMask();
            var args = $.extend({}, options, arg);
            // var alert_str = '<div id="dlg" ><p id="dlg-cfm-title" >'+args.title+'</p><p id="dlg-cfm-cont">'+args.cont+'</p><span id="alt-btn">'+args.okVal+'</span></div>';
            var alert_str = '<div id="dlg" ><p id="dlg-cfm-title" >'+args.title+'</p><p id="dlg-alt-cont">'+args.cont+'</p></div>';
            body.append(alert_str);
            var alert_top = (w.height()-$("#dlg").height())/2,
                alert_left = (w.width()-$("#dlg").width())/2;
            $("#dlg").css({"height":args.height, "width":args.width, "top":alert_top, "left":alert_left});
            if(args.time){
                setTimeout(function(){
                    $("#mask,#dlg").remove();
                    window.location.href = window.location.href;
                }, args.time * 1000);
            }
        },

        confirm : function(arg){
            showMask();
            var args = $.extend({}, options, arg);
            var alert_str = '<div id="dlg"><p id="dlg-cfm-title">'+args.title+'</p><p id="dlg-cfm-cont">'+args.cont+'</p><span id="dlg-cfm-ok">'+args.okVal+'</span><span id="dlg-cfm-cancel">'+args.canVal+'</span></div>';
            body.append(alert_str);
            var cfg_top = (w.height()-args.height)/2,
                cfg_left = (w.width()-args.width)/2;

            $("#dlg").css({"height":args.height, "width":args.width, "top":cfg_top, "left":cfg_left});

            //确认操作
            $("#dlg-cfm-ok").on("click", args.ok);

            //取消操作
            if(args.cancel)
                $("#dlg-cfm-cancel").on("click", args.cancel);
            else
                cancel($("#dlg-cfm-cancel"));
        }
    });
})(jQuery, window)
