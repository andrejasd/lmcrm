/**
 * Created by tiger on 24.12.15.
 * dependency :
 *
 * --nessary :
 * jQuery
 * jQuery Validation Plugin - https://github.com/jzaefferer/jquery-validation
 * doT.js  - https://github.com/olado/doT // Template engine
 *
 * --custom (used in rules) :
 * Sortable - git://github.com/rubaxa/Sortable.git
 * Google maps -
 * - GMapInit - custom wrapper for google maps initialize with custom elements
 * -- MarkerClusterer for Google Maps - https://googlemaps.github.io/js-marker-clusterer/docs/reference.html
 * Bootbox - https://github.com/makeusabrew/bootbox // Wrappers for JavaScript alert(), confirm() and other flexible dialogs using Twitter's bootstrap framework http://bootboxjs.com
 * CkFinder - https://cksource.com/ckfinder
 *
 */

(function($) {
    "use strict";

    var jSplash = function(container,options) {
        var _this = this;
        this.raw = [];
        this._initialized = false;
        this.$container = $(container);
        this.counter = 0;

        this.option = { // default options
            modal: '#modal-page',
            form: '.jSplash-form',
            event: {
                onShow : null,
                onEdit : null,
                onModal : null,
            }
        };

        this._construct = function (options) {
            this._initialized = true;
            this.helper._extend(options, this.option);
        };


        // --- Model ---//
        this.model = {
            db : {},
            load : function (data) {
                _this.raw = $.extend(true, {}, data);
                model.db = data;
            },
            save : function (data, index) {
                var index = (index || index === 0) ? index : false;
                var new_data = {};
                // extend new values by existing one
                if (data.entity.renderType == 'group') {
                    new_data = data.entity.values[index] || {};
                }
                if (data.entity.variables) {
                    for (var i in data.entity.variables) {
                        if (!data.entity.variables[i]) {
                            continue;
                        }
                        new_data[i] = data.entity.variables[i].values; // extend new values by existing one
                        for (var j in data.values) {
                            if (i == data.values[j].name || i == data.values[j].name.replace(/^jsp\d+-/g,'')) {
                                new_data[i] = data.values[j].value;
                                break;
                            }
                        }
                    }
                    if (!data.entity.values) {
                        data.entity.values = new Array()
                    }
                    ;
                    if (index === false) {
                        if(!data.entity.values) { data.entity.values=[]; }
                        data.entity.values.push(new_data);
                    } else {
                        data.entity.values[index] = new_data;
                    }
                } else {
                    new_data = null;
                    for (var j in data.values) {
                        if (data.entity.name == data.values[j].name) {
                            new_data = data.values[j].value;
                            break;
                        }
                    }
                    data.entity.values = new_data;
                }
                this.onSave();
            },
            store_array: function(data,index) {
                var index = (index || index === 0) ? index : false;
                var new_data = {};
                if(index !== false) {
                    if(typeof data.entity.values!='object') {
                        if(typeof data.entity.values=='string') {
                            data.entity.values = [];
                        } else {
                            data.entity.values = [data.entity.values];
                        }
                    }
                    // extend new values by existing open
                    new_data = data.entity.values[index] || {};
                    new_data = {};
                    for (var j in data.values) {
                        new_data[j] = data.values[j];
                    }
                    data.entity.values[index] = new_data;
                } else {
                    new_data = data.values;
                    if(!data.entity.values) { data.entity.values=[]; }
                    data.entity.values.push(new_data);
                }
                this.onSave();
            },
            delete_array : function (data, index) {
                var index = (index || index === 0) ? index : false;
                if (index !== false) {
                    data.entity.values.splice(index,1);
                    //delete data.entity.values[index];
                }
                return true;
            },
            delete : function (data, index) {
                var index = (index || index === 0) ? index : false;
                if (data.entity.variables) {
                    if (index === false) {
                        ;
                    }
                    else {
                        //data = null;
                        if(data.entity.values[index].id){
                            data.entity.values[index]._status = 'DELETE';
                        } else {
                            delete data.entity.values[index];
                        }
                    }
                }
                else {
                    data.entity.values = [];
                }
                return true;
            },
            serialize : function (db) {
                var db = db || _this.model.db;
                var json = {};
                var flag = false;
                var pos = {};

                if (typeof db == 'object') {
                    for (var i in db) {
                        flag = false;

                        if (!flag && Object.prototype.toString.call(db) === '[object Array]' && typeof db[i] == 'object') {
                            var res = _this.model.serialize(db[i]);
                            //json[i] = $.extend(true,{},res);
                            for (var k in res) {
                                if (!pos[k]) {
                                    pos[k] = 0;
                                }
                                pos[k]++;
                                json[i] = $.extend(true, {}, res[k]);
                                if (json[i]['targetEntity']) {
                                    json[i]['variables'] = json[i]['variables'] || {};
                                }
                                json[i]['position'] = pos[k];
                            }
                            flag = true;
                        }
                        else {
                            json[i] = {};
                            if (!db[i]) {
                                json[i] = null;
                                continue;
                            }

                            if (db[i].hasOwnProperty('targetEntity')) {
                                json[i].targetEntity = db[i]['targetEntity'];
                                if(db[i]['id']){ json[i].id = db[i]['id'] || null; }
                                json[i]['variables'] = json[i]['variables'] || {};
                                flag = true;
                            } else {
                                json[i] = '';
                            }

                            if (db[i].hasOwnProperty('values')) {
                                if (Object.prototype.toString.call(db[i].values) === '[object Array]') {
                                    db[i].values = (!db[i].values.length) ? '' : db[i].values;
                                }
                                if (db[i].values || db[i].values === 0 || db[i].values === false || db[i].values === '') {
                                    if (!db[i].hasOwnProperty('targetEntity')) {
                                        json[i] = db[i]['values'];
                                    } else {
                                        json[i]['variables'] = _this.helper._deepCopy(db[i]['values']);
                                        if (!json[i]['variables'] || json[i]['variables'] == []) {
                                            json[i]['variables'] = {};
                                        }
                                    }
                                }
                                flag = true;
                            }
                            if (db[i].hasOwnProperty('variables')) {
                                var res = _this.model.serialize(db[i]['variables']);
                                if (typeof res == 'object') {
                                    if (_this.helper._objLength(res) && db[i].targetEntity) {
                                        var tVar = res;
                                        json[i]['variables'] = (_this.helper._objLength(json[i]['variables'])) ? $.extend(true, {}, json[i]['variables']) : res;
                                        for (var k in tVar) { // copy children values
                                            if (Object.prototype.toString.call(tVar[k]) === '[object Array]') {
                                                tVar[k] = (!tVar[k].length) ? '' : tVar[k];
                                            }
                                            if (tVar[k] || tVar[k] === 0 || tVar[k] === false || tVar[k] === '') {
                                                //json[i]['variables'] = $.extend(true, {}, json[i]['variables'], tVar[k]);
                                                for (var kj in json[i]['variables']) {
                                                    if (kj == k) {
                                                        json[i]['variables'][k] = tVar[k];
                                                    }
                                                    ;
                                                }
                                                if (_this.helper._objLength(tVar[k])) {
                                                    json[i]['variables'][k] = tVar[k];
                                                }
                                            }
                                        }
                                        flag = true;
                                    }
                                    else {
                                        json[i]['variables'] = json[i]['variables'] || {};
                                        flag = flag || false;
                                    }
                                }
                                else {
                                    json[i]['variables'] = json[i]['variables'] || {};
                                    flag = true;
                                }
                            }
                            if (db[i].hasOwnProperty('renderType')) {
                                switch (db[i]['renderType']) {
                                    case 'group':
                                        for (var k in json[i]['variables']) {
                                            if (!(k >= 0 || k < 0)) { // not initialized entity val
                                                //json[i]['variables'] = {0:_this.helper._deepCopy(json[i]['variables'])};
                                                json[i]['variables'] = [];
                                                break;
                                            }
                                        }
                                        break;
                                    default:
                                        ;
                                }

                            }

                            if (json[i] === false) {
                                json[i] = null;
                            }
                            //if(!flag) { json[i]=null; }
                        }
                    }
                }

                return json;
            },
            onSave : function(){
                _this.afterEdit() ;
            },
        };
        var model = this.model;

        this.tmpl = {

            render : function (data, context, params) {
                var data = data || _this.model.db;
                var context = context || 'show';
                var params = params || []; // for chain || maybe remove in future
                var type = true;
                var $html = $('<root/>');
                if (data.renderType) {
                    data = [data];
                }
                for (var i in data) {
                    if (!data[i]) {
                        continue;
                    }

                    if (_this.helper._objLength(data[i]) == 1) { //Array of objects (first-level config sceleton)
                        $html = $html.append(tmpl.render(data[i], context));
                    } 
                    else {
                        if(_this._autodata[data[i].renderType]) {
                            data[i].variables = _this.helper._extend(_this._autodata[data[i].renderType],data[i].variables||{});
                        }

                        if (data[i].settings) {
                            type = (data[i].settings.view) ? data[i].settings.view[context] : false;
                            switch (context) {
                                case 'show':
                                    type = type || params.chain;
                                    type = type || 'default.' + ( data[i].settings.type || data[i].renderType );
                                    break;
                                case 'modal':
                                case 'edit':
                                    type = type || 'modal.' + ( data[i].settings.type || data[i].renderType );
                                    break;
                                default:
                                    type = false;
                            }
                            ;
                        } else {
                            type = 'default.container';
                        }
                        //if (data[i].renderType && (data[i].renderType == 'container' || data[i].renderType == 'group') && data[i].variables) {
                        if (data[i].variables) {
                            data[i].chain = tmpl.render(data[i].variables, context, {values: data[i].values || []});
                        } else {
                            data[i].chain = null;
                        }

                        if (!data[i].values && params.values) {
                            data[i].values = false;
                            for (var j in params.values) {
                                if (j == data[i].name && params.values[j]._status != 'DELETE') {
                                    data[i].values = params.values[j];
                                    break;
                                }
                            }
                        }

                        $html.append(tmpl.renderItem(type || true, data[i], context));

                        if (data[i].chain) {
                            if ($html.find('chain').length) {
                                $html.find('chain').after(data[i].chain).remove();
                            }
                        }
                    }
                }
                $html = $(document.createDocumentFragment()).append($html.contents().unwrap());
                return $html;
            },

            show : function (data, element, context) {
                var $element = (element) ? $(element) : _this.$container;
                var context = context || 'show';
                var data = data || _this.model.db;
                var $html = tmpl.render(data, context);
                $element.html('').append($html);
                return tmpl;
            },

            renderItem : function (type, data, context) {
                var data = data || {};
                if(data.hasOwnProperty('name')) {
                    data['name'] = 'jsp'+_this.counter+'-'+data['name'].replace(/^jsp\d+-/g,'');
                    _this.counter++;
                }
                var context = context || 'show';
                var $html = $('<root/>');
                switch (type) {
                    case 'list.sortable':
                        var ls_settings = data.settings['list.sortable'] || {};
                        var cdata = {};
                        cdata.data = data.values || [];
                        if (ls_settings.title) {
                            var tmpl_data = [];
                            for (var j in data.values) {
                                var list_title = '';
                                list_title += '<span>';
                                for (var i in ls_settings.title) {
                                    var tdata = '';
                                    switch (typeof(data.values[j])) {
                                        case 'object':
                                            if (data.values[j].hasOwnProperty(ls_settings.title[i])) {
                                                tdata = data.values[j][ls_settings.title[i]];
                                            } else {
                                                tdata = data.values[j][i];
                                            }
                                            break;
                                        default:
                                            tdata = data.values[j];
                                    }
                                    ;
                                    list_title += tdata + ' ';
                                }
                                list_title += '</span>';
                                tmpl_data.push(list_title);
                            }
                            cdata.data = tmpl_data;
                        }
                        ;
                        cdata.controls = ['move', 'edit', 'delete'];
                        if (ls_settings.controls) {
                            var tmpl_data = [];
                            for (var i in ls_settings.controls) {
                                tmpl_data.push(ls_settings.controls[i]);
                            }
                            cdata.controls = tmpl_data;
                        }
                        data.tmpl = cdata;
                        $html.append($(doT.template(tmpl.view(type))(data)));
                        _this.tmpl.addRule('modal.create', $html.find('.splash-create'), data, []);

                        $html.find('.splash-edit').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'modal.edit', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        $html.find('.splash-delete').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'value.delete', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        _this.tmpl.addRule('sortable', $html.find('.sortable'), data, null, {key: 'position'});
                        break;
                    case 'list.gallery':
                        var ls_settings = data.settings['list.gallery'] || {};
                        var cdata = {};
                        cdata.data = data.values || [];

                        var tmpl_data = [];
                        for (var j in data.values) {
                            var list_title = '';
                            list_title += '<span>';
                            list_title += '<img src="' + data.values[j].img + '" class="max-width-150 max-height-150">'
                            list_title += '</span>';
                            tmpl_data.push(list_title);
                        }
                        cdata.data = tmpl_data;

                        cdata.controls = ['move', 'edit', 'delete'];
                        if (ls_settings.controls) {
                            var tmpl_data = [];
                            for (var i in ls_settings.controls) {
                                tmpl_data.push(ls_settings.controls[i]);
                            }
                            cdata.controls = tmpl_data;
                        }
                        data.tmpl = cdata;
                        $html.append($(doT.template(tmpl.view('list.gallery'))(data)));
                        _this.tmpl.addRule('modal.gallery.create', $html.find('.splash-create'), data, []);
                        $html.find('.splash-edit').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'modal.gallery.edit', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        $html.find('.splash-delete').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'value.delete', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        _this.tmpl.addRule('sortable', $html.find('.sortable'), data, null, {key: 'position'});
                        break;
                    case 'container.gmap':
                        var ls_settings = data.settings['list.gallery'] || {};
                        $html.append($(doT.template(tmpl.view(type))(data)));
                        if (data.variables) {
                            data.chain = tmpl.render(data.variables, context, {values: data.values || []});
                            if ($html.find('chain').length) {
                                $html.find('chain').after(data.chain).remove();
                            }
                        }
                        var param = {};
                        param.lat = (ls_settings['lat']) ? ls_settings['lat'] : '[name="lat"]';
                        param.lon = (ls_settings['lon']) ? ls_settings['lon'] : '[name="lon"]';
                        _this.tmpl.addRule('gmap', $html, null, [], param);

                        break;
                    case 'form.dynamic':
                        var ls_settings = data.settings['form.dynamic'] || {};
                        var cdata = {};
                        cdata.data = data.values || [];
                        var tmpl_data = [];
                        for (var j in data.values) {
                            if(data.values[j]._status=='DELETE') { continue; }
                            var list_title = doT.template(tmpl.view('form.field'))(data.values[j]);
                            tmpl_data.push(list_title);
                        }
                        cdata.data = tmpl_data;

                        cdata.controls = ['move', 'edit', 'delete'];
                        if (ls_settings.controls) {
                            var tmpl_data = [];
                            for (var i in ls_settings.controls) {
                                tmpl_data.push(ls_settings.controls[i]);
                            }
                            cdata.controls = tmpl_data;
                        }
                        cdata.fields = {};
                        var fl_settings = data.settings['fields'] || false;
                        if (fl_settings) {
                            var tmpl_data = {};
                            for (var i in fl_settings) {
                                var key = fl_settings[i];
                                tmpl_data[key] = true;
                            }
                            cdata.fields = tmpl_data;
                        } else {
                            cdata.fields['all']=true;
                        }
                        data.tmpl = cdata;
                        $html.append($(doT.template(tmpl.view('form.dynamic'))(data)));

                        _this.tmpl.addRule('sortable', $html.find('.sortable'), data, null, {key: 'position'});
                        _this.tmpl.addRule('form.dynamic.before_create', $html.find('.splash-create'), data, []);
                        $html.find('.splash-edit').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'form.dynamic.edit', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        $html.find('.splash-delete').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'value.delete', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        break;
                    case 'form.attributes':
                        var ls_settings = data.settings['form.attributes'] || {};
                        var cdata = {};
                        cdata.data = data.values || [];
                        var tmpl_data = [];
                        for (var j in data.values) {
                            if(data.values[j]._status=='DELETE') { continue; }
                            var list_title = doT.template(tmpl.view('attributes.field'))(data.values[j]);
                            tmpl_data.push(list_title);
                        }
                        cdata.data = tmpl_data;

                        cdata.controls = ['move', 'edit', 'delete'];
                        if (ls_settings.controls) {
                            var tmpl_data = [];
                            for (var i in ls_settings.controls) {
                                tmpl_data.push(ls_settings.controls[i]);
                            }
                            cdata.controls = tmpl_data;
                        }
                        cdata.fields = {};
                        var fl_settings = data.settings['fields'] || false;
                        if (fl_settings) {
                            var tmpl_data = {};
                            for (var i in fl_settings) {
                                var key = fl_settings[i];
                                tmpl_data[key] = true;
                            }
                            cdata.fields = tmpl_data;
                        } else {
                            cdata.fields['all']=true;
                        }
                        data.tmpl = cdata;
                        $html.append($(doT.template(tmpl.view('form.attributes'))(data)));

                        _this.tmpl.addRule('sortable', $html.find('.sortable'), data, null, {key: 'position'});
                        _this.tmpl.addRule('form.attributes.before_create', $html.find('.splash-create'), data, []);
                        $html.find('.splash-edit').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'form.attributes.edit', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        $html.find('.splash-delete').each(function (i, value) {
                            return function (idx, $context) {
                                _this.tmpl.addRule(/*type */'value.delete', /*context*/ $context, /*entity*/ data, /*data*/ data.values[idx], /*params*/{index: idx});
                            }(i, $(this));
                        });
                        break;
                    case 'default.statuses':
                        var $container = $(doT.template(tmpl.view(type))(data));
                        $html.append($container);
                        $container.find("input,textarea,select").change(function(){
                            var $elements = $(this).closest('.row').find("input,textarea,select");
                            var indx = $(this).closest(".row-container").find(".duplicated").index($(this).closest('.row'));
                            return _this.route.get('default.statuses', data, {index:indx, elements:$elements});
                        });
                        $container.find(".btn-duplicate-remove").click(function(){
                            var indx = $(this).closest(".row-container").find(".duplicated").index($(this).closest('.row'));
                            return _this.route.get('delete_array', data, {index:indx});
                        });
                        _this.tmpl.addRule('duplicate_option', $container,null,null,null);
                        break;
                    case 'default.icon':
                    case 'modal.icon':
                        $html.append($(doT.template(tmpl.view(type))(data)));
                        _this.tmpl.addRule('icon.change', $html.find('.select-icon'), data);
                        break;
                    case 'default.text':
                    case 'default.textarea':
                    case 'default.select':
                    case 'default.upload':
                        $html.append($(doT.template(tmpl.view(type))(data)));
                        _this.tmpl.addRule('value.edit', $html.find('input,textarea,select'), data);
                        break;
                    case 'default.checkbox':
                        $html.append($(doT.template(tmpl.view(type))(data)));
                        _this.tmpl.addRule('checkbox.change', $html.find('input[type="checkbox"]'), data);
                        break;
                    case 'default.image':
                    case 'modal.image':
                        $html.append($(doT.template(tmpl.view(type))(data)));
                        _this.tmpl.addRule('image.change', $html.find('.image-editable .edit'), data);
                        _this.tmpl.addRule('image.delete', $html.find('.image-editable .delete'), data);
                        break;
                    default: //* --- no aditional rules, just render  --- *//
                        $html.append($(doT.template(tmpl.view(type))(data)));
                }
                $html = $(document.createDocumentFragment()).append($html.contents().unwrap());
                return $html;
            },

            view : function (path) {
                var path = path;
                var view=false;
                if(_this.tmpl_defered[path]) {
                    view = _this.tmpl_defered[path];
                } else {
                    if (typeof path === "string") {
                        path = path.split(".");
                    }
                    if (!(path instanceof Array) || path.length === 0) {
                        return;
                    }
                    var view = tmpl.viewes;
                    for (var i in path) {
                        if (view.hasOwnProperty(path[i])) {
                            view = view[path[i]];
                        } else {
                            return tmpl.viewes.clean;
                        }
                    }
                }
                if (typeof view == 'string') {
                    return view;
                }
                else if (typeof view == 'function') {
                    return view();
                }
                return '';
            },

            defered : {},

            viewes : { // this - reference to current object
                modal: {
                    open: '<div><chain><!--{ {=it.chain} }--></chain></div>',

                    container: '<div><chain><!--{ {=it.chain} }--></chain></div>',
                    group: '<chain><!--{ {=it.chain} }--></chain>',

                    text: function () {
                        return tmpl.view('default.text');
                    },
                    textarea: function () {
                        return tmpl.view('default.textarea');
                    },
                    image: function () {
                        return tmpl.view('default.image');
                    },
                    icon: function () {
                        return tmpl.view('default.icon');
                    },
                    select: function () {
                        return tmpl.view('default.select');
                    },
                    checkbox: function () {
                        return tmpl.view('default.checkbox');
                    },
                },
                //clean:'{{=it}}{{?it.chain}}<chain><!--{ {=it.chain} }--></chain>{{?}}'
                clean: ''
            },

            // Rules - events in render
            addRule : function (rule, context, entity, data, params) {
                if (!rule) {
                    return false;
                }
                var $context = (typeof context == 'object') ? context : $(context) || _this.$container;
                var data = data || [];
                var params = params || {};

                var _result = true;
                switch (rule) {
                    case 'icon.change':                        
                        $context.on('click', function(sdata, params){
                            return function(){
                                params.$icon = $(this).find('.img-container');
                                params.$input = $(this).parent().parent().parent().find('input[type=text]');
                                _this.route.get('icon.change', sdata, params);
                            }
                                                    
                        }({entity: entity, values: null}, params));
                        break;
                    case 'sortable':
                        $context.each(function (index) {
                            var list = Sortable.create($context.get(index), {
                                handle: '.glyphicon-move',
                                animation: 150,
                                onSort: function (/**Event*/evt) {
                                    _this.route.get('position.update', entity, {
                                        oldIndex: evt.oldIndex,
                                        newIndex: evt.newIndex
                                    });
                                }
                            });
                        });
                        break;
                    case 'modal.create':
                    case 'modal.edit':
                    case 'modal.gallery.create':
                    case 'modal.gallery.edit':
                        if (!entity) {
                            return false;
                        }
                        $context.on('click', function (route, sdata, params) {
                            return function () {
                                _this.route.get(rule, sdata, params);
                            }
                        }(rule, entity, {index: params['index'], values: data}));
                        break;
                    case 'form.dynamic.edit': case 'form.attributes.edit':
                        if (!entity) { return false; }
                        $context.on('click', function (rule, sdata, params) {
                            return function () {
                                _this.route.get(rule, sdata, params);
                            }
                        }(rule, entity, {index: params['index'], values: data}));
                        break;
                    case 'form.dynamic.before_create': case 'form.attributes.before_create':
                        if (!entity) { return false; }
                        $context.on('click', function (rule, sdata, params) {
                            return function () {
                                _this.route.get(rule, sdata, null);
                            }
                        }(rule, entity, {}));
                        break;
                    case 'form.dynamic.create': case 'form.attributes.create':
                        if (!entity) { return false; }
                        (function(rule, sdata, params) {
                            $context.on('change', function () {
                                if($(this).val()) {
                                    _this.route.get(rule, sdata, $(this).val());
                                } else {
                                    return true;
                                }
                            })
                        })(rule, entity, {});
                        break;
                    case 'value.edit':
                        $context.on('change', function (sdata, params) {
                            return function () {
                                if (!params) {
                                    params = {};
                                }
                                params.values = $(this).serializeArray();
                                _this.route.get('update', sdata, params);
                            }
                        }({entity: entity, values: null}, params));
                        break;
                    case 'value.delete':
                        $context.on('click', function (sdata, params) {
                            return function () {
                                bootbox.confirm(trans('delete_message'), function (result) {
                                    if (result) {
                                        _this.route.get('delete', sdata, params);
                                    }
                                });
                            }
                        }({entity: entity, values: null}, params));
                        break;
                    case 'image.delete':
                        $context.on('click', function (sdata, params) {
                            return function () {
                                params.$img = $(this).closest('.image-editable').children('img').first();
                                bootbox.confirm(trans('delete_message'), function (result) {
                                    if (result) {
                                        _this.route.get('delete', sdata, params);
                                    }
                                });
                            }
                        }({entity: entity, values: null}, params));
                        break;
                    case 'checkbox.change':
                        $context.on('change', function (sdata, params) {
                            return function () {
                                if (!params) {
                                    params = {};
                                }
                                params.entityval = ($(this).is(':checked')) ? 1 : 0;
                                _this.route.get('update', sdata, params);
                                return true;
                            }
                        }({entity: entity, values: null}, params));
                        break;
                    case 'image.change':
                        $context.on('click', function (sdata, params) {
                            return function () {
                                params.$img = $(this).closest('.image-editable').children('img').first();
                                _this.route.get('image.change', sdata, params);
                            }
                        }({entity: entity, values: null}, params));
                        break;
                    case 'split_option':
                        $context.find('.btn-split').click(function() {
                            var $newItem =  $context.find('.duplicate').first()
                                .clone(true).removeClass('hidden').addClass('duplicated')
                                .insertAfter($(this).closest('.duplicated'));
                            $newItem
                                .find('.data').attr('name', $newItem.find('.data').first().data('name'));
                            $newItem
                                .find('input,select').val(null);

                            $newItem.find('.data').first().after(
                                $('<input type="hidden" class="extend name-ignore" value="" data-name="parent" />')
                                    .val($(this).closest('.duplicated').find('.data').first().data('id'))
                            );
                            $(this).closest('.duplicated').find('.data').first().after(
                                $('<input type="hidden" class="extend name-ignore" value="1" data-name="split" />')
                            );
                        });
                        break;
                    case 'duplicate_option':
                        $context.find('.btn-duplicate-add').click(function() {
                            var $newItem =  $context.find('.duplicate').first()
                                .clone(true).removeClass('hidden').addClass('duplicated')
                                .insertAfter($context.find('.duplicate').last());
                            $newItem
                                .find('.data').attr('name', $newItem.find('.data').first().data('name'));
                            $newItem
                                .find('input,select').val(null);

                            $newItem.find('.random-name').each(function(){
                                var rID = Math.floor((Math.random() * 1000) + 1);
                                $(this).attr('name','jsp-'+rID);
                                $newItem.find(".mediabrowser-js").each(function(){
                                    $(this).attr('href',$(this).attr('href')+'jsp-'+rID);
                                });
                            });
                        });
                        $context.find('.duplicate').each(function(){
                            (function($item){
                                $item.find('.select').change(function() {
                                    if( $(this).data('extend') || $(this).find("option:selected").data('extend') ) {
                                        $(this).closest('.duplicated').find('input').prop( "disabled", false );
                                    } else {
                                        $(this).closest('.duplicated').find('input').prop( "disabled", true).val(null);
                                    }
                                    $(this).closest('.duplicated').find('.data').val(
                                        $(this).val()
                                    );
                                });
                                $item.find('.btn-duplicate-remove').click(function() {
                                     $(this).closest('.duplicated').remove();
                                });
                                /*
                                $item.find('input.extend').change(function(){
                                    var $hidden = $(this).closest('.duplicated').find('.data'),
                                        $select = $(this).closest('.duplicated').find('.select').first();

                                    $hidden.val($select.val()+'['+$(this).val()+']');
                                });
                                */
                            })($(this));
                        });
                        break;
                    case 'validate':
                        var validator = null;
                        // Neon like validation init
                        if($context.data("validator")) {
                            validator = $context.data("validator");
                            //break;
                        }
                        var opts = {
                            debug: false,
                            rules: {},
                            messages: {},
                            errorElement: 'span',
                            errorClass: 'validate-has-error',
                            highlight: function (element) {
                                $(element).closest('.form-group').addClass('validate-has-error');
                            },
                            unhighlight: function (element) {
                                $(element).closest('.form-group').removeClass('validate-has-error');
                            },
                            errorPlacement: function (error, element) {
                                if (element.closest('.has-switch').length) {
                                    error.insertAfter(element.closest('.has-switch'));
                                }
                                else if (element.parent('.checkbox, .radio').length || element.parent('.input-group').length) {
                                    error.insertAfter(element.parent());
                                }
                                else {
                                    error.insertAfter(element);
                                }
                            },
                            submitHandler: function (form) {
                                return false;
                            },
                            invalidHandler: function (event, validator) {
                                ;
                            }
                        };

                        var $fields = $context.find('[data-validate]');
                        $fields.each(function (j, el2) {
                            var $field = $(el2),
                                name = $field.attr('name'),
                                validate = $field.attr('validate') ? $field.attr('validate').toString() : '',
                                _validate = validate.split(',');

                            for (var k in _validate) {
                                var rule = _validate[k],
                                    params,
                                    message;

                                if (typeof opts['rules'][name] == 'undefined') {
                                    opts['rules'][name] = {};
                                    opts['messages'][name] = {};
                                }

                                if ($.inArray(rule, ['required', 'url', 'email', 'number', 'date', 'digits', 'dateISO', 'creditcard']) != -1) {
                                    opts['rules'][name][rule] = true;

                                    message = $field.data('message-' + rule);

                                    if (message) {
                                        opts['messages'][name][rule] = message;
                                    }
                                }
                                // Parameter Value (#1 parameter)
                                else if (params = rule.match(/(\w+)\[(.*?)\]/i)) {
                                    if ($.inArray(params[1], ['min', 'max', 'minlength', 'maxlength', 'equalTo']) != -1) {
                                        opts['rules'][name][params[1]] = params[2];


                                        message = $field.data('message-' + params[1]);

                                        if (message) {
                                            opts['messages'][name][params[1]] = message;
                                        }
                                    }
                                }
                                if(validator) {
                                    var field_opt = opts['rules'][name];
                                        field_opt.messages = opts['messages'][name];
                                    $field.rules('add',field_opt);
                                }
                            }
                        });
                        // remove old validator and set new one
                        if(validator) {
                            ;// aditional rules already added
                        } else {
                            validator = $context.validate(opts);
                        }
                        _result = validator;
                        break;
                    case 'gmap':
                        var gmap_opt = {};
                        if($context.find('.map-search').length) {
                            gmap_opt.searchBox = $context.find('.map-search').first()[0];
                        } else {
                            break;
                        }
                        gmap_opt.searchBoxHighlignt = {
                            lat: $context.find(params.lat),
                            lng: $context.find(params.lon),
                            syncOnInit: true
                        };
                        var $map = $context.find('.map-render').first();

                        if (typeof google === 'object' && typeof google.maps === 'object') {
                            $map.GMapInit(gmap_opt);
                        } else {
                            $.getScript("https://maps.googleapis.com/maps/api/js?libraries=places", function () {
                                $map.GMapInit(gmap_opt);
                            });
                        }
                        break;
                    default:
                        _result = false;
                }

                return _result;
            },
        };
        var tmpl = this.tmpl;

        this.route =  {
            get : function (alias, data, params) {
                var data = data || null;
                var result = false;
                switch (alias) {
                    case 'modal.create':
                        result = _this.controller.modal_open(data, {do: 'create', values: params.values});
                        break;
                    case 'modal.edit':
                        result = _this.controller.modal_open(data, {
                            do: 'edit',
                            index: params.index,
                            values: params.values
                        });
                        break;
                    case 'modal.gallery.create':
                        result = _this.controller.modal_gallery_open(data, {do: 'create', values: params.values});
                        break;
                    case 'modal.gallery.edit':
                        result = _this.controller.modal_gallery_open(data, {
                            do: 'edit',
                            index: params.index,
                            values: params.values
                        });
                        break;
                    case 'default.statuses':
                        result = _this.controller.dynamic_statuses_save(data, params)
                        break;
                    case 'form.attributes.before_create':
                        result = _this.controller.dynamic_form_attr_preopen(data, params);
                        break;
                    case 'form.attributes.create':
                        result = _this.controller.dynamic_form_attr_open(data, {
                            do: 'store_array',
                            ftype: params
                        });
                        break;
                    case 'form.attributes.edit':
                        result = _this.controller.dynamic_form_attr_open(data, {
                            do: 'edit_array',
                            ftype: params.index,
                            values: params.values
                        });
                        break;
                    case 'form.dynamic.before_create':
                        result = _this.controller.dynamic_form_preopen(data, params);
                        break;
                    case 'form.dynamic.create':
                        result = _this.controller.dynamic_form_open(data, {
                            do: 'store_array',
                            ftype: params
                        });
                        break;
                    case 'form.dynamic.edit':
                        result = _this.controller.dynamic_form_open(data, {
                            do: 'edit_array',
                            ftype: params.index,
                            values: params.values
                        });
                        break;
                    case 'create':
                        result = _this.controller.store(data);
                        break;
                    case 'store_array':
                        result = _this.controller.store_array(data,params);
                        break;
                    case 'delete_array':
                        result = _this.controller.delete_array(data,params);
                        break;
                    case 'edit_array':
                        result = _this.controller.store_array(data,params);
                        break;
                    case 'edit':
                        result = _this.controller.save(data, params);
                        break;
                    case 'position.update':
                        result = _this.controller.position_update(data, params);
                        break;
                    case 'update':
                        params.index = data.entity.name;
                        result = _this.controller.update(data, params);
                        break;
                    case 'delete':
                        if (typeof params.index !== "number" && !params.index) params.index = data.entity.name;
                        result = _this.controller.delete(data, params);
                        break;
                    case 'image.change':
                        result = _this.controller.image_ck(data, params);
                        break;
                    case 'icon.change':
                        result = _this.controller.icon_select(data, params);
                        break;
                    default:
                        ;
                }
                return result;
            }

        };
        var route = this.route;

        this.controller = {
            modal_open : function (sdata, param) {
                if (param.values) for (var j in sdata.variables) {
                    if (!sdata.variables[j]) {
                        continue;
                    }
                    if (param.values.hasOwnProperty(sdata.variables[j].name)) {
                        sdata.variables[j].values = param.values[sdata.variables[j].name];
                    } else {
                        sdata.variables[j].values = param.values[j];
                    }
                }
                _this.tmpl.show(sdata, $(_this.option.modal).find('.modal-body'), 'edit');

                var validator = _this.tmpl.addRule('validate', $(_this.option.modal).find('form.validate'));
                $(_this.option.modal).find('.btn-save').off().on('click', function (validator) {
                    return function () {
                        if (validator.form()) {
                            var $modal = $(this).closest('.modal');
                            var data={};
                            $.each($modal.find('input,textarea,select'), function(i, obj) {
                                if(obj.name && !$(obj).hasClass('name-ignore') ) {
                                    var $extend = $(obj).closest('.duplicate').find('input.extend:not([data-name])');
                                    var ext = null;
                                    if($extend.length>1) {
                                        ext = [];
                                        for(var i=0;i<$extend.length;i++){
                                            ext[i]= ($extend.eq(i).attr('type') == 'checkbox' || $extend.eq(i).attr('type') == 'radio') ? (($extend.eq(i).is(':checked')) ? 1 : 0) : $extend.eq(i).val();
                                        }
                                    } else {
                                        ext = ($extend.attr('type') == 'checkbox' || $extend.attr('type') == 'radio') ? (($extend.is(':checked')) ? 1 : 0) : $extend.val();
                                    }
                                    if($(obj).attr('type')=='radio' || $(obj).attr('type')=='checkbox') {
                                        if(!$(obj).is(':checked')) { return true; }
                                    }
                                    var cdata = {};
                                    if($(obj).val()) {
                                        if($(obj).data('type')=='record') {
                                            cdata={'id':$(obj).data('id')||0,'val':$(obj).val(), 'vale': ext};
                                        } else {
                                            cdata=$(obj).val()+((ext)? '['+ext+']' : '');
                                        }
                                    }
                                    var $extend = $(obj).closest('.duplicate').find('input.extend[data-name]');
                                    for(var i=0;i<$extend.length;i++){
                                        var $ext = $extend.eq(i);
                                        cdata[$ext.data('name')] = $ext.val();
                                    }
                                    if($(obj).val()) {
                                        if (data[obj.name]) {
                                            if (Object.prototype.toString.call(data[obj.name]) !== '[object Array]') {
                                                data[obj.name] = [data[obj.name]];
                                            }
                                            data[obj.name].push(cdata);
                                        } else {
                                            data[obj.name]= cdata;
                                        }
                                    }
                                }
                            });
                            var store_data = data;
                            store_data['_type'] = fdata.cf.name.replace(/^jsp\d+-/g,'');

                            if (_this.route.get(param.do, {entity: sdata, values: store_data}, index)) {
                                $modal.modal('hide');
                                _this.route.get('position.update', sdata, {oldIndex: 0, newIndex: 0});
                            }

                            //*------------------------------------------------------------------------------
/*
                            var $modal = $(this).closest('.modal');
                            var data = $modal.find('input,textarea,select').serializeArray();
                            if (_this.route.get(param.do, {entity: sdata, values: data}, param)) {
                                $modal.modal('hide');
                            }
                            _this.route.get('position.update', sdata, {oldIndex: 0, newIndex: 0});
*/
                        }
                    };
                }(validator));

                $(_this.option.modal)
                    .one('hide.bs.modal', function (e) {
                        var $modal = $(this).closest('.modal');
                        $modal.find('.modal-body').html('').empty();
                    })
                    .modal('show', {backdrop: 'static'});

                this.onModal(_this.option.modal);
                return c;
            },

            modal_gallery_open : function (sdata, param) {
                if (param.values) for (var j in sdata.variables) {
                    if (param.values.hasOwnProperty(sdata.variables[j].name)) {
                        sdata.variables[j].values = param.values[sdata.variables[j].name];
                    } else {
                        sdata.variables[j].values = param.values[j];
                    }
                }
                _this.tmpl.show(sdata, $(_this.option.modal).find('.modal-body'), 'edit');
                $(_this.option.modal).find('.btn-save').off().on('click', function () {
                    var $modal = $(this).closest('.modal');
                    var tdata = _this.serialize(sdata.variables);
                    var data = new Array();
                    for (var i in tdata) {
                        data.push({name: i, value: tdata[i]});
                    }
                    if (_this.route.get(param.do, {entity: sdata, values: data}, param)) {
                        $modal.modal('hide');
                    }
                    _this.route.get('position.update', sdata, {oldIndex: 0, newIndex: 0});
                    return false;
                });

                $(_this.option.modal)
                    .one('hide.bs.modal', function (e) {
                        var $modal = $(this).closest('.modal');
                        $modal.find('.modal-body').html('').empty();
                    })
                    .modal('show', {backdrop: 'static'});
                return c;
            },

            dynamic_form_attr_preopen: function(sdata, param){
                _this.tmpl.show(sdata, $(_this.option.modal).find('.modal-body'), 'edit');
                _this.tmpl.addRule('form.attributes.create',$(_this.option.modal).find('.modal-body select#ftype'),sdata,null,null);
                $(_this.option.modal).find('.btn-save').off();
                $(_this.option.modal)
                    .one('hide.bs.modal', function (e) {
                        var $modal = $(this).closest('.modal');
                        $modal.find('.modal-body').html('').empty();
                    })
                    .modal('show', {backdrop: 'static'});
                return c;
            },

            dynamic_form_attr_open: function (sdata, param) {
                var centity = sdata.variables[param.ftype];
                var index = (isFinite(param.ftype)) ? param.ftype : false;
                if(!centity) {
                    centity =  {name:param.values['_type']};
                    centity.settings = sdata.variables[param.values['_type']].settings;
                    centity.values = param.values;
                }
                if(!centity.settings) { return c; }
                    centity.settings.type='attributes';
                var fdata = {cf: centity,index: index};
               _this.tmpl.show(fdata, $(_this.option.modal).find('.modal-body'), 'edit');
                $(_this.option.modal).find('.modal-body .panel').last().remove(); // container render issue
                var validator = _this.tmpl.addRule('validate', $(_this.option.modal).find('form.validate'));
                (function(fdata,validator) {
                    $(_this.option.modal).find('.btn-save').off().on('click', function () {
                        //        if (validator.form()) {
                        var $modal = $(this).closest('.modal');
                        var data={};
                        $.each($modal.find('input,textarea,select'), function(i, obj) {
                            if(obj.name && !$(obj).hasClass('name-ignore') ) {
                                var $extend = $(obj).closest('.duplicate').find('input.extend:not([data-name])');
                                var ext = null;
                                if($extend.length>1) {
                                    ext = [];
                                    for(var i=0;i<$extend.length;i++){
                                        ext[i]= ($extend.eq(i).attr('type') == 'checkbox' || $extend.eq(i).attr('type') == 'radio') ? (($extend.eq(i).is(':checked')) ? 1 : 0) : $extend.eq(i).val();
                                    }
                                } else {
                                    ext = ($extend.attr('type') == 'checkbox' || $extend.attr('type') == 'radio') ? (($extend.is(':checked')) ? 1 : 0) : $extend.val();
                                }
                                if($(obj).attr('type')=='radio' || $(obj).attr('type')=='checkbox') {
                                    if(!$(obj).is(':checked')) { return true; }
                                }
                                var cdata = {};
                                if($(obj).val()) {
                                    if($(obj).data('type')=='record') {
                                        cdata={'id':$(obj).data('id')||0,'val':$(obj).val(), 'vale': ext};
                                    } else {
                                        cdata=$(obj).val()+((ext)? '['+ext+']' : '');
                                    }
                                }
                                var $extend = $(obj).closest('.duplicate').find('input.extend[data-name]');
                                for(var i=0;i<$extend.length;i++){
                                    var $ext = $extend.eq(i);
                                    cdata[$ext.data('name')] = $ext.val();
                                }
                                if($(obj).val()) {
                                    if (data[obj.name]) {
                                        if (Object.prototype.toString.call(data[obj.name]) !== '[object Array]') {
                                            data[obj.name] = [data[obj.name]];
                                        }
                                        data[obj.name].push(cdata);
                                    } else {
                                        data[obj.name]= cdata;
                                    }
                                }
                            }
                        });
                        var store_data = data;
                            store_data['_type'] = fdata.cf.name.replace(/^jsp\d+-/g,'');

                        if (_this.route.get(param.do, {entity: sdata, values: store_data}, index)) {
                            $modal.modal('hide');
                            _this.route.get('position.update', sdata, {oldIndex: 0, newIndex: 0});
                        }
                        //        }
                    });
                })(fdata,validator);
                _this.tmpl.addRule('duplicate_option',$(_this.option.modal).find('.modal-body'),null,null,null);
                _this.tmpl.addRule('split_option',$(_this.option.modal).find('.modal-body'),null,null,null);
                $(_this.option.modal)
                    .one('hide.bs.modal', function (e) {
                        var $modal = $(this).closest('.modal');
                        $modal.find('.modal-body').html('').empty();
                    })
                    .modal('show', {backdrop: 'static'});

                this.onModal(_this.option.modal);
                return c;
            },

            dynamic_statuses_save: function(sdata, param) {
                var $elements = param.elements;
                var index = param.index;
                var data={};
                $.each($elements, function(i, obj) {
                    if(obj.name && !$(obj).hasClass('random-name')) {
                        var $extend = $(obj).closest('.duplicate').find('input.extend');
                        var ext = null;
                        if($extend.length>1) {
                            ext = [];
                            for(var i=0;i<$extend.length;i++){
                                ext[i]= ($extend.eq(i).attr('type') == 'checkbox' || $extend.eq(i).attr('type') == 'radio') ? (($extend.eq(i).is(':checked')) ? 1 : 0) : $extend.eq(i).val();
                            }
                        } else {
                            ext = ($extend.attr('type') == 'checkbox' || $extend.attr('type') == 'radio') ? (($extend.is(':checked')) ? 1 : 0) : $extend.val();
                        }
                        if($(obj).attr('type')=='radio' || $(obj).attr('type')=='checkbox') {
                            if(!$(obj).is(':checked')) { return true; }
                        }
                        if($(obj).val()) {
                            if (Object.prototype.toString.call(data) === '[object Array]') {
                                //if (Object.prototype.toString.call(data) !== '[object Array]') { data = [data]; }
                                data.push({'id':$(obj).data('id')||0,'val':$(obj).val(), 'vale': ext});
                            } else {
                                data={'id':$(obj).data('id')||0,'val':$(obj).val(), 'vale': ext};
                            }
                        }
                        data['position']=index+1;
                    }
                });
                var store_data = data;
                if (_this.route.get('store_array', {entity: sdata, values: store_data}, index)) {
                    //_this.route.get('position.update', sdata, {oldIndex: 0, newIndex: 0});
                }
                return c;
            },

            dynamic_form_preopen: function(sdata, param){
                _this.tmpl.show(sdata, $(_this.option.modal).find('.modal-body'), 'edit');
                _this.tmpl.addRule('form.dynamic.create',$(_this.option.modal).find('.modal-body select#ftype'),sdata,null,null);
                $(_this.option.modal).find('.btn-save').off();
                $(_this.option.modal)
                    .one('hide.bs.modal', function (e) {
                        var $modal = $(this).closest('.modal');
                        $modal.find('.modal-body').html('').empty();
                    })
                    .modal('show', {backdrop: 'static'});
                return c;
            },

            dynamic_form_open: function (sdata, param) {
                var centity = sdata.variables[param.ftype];
                var index = (isFinite(param.ftype)) ? param.ftype : false;
                if(!centity) {
                    centity =  {name:param.values['_type']};
                    centity.settings = sdata.variables[param.values['_type']].settings;
                    centity.values = param.values;
                }
                if(!centity.settings) { return c; }
                centity.settings.type='dynamic';
                var fdata = {cf: centity,index: index};
                _this.tmpl.show(fdata, $(_this.option.modal).find('.modal-body'), 'edit');
                $(_this.option.modal).find('.modal-body .panel').last().remove(); // container render issue
                var validator = _this.tmpl.addRule('validate', $(_this.option.modal).find('form.validate'));
                (function(fdata,validator) {
                    $(_this.option.modal).find('.btn-save').off().on('click', function () {
                        //        if (validator.form()) {
                        var $modal = $(this).closest('.modal');
                        var data={};
                        $.each($modal.find('input,textarea,select'), function(i, obj) {
                            if(obj.name && !$(obj).hasClass('random-name')) {
                                var $extend = $(obj).closest('.duplicate').find('input.extend');
                                var ext = null;
                                if($extend.length>1) {
                                    ext = [];
                                    for(var i=0;i<$extend.length;i++){
                                        ext[i]= ($extend.eq(i).attr('type') == 'checkbox' || $extend.eq(i).attr('type') == 'radio') ? (($extend.eq(i).is(':checked')) ? 1 : 0) : $extend.eq(i).val();
                                    }
                                } else {
                                    ext = ($extend.attr('type') == 'checkbox' || $extend.attr('type') == 'radio') ? (($extend.is(':checked')) ? 1 : 0) : $extend.val();
                                }
                                if($(obj).attr('type')=='radio' || $(obj).attr('type')=='checkbox') {
                                    if(!$(obj).is(':checked')) { return true; }
                                }
                                if($(obj).val()) {
                                    if (data[obj.name]) {
                                        if (Object.prototype.toString.call(data[obj.name]) !== '[object Array]') {
                                            data[obj.name] = [data[obj.name]];
                                        }
                                        if($(obj).data('type')=='record') {
                                            data[obj.name].push({'id':$(obj).data('id')||0,'val':$(obj).val(), 'vale': ext});
                                        } else {
                                            data[obj.name].push($(obj).val()+((ext)? '['+ext+']' : ''));
                                        }
                                    } else {
                                        if($(obj).data('type')=='record') {
                                            data[obj.name]={'id':$(obj).data('id')||0,'val':$(obj).val(), 'vale': ext};
                                        } else {
                                            data[obj.name]=$(obj).val()+((ext)? '['+ext+']' : '');
                                        }
                                    }
                                }
                            }
                        });
                        var store_data = data;
                        store_data['_type'] = fdata.cf.name.replace(/^jsp\d+-/g,'');

                        if (_this.route.get(param.do, {entity: sdata, values: store_data}, index)) {
                            $modal.modal('hide');
                            _this.route.get('position.update', sdata, {oldIndex: 0, newIndex: 0});
                        }
                        //        }

                    });
                })(fdata,validator);
                _this.tmpl.addRule('duplicate_option',$(_this.option.modal).find('.modal-body'),null,null,null);
                $(_this.option.modal)
                    .one('hide.bs.modal', function (e) {
                        var $modal = $(this).closest('.modal');
                        $modal.find('.modal-body').html('').empty();
                    })
                    .modal('show', {backdrop: 'static'});

                this.onModal(_this.option.modal);
                return c;
            },

            image_ck : function (sdata, param) {
                $(_this.option.modal)
                    .one('hide.bs.modal', function (e) {
                        var $modal = $(this).closest('.modal');
                        $modal.find('.modal-body').html('').empty();

                    })
                    .modal('show', {backdrop: 'static'});

                this.onModal(_this.option.modal);


                CKFinder.modal({
                    height: 600,
                    displayFoldersPanel: false,
                    resourceType: 'Images',
                    chooseFiles: true,
                    chooseFilesOnDblClick: true,
                    removeModules: 'ContextMenu,FileDownload,FilesMoveCopy',
                    onInit: function (finder) {
                        finder.on('files:choose', function (evt) {
                            var file = evt.data.files.first();
                            param.$img.attr('src', file.getUrl());
                            _this.route.get('update', sdata, {entityval: file.getUrl()});
                        });
                        finder.on('file:choose:resizedImage', function (evt) {
                            param.$img.attr('src', evt.data.resizedUrl);
                            _this.route.get('update', sdata, {entityval: evt.data.resizedUrl});
                        });
                    }
                });
                return c;
            },

            icon_select: function (data, param) {
                $('#modal-icon .modal-body a').off().on('click',function(){
                    return function() {
                        var icon = $(this).children('i').first().clone()[0].outerHTML;
                        param.$icon.html(icon);
                        param.$input.val(icon);
                        $('#modal-icon').modal('hide');
                        return false;
                    }
                }());
                $('#modal-icon').modal('show', {backdrop: 'static'});
            },

            delete : function (data, param) {
                //if(param.values) { data.values=param.values; }
                _this.model.delete(data, param.index);
                if (param.$img) {
                    param.$img.attr('src', 'http://placehold.it/250x250');
                } else {
                    _this.show();
                }
                return true;
            },

            store : function (data) {
                _this.model.save(data);
                _this.show();
                return true;
            },

            store_array : function (data,params) {
                var values = data.values || [];
                data.values = values;
                _this.model.store_array(data,params);
                _this.show();
                return true;
            },

            delete_array : function (data,params) {
                data.values = data.values || [];
                var indx = params.index || false;
                _this.model.delete_array({entity:data},indx);
                _this.show();
                return true;
            },

            save : function (data, param) {
                _this.model.save(data, param.index);
                _this.show();
                return true;
            },

            update : function (data, param) {
                if (param.values) {
                    data.values = param.values;
                }
                if (param.entityval || param.entityval === 0 || param.entityval === false) {
                    data.values = [
                        {
                            name: data.entity.name,
                            value: param.entityval
                        }
                    ];
                }
                _this.model.save(data, param.index);
                return true;
            },

            position_update : function (data, param) {
                var start = (param.newIndex > param.oldIndex) ? param.oldIndex : param.newIndex;
                var end = (param.newIndex > param.oldIndex) ? param.newIndex : param.oldIndex;
                var offset = (param.newIndex > param.oldIndex) ? 1 : -1;
                var values = $.extend(true, [], data.values);
                for (var i in values) {
                    if (!values[i].position) values[i].position = parseInt(i) + 1;
                    if (start <= i && i <= end) {
                        values[i].position -= offset;
                    }
                }
                values[param.oldIndex].position = param.newIndex + 1;
                values.sort(function (a, b) {
                    return a.position - b.position;
                });
                data.values = values;
                return true;
            },

            load : function (data, url, param) {
                var url = url || false;
                var param = param || [];
                if (url) {
                    url = data;
                    return function (obj) {
                        $.ajax({
                            url: url,
                            data: param,
                            contentType: 'json',
                            success: function (data) {
                                obj.load(data, false);
                                obj.show();
                            }
                        });
                    }(_this);
                } 
                else {
                    _this.model.load(data);
                }
                return c;
            },

            validate : function ($form) {
                var $form = $form || $(_this.option.form),
                    _result = null;
                var validator = _this.tmpl.addRule('validate', $form);
                if (validator.form()) {
                    _result = true;
                } else {
                    _result = false;
                }
                return _result;
            },

            serialize : function (db, $form, validate) {
                var validate = validate || false;
                var $wrapper = $form || _this.$container;
                $wrapper.find('.force-change').change();
                if (validate) {
                    if (!c.validate($form)) {
                        return false;
                    }
                }
                var data = {};
                data = _this.model.serialize();
                return data;
            },

            onModal: function ($container) { if(_this.option.event.onModal) { _this.option.event.onModal($container) } },

        };
        var c = this.controller;
        // ------------------------------------------------------------------------------------

        this.setHandler = function (context) {
            this.$container = (typeof context == 'object') ? context : $(context);
            return this;
        };

        this.load = function (data, url, param) {
            this.controller.load(data, url, param);
            return this;
        };

        this.prepare = function(opt){
            this.tmpl.prepare(opt);
            return this;
        };

        this.settings = function(path,val){
            var value = this.model.db.data['settings'];
            var path = path.split('.');
            for(var i=0; i<path.length-1;i++){
                value=value[path[i]];
            }
            if(val) { value[path[path.length-1]]=val;  }
            return value;
        };

        this.show = function () {
            this.tmpl.show();
            if(this.option.event.onShow) { this.option.event.onShow(this.$container); }
            return this;
        };

        this.afterEdit = function() {
            if(this.option.event.onEdit) { this.option.event.onEdit(this.$container); }
        };

        this.serialize = function (db) {
            return this.controller.serialize(db, null, true);
        };

        this.helper = {
            _extend: function (source, destination) {
                var destination = destination || this.option;
                for (var property in source) {
                    if (source[property] && source[property].constructor &&
                        source[property].constructor === Object) {
                        destination[property] = destination[property] || {};
                        this._extend(source[property], destination[property]);
                    } else {
                        destination[property] = source[property];
                    }
                }
                return destination;
            },
            _objLength: function (obj) {
                var count = 0;
                if (typeof obj == 'object') {
                    for (var key in obj) {
                        if (obj.hasOwnProperty(key)) {
                            ++count;
                        }
                    }
                }
                return count;
            },
            _deepCopy: function (oldObj) {
                var newObj = oldObj;
                if (oldObj && typeof oldObj === 'object') {
                    newObj = Object.prototype.toString.call(oldObj) === "[object Array]" ? [] : {};
                    for (var i in oldObj) {
                        newObj[i] = this._deepCopy(oldObj[i]);
                    }
                }
                return newObj;
            }
        };

        this._autodata = {
            "dynamicForm": {
                "email": {
                    "name": "email",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "E-mail",
                        "placeholder": {"required": true, "value": "email@mail.com"},
                        //"required": {"value": 1, "edit": false}
                    }
                },
                "textarea": {
                    "name": "textarea",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "Text Area",
                        "placeholder": {"required": true},
                        "validate": {"required": false, "value": "email"},
                        "minHeight": {"required": false, "value": "120"},
                        //"required": {"value": 0}
                    }
                },
                "input": {
                    "name": "input",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "Text Input",
                        "placeholder": {"required": false},
                        "validate": {"required": false},
                        //"required": {"value": 0}
                    }
                },
                "checkbox": {
                    "name": "checkbox",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "CheckBox",
                        "option": {"value": [{'id':0,'val':"checkbox1"},{'id':0,'val':"checkbox2"},{'id':0,'val':"checkbox3"}]},
                        //"required": {"value": 0}
                    }
                },
                "radio": {
                    "name": "radio",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "Radio",
                        "option": {"value": [{'id':0,'val':"radio1"},{'id':0,'val':"radio2"},{'id':0,'val':"radio3"}]},
                        //"required": {"value": 0}
                    }
                },
                "select": {
                    "name": "select",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "Dropdown",
                        "option": {"value": [{'id':0,'val':"option1"},{'id':0,'val':"option2"},{'id':0,'val':"option3"}]},
                        //"required": {"value": 0}
                    }
                },
                "calendar": {
                    "name": "calendar",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "Calendar",
                        //"required": {"value": 0}
                    },
                },
                "submit": {
                    "name": "submit",
                    "settings": {
                        "id":false,
                        "icon":null,
                        "label": "Submit",
                    },
                },
            },
            "dynamicAttributes": { },
        };
        this._autodata['dynamicAttributes'] = this._autodata['dynamicForm'];

        this.destroy = function (force) {
            var force = (force) ? true : false;
            this.raw = [];
            this._initialized = false;

            this.model.db = {};
            if(force){
                delete this.tmpl.defered;
                this.tmpl.defered = {};
            }
            return this;
        };
        this.init = function () {
            return this._construct(this.option);
        };

        if (!this._initialized) {
            this._construct(options);
        }
    };

    jSplash.prototype.tmpl_defered = {
            'list.sortable':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                    '<button type="button" class="btn btn-success btn-lg btn-icon icon-left in-modal splash-create"><i class="entypo-plus"></i>{{=trans(it.settings.button)}}</button>'+
                '</div>'+
                '</div>'+
                '<div class="list-group sortable">'+
                    '{{~it.tmpl.data :value:index }}'+
                '<div class="list-group-item {{?it.values[index]._status=="DELETE" }}hidden{{?}}">'+
                    '<span>{{=value}}</span>'+
                '<span class="pull-right">'+
                    '{{?it.tmpl.controls.indexOf("move")!=-1}}<span class="glyphicon glyphicon-move" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("edit")!=-1}}<span class="glyphicon glyphicon-pencil in-modal splash-edit" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("delete")!=-1}}<span class="glyphicon glyphicon-trash splash-delete" aria-hidden="true"></span>{{?}}'+
                '</span>'+
                '</div>'+
                '{{~}}'+
                '</div>',
            'list.gallery':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                '<button type="button" class="btn btn-success btn-lg btn-icon icon-left in-modal splash-create"><i class="entypo-plus"></i>{{=trans(it.settings.button)}}</button>'+
                '</div>'+
                '</div>'+
                '<div class="list-group sortable">'+
                    '{{~it.tmpl.data :value:index }}'+
                '<div class="list-group-item gallery-item {{?it.values[index]._status=="DELETE" }}hidden{{?}}">'+
                    '<span class="gallery-image-reserve">{{=value}}</span>'+
                '<span class="pull-right">'+
                    '{{?it.tmpl.controls.indexOf("move")!=-1}}<span class="glyphicon glyphicon-move" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("edit")!=-1}}<span class="glyphicon glyphicon-pencil in-modal splash-edit" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("delete")!=-1}}<span class="glyphicon glyphicon-trash splash-delete" aria-hidden="true"></span>{{?}}'+
                '</span>'+
                '</div>'+
                '{{~}}'+
                '</div>',
            'form.dynamic':
                    '<div class="list-group sortable">'+
                    '{{~it.tmpl.data :value:index }}'+
                '<div class="list-group-item">'+
                    '<div class="row">'+
                    '<span class="col-xs-10">{{=value}}</span>'+
                '<span class="col-xs-2 form-group">'+
                    '{{?it.tmpl.controls.indexOf("move")!=-1}}<span class="glyphicon glyphicon-move" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("edit")!=-1}}<span class="glyphicon glyphicon-pencil in-modal splash-edit" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("delete")!=-1}}<span class="glyphicon glyphicon-trash splash-delete" aria-hidden="true"></span>{{?}}'+
                '</span>'+
                '</div>'+
                '</div>'+
                '{{~}}'+
                '</div>'+
                '<div class="col-xs-12">'+
                    '<div class="form-group">'+
                    '<button type="button" class="btn btn-success btn-icon in-modal splash-create"><i class="entypo-plus"></i>{{=trans(it.settings.button)}}</button>'+
                '</div>'+
                '</div>',
            'form.attributes':'<div class="panel panel-default">'+
                '<!--<div class="panel-heading">'+
                '<div class="panel-title" >{{=it.settings.label||""}}</div>'+
                '<div class="panel-options">'+
                '<a data-rel="collapse" href="#">'+
                '<i class="entypo-down-open"></i>'+
                '</a>'+
                '</div>'+
                '</div>-->'+
                '<div class="panel-body">'+
                '<div class="list-group sortable">'+
                '{{~it.tmpl.data :value:index }}'+
                '<div class="list-group-item">'+
                '<div class="row">'+
                '<span class="col-xs-10">{{=value}}</span>'+
                '<span class="col-xs-2 form-group">'+
                '{{?it.tmpl.controls.indexOf("move")!=-1}}<span class="glyphicon glyphicon-move" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("edit")!=-1}}<span class="glyphicon glyphicon-pencil in-modal splash-edit" aria-hidden="true"></span>{{?}}'+
                '{{?it.tmpl.controls.indexOf("delete")!=-1}}<span class="glyphicon glyphicon-trash splash-delete" aria-hidden="true"></span>{{?}}'+
                '</span>'+
                '</div>'+
                '</div>'+
                '{{~}}'+
                '</div>'+
                '<div class="col-xs-12">'+
                '<div class="form-group">'+
                '<button type="button" class="btn btn-success btn-icon in-modal splash-create"><i class="entypo-plus"></i>{{=it.settings.button }}</button>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>',
            'default.container':'<div class="panel panel-default">'+
                '<div class="panel-heading">'+
                    '<div class="panel-title">{{?it.settings && it.settings.label}}{{=trans(it.settings.label)}}{{?}}</div>'+
                '</div>'+
                '<div class="panel-body" >'+
                    '{{?it.chain}}<chain><!--{ {=it.chain} }--></chain>{{?}}'+
                '</div>'+
                '</div>',
            'default.text':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                '<label class="control-label _col-sm-2" >{{=trans(it.settings.label)}}</label>'+
                '<input type="text" name="{{=it.name}}"'+
                '{{ for(var index in it.attributes) { }} {{=index}}="{{=it.attributes[index] }}" {{ } }}'+
                '{{?it.settings.validate}} data-validate="{{=it.settings.validate}}" {{?}}'+
                '{{?it.values}}value="{{=it.values}}"{{?}}'+
                '>'+
                '<div class="text-danger"></div>'+
                '</div>'+
                '</div>',
            'default.textarea':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                '<label class="control-label _col-sm-2" >{{=it.settings.label }}</label>'+
                '<textarea name="{{=it.name}}"'+
                '{{ for(var index in it.attributes) { }} {{=index}}="{{=it.attributes[index] }}" {{ } }}'+
                '{{?it.settings.validate}} data-validate="{{=it.settings.validate}}" {{?}}'+
                '>{{?it.values}}{{=it.values}}{{?}}</textarea>'+
                '<div class="text-danger"></div>'+
                '</div>'+
                '</div>',
            'default.checkbox':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                '<label class="control-label">'+
                '<input type="checkbox" name="{{=it.name}}"'+
                '{{ for(var index in it.attributes) { }} {{=index}}="{{=it.attributes[index] }}" {{ } }}'+
                '{{?it.settings.validate}} data-validate="{{=it.settings.validate}}" {{?}}'+
                '{{?it.values}}value="{{=it.values}}" CHECKED{{?}}'+
                '>'+
                '{{=it.settings.label }}</label>'+
                '<div class="text-danger"></div>'+
                '</div>'+
                '</div>',
            'default.select':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                '<label class="control-label _col-sm-2">{{=it.settings.label }}</label>'+
                '<select name="{{=it.name}}"'+
                '{{ for(var index in it.attributes) { }} {{=index}}="{{=it.attributes[index] }}" {{ } }}'+
                '{{?it.settings.validate}} data-validate="{{=it.settings.validate}}" {{?}}'+
                '>'+
                '{{?it.settings && it.settings.option}}'+
                '{{~it.settings.option :value:index}}'+
                '<option value="{{=value.key}}" {{=(value.key==it.values)?"SELECTED":""}}>'+
                '{{=value.value}}'+
                '</option>'+
                '{{~}}'+
                '{{?}}'+
                '</select>'+
                '<div class="text-danger"></div>'+
                '</div>'+
                '</div>',
            'default.image':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                '<label class="control-label _col-sm-2">{{=trans(it.settings.label)}}</label>'+
                '<span class="image-editable">'+
                    '<img {{ for(var index in it.attributes) { }} {{=index}}="{{=it.attributes[index] }}" {{ } }} src="{{?it.values && it.values!="" }}{{=it.values}}{{?? true}}http://placehold.it/250x250{{??}}{{?}}" >'+
                '<div class="image-options">'+
                '<a href="#" class="edit"><i class="entypo-pencil"></i></a>'+
                '<a href="#" class="delete"><i class="entypo-cancel"></i></a>'+
                '</div>'+
                '</span>'+
                '<div class="text-danger"></div>'+
                '</div>'+
                '</div>',
            'default.icon':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                    '<label class="control-label _col-sm-2" >{{=trans(it.settings.label)}}</label>'+
                '<div class="gallery-env col-sm-4 col-xs-6 edit-page-opt">'+
                    '<article class="image-thumb portfolio-item">'+
                    '<a class="image select-icon" href="#">'+
                    '<span class="img-container">'+
                    '{{=it.values}}'+
                '</span>'+
                '</a>'+
                '<div class="image-options">'+
                    '<a class="edit" href="#"><i class="entypo-pencil"></i></a>'+
                    '<!--<a href="#" class="delete"><i class="entypo-cancel"></i></a>-->'+
                    '</div>'+
                    '</article>'+
                    '</div>'+
                    '<input type="text" name="{{=it.name}}"'+
                '{{ for(var index in it.attributes) { }} {{=index}}="{{=it.attributes[index] }}" {{ } }}'+
                '{{?it.settings.validate}} data-validate="{{=it.settings.validate}}" {{?}}'+
                '{{?it.values}}value="{{!it.values}}"{{?}}'+
                '>'+
                '<div class="text-danger"></div>'+
                '</div>'+
                '</div>',
            'default.upload':'<div class="form-group">'+
                '<div class="col-xs-12">'+
                '<div class="input-group">'+
                '<span class="input-group-btn">'+
                '<a data-fancybox-type="iframe" href="/mediabrowser/{{=it.name}}" class="btn btn-default mediabrowser-js" type="button"><span class="glyphicon glyphicon-paperclip"></span></a>'+
                '</span>'+
                '<input type="text" name="{{=it.name}}" value="{{=it.values||""}}" class="form-control force-change" />'+
                '</div>'+
                '</div>'+
                '</div>',
    };

    window.trans=function(phrase){
        var path=false;
        if(typeof (dictionary) == 'undefined') { return phrase; }
        var str=dictionary;

        if (typeof phrase === "string") {
            path = phrase.split(".");
        }
        if (!(path instanceof Array) || path.length === 0) {
            return ;
        }
        for (var i in path) {
            if (dictionary.hasOwnProperty(path[i])) {
                str = str[path[i]];
            } else {
                return phrase;
            }
        }
        return str;
    };

    (function(){
        var list =[
                'attributes.field',
                'container.gmap',
                'default.statuses',
                'form.field',
                'modal.attributes',
                'modal.dynamic',
            ],
            item = null;

        for (var i=0; i<list.length; i++) {
            item = list[i];

            if (!item) {
                continue;
            }

            (function(item){
                $.ajax({
                    type: "GET",
                    url: '/components/jSplash/jSplashTmpl/'+item+'.html',
                    async: false,
                    success: function(resp) {
                        jSplash.prototype.tmpl_defered[item]=resp;
                    },
                    error: function() {
                        return false;
                    }
                });
            })(item);
        }

    })(jSplash);

    $.fn.jSplash = function( options ) {
        return this.each(function () {
            options = $.extend( { handle: 'splash' }, options );
            $(this).data( options.handle, new jSplash( this, options ) );
        });
    };

}(jQuery));