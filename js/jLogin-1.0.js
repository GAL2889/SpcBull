// JavaScript Document
/*************************************************************
 * jLogin - jQuery Plugin
 * Disguise and Hash Input Text for Authentication/Login before sending to process page
 *
 * Examples and documentation at: http://aku.salimag.us/jlogin-authentication-plugin-v-1-0.html
 * 
 * Created By Agus Salim
 * 
 * Version: 1.0 (06/21/2011)
 * Requires: jQuery v1.3+
 *
 /*************************************************************/

(function($) {
    $.fn.jLogin = function(options) {
        //set default parameter for this plugin
        var defaults = {
            tUser: 'tUser',
            tPass: 'tPass',
            oUser: 'jlog-user',
            oPass: "jlog-pass",
            okBtn: 'Login',
            btnStyle: '',
            url: 'check-login.php',
            method: 'POST',
        }
        var param = $.extend({}, defaults, options);	//read default options and compare with used defined options
        var elem = $(this);
        var jlog_sKey = unique_salt();
        jLog_createForm();
        //alert(unique_salt());

        //function to create virtual FORM DUMMY that will hold hash user name and password
        function jLog_createForm() {
            var isi = '<form action="' + param.url + '" id="jlog-frm" name="" method="' + param.method + '"></form>';
            var t1 = '<input type="hidden" id="' + param.oUser + '" name="' + param.oUser + '" />';
            var t2 = '<input type="hidden" id="' + param.oPass + '" name="' + param.oPass + '" />';
            var t3 = '<input type="hidden" id="jlog-key" name="jlog-key" value="' + jlog_sKey + '" />';
            var t4 = '<input type="submit" id="jlog-submit" name="jlog-submit" value="' + param.okBtn + '" style="width:auto; ' + param.btnStyle + '" />';
            elem.append(isi);
            $('#jlog-frm').append(t1);
            $('#jlog-frm').append(t2);
            $('#jlog-frm').append(t3);
            $('#jlog-frm').append(t4);
            setUI();
        }

        function setUI() {
            $('#' + param.tUser).val('');	//empty User name input
            $('#' + param.tPass).val('');	//empty Password input

            //bind to keyup event on User Name input and the encrypt it 
            //and put the result on the dummy User Name input
            $('#' + param.tUser).bind('keyup', function(e) {
                var dumUser = genEncrypt($('#' + param.tUser).val());
                $('#' + param.oUser).val(dumUser);
                if (e.keyCode == 13) {
                    $('#' + param.tPass).focus();
                }	//if enter the focus on password input
            });
            //bind to keyup event on Password input and the encrypt it 
            //and put the result on the dummy Password input
            $('#' + param.tPass).bind('keyup', function(e) {
                var dumPass = genEncrypt($('#' + param.tPass).val());
                $('#' + param.oPass).val(dumPass);
                if (e.keyCode == 13) {
                    $('#jlog-submit').trigger('click');
                }
            });
        }

        //function to generate encrypted user and password
        function genEncrypt(plainText) {
            var x = 1;
            plainText = jlog_sKey + SHA1(plainText);
            while (x <= 100) {
                plainText = SHA1(plainText);
                x++;
            }
            return plainText;
        }

        //function to make unique salt key
        function unique_salt() {
            return SHA1(mt_rand().toString());
        }

        // Returns a random number from Mersenne Twister -----------------------------------------------------------------------------
        // 
        // version: 1103.1210
        // discuss at: http://phpjs.org/functions/mt_rand    // +   original by: Onno Marsman
        // *     example 1: mt_rand(1, 1);
        // *     returns 1: 1
        function mt_rand(nMin, nMax) {
            var argc = arguments.length;
            if (argc === 0) {
                nMin = 0;
                nMax = 2147483647;
            } else if (argc === 1) {
                throw new Error('Warning: mt_rand() expects exactly 2 parameters, 1 given');
            }
            return Math.floor(Math.random() * (nMax - nMin + 1)) + nMin;
        }
        // END Returns a random number from Mersenne Twister -------------------------------------------------------------------------		

        // Importan function to convert plain text to encrypted text using SHA1-------------------------------------------------------
        /**
         *
         *  Secure Hash Algorithm (SHA1)
         *  Thanks to :
         *  http://www.webtoolkit.info
         *  for providing this function
         *
         **/
        function SHA1(msg) {
            function rotate_left(n, s) {
                var t4 = (n << s) | (n >>> (32 - s));
                return t4;
            }
            ;

            function lsb_hex(val) {
                var str = "";
                var i;
                var vh;
                var vl;

                for (i = 0; i <= 6; i += 2) {
                    vh = (val >>> (i * 4 + 4)) & 0x0f;
                    vl = (val >>> (i * 4)) & 0x0f;
                    str += vh.toString(16) + vl.toString(16);
                }
                return str;
            }
            ;

            function cvt_hex(val) {
                var str = "";
                var i;
                var v;

                for (i = 7; i >= 0; i--) {
                    v = (val >>> (i * 4)) & 0x0f;
                    str += v.toString(16);
                }
                return str;
            }
            ;


            function Utf8Encode(string) {
                string = string.replace(/\r\n/g, "\n");
                var utftext = "";

                for (var n = 0; n < string.length; n++) {

                    var c = string.charCodeAt(n);

                    if (c < 128) {
                        utftext += String.fromCharCode(c);
                    }
                    else if ((c > 127) && (c < 2048)) {
                        utftext += String.fromCharCode((c >> 6) | 192);
                        utftext += String.fromCharCode((c & 63) | 128);
                    }
                    else {
                        utftext += String.fromCharCode((c >> 12) | 224);
                        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                        utftext += String.fromCharCode((c & 63) | 128);
                    }

                }

                return utftext;
            }
            ;

            var blockstart;
            var i, j;
            var W = new Array(80);
            var H0 = 0x67452301;
            var H1 = 0xEFCDAB89;
            var H2 = 0x98BADCFE;
            var H3 = 0x10325476;
            var H4 = 0xC3D2E1F0;
            var A, B, C, D, E;
            var temp;

            msg = Utf8Encode(msg);

            var msg_len = msg.length;

            var word_array = new Array();
            for (i = 0; i < msg_len - 3; i += 4) {
                j = msg.charCodeAt(i) << 24 | msg.charCodeAt(i + 1) << 16 |
                        msg.charCodeAt(i + 2) << 8 | msg.charCodeAt(i + 3);
                word_array.push(j);
            }

            switch (msg_len % 4) {
                case 0:
                    i = 0x080000000;
                    break;
                case 1:
                    i = msg.charCodeAt(msg_len - 1) << 24 | 0x0800000;
                    break;

                case 2:
                    i = msg.charCodeAt(msg_len - 2) << 24 | msg.charCodeAt(msg_len - 1) << 16 | 0x08000;
                    break;

                case 3:
                    i = msg.charCodeAt(msg_len - 3) << 24 | msg.charCodeAt(msg_len - 2) << 16 | msg.charCodeAt(msg_len - 1) << 8 | 0x80;
                    break;
            }

            word_array.push(i);

            while ((word_array.length % 16) != 14)
                word_array.push(0);

            word_array.push(msg_len >>> 29);
            word_array.push((msg_len << 3) & 0x0ffffffff);


            for (blockstart = 0; blockstart < word_array.length; blockstart += 16) {

                for (i = 0; i < 16; i++)
                    W[i] = word_array[blockstart + i];
                for (i = 16; i <= 79; i++)
                    W[i] = rotate_left(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1);

                A = H0;
                B = H1;
                C = H2;
                D = H3;
                E = H4;

                for (i = 0; i <= 19; i++) {
                    temp = (rotate_left(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }

                for (i = 20; i <= 39; i++) {
                    temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }

                for (i = 40; i <= 59; i++) {
                    temp = (rotate_left(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }

                for (i = 60; i <= 79; i++) {
                    temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
                    E = D;
                    D = C;
                    C = rotate_left(B, 30);
                    B = A;
                    A = temp;
                }

                H0 = (H0 + A) & 0x0ffffffff;
                H1 = (H1 + B) & 0x0ffffffff;
                H2 = (H2 + C) & 0x0ffffffff;
                H3 = (H3 + D) & 0x0ffffffff;
                H4 = (H4 + E) & 0x0ffffffff;

            }

            var temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);

            return temp.toLowerCase();

        }
        // END Importan function to convert plain text to encrypted text using SHA1---------------------------------------------------

    }
})(jQuery);
