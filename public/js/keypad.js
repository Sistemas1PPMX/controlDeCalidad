(function ($) {
    function Keypad(el, options) {
        this.el = el;
        this.instance = undefined;
        this.options = $.extend(true, {
            isRandom: false,
            valueAttr: 'keyVal',
            template: false,
            container: 'body',
            cmd: 'cmd'
        }, options);

        this.CMD_CLEAR = 'clear';
        this.CMD_BACK = 'back';
    };
    Keypad.prototype = new Object();

    Keypad.prototype.init = function () {
        this.el.attr('readonly', true);
        this._initLayout();
    };
    Keypad.prototype._initLayout = function () {
        var tpl;

        if(this.options.template) {
            tpl = $(this.options.template).html();
        }
        else {
            tpl = $(this.template);
        }

        $tpl = $(tpl);
        $tpl.toggleClass('active', false);
        var ns = this.getKeyNumbers();
        for (var i = 0; i < ns.length; i++) {
            var v = ns[i];
            $tpl.find('.' + i).attr(this.options.valueAttr, v).text(v);
        }
        this.instance = $tpl;
        $tpl.appendTo(this.options.container);
        this._bindEvents();
    };
    Keypad.prototype._bindEvents = function () {
        var instance = this.instance;
        var self = this;
        this.el.on('focus', function () {
            self.show();
        });
        instance.on('click', 'button', function (e) {
            e.stopPropagation();
            var val = $(this).attr(self.options.valueAttr);
            var cmd = $(this).attr('cmd');
            if (cmd == self.CMD_BACK) {
                self._back();
            }
            else if (cmd == self.CMD_CLEAR) {
                self._clear();
            }
            else {
                self._appendValue(val);
            }
            if ($("#nip").val().length == 4) {
                $.get('sessionLogin/'+$("#nip").val()+"", function(response, state){
                    if (response[0].usuario == 1) {
                        $.get("abreSession/"+$("#nip").val()+"", function(response, state){
                            /*alert(response);*/
                        window.location.href = "/";
                        })
                    }else{
                    $("#nip").val("");
                    }
                })
            }
            return false;
        });
        instance.on('click', function () {
            self.hide();
        });
    };
    Keypad.prototype._back = function () {
        var val = this.el.val();
        this.el.val(val.substring(0, val.length -1));
    };
    Keypad.prototype._clear = function () {
        this.el.val('');
    };
    Keypad.prototype._appendValue = function (pressedVal) {
        var val = this.el.val();
        var cursorPos = this._getCursorIndex();
        var newVal = '';

        newVal = val.substring(cursorPos, val.length) + val.substring(0, cursorPos) + pressedVal ;

        this.el.val(newVal);
    };
    Keypad.prototype._getCursorIndex = function (oField) {
        var pos = 0;
        if (this.el.get(0) && typeof this.el.get(0).selectionStart == 'number') {
            pos = this.el.get(0).selectionStart;
        }
        return pos;
    };
    Keypad.prototype.show = function () {
        this.instance.addClass('active');  
    };
    Keypad.prototype.hide = function () {
        this.instance.removeClass('active');
    }
    Keypad.prototype.getKeyNumbers = function () {
        var ns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        isRandom = this.options.isRandom;
        if (isRandom) {
            var newNs = [];
            var running = true;
            while (running) {
                if (ns.length != 0) {
                    var i = Math.floor(Math.random() * ns.length);
                    newNs.push(ns.splice(i, 1)[0]);
                }
                else {
                    running = false;
                }

            }
            return newNs;
        }
        return ns;
    }
    Keypad.prototype.template = '   ' +
    '    <div class="keypad">   ' +
    '        <table>   ' +
    '            <colgroup>   ' +
    '                <col width="33.33%">   ' +
    '                <col width="33.33%">   ' +
    '                <col width="33.33%">   ' +
    '            </colgroup>   ' +
    '            <tbody>   ' +
    '                <tr>   ' +
    '                    <td><button type="button" class="1">1</button></td>   ' +
    '                    <td><button type="button" class="2">2</button></td>   ' +
    '                    <td><button type="button" class="3">3</button></td>   ' +
    '                </tr>   ' +
    '                <tr>   ' +
    '                    <td><button type="button" class="4">4</button></td>   ' +
    '                    <td><button type="button" class="5">5</button></td>   ' +
    '                    <td><button type="button" class="6">6</button></td>   ' +
    '                </tr>   ' +
    '                <tr>   ' +
    '                    <td><button type="button" class="7">7</button></td>   ' +
    '                    <td><button type="button" class="8">8</button></td>   ' +
    '                    <td><button type="button" class="9">9</button></td>   ' +
    '                </tr>   ' +
    '                <tr>   ' +
    '                    <td><button type="button" class="text-sm" cmd="clear">Clear</button></td>   ' +
    '                   <td><button type="button" class="0">0</button></td>   ' +
    '                    <td><button type="button" class="text-sm" cmd="back">Back</button></td>   ' +
    '                </tr>   ' +
    '            </tbody>   ' +
    '        </table>   ' +
    '    </div>   ';
    window.keypad = new Keypad({});

    $.fn.keyPad = function (options) {
        var kp = new Keypad(this, options);
        kp.init();
    };

})(jQuery);