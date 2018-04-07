var _Cookie = function(){}

_Cookie.prototype = {

        url: 		"",
        cookie : "",
    init : function(url)
    {
        this.url = url;
    },

    getCookie : function(){
        var name = this.url + "=";
        console.log(name);
        var decodedCookie = decodeURIComponent(document.cookie);
        console.log("decodedCookie : " + decodedCookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                if (c.substring(name.length, c.length)=="")
                    return "";	
                else return c.substring(name.length, c.length);
            }
        }
        return "";
    },

    addCookie : function(val){
        var cookie_data = this.getCookie();
        cookie_data = cookie_data + val + ",";
        this.save_cookie(cookie_data);
    },

	save_cookie : function(cookie_data){
        var d = new Date();
        d.setTime(d.getTime() + (48*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = this.url + "=" + cookie_data + ";"  + expires + ";path=/";
    },

    exchange : function(val1, val2)
    {
        var cookie_data = this.getCookie();
        var _cookie = cookie_data.split(",");
        var first, second;
        for (var i = 0; i<_cookie.length;i++){
            if (parseInt(_cookie[i])==val1) first = i;
            if (parseInt(_cookie[i])==val2) second = i;
        }

        _cookie[second] = val1;
        _cookie[first]  = val2;
        cookie_data = "";
        for (var i = 0; i<_cookie.length;i++){
            cookie_data = cookie_data + _cookie[i] + ",";
        }
        this.save_cookie(cookie_data);
    },

    delete_cookie : function(val){
        var cookie_data = this.getCookie();
        cookie_data.replace(val+",", "");
        this.save_cookie(cookie_data);
    },
    clear_cookie : function(){
        this.save_cookie("");
    }
}

var _cookie = new _Cookie();
var urls = window.location.href.split('/');
var url = urls[urls.length-1];
_cookie.init(url);



// function getCookie(url) {
// 	var name = url + "=";
// 	console.log(name);
// 	var decodedCookie = decodeURIComponent(document.cookie);
// 	console.log("decodedCookie : " + decodedCookie);
// 	var ca = decodedCookie.split(';');
// 	for(var i = 0; i <ca.length; i++) {
// 		var c = ca[i];
// 		while (c.charAt(0) == ' ') {
// 			c = c.substring(1);
// 		}
// 		if (c.indexOf(name) == 0) {
// 			if (c.substring(name.length, c.length)=="")
// 				return "";	
// 			else return c.substring(name.length, c.length);
// 		}
// 	}
// 	return "";
// }
// /* function for get cookie information */
// function setCookie(curl,cvalue) {

// 	var d = new Date();
// 	d.setTime(d.getTime() + (48*60*60*1000));
// 	var expires = "expires="+ d.toUTCString();
// 	cookie_data = cookie_data + cvalue + ",";
// 	if (cvalue === "")
// 		document.cookie = curl + "=" + ";"  + expires + ";path=/";
// 	else 
// 		document.cookie = curl + "=" + cookie_data + ";"  + expires + ";path=/";
// }

// function oder_change(val1, val2){

// }

// function delete_cookie(val1){

// }
