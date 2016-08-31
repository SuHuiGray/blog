(function($,undefined){
    'use strict';
    var old = $.fn.page,w = window,slice = Array.prototype.slice;
    var isFunc = function(obj){ return typeof(obj) === 'function'; };
    var isStr = function(obj){ return typeof(obj) === 'string'; };
    var isObj = function(obj){ return typeof(obj) === 'object'; };
    var Page = function(elem,options){
        var that = this,opts;
        that.$elem = $(elem);
        opts = that.opts = $.extend({}, $.fn.page.defaults, options);
        // 分组是否为一个数字
        opts.groups = parseInt(opts.groups);
        if (isNaN(opts.groups)) {
            throw new Error('Groups option is not correct!');
        }
        // 点击事件
        if (opts.onPageClick instanceof Function) {
            that.$elem.first().on('page', opts.onPageClick);
        }
        // 是否从指定地址栏找起始页
        if (opts.href) {
            var m, regexp = opts.href.replace(/[-\/\\^$*+?.|[\]]/g, '\\$&');
            regexp = regexp.replace(opts.hrefVariable, '(\\d+)');
            if ((m = new RegExp(regexp, 'i').exec(w.location.href)) != null) {
                opts.start = parseInt(m[1], 10);
            }
        }
        // 初始化容器
        var tagName = that.$elem.prop('tagName');
        that.$box = tagName === 'UL' ? that.$elem : $('<ul></ul>');

        // 添加样式
        that.$box.addClass(that.opts.theme);
        // 如果不是UL节点，把容器添加到当前节点
        if (tagName !== 'UL') {
            that.$elem.append(that.$box);
        }

        // 是否ajax请求
        that.isAjax =  opts.url != null && opts.start > 0;
        that._params = {};  // ajax请求的默认参数
        that._params[opts.sizename] = opts.size;
        if(opts.params){
            $.extend(that._params,opts.params);
        }
        that._oldparams = $.extend({},that._params);
        // 渲染
        that.show(opts.start);
        //that.render(that.getPages(that.opts.start,that.opts.total));
        // 设置事件
        this.setupEvents();
        return that;
    };
    Page.prototype = {
        constructor: Page,
        obj:function(){return this},
        // 销毁
        destroy: function () {
            var that = this;
            that.$elem.empty();
            that.$elem.removeData('xh-page');
            that.$elem.off('page');
            that._params = null;
            that._oldparams = null;
            that.total = null;
            return that;
        },
        // 建立分页条目
        buildItem: function (type, page) {
            var itemContainer = $('<li></li>'),
                itemContent = $('<a></a>'),
                itemText = null,that = this;
            switch (type) {
                case 'page':
                    itemText = page;
                    itemContainer.addClass(that.opts.pageClass);
                    break;
                case 'first':
                    itemText = that.opts.first;
                    itemContainer.addClass(that.opts.firstClass);
                    break;
                case 'prev':
                    itemText = that.opts.prev;
                    itemContainer.addClass(that.opts.prevClass);
                    break;
                case 'next':
                    itemText = that.opts.next;
                    itemContainer.addClass(that.opts.nextClass);
                    break;
                case 'last':
                    itemText = that.opts.last;
                    itemContainer.addClass(that.opts.lastClass);
                    break;
                default:
                    break;
            }

            itemContainer.data('page', page);
            itemContainer.data('page-type', type);
            itemContainer.append(itemContent.attr('href', this.makeHref(page)).html(itemText));
            return itemContainer;
        },
        buildListItems: function (pages) {
            var $listItems = $(),that = this;
            if (that.opts.first) {
                $listItems = $listItems.add(that.buildItem('first', 1));
            }

            if (that.opts.prev) {
                var prev = pages.page > 1 ? pages.page - 1 : that.opts.loop ? pages.total  : 1;
                $listItems = $listItems.add(that.buildItem('prev', prev));
            }

            for (var i = 0; i < pages.numeric.length; i++) {
                $listItems = $listItems.add(that.buildItem('page', pages.numeric[i]));
            }

            if (that.opts.next) {
                var next = pages.page < pages.total ? pages.page + 1 : that.opts.loop ? 1 : pages.total;
                $listItems = $listItems.add(that.buildItem('next', next));
            }

            if (that.opts.last) {
                $listItems = $listItems.add(that.buildItem('last', pages.total));
            }
            return $listItems;
        },
        getPages:function(page,total){
            var pages = [],that = this,opts = that.opts,groups;
            groups = total< opts.groups ? total : opts.groups;
            var half = Math.floor(groups / 2);
            var start = page - half + 1 - groups % 2;
            var end = page + half;

            // handle boundary case
            if (start <= 0) {
                start = 1;
                end = groups;
            }
            if (end > total) {
                start = total - groups + 1;
                end = total;
            }

            var itPage = start;
            while (itPage <= end) {
                pages.push(itPage);
                itPage++;
            }
            that.total = total;
            return {"page": page, "numeric": pages,"total":total};
        },
        render: function (pages) {
            var that = this;
            that.$box.children().remove();
            that.$box.append(that.buildListItems(pages));
            if(pages.page > pages.total) pages.page = pages.total;
            var children = that.$box.children();
            children.filter(function () {
                return $(this).data('page') === pages.page && $(this).data('page-type') === 'page';
            }).addClass(that.opts.activeClass);

            children.filter(function () {
                return $(this).data('page-type') === 'first';
            }).toggleClass(that.opts.disabledClass, pages.page === 1);

            children.filter(function () {
                return $(this).data('page-type') === 'last';
            }).toggleClass(that.opts.disabledClass, pages.page === pages.total);

            children.filter(function () {
                return $(this).data('page-type') === 'prev';
            }).toggleClass(that.opts.disabledClass, !that.opts.loop && pages.page === 1);

            children.filter(function () {
                return $(this).data('page-type') === 'next';
            }).toggleClass(that.opts.disabledClass, !that.opts.loop && pages.page === pages.total);
            // 小于1的时候，隐藏分页
            that.$elem[pages.total < 1 ? 'hide':'show']();
        },
        makeHref: function (c) {
            var that = this;
            return that.opts.href ? that.opts.href.replace(that.opts.hrefVariable, c) : "javascript:;";
        },
        setupEvents: function () {
            var base = this;
            this.$box.off('click');
            this.$box.find('li').off('click');
            this.$box.on('click','li',function(evt){
                var $this = $(this);
                if ($this.hasClass(base.opts.disabledClass) || $this.hasClass(base.opts.activeClass)) {
                    $this.click(function (evt) {
                        evt.preventDefault();
                    });
                    return;
                }
                // Prevent click event if href is not set.
                !base.opts.href && evt.preventDefault();
                var page = parseInt($this.data('page'), 10);
                base.$elem.trigger('page', page);
                base.show(page);
            });
        },
        param:function(name,value){
            var that = this;
            if(value !== undefined)
            {
                if(value === null)
                {
                    that._params[name] = null;
                    delete that._params[name];
                }else{
                    that._params[name] = value;
                }
                return that;
            }else
                return undefined === that._params[name] ? null : that._params[name];
        },
        reset:function(){
            var that = this;
            for(var i in that._params)
            {
                that._params[i] = null;
                delete that._params[i];
            }
            $.extend(that._params,that._oldparams);
            that._params = that._oldparams;
            return that;
        },
        reload:function(page){
            var that = this;
            page = page || that.param('page');
            that.show(page);
        },
        show: function (page) {
            var that = this,opts = that.opts;
            if(that.isAjax)
            {
                that._params[opts.pagename] = page;
                $.ajax({
                    url: opts.url,
                    dataType: 'json',
                    data: that._params,
                    beforeSend: function (xhr) {
                        if(isFunc(opts.before))opts.before(xhr);
                    },
                    complete: function (xhr, status) {
                        if(isFunc(opts.complete))opts.complete(xhr,status);
                    },
                    success: function (result) {
                        var total = 0;
                        if(result)
                        {
                            total = result[opts.resname];
                            total = total != null && total != undefined ? total : 0;
                        }
                        that.render(that.getPages(page,total));
                        if(total > 0 && opts.contrast && page > total)
                        {
                            that.reload(total); return !1;
                        }
                       if(isFunc(opts.success))opts.success.call(that,result,page);
                    }
                })
            }else{
                that.render(this.getPages(page,opts.total));
            }
            // that.$elem.trigger('page', page);
            return that;
        }
    };
    $.fn.page = function (option) {
        var args = slice.call(arguments, 1);
        var methodReturn;

        var $this = $(this);
        var data = $this.data('xh-page');
        var options = isObj(option) && option;

        if (!data) $this.data('xh-page', (data = new Page(this, options) ));
        if (isStr(option)) methodReturn = data[ option ].apply(data, args);

        return ( methodReturn === undefined ) ? $this : methodReturn;
    };


    $.fn.page.defaults = {
        total: 0,
        start: 1,
        groups: 10,
        href: false,
        contrast:false, // 是否比较，当ajax删除分页的数据时，页数还是当前页，但是数据只有2页的情况
        hrefVariable: '{{number}}',
        first: '首页',
        prev: '上一页',
        next: '下一页',
        last: '尾页',
        loop: false,
        onPageClick: null,
        theme: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled',
        url: null,
        params: null,
        success: null,
        before: null,
        complete: null,
        size:10,
        pagename: 'page',
        sizename: 'size',
        resname: 'total'
        /*ajax: {

        }*/
    };

    $.fn.page.Constructor = Page;

    $.fn.page.noConflict = function () {
        $.fn.page = old;
        return this;
    };
}(jQuery));