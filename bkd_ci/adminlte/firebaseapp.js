//var path_sync = '/simpg/index.php/senddatatoserver/syncByLog';
//var hostname = "http://"+document.location.hostname;
function firebaseapp(plant,syncurl) {
  var _0x7506=["\x41\x49\x7A\x61\x53\x79\x44\x35\x54\x44\x41\x50\x44\x64\x4D\x6D\x4A\x61\x77\x59\x42\x69\x70\x5A\x68\x53\x7A\x68\x79\x53\x53\x4F\x49\x6E\x64\x78\x34\x55\x73","\x73\x69\x6D\x70\x67\x2D\x36\x32\x32\x61\x36\x2E\x66\x69\x72\x65\x62\x61\x73\x65\x69\x6F\x2E\x63\x6F\x6D","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x73\x69\x6D\x70\x67\x2D\x36\x32\x32\x61\x36\x2E\x66\x69\x72\x65\x62\x61\x73\x65\x69\x6F\x2E\x63\x6F\x6D\x2F","\x73\x69\x6D\x70\x67\x2D\x36\x32\x32\x61\x36\x2E\x61\x70\x70\x73\x70\x6F\x74\x2E\x63\x6F\x6D","\x69\x6E\x69\x74\x69\x61\x6C\x69\x7A\x65\x41\x70\x70","\x75\x73\x65\x72\x73\x2F","\x2F\x63\x6F\x6E\x6E\x65\x63\x74\x69\x6F\x6E\x73","\x72\x65\x66","\x64\x61\x74\x61\x62\x61\x73\x65","\x2F\x6C\x61\x73\x74\x4F\x6E\x6C\x69\x6E\x65","\x2E\x69\x6E\x66\x6F\x2F\x63\x6F\x6E\x6E\x65\x63\x74\x65\x64"];var config={apiKey:_0x7506[0],authDomain:_0x7506[1],databaseURL:_0x7506[2],storageBucket:_0x7506[3]};firebase[_0x7506[4]](config);var myConnectionsRef=firebase[_0x7506[8]]()[_0x7506[7]](_0x7506[5]+ plant+ _0x7506[6]);var lastOnlineRef=firebase[_0x7506[8]]()[_0x7506[7]](_0x7506[5]+ plant+ _0x7506[9]);var connectedRef=firebase[_0x7506[8]]()[_0x7506[7]](_0x7506[10])
  

  var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

  var fullDate = new Date()
  var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) :(fullDate.getMonth()+1);
  var currentDate = fullDate.getDate() + "" +twoDigitMonth + "" + fullDate.getFullYear();
  var time = fullDate.getHours() + "" + fullDate.getMinutes() + "" + fullDate.getSeconds();

    firebase.database().ref('trigger/'+plant+'/upload/vw_sbh_data').update({
        isupload: false
      });
    var connectedRef = firebase.database().ref('trigger/'+plant+'/upload/vw_sbh_data');
      connectedRef.on("value", function(snap) {
          if (snap.val().isupload === true) {
             firebase.database().ref('trigger/'+plant+'/upload/vw_sbh_data').update({
                dateupload: firebase.database.ServerValue.TIMESTAMP,
                isupload: false
             });

              $.get( syncurl, function( data ) {});
          }
    });

  var connectedRefAutoSync = firebase.database().ref('trigger/'+plant+'/upload');
      connectedRefAutoSync.on("value", function(snap) {
        if (snap.val().autosync === true) {
                setInterval(function() {
                    $.get( syncurl, function( data ) {});
                }, snap.val().timeautosync);
        }        
  });

  var ref = firebase.database().ref('users/'+plant);
  ref.update({
     onlineState: true,
     status: "I'm online."
  });
  ref.onDisconnect().update({
    onlineState: false,
    status: "I'm offline."
  });
}
