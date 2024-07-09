var facebookloginUrl = '/facebookConnector.php';

var fb_api = function() {
    this.appID = appId; // the application's ID (provided by Facebook)
    this.currentUser = null; // a JSON object that will hold the current user's data
    this.token = null; // the access token of the current Facebook session
    this.swfLoaded = false; // If swf loaded?
};

fb_api.prototype = {
    // calling the init method of the Facebook's API
    init:function() {
        log("init appID=" + this.appID);
        FB.init({
            appId : this.appID,
            status: true,
            cookie: true,
            xfbml: true
        });
        // CANVAS RESIZE
        FB.Canvas.setAutoGrow();
    },
    //
    getLoginStatus:function() {
        log("getLoginStatus");
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {		
                log("Logged in.");
                F.token = response.authResponse.accessToken;
                F.getCurrentUserInfo();
            //} else if (response.status === 'not_authorized') {
            //log("the user is logged in to Facebook, but has not authenticated your app");
            } else {
                log("Not logged in.");
                F.showFlash();
            }
        });
    },
    getLogin: function (callback){
        log("Try to login");
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {		
                log("User logged already.");
                F.token = response.authResponse.accessToken;
                F.getCurrentUserInfo();
                
                // Run Callback function if user is logged in.
                if (callback && typeof(callback) == 'function'){
                    callback();
                }
            //} else if (response.status === 'not_authorized') {
            //log("the user is logged in to Facebook, but has not authenticated your app");
            } else {
                log("Auto login tries to log user manually");
                
                // Login Mechanism.
                FB.login(function(response) {
                    if (response.authResponse) {
                        log("Logging successful.");
                        F.token = response.authResponse.accessToken;
                        F.getCurrentUserInfo();

                        log("Logging succeed");
                        
                        // (TRIAL) Run Callback function if user is logged in.
                        if (callback && typeof(callback) == 'function'){
                            callback();
                        }

                        // Redirect to facebook connnect.
                        //top.location = facebookloginUrl;
                        //return true;

                    } else {
                        log("Logging failed.");
                        return false;
                    }
                }, {
                    scope: 'email,user_birthday,publish_stream,user_photos'
                });
                // --- //
            }
        });
    },
    //
    getCurrentUserInfo:function() {
        log("getCurrentUserInfo");
        FB.api('/me', function(response) {
            if(response) {
                F.currentUser = response;
            } else {
                log("getCurrentUserInfo failed");
            }
            // Show flash after getCurrentUserInfo whenether it fails or succeeds.
            F.showFlash();
        });
    },
    //
    getToken:function(){
        log("GetToken");
        F.getFlash().onGetToken(this.token);
    },
    //
    getUserDetails:function(){
        log("GetUserDetails");
        F.getFlash().onGetUserDetails(JSON.stringify(this.currentUser));
    },
    //
    getFriends:function() {
        log("getFriends");
        FB.api('/me/friends', function(response) {
            if(response) {
                var i;
                log("response.data.length:"+response.data.length);
                for(i=0; i<response.data.length; i++){
                    log("image"+i+" :"+response.data[i].id);
                    response.data[i].photo = fb_api.prototype.getProfilePicture(null, response.data[i].id, true);
                }
                response.data.sort(function(a,b)
                {
                    if (a.name < b.name)
                        return -1;
                    if (a.name > b.name)
                        return 1;
                    return 0;

                });
                F.getFlash().onGetFriends(JSON.stringify(response.data));
            } else {
                log("getFriends failed");
            }
        });
    },
    //
    /**
     * requires "user_photos,friends_photos"
     */
    getAlbums:function(id) {
        log("getAlbums");
        var url;
        if(id != null){
            url = '/'+id+'/albums';
        }else{
            url = '/me/albums';
        }
        FB.api(url, function(response) {
            if(response) {
                F.getFlash().onGetAlbums(JSON.stringify(response.data));
            } else {
                log("getAlbums failed");
            }
        });
    },
    //
    createAlbum:function(aname,amessage){
        log("createAlbum");
        var params = {
            name: aname,
            message: amessage
        };
        FB.api('/me/albums', 'post', params, function(response) {
            if(response) {
                
                log(response);
                
                F.getFlash().onCreateAlbum(JSON.stringify(response));
            } else {
                log("postWithApi failed");
            }
        });
    },
    /**
     * requires "user_photos,friends_photos"
     * 
     * url size format	:	t, q, n
     * ex	:	<xxx>_t.jpg
     */
    getPhotos:function(id) {
        log("getPhotos");
        var url;
        if(id != null){
            url = '/'+id+'/photos';
        }else{
            url = '/me/photos';
        }
        FB.api(url, function(response) {
            if(response) {
                F.getFlash().onGetPhotos(JSON.stringify(response.data));
            } else {
                log("getPhotos failed");
            }
        });
    },
    //
    getProfilePicture:function(size, id, isreturn){
        //size:square,small,normal,large
        log("getProfilePicture id:"+id+" size:"+size);
        var url;
        if(id != null){
            if(size == null || size == ""){
                size = "small";
            }
            url = "https://graph.facebook.com/"+id+"/picture?type="+size;
        }
        else
        {
            if(size == null || size == ""){
                size = "small";
            }
            url = "https://graph.facebook.com/"+this.currentUser.id+"/picture?type="+size;
        }
        log("url:"+url);
        if(isreturn != null){
            return url;
        }else{
            F.getFlash().onGetProfilePicture(url);
        }
    },
    //
    postWithUi:function(plink,ppicture,pname,pcaption,pdescription){
        log("postWithUi");
        F.getLogin(function (){
            // function
            var obj = {
                method: 'feed',
                link: plink,
                picture: ppicture,
                name: pname,
                caption: pcaption,
                description: pdescription
            };
            FB.ui(obj, function(response) {
                if(response) {
                    F.getFlash().onPostWithUi(JSON.stringify(response));
                } else {
                    log("postWithUi failed");
                }
            });
            // end function
        });
    },
    //
    postWithCampaignUi:function(plink,ppicture,pname,pcaption,pdescription){
        log("postWithUiCampaign");
        F.getLogin(function (){
            // function
            var obj = {
                method: 'feed',
                link: plink + FB.getUserID(),
                picture: ppicture,
                name: pname,
                caption: pcaption,
                description: pdescription
            };
            FB.ui(obj, function(response) {
                if(response) {
                    //F.getFlash().onPostWithUi(JSON.stringify(response));
                } else {
                    log("postWithUi failed");
                }
            });
            // end function
        });
    },
    //
    postWithApi:function(pmessage,plink,ppicture,pname,pcaption,pdescription){
        log("postWithApi");
        var params = {
            message: pmessage,
            link: plink,
            picture: ppicture,
            name: pname,
            caption: pcaption,
            description: pdescription
        };
        FB.api('/me/feed', 'post', params, function(response) {
            if(response) {
                F.getFlash().onPostWithApi(JSON.stringify(response));
            } else {
                log("postWithApi failed");
            }
        });
    },
    //
    sendRequestToRecipients:function(rmessage,rto){
        log("sendRequestToRecipients");
        var params = {
            method: 'apprequests',
            message: rmessage,
            to: rto
        };
        FB.ui(params, function(response) {
            if(response) {
                F.getFlash().onSendRequestToRecipients(JSON.stringify(response));
            } else {
                log("sendRequestToRecipients failed");
            }
        });   
    },
    //
    sendRequestWithSelector:function(rmessage){
        log("sendRequestWithSelector");
        var params = {
            method: 'apprequests',
            message: rmessage
        };
        FB.ui(params, function(response) {
            if(response) {
                F.getFlash().onSendRequestWithSelector(JSON.stringify(response));
            } else {
                log("sendRequestWithSelector failed");
            }
        });  
    },
    //
    sendFriendRequest:function(userid){
        log("sendFriendRequest");
        var params = {
            method: 'friends.add',
            id: userid
        };
        FB.ui(params, function(response) {
            if(response) {
                F.getFlash().onSendFriendRequest(JSON.stringify(response));
            } else {
                log("sendFriendRequest failed");
            }
        });  
    },
    //
    showFlash:function() {
        if (F.swfLoaded == false){
            // Sanalika.php function.

            /*
            if (window.initSwf){
                log("Display swf");
                
                // Init swf on page script.
                initSwf();
                
                F.swfLoaded = true;
            } else {
                log("Init swf is absent, we are not in play page, that's ok");
            }
            */
            F.swfLoaded = true;
        } else {
            log("Swf already loaded.");
        }
    },
    //
    getFlash:function() {
        log('getFlash (to trigger methods in swf)')
        return document.getElementById("sanalikaflashcontent");
    }
};

function log(obj) {
    if(window.console) {
        console.log(obj);
    }
}
