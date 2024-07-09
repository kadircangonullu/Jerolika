/* simple proof-of-concept code, for testing only */

if (typeof($adtext) == 'undefined'){
var $adtext = (function ()
{

 var appNamespace = "$adtext";
 var version = "";

 var opts = {
  lines: 13, // The number of lines to draw 13
  length: 5, // The length of each line 5
  width: 2, // The line thickness 5
  radius: 3, // The radius of the inner circle 4
  corners: 1, // Corner roundness (0..1) 1
  rotate: 0, // The rotation offset
  color: '#404040', // #rgb or #rrggbb dev #404040
  speed: 1.8, // Rounds per second 1.8
  trail: 60, // Afterglow percentage 40
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: 'auto', // Top position relative to parent in px
  left: 'auto' // Left position relative to parent in px
 };

 var spinner;
 var gSpinTimer=0;

 //    var spinner = new Spinner(opts).spin(target); 

 var pub = {};
 var global_kwlist = [];
 var global_linkwords = [];

 var gNodeList = [];
 var gTextNodeList = [];
 var harvestDepth=0;
 var wordlinks={};

 var nodes = [];
 var nodeLevel = 0;
 var nodeIndex = 0;
 var hdiag = '';



 var depth = 0;
 var tinfo = '<pre>';
 var myTextNodes = [];

 var activeObj = 0;
 var gframe = 0;

 var state = 0;
 var states = {
  idle: 0,
  polling: 1,
  ready: 2,
  error: 4,
  adclosing: 5
 };
 var statetext = {
  0: 'idle',
  1: 'polling',
  2: 'ready',
  4: 'error',
  5: 'adclosing'
 };

 var link = {
  title: '',
  desc: '',
  vurl: '',
  bid: '',
  ecb: '',
  click: ''
 };

 var config = {
  coreDomain: 'intext.nav-links.com',
  supportedBrowsers: 'firefox,iphone,xie,chrome,xsafari,xopera',
  supportedMobileBrowsers: 'iphone,ipad,xandroid,xgeneric',
  supportedCMS: 'wordpress,xdrupal,xjoomla,xphpbb,xvtbulletin,xblogger,xtumblr,xweebly',
  options:'',
  options2: '',
  adbox_logo_blank: 1, 
  afid: '',
  subid: '',
  helpurl: 'http://www.nav-links.com/help.html',
  brand_title: '',
  brand_helpurl: '',
  brand_privacyurl: '',
  maxP1: 0, 
  maxP2: 0, 
  maxP3: 0, 
  maxSpanCount: 5,
  mpl: 0, 
  rms: 1,
  maxDuplicates: 1,
  maxHTMLSend: 5000,
  minPageWords: 150,
  boxWidth: 315,
  boxHeight: 185,
  maxMouseAwayMS: 520,
  maxLastAdFocusMS: 520,
  maxInitZeroMouseMS: 3000,
  minAdBoxShowTimeMS: 1200
 };

 var properties = {
  url_afid: 'advertisewp',
  url_subid: 'advertisewp11',
  url_maxlinks: '8',
  url_linkcolor: '',
  url_options: 'metarank',
  browserbase: 'chrome/safari',
  browserver: '31.0.1650.63',
  browsersupport: '1',
  appsig: 'S20131387026297z',
  subscribe: '',
  subscribe2: '',
  branduid: '29231d25e08b9525dc6ecfe29741d1da|1387026297',
  browser: '?',
  ua: '?',
  version: '?',
  supportedMobileBrowser: 0,
  osname: '?',
  refer_url: 'http://www.com.nu/',
  page_url: '?',
  refer_domain: 'com.nu',
  page_domain: '?',
  mobile: 0,
  cms: '?',
  last_polling_start_timestamp: 0, 
  adult_kw_matches: '',
  adult_pagetext_hits: 0,
  adult_meta_hits: 0,
  adult_pageurl_hits: 0,
  adbox_visible: 0, 
  adbox_display_timestamp: 0, 
  adbox_query_text: '',
  activespan: '?',
  spanmap: '',
  activetitle: '',
  activedomain: '',
  activeclick: '',
  activebid: '',
  activeclick2: '',
  activeecb: '',
  spancount: 0, 
  metarankhits: 0, 
  intdisthits: 0, 
  adpos_left: 0,
  adpos_top: 0,
  adpos_top_adjusted: 0,
  adpos_left_adjusted: 0,
  adpos_line_height: 0,
  adpop_events_active: 0,
  adpop_adclick: 0,
  adpop_pagetext_click: 0,
  textlink_left: 0, 
  textlink_top: 0, 
  textlink_height: 0, 
  textlink_width: 0,
  lastMouseMove:0,
  mouseOverPageTextX: 0, 
  mouseOverPageTextY: 0, 
  mousePageX:0,
  mousePageY:0,
  lastFocusTimestamp:0, 
  lastMouseAwayAd: 0,
  lastMouseOverAd: 0
 };


 var rcache = new Array();
 var usecache = 1;
 var autoClose = 0;
 var adErrorCount = 0;
 var maxErrorCount = 3;
 var debugMode = 0;
 var d4count = 0;
 var d4text = '';
 var allowClickThru = 0;

 var testLanding = "http://intext.advertise.com/misc/landing.html";
 var useTestLanding = 0;



 var gTimer;
 var gclickTextFlag = 0;
 var gclickf862se3j7u8Flag = 0;
 var gboxShowTime = 0;
 var gboxDisplayTime = 0;
 var glastMouseAwayAd = 0;
 var glastMouseOverAd = 0;
 var gcloseAdEvent = 0; // not used, remove ?

 var initflag = 0;
 var stopwordhash = new Array();
 var pagewordhash = new Array();
 var linkcount = 0;
 var adpop_spinner_span;
 var adpop_adbox_span;
 var f862se3j7u8_class;

 var ajax, ajaxcontrol={};


 pub.processPage = function ()
 {
  if (0) return;

  startup();

 }



 function startup()
 {
  var html = '';
  var title = '';
  var pageurl = '';
  var metaCollection;
  var metakw = '';
  var metadesc = '';
  var h2text = '';
  var imgtext = '';



  properties.userip = '88.252.204.226'; 

  setBrandingParms(); /* should come first */

  setBrowserProperties();
  writeLog(1,'browser2b: '+properties.browser);
  if (properties.browser == 'ie') config.maxHTMLSend=3500;

  checkSubscriberStatus(); 
  writeLog(1,'Subscribe2 value = '+properties.subscribe2);

  writeLog(1, 'startup() ver=2013-08-30');
  writeLog(1,'BrowserBase: '+properties.browserbase+'  ver='+properties.browserver);
  writeLog(1,'BrowserSupport: '+properties.browsersupport);
  writeLog(1,'config.rms: '+config.rms);

  setPageLocation();
  if (properties.page_url.length <= 0 || properties.page_domain.length <= 0)
  {
   writeLog(1,'PageLocation: cant determine script page url');
   sendAbortMessage('pagelocation: cant determine script page url');
   return(0);
  }

  if (properties.page_url.indexOf(config.coreDomain) >= 0)
   {
    writeLog(1,'PageLocation: script not allowed on core domain.');
    sendAbortMessage('pagelocation: script not allowed on core domain.');
    return(0);
   }

  setPublisherParms();

  setOSVersion();


  if (document.body)
   {
     writeLog(1,"Startup: document.body found");
   }
  else
   {
    writeLog(1, "Error: document.body not defined (yet)");
    sendAbortMessage("document body not defined, script aborted");
    return(0);
   }


  /* setBrowserProperties(); */
  setContentManagementSystem();

 if (0)
  {
   if (typeof Spinner === 'undefined') /* temp thing until we write our on spinner (ah) */
    {
     writeLog(1,'warning: spinner not available, script aborted.');
     return(0);
    }
   else
    {
     writeLog(1,'info: spinner supported.');
    }
  }


  sendStartupMessage('afid='+config.afid+' pageurl=['+properties.page_url+']');


  if (1==0 && !(properties.userip == '76.20.232.116' || properties.userip == '66.150.185.98'))
  {
   myAlert(0, 'userip 88.252.204.226 not supported. uip=' + properties.userip);
   return (0);
  }

  if (config.afid.length <= 0)
  {
   writeLog(1,'publisher: no affiliate id provided, script aborted.'); 
   sendAbortMessage('publisher: no affiliate id provided, script aborted.')
   return(0);
  }

  if (config.maxSpanCount <= 0)
  {
   writeLog(1,'publisher: maxlinks set to zero, script aborted.');
   sendAbortMessage('publisher: maxlinks set to zero, script aborted.');
   return(0);
  }

  if (supportedBrowser() == 0)
  {
   writeLog(1, 'browser not supported / ' + properties.browser + ' ' + properties.version);
   writeLog(1, 'browser not supported: '+properties.browserbase+' ver='+properties.browserver);
   sendAbortMessage('browser not supported:'+properties.browserbase+' ver='+properties.browserver);
   return (0);
  }
 else
  {
   writeLog(1,'browser supported: '+properties.browserbase+' ver='+properties.browserver);
  }

  if (1==0 && supportedCMS() == 0)
   {
    writeLog(1, 'cms platform not supported: ' + properties.cms);
    sendAbortMessage('cms platform not supported: ' + properties.cms);
    return(0);
   }


  
  if (properties.page_url.toLowerCase().substr(0,5) == 'https')
   {
    writeLog(1, "secure web page detected, script aborted.");
    sendAbortMessage("secure web page, script aborted url=["+properties.page_url+"]");
    return(0);
   }

   writeLog(1,'SubscribeCookie Value = ['+properties.subscribe+']');
  if (1==1 && properties.subscribe.substr(0,2) == 'no')
   {
    writeLog(1,'User has previously requested to opt-out, script aborted.');
    sendAbortMessage('User has previously requested to opt-out, script aborted.');
    return(0);
   }

  if (1==1 && properties.subscribe2.substr(0,2) == 'no') /* local check, need server side cookie echo? */
   {
    writeLog(1,'OptOut: CheckNow, User has previously requested to opt-out, script aborted.');
    sendAbortMessage('User has previously requested to opt-out, script aborted.');
    return(0);
   }

  ajax = setupAjax();

  pagewordhash = []; 


  if (initflag == 0) init();

  writeLog(1,'starting text harvest');
  var obj = document.body; // alert: this works -->  document.getElementsByTagName('body')[0];
  myHarvest(obj); 


  // var str="gNodeList.length="+gNodeList.length+",  gTextNodeList.length="+gTextNodeList.length;
  // try { document.getElementById('nodes').innerHTML=str;} catch(e) {alert('nodes div not found'); }


 html = getDocumentText(); 
 pageurl = document.location.href;
 title = document.title;

  if (pageurl.length > 255)
   pageurl= pageurl.substr(0, 150) + '...';

  metaCollection = document.getElementsByTagName('meta');
  for (var i = 0; i < metaCollection.length; i++)
  {
   if (metaCollection[i].name.toLowerCase() == 'keywords')
    {
     metakw=metaCollection[i].content;
     metakw=cleanup_misc_text(metakw);
     metakw=finalize_misc_text(metakw, 255);

    }
   if (metaCollection[i].name.toLowerCase() == 'description')
    {
     metadesc=metaCollection[i].content;
     metadesc=cleanup_misc_text(metadesc);
     metadesc=finalize_misc_text(metadesc, 255);
    }
  }

  h2text = getTagText('h2');
  h2text = cleanup_misc_text(h2text);
  h2text = finalize_misc_text(h2text, 255);

  title= cleanup_misc_text(title);
  title= finalize_misc_text(title, 255);

  /* imgtext = getTagText('img'); not used right now (ah) */

  writeLog(1, 'pre cleanup html bytes='+html.length);

  html = cleanup_page_text(html);
  writeLog(1, 'post cleanup html bytes='+html.length);
  writeLog(1, 'title.length    = '+title.length);
  writeLog(1, 'metakw.length   = '+metakw.length);
  writeLog(1, 'metadesc.length = '+metadesc.length);
  writeLog(1, 'h2text.length   = '+h2text.length);
  writeLog(1, 'imgtext.length  = '+imgtext.length);

 var sendHDRBytes = calcEncoding('url',   pageurl)
                +calcEncoding('title',    title)
                +calcEncoding('metakw',   metakw)
                +calcEncoding('metadesc', metadesc)
                +calcEncoding('h2text',   h2text)
                +calcEncoding('imgtext', imgtext);

 writeLog(1, 'encoded hdr send bytes = '+sendHDRBytes);
 var maxSend=config.maxHTMLSend - sendHDRBytes;
 writeLog(1,' config.maxHTMLSend = '+config.maxHTMLSend+'  adjusted to '+maxSend);

 var html_raw_length=html.length;
 html = finalize_page_text(html, maxSend);

 writeLog(1, 'post finalize html bytes='+html.length+'  raw len='+html_raw_length);

 var page_word_count=0;
 if (html == "")
 {
  myAlert(0, "No Data");
 }
 else
 {
  html = html.replace(new RegExp('/<!--(.*)-->/g'), " "); /* review (ah) */
  page_word_count = parse_words(html.toLowerCase());
  /* var b = pageurl.length + title.length + metakw.length + metadesc.length + w.length; */
 }

 writeLog(1,'sending page data to analyzer, bytes='+(sendHDRBytes+html.length)+' max='+config.maxHTMLSend);

 var rnum = Math.floor(Math.random() * (1000 * 1000));
 
  /* note: IE has a max post limit of ~3200 bytes ... and encoding can increase sent by 1.5 */

  var htmlSendBytes=encodeURIComponent(html).length;
  var sendBytes=sendHDRBytes + htmlSendBytes + 50;
  
  if (sendBytes >= config.maxHTMLSend)
   {
    writeLog(1,'total data post exceeds config.maxHTMLSend of '+config.maxHTMLSend);
    sendAbortMessage('total data post '+sendBytes+' exceeds '+config.maxHTMLSend+' afid='+config.afid+' maxSend='+maxSend+' hdr='+sendHDRBytes+' html='+htmlSendBytes+' url=['+pageurl+']');
    return(0);
   }

  if (1==0 && page_word_count < 10) /* config.minPageWords  */
   {
     writeLog(1,'Page words = '+page_word_count+' below min of '+config.minPageWords+', script aborted.');
     sendAbortMessage('minimum pagewords not reached, pagewords='+page_word_count+' min='+config.minPageWords+' afid='+config.afid+' url=['+pageurl+']'); 
    return(0);
   }
  
  properties.last_polling_start_timestamp=getMSTime();


  ajax(
  {
   async: true,
   url: 'http://'+config.coreDomain+'/util/intexteval.pl?op=eval&x=3&xop=eval&rnum='+rnum,
   type: 'POST',
   dataType: 'text/plain',
   charset: 'utf-8',
   timeout: 5000,
   data: {
    "appsig": properties.appsig,
    "branduid": properties.branduid,
    "afid": config.afid,
    "subid": config.subid,
    "core": config.coreDomain,
    "url": pageurl,
    "maxpagelinks": config.mpl,
    "options": config.options,
    "title": title,
    "metakw": metakw,
    "metadesc": metadesc,
    "h2text": h2text,
    "imgtext": imgtext,
    "html": html
   },
   load: function ()
   {},
   success: function (data, textStatus, xhr)
   {
    
    properties.last_polling_start_timestamp=0;

    checkForSysMsg(data);

    var xml = parseTag(data, "<sponsored>", "</sponsored>");

    writeLog(1,'creating inpage hyperlinks, data.length='+data.length);

    if (1==1 && (properties.userip == '66.150.185.98' || properties.userip == '24.126.154.251') )
     {
      writeLog(1,'EVAL RESPONSE:['+data+']');
     }


    var p1 = parseTag(data, "<p1>", "</p1>");
    var p2 = parseTag(data, "<p2>", "</p2>");
    var p3 = parseTag(data, "<p3>", "</p3>");

    var p1 = parseTag(data, "<hvtp1>", "</hvtp1>");
    var p2 = parseTag(data, "<hvtp2>", "</hvtp2>");
    var p3 = parseTag(data, "<hvtp3>", "</hvtp3>");

    var p1Terms=p1.split('\|');
    var p2Terms=p2.split('\|');
    var p3Terms=p3.split('\|');

    var adult_kw_matches= parseTag(data, "<adultmatches>", "</adultmatches>");
    var adult_pagetext_hits= parseTag(data, "<adult>", "</adult>");
    var adult_meta_hits= parseTag(data, "<adultmeta>", "</adultmeta>");
    var adult_pageurl_hits= parseTag(data, "<adultpageurl>", "</adultpageurl>");

    var domainBlockFlag= parseTag(data, "<domainblock>", "</domainblock>");

    properties.adult_kw_matches=adult_kw_matches;
    properties.adult_pagetext_hits=parseIntV2(adult_pagetext_hits);
    properties.adult_meta_hits=parseIntV2(adult_meta_hits);
    properties.adult_pageurl_hits=parseIntV2(adult_pageurl_hits);

    writeLog(1,'adult matches      ='+properties.adult_kw_matches);
    writeLog(1,'adult url      hits='+properties.adult_pageurl_hits);
    writeLog(1,'adult meta     hits='+properties.adult_meta_hits);
    writeLog(1,'adult pagetext hits='+properties.adult_pagetext_hits);

    var adultPageFlag = checkAdultPage();
    writeLog(1,'adult content flag = '+adultPageFlag);
    if (adultPageFlag > 0)
     {
      writeLog(1,'adult page detected, script aborted.');
      sendProcessPageMessageV2(1, 'adult content: hits='
                              +properties.adult_pageurl_hits+','
                              +properties.adult_meta_hits+','
                              +properties.adult_pagetext_hits
                              +'  domain='+properties.page_domain+' afid='+config.afid+':'+config.subid+'  page='+properties.page_url);
      sendAbortMessage('adult page detected domain='+properties.page_domain+' afid='+config.afid+':'+config.subid+'  page='+properties.page_url);
      return(0);
     }

    if (domainBlockFlag > 0)
     {
      writeLog(1,'domain block flag, script aborted.');
      sendAbortMessage('domain block domain='+properties.page_domain+' afid='+config.afid+':'+config.subid+'  page='+properties.page_url);
      return(0);
     }

    writeLog(1,'term candidates: p1='+p1Terms.length+'  p2='+p2Terms.length+' p3='+p3Terms.length);

    


    if (1== 0 &&  config.afid == 'blueseek1') {config.maxSpanCount=10; config.maxP2=0;}

    if (1==1 && config.maxSpanCount <= 10)
     {
       if (p2Terms.length > 10 ) config.maxP3=2;
     }

    // if (p3.length > 0 || 1 == 1) p3 += "|j572,10,0,0";       // alert:  test thing remove 
    // if (p3.length > 0 || 1 == 1) p3 += "|investing,10,0,0";  // alert: test thing 

    writeLog(1,'text node list size = '+gTextNodeList.length);

    properties.metarankhits=0;
    properties.intdisthits=0;

    var p3count=setLinkTermsByNodeList(p3Terms, '3 word terms', config.maxP3);
    var p2count=setLinkTermsByTermList(p2Terms, '2 word terms', config.maxP2);
    var p1count=setLinkTermsByTermList(p1Terms, 'single terms', config.maxP1);

    buildSpanMap();
    writeLog(1,'spanmap='+properties.spanmap);

    // writeLog(1,'links: p1='+p1count+' p2='+p2count+', p3='+p3count);
    writeLog(1,'links: total=' +properties.spancount+' (max='+config.maxSpanCount+')');

    if (config.options2.toLowerCase().indexOf("linkstats") != -1)
     {
      sendProcessPageMessageV2(1, 'linkstat:' +properties.spancount
                                 +' metahits='+properties.metarankhits
                                 +' intdisthits='+properties.intdisthits
                                 +' spanmap='+properties.spanmap+';'
                                 +' domain='+properties.page_domain
                                 +' afid='+config.afid+':'+config.subid
                                 +' page='+properties.page_url.substr(0, 100));
     }

   },
   error: function (obj, textStatus, errThrow)
   {
    writeLog(1, "Error(2):" + textStatus + '/err=' + errThrow + '/status=' + obj.status + '/resp=' + obj.responseText);
    writeLog(1,'-----------------------------------------------');
    properties.last_polling_start_timestamp=0;
   },
   complete: function (xhr, textStatus)
   {
    writeLog(1,'Page Ready!');
    writeLog(1,'-----------------------------------------------');
    properties.last_polling_start_timestamp=0;
   }
  });

 }

 function setBrandingParms()
 {
  var coreDomain='intext.nav-links.com';
  var helpurl='http://intext.nav-links.com/help.html';
  var extbrand='1';

  if (coreDomain.charAt(0) != '$' && coreDomain.length > 0)
   config.coreDomain=coreDomain;

  if (helpurl.charAt(0) != '$' && helpurl.length > 0)
   config.helpurl=helpurl;

  if (parseInt(extbrand) == 1)
   config.adbox_logo_blank=1;
  else
   config.adbox_logo_blank=0;

  if (config.brand_title.length > 0)
   {
    /* alert: here ??? */ 
   }



  writeLog(1,'Brand.core='+config.coreDomain);
  writeLog(1,'Brand.help='+config.helpurl);
  writeLog(1,'Brand.blank='+config.adbox_logo_blank);
  writeLog(1,'Brand.title='+config.brand_title);
  writeLog(1,'Brand.help='+config.brand_helpurl);
  writeLog(1,'Brand.privacy='+config.brand_privacyurl);
  if (config.brand_title.length > 0 && config.brand_helpurl.length == 0)
   {
    writeLog(1,'Brand helpurl is invalid or not present, using default help url.');
   }


  return(1);
 }


 function setPageLocation()
 {
  var pageurl='';
  var pagehost='';


  try
   {
    var url=''+window.location.href;
    var domain=''+window.location.hostname;
    properties.page_url=url;  /* indexOf() failed if set directly */
    properties.page_domain=domain;

   }
  catch(e)
   {
    properties.page_url=''; /* 'http://www.com.nu/'; */
    properties.page_domain=''; /* 'com.nu'; */
   }

 if (properties.page_url.length <= 0)
  {
  try
   {
    var url=''+document.location.href;
    properties.page_url=url;
   }
  catch(e)
   {
   }
  }

  writeLog(1, 'page='+properties.page_url);
  writeLog(1, 'domain='+properties.page_domain);

 if (properties.page_url.length <= 0 || properties.page_domain <= 0)
  {
   return(-1);
  }

 return(0);

 }


 function setPublisherParms()
 {
  var afid='';
  var subid='';
  var maxlinks=5;
  var linkcolor='';
  var options='';

  if (!(typeof _intext_afid       === 'undefined')) afid=_intext_afid;
  if (!(typeof _intext_subid      === 'undefined')) subid=_intext_subid;
  if (!(typeof _intext_maxlinks   === 'undefined')) maxlinks=parseInt(_intext_maxlinks);
  if (!(typeof _intext_linkcolor  === 'undefined')) linkcolor=_intext_linkcolor;

 writeLog(1,'url_afid='+properties.url_afid);
  if (properties.url_afid.length > 0) afid=properties.url_afid; 
  if (properties.url_subid.length > 0) subid=properties.url_subid; 
  if (properties.url_maxlinks.length > 0) maxlinks=properties.url_maxlinks;
  if (properties.url_linkcolor.length > 0) linkcolor=properties.url_linkcolor;

  if (properties.url_options.length > 0) options=properties.url_options;


  setPublisherParmsByVar(afid, subid, maxlinks, linkcolor, options);
 
 }

 function setPublisherParmsByVar(afid, subid, maxlinks, linkcolor, options)
 {

  config.afid='';
  config.subid='';
  config.linkColor='#009900';
  config.options='';


  if (maxlinks <0 || maxlinks > 25)
   config.maxSpanCount=5;
  else
   config.maxSpanCount=maxlinks;

  config.mpl=parseInt(maxlinks);


  if (config.maxSpanCount != 0 && config.maxSpanCount < 2)
   config.maxSpanCount=2;
 
  afid=afid.toLowerCase();
  subid=subid.toLowerCase();
  
  config.afid=afid; 
  config.subid=subid;

  config.options=options;

  if (linkcolor.length == 6 || linkcolor.length == 7)
   {
    if (linkcolor.length == 6)
     config.linkColor='#'+linkcolor;
    else
     config.linkColor=linkcolor;
   }

  if (1==0)
   {
    config.linkColor='#0000D5'; /*  forced blue per + toggle blue/red  per daniel (ah) */
    try
     {
      var d=new Date();
      var mday=d.getDate();
      if (mday % 2 == 0)
       config.linkColor='#D50000';
      else
      config.linkColor='#0000D5'; 
     } catch(e) {}
   }

  writeLog(1,'publisher: afid='+config.afid+', subid='+config.subid+', maxlinks='+config.maxSpanCount+', color='+config.linkColor);
  writeLog(1,'publisher: options='+config.options);

 }


 function setOSVersion()
 {
  var osname='?';
  var osname2='?';

  if (navigator.appVersion.toLowerCase().indexOf("win")!=-1) osname="windows";
  if (navigator.appVersion.toLowerCase().indexOf("mac")!=-1) osname="macos";
  if (navigator.appVersion.toLowerCase().indexOf("x11")!=-1) osname="unix";
  if (navigator.appVersion.toLowerCase().indexOf("linux")!=-1) osname="linux" 
  
  properties.osname=osname; 
  properties.appversion=navigator.appVersion;

  var oslist= {
               'Windows 3.11':        'Win16',
               'Windows 95':          '(Windows 95)|(Win95)|(Windows_95)',
               'Windows 98':          '(Windows 98)|(Win98)',
               'Windows 2000':        '(Windows NT 5.0)|(Windows 2000)',
               'Windows XP':          '(Windows NT 5.1)|(Windows XP)',
               'Windows Server 2003': '(Windows NT 5.2)',
               'Windows Vista' :      '(Windows NT 6.0)',
               'Windows 7':           '(Windows NT 7.0)',
               'Windows NT 4.0':      '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
               'Windows ME':          'Windows ME',
               'Open BSD':            'OpenBSD',
               'Sun OS':              'SunOS',
               'Linux':               '(Linux)|(X11)',
               'Mac OS':              '(Mac_PowerPC)|(Macintosh)',
               'QNX':                 'QNX',
               'BeOS':                'BeOS',
               'OS/2':                'OS/2',
               'Bot':                 'nuhk|Googlebot|Yammybot|Openbot|Slurp|MSNBot|Teoma|ia_archiver'
               };

  for (var str in oslist)
   {
    var e=oslist[str].split('\|');
    for(var i=0; i<e.length; i++)
     {
      var xstr=e[i].toLowerCase();
      if (navigator.appVersion.toLowerCase().indexOf(xstr) >= 0)
       {
        osname2=oslist.str;
        break;
       }
     }
    if (osname2.length > 0) break;
   } 
  
 properties.osname2=osname2;

 writeLog(1,'OSCheck: appversion='+properties.appversion+',  os='+osname+',  os2='+osname2);
 
 }

 function setBrowserProperties()
 {

  writeLog(1, 'setting browser properties');

  properties.browser = navigator.appCodeName.toLowerCase();
  properties.ua = navigator.userAgent.toLowerCase();
  properties.version = navigator.appVersion.toLowerCase();


  if (properties.ua.indexOf('firefox') >= 0)
   properties.browser = 'firefox';
  else if (properties.ua.indexOf('msie') >= 0)
   properties.browser = 'ie';
  else if (properties.ua.indexOf('chrome') >= 0)
   properties.browser = 'chrome';
  else if (properties.ua.indexOf('rv:11') >= 0)
   properties.browser = 'ie';
  else if (properties.ua.indexOf('safari') >= 0)
   properties.browser = 'safari';
  else
   properties.browser = '?';



  if (properties.ua.indexOf('mobile') >= 0)
   {
    if (properties.ua.indexOf('iphone') >= 0)
     properties.browser = 'iphone';
    else if (properties.ua.indexOf('ipad') >= 0)
     properties.browser = 'ipad';
    else
     properties.browser = 'generic';
    
    properties.mobile=1;
   }
  else
   properties.mobile=0;

  if (1==0) /* force browser config, for test only */
   {
     properties.mobile=1;
     properties.browser='generic';
   }

 }

 function setContentManagementSystem()
 {
  writeLog(1, 'setting content management system type');
  var metagen=document.getElementsByName("generator");
 
  // check meta generator tags
  for(var i=0; i<metagen.length; i++)
   {
    var content=metagen[i].getAttribute("content").toLowerCase();
    
    if (content.indexOf("blogger")   >= 0) { properties.cms= 'blogger'; break; }
    if (content.indexOf("joomla")    >= 0) { properties.cms= 'joomla'; break; }
    if (content.indexOf("phpbb")     >= 0) { properties.cms= 'phpbb'; break; }
    if (content.indexOf("tumblr")    >= 0) { properties.cms= 'tumblr'; break; }
    if (content.indexOf("weebly")    >= 0) { properties.cms= 'weebly'; break; }
    if (content.indexOf("wordpress") >= 0) { properties.cms= 'wordpress'; break; }
   }

  // another method is to check for objects directly 

  if(typeof window["Drupal"]    != 'undefined') {  properties.cms="drupal"; }
  if(typeof window["Joomla"]    != 'undefined') {  properties.cms="joomla"; }
  if(typeof window["blogger"]   != 'undefined') {  properties.cms="joomla"; }
  if(typeof window["vBulletin"] != 'undefined') {  properties.cms="vbulletin"; }
  if(typeof window["phpbb"]     != 'undefined') {  properties.cms="phpbb"; }
  if(typeof window["Tumblr"]    != 'undefined') {  properties.cms="tumblr"; }
 
  // nasty wordpress... lets check some link stuff 
  var links=document.getElementsByTagName("link");
  for(var i=0; i<links.length; i++)
   {
     var href=links[i].getAttribute("href");
     if (!href) continue;
    
     if (href.toLowerCase().indexOf("wp-content") >= 0) { properties.cms="wordpress";}
     // add other checks here as needed 
   }

  writeLog(1,'properties.cms='+properties.cms); 

 }


function checkAdultPage()
{
 var adult=0;

 if (properties.adult_pageurl_hits > 0)
  adult++;

 if (properties.adult_meta_hits >= 2)
  adult++;

 if (properties.adult_pagetext_hits >= 5)
  adult++;

 return(adult);
}

 function checkSubscriberStatus()
 {
  var value=readCookie('subscribe');

  properties.subscribe2=value; 
 
 }


 function supportedBrowser()
 {

  if (properties.mobile == 0)
   writeLog(1, 'checking supported browsers, current='+properties.browser);
  else
   writeLog(1, 'checking supported browsers, current='+properties.browser+' / mobile');


  properties.supportedMobileBrowser=0;

  if (properties.mobile == 1)
   {
    var smflag=0;
    var list = config.supportedMobileBrowsers.split(',');
    for (var i = 0; i < list.length; i++)
     if (properties.browser == list[i])
      smflag=1;

    if (smflag == 0)
     {
      writeLog(1,'mobile browser '+properties.browser+' not supported.');
      return(0);
     }
    writeLog(1,'mobile browser '+properties.browser+' supported.');

    properties.supportedMobileBrowser=1;
     
    return(1);
   }
  

  // alert: add version checking

  var list = config.supportedBrowsers.split(',');
  for (var i = 0; i < list.length; i++)
   if (properties.browser == list[i])
    return (1);


  /* alert: quick mod to enable support for ie 8,9, 10 formalize later (ah) */
  if (1 == 1 && ( (1==1 && properties.browserbase == 'msie' && parseInt(properties.browserver) == 11)
                                                    ||
                  (1==1 && properties.browserbase == 'msie' && parseInt(properties.browserver) == 10)
                                                    ||
                  (1==1 && properties.browserbase == 'msie' && parseInt(properties.browserver) == 9)
                                                    ||
                  (properties.browserbase == 'msie' && parseInt(properties.browserver) == 8)
                )
    ) 
   return(1);

  return (0);
 }

function supportedCMS()
 {

  writeLog(1, 'checking supported cms platforms: '+properties.cms);

  if (properties.cms == '?') return(1);

  var list = config.supportedCMS.split(',');
  for (var i = 0; i < list.length; i++)
   if (properties.cms== list[i])
    return (1);

  return (0);
 }





 function setLinkTermsByNodeList(linkwords, termtype, maxhits)
 {
  var count = 0;
  var max = 200;
  var hits = 0;
  var metarankhits=0;
  var intdisthits=0;

  /* tag words by transversing node list */

  if (linkwords.length > 0)
  {
   for (var n = 0; n < gTextNodeList.length; n++)
   {
    for (var i = 0; i < linkwords.length && i < max && properties.spancount <= config.maxSpanCount; i++)
    {
     var e = linkwords[i].split(',');
     if (e[1] > 0)
     {
      var termhits = setLinks5(gTextNodeList[n], e[0]);
      if (termhits > 0) writeLog(1,'term hit='+e[0]);
      if (termhits > 0 && e[3] == 999) metarankhits++;
      if (termhits > 0 && e[3] == 9992) intdisthits++;
      hits += termhits;
      if (maxhits > 0 && hits >= maxhits) break; 
      count++;
     }
    }
    if (maxhits > 0 && hits >= maxhits) break; 
   }
  }
 
  properties.metarankhits+=metarankhits;
  properties.intdisthits+=intdisthits;

  writeLog(1,'Pageset: '+termtype+' count='+hits);
  return (hits);
 }



 function setLinkTermsByTermList(linkwords, termtype, maxhits)
 {
  var count = 0;
  var max = 200;
  var hits = 0;
  var metarankhits=0;
  var intdisthits=0;

  /* tag words by transversing candidate term list */

  if (linkwords.length > 0)
  {
   for (var i = 0; i < linkwords.length && i < max && properties.spancount <= config.maxSpanCount; i++)
    {
     var e = linkwords[i].split(',');
     for (var n = 0; n < gTextNodeList.length; n++)
      {
       if (e[1] > 0)
        {
        var termhits = setLinks5(gTextNodeList[n], e[0]);
        if (termhits > 0) writeLog(1,'term hit='+e[0]);
        if (termhits > 0 && e[3] == 999)   metarankhits++;
        if (termhits > 0 && e[3] == 9992) intdisthits++;
        hits += termhits;
        if (maxhits > 0 && hits >= maxhits) break; 
        count++;
       }
      }
     if (maxhits > 0 && hits >= maxhits) break; 
    }
   }

  properties.metarankhits+=metarankhits;
  properties.intdisthits+=intdisthits;

  writeLog(1,'Pageset: '+termtype+' count='+hits);
  return (hits);
 }





 function getLineHeight(element)
 {

  //  return (16); // alert: quick test returning fixed line height, use proper method 

  try
  {
   var h=getObjectHeight(element);
   return(h);

   var temp = document.createElement(element.nodeName);
   temp.setAttribute("style", "margin:0px;padding:0px;font-family:" + element.style.fontFamily + ";font-size:" + element.style.fontSize);
   temp.innerHTML = "test";
   temp = element.parentNode.appendChild(temp);
   var ret = temp.clientHeight;
   temp.parentNode.removeChild(temp);
   return Math.round(ret);
  }
  catch (e)
  {
   return (14); // default 
  }

 }

 function getMSTime()
 {
  var d = new Date();
  var s = d.getTime();

  return(s);
 }


 function readCookie(name)
 {
 var empty='';
 var nameEQ = name + "=";
 var ca = document.cookie.split(';');

 for(var i=0;i < ca.length;i++)
  {
   var c = ca[i];
   while (c.charAt(0)==' ')
    c = c.substring(1,c.length);
   if (c.indexOf(nameEQ) == 0)
    return c.substring(nameEQ.length,c.length);
  }
  return empty;
 }

 function checkForSysMsg(xml)
  {
    var msg= parseTag(xml, "<sysmsg>", "</sysmsg>");

    if (msg.length > 0)
     writeLog(1,'SysMsg: '+msg);

  }
 

 function processHoverEvent()
 {
  var d = new Date();
  var s = d.getTime();

  writeLog(1,'processHoverEvent()');

    state = states.polling;

  // alert: check if same box already open ?

  var r = getResultCache(properties.adbox_query_text);
  if (r.title.length > 0)
  {
   // adpop_span.style.top=parseInt(adpop_span.style.top)+30+'px';
   // myAlert(1,'line height='+adpop_span.style.line_height);

   // adpop_span.style.top = parseInt(adpop_span.style.top) + getLineHeight(obj) + 10 + 'px';

   // spinner.stop();
   stopSpinner();


   setAdBoxPosition();
   var adhtml = buildAdPopHTML(r.title, r.desc, r.domain, r.click);
   setActiveClickThru(r.title, r.domain, r.click, r.bid, r.click2, r.ecb);

   adpop_span.style.textDecoration="none"; // alert: testing something 

   adpop_span.innerHTML = adhtml;
   displayAdBox();
   properties.adpop_events_active=1;

   // state = states.ready;
   gboxShowTime = 0;
   resetBoxShowTime();
   setLastFocusTime();
   
   properties.lastMouseAwayAd =0;
   properties.lastMouseOverAd = 0;
 
   glastMouseAwayAd = 0;
   glastMouseOverAd = 0;

   if (gTimer) clearInterval(gTimer);
   gTimer = setInterval(function () { checkDisplayFocus(); }, 50);

   // alert: seems old review for new methods --> cached result activeObj.addEventListener("mousemove", setLastFocusTime, false);

   state = states.ready;
   return;
  }


  var rnum = Math.floor(Math.random() * (1000 * 1000));

  properties.last_polling_start_timestamp=getMSTime();

 //adQueryTimoeout= setTimeout(function() { try { abortAdQquery(); } catch(e) {} }, 10000);

 try 
 {  

  ajax(
  {
   async: true,
   url: 'http://'+config.coreDomain+'/util/intexteval.pl?x=3&xop=adquery&rnum='+rnum,
   type: 'GET',
   timeout: 3000,
   dataType: 'text/plain',
   data: {
    "appsig": properties.appsig,
    "branduid": properties.branduid,
    "op": 'adquery',
    "query": properties.adbox_query_text,
    "Terms": properties.adbox_query_text,
    "affiliate": config.afid,
    "subid": config.subid,
    "ip": properties.userip,
    "branduid": properties.branduid,
    "Hits_Per_Page": 1,
    "ua": properties.ua,
    "domain": properties.page_domain,
    "serverurl": properties.page_url
   },
   load: function ()
   {
    writeLog(1, 'Hover: query to server for ad.');
    state = states.polling;

   },
   success: function (data, textStatus, xhr)
   {
    state = states.idle; /* alert: review this */
    properties.last_polling_start_timestamp=0;
    
    checkForSysMsg(data);

    myAlert(0, "srv:" + data);
    writeLog(1, 'Hover: xmlr result returned.  left='+properties.adpos_left+', top='+properties.adpos_top);
    var xml = parseTag(data, "<adtext>", "</adtext>");

    var title = parseTag(xml, "<title><![CDATA[", "]]></title>");
    var bid= parseTag(xml, "<bid><![CDATA[", "]]></bid>");
    var desc = parseTag(xml, "<description><![CDATA[", "]]></description>");
    var vurl = parseTag(xml, "<url><![CDATA[", "]]></url>");
    var domain = parseTag(xml, "<domain>", "</domain>");
    var click = parseTag(xml, "<redirect><![CDATA[", "]]></redirect>");
    var click2 = parseTag(xml, "<click2>","</click2>");
    var ecb= parseTag(xml, "<ecb>", "</ecb>");
    var oclick = click;


    if (click.length > 0 && useTestLanding == 1)
     {
        click = testLanding; // alert: remove 
     }

     if (1==1 && (properties.page_url.indexOf("hayden.com") >= 0 || properties.page_url.indexOf(config.coreDomain) >= 0))
      {
       click=testLanding;
      } 


    if (title.length > 0 && usecache == 1)
    {
     var r = new Array(); // = { title:'', desc:'', vurl:'', click:''};
     r.query = properties.adbox_query_text.toLowerCase();
     r.title = title;
     r.desc = desc;
     r.vurl = vurl;
     r.domain = domain;
     r.bid = bid;
     r.click = click;
     r.click2 = click2;
     r.ecb= ecb;
     rcache[r.query] = r;
    }

    // spinner.stop();
    stopSpinner();



   // alert('adpop_span.style.left='+adpop_span.style.left+', adpop_span.style.top='+adpop_span.style.top+', adpop_span.style.position='+adpop_span.style.position);

    if (validAdData(title, desc, domain, click) == 1)
    {
     adErrorCount = 0;
     // domain = 'priceline.com';
     setAdBoxPosition();
     var adhtml = buildAdPopHTML(title, desc, domain, click);
     setActiveClickThru(title, domain, click, bid, click2, ecb);


     adpop_span.innerHTML = adhtml;

     if (properties.supportedMobileBrowser == 1) // alert: just quick test, needs more review (ah)
      {
      properties.adpop_pagetext_click=1;
      // state = states.idle;
      // activeObj = 0;
      // window.location.href = click;
      // return; 
      } 


     state = states.ready;
     setLastFocusTime();
     gboxShowTime = 0;
 
     properties.lastMouseAwayAd = 0;
     properties.lastMouseOverAd = 0;

     glastMouseAwayAd = 0;
     glastMouseOverAd = 0;

     if (gTimer) clearInterval(gTimer);
     gTimer = setInterval(function () { checkDisplayFocus(); }, 50);

     // alert: 04/22 remove activeObj.addEventListener("mouseleave", doMouseExitAdBox, false); // alert: sometimes activeObj not defined here 
     // alert: 04/22 remove activeObj.addEventListener("mousemove", setLastFocusTime, false);

     resetBoxShowTime();

     displayAdBox();
     properties.adpop_events_active=1;

    }
    else
    {
     properties.last_polling_start_timestamp=0;
    sendDisplayMessage('QueryFail: event=nodata domain='+properties.page_domain+' afid='+config.afid+':'+config.subid+' uip='+properties.userip+' q=['+properties.adbox_query_text+'] r=['+properties.page_url+'] b=['+properties.browser+']');
     writeLog(1, 'HoverEvent: invalid xml ad data');
     closeActiveAd();
     state = states.idle;
     activeObj = 0;
     adErrorCount++;
     writeDebug(0, "no data for adv");
    }
   },
   error: function (xhr, textStatus, errThrow)
   {

    sendDisplayMessage('QueryFail: event=comerror domain='+properties.page_domain+' afid='+config.afid+':'+config.subid+' uip='+properties.userip+' q=['+properties.adbox_query_text+'] r=['+properties.page_url+'] b=['+properties.browser+'] err='+textStatus);

    properties.last_polling_start_timestamp=0;
    writeLog(1, 'HoverEvent: ajax request error for xml ad data');
    var adhtml = buildAdPopHTML(':error', '', '', '');
    state = states.error;
    writeLog(1, "<b>Error Fetching Query</b>" + textStatus + '/' + errThrow + '/' + state);
    stopSpinner();
    closeActiveAd();
    state = states.idle;
    activeObj = 0;

   },
   complete: function (xhr, textStatus)
   {
    properties.last_polling_start_timestamp=0;
    writeLog(1, 'Hover: query complete');

   }
  });
 }
 catch(e)
  {
    writeLog(1, 'ajax: error');
    stopSpinner();
    closeActiveAd();
    state = states.idle;
    activeObj = 0;
  }
 
 }

 function validAdData(title, desc, domain, click)
 {
  var ret = 1;
  if (!(title.length >= 3 && desc.length > 10 && domain.length > 5 && click.length > 12))
  {
   ret = 0;
  }
  //  alert:  add other eval here 

  return (ret);
 }


 function abortAdQuery()
 {
   return(0); 
 }

 function getResultCache(query)
 {
  writeLog(1, 'Cache: checking for q=' + query.toLowerCase());
  var r = new Array();

  r.title = '';

  if (query.toLowerCase() in rcache)
  {
   r = rcache[query.toLowerCase()];
   writeLog(1, 'Cache: cache record found.');
  }
  else
   writeLog(1, 'Cache: cache record NOT found.');

  return (r);
 }


 pub.debug44 = function (obj)
 {
  try
  {
   document.getElementById('nodes').innerHTML = hdiag;
  }
  catch (e)
  {}
  return;


  var content = getNodeTree(null, null, 'junk');
  content = '<b>Browser Rendered Node Tree</b><br>' + content;


  var obj = obj || document.getElementsByTagName('body')[0];
  myHarvest(obj);
  var str = "gNodeList.length=" + gNodeList.length + ",  gTextNodeList.length=" + gTextNodeList.length;

  content += "\n<hr>\n" + str + "\n<hr>\n" + hdiag;



  content += '\n<hr>\n';
  for (var i = 0; i < gTextNodeList.length; i++)
  {
   var p3 = '';
   var p2 = "cell phones,10,0,0|homes for,10,0,0";
   var p1 = '';

   content += 'node eval ' + i + ' t=[' + gTextNodeList[i].data + ']<br>\n';
   setLinks5(gTextNodeList[i], 'J572');

  // var linkcount = setLinkTerms(p3.split('|'));
  // if (linkcount < 10) linkcount += setLinkTerms(p2.split('|'));
  // if (linkcount < 10) linkcount += setLinkTerms(p1.split('|'));
   
  }

  try
  {
   document.getElementById('nodes').innerHTML = content;
  }
  catch (e)
  {}

 }
 pub.debug55 = function (obj)
 {
  gclickTextFlag = 0;
 }

 function resetBoxShowTime()
 {
  var d = new Date();
  var s = d.getTime();
  gboxDisplayTime = s;
 }

 function setupPageMouse()
 {
  var c = document; /* alert: prior ie .body; */ 

  // c.addEventListener("mousemove", doMousePageMove, false);
  addEvent(c, "mousemove", doMousePageMove);
 }


 function setupPageScroll()
 {
  var c = window; // scrolls at the window level 

  addEvent(c, "scroll", onScrollEvent);
 }


 function doMousePageMove(e)
 {
  var d = new Date();
  var s = d.getTime();

  var x = e.clientX;
  var y = e.clientY;

  properties.lastMouseMove=s;

 
  var scroll = GetScrollPositions(0);
 

  properties.mousePageX = Math.round(x)+scroll.left;
  properties.mousePageY = Math.round(y)+scroll.top;

  if (state == states.polling)
   {
    var current_polling_duration= s - properties.last_polling_start_timestamp;
    if (properties.last_polling_start_timestamp > 0 && current_polling_duration > 5000) /* 5ms */
     {
       writeLog(1,'*********************MousePageMove: calling ajax abort dur='+current_polling_duration);
       ajaxcontrol.cancel();
       
       
     }
   }


  writeDebug3('PageMouse =' + x + ',' + y);

  checkMouseOverAdBox();

 }


 function checkMouseOverAdBox()
 {
  var d = new Date();
  var s = d.getTime();

  if (properties.adbox_visible == 0) { writeDebug2('ActiveObj == 0 , t='+s); return; }


  var rect = adpop_span.getBoundingClientRect();

  var width = document.getElementById('f862se3j7u8pop').offsetWidth;
  var height = adpop_span.offsetHeight + 2;

  var rect_left=parseInt(rect.left); 
  var rect_top=parseInt(rect.top); 

  width = 315; // alert: temp thing, get from object vs hardcode
  height = 200;

  //  bounding box must consider link text as well 

  var minX = rect_left;
  var maxX = rect_left + width;
  var minY = rect_top - getLineHeight(adpop_span) - 10;
  if (minY <= 0) minY = 0;

  var maxY = rect_top + height + getLineHeight(adpop_span);

  if (mouseOverActiveAd(properties.mousePageX, properties.mousePageY) == 1)
   {
    writeDebug2(s + " Mouse is over Ad mouse.x=" + properties.mousePageX + ',' + properties.mousePageY + '  adpos=' + rect_left + ',' + rect_top + ', x(' + minX + ',' + maxX + ') y(' + minY + ',' + maxY + ')');

     properties.lastMouseAwayAd =0;
     properties.lastMouseOverAd =s;

     glastMouseAwayAd = 0;
     glastMouseOverAd = s;
     return(1);
   }

 
  properties.lastMouseAwayAd=s;
  // properties.lastMouseOverAd=0;

  glastMouseAwayAd = s;
  glastMouseOverAd = 0;

  writeDebug2(s + " Mouse <font color=#ff0000>NOT</font> over Ad mouse.x=" + properties.mousePageX + ',' + properties.mousePageY + '  adpos=' + rect_left + ',' + rect_top + ', x(' + minX + ',' + maxX + ') y(' + minY + ',' + maxY + ')');

  return (0);

 }



 function mouseOverActiveAd(mouseX, mouseY)
 {
  var overAdBox=0, overTextLink=0;

  //  is mouse over the adbox allocated area 

  if ( (mouseX >= properties.adpos_left_adjusted && mouseX <= properties.adpos_left_adjusted + config.boxWidth)
       && 
       (mouseY >= properties.adpos_top_adjusted && mouseY <= properties.adpos_top_adjusted + config.boxHeight)
      )
    {
     overAdBox=1;
    }


 if ( (mouseX >= properties.textlink_left && mouseX <= properties.textlink_left + properties.textlink_width)
      && 
      (mouseY >= properties.textlink_top && mouseY <= properties.textlink_top + properties.textlink_height)
      )
    {
     overTextLink=1;
    }

  
  if (overTextLink == 1 || overAdBox == 1 ) 
    return(1)  

  return(0);
 }


 function onScrollEvent()
 {
  // writeLog(1,'scroll event');
  if (properties.adbox_visible == 1)
   {
     closeActiveAd();
     // updateAdBoxPosition(); 
   }
 }


 function checkDisplayFocus()
 {
  var d = new Date();
  var s = d.getTime();

  var mouseOverAdFlag = 0;

  var adbox_display_duration=0;
 
  var adbox_last_focus_duration =0;

  if (properties.adbox_display_timestamp > 0)
   {
    adbox_display_duration = s - properties.adbox_display_timestamp;
   }

   
  if (properties.lastFocusTimestamp > 0)
   {
     adbox_last_focus_duration = s - properties.lastFocusTimestamp;
   }



  // if (s - properties.lastMouseOverAd < config.maxLastAdFocusMS)
  if (properties.lastMouseOverAd > 0 )
  {
   mouseOverAdFlag = 1;
  }

  
  if (properties.lastMouseAwayAd > 0 && s - properties.lastMouseAwayAd > config.maxMouseAwayMS )
  {
   mouseOverAdFlag = 0; // mouse away too long 
  }



  if (properties.adpop_adclick == 1 || properties.adpop_pagetext_click ==1)
   {
    writeLog(1,'ad/text click detected.');
   }




  writeDebug3('mouseoverad='+mouseOverAdFlag+' now=' + s + ' lastfocus=' + properties.lastFocusTimestamp+ ',  autoclose=' + autoClose + ',  lastfocusage=' +   adbox_last_focus_duration+' (max='+config.maxLastAdFocusMS+')  disp='+adbox_display_duration+' (max='+config.minAdBoxShowTimeMS+')'); 

 if (properties.lastMouseOverAd == 0 && adbox_display_duration > config.maxInitZeroMouseMS) // 3 sec 
  {
    writeLog(1,'zero mouse activity: adbox display duration exceeded '+adbox_display_duration+', max='+config.maxInitZeroMouseMS);
    clearInterval(gTimer);
    gTimer = 0;
    gclickTextFlag = 0;
    closeActiveAd();
    return; 
  }



  if (adbox_last_focus_duration  > config.maxLastAdFocusMS 
      && adbox_display_duration  > config.minAdBoxShowTimeMS
      && properties.lastMouseOverAd > 0 ) // && autoClose == 1)
  {
   if (mouseOverAdFlag == 0)
   {
    writeDebug3('auto close 1 suggested lastfocus=' + adbox_last_focus_duration + ', max=' + config.maxLastAdFocusMS + ', OverAd=' + mouseOverAdFlag + '= now:' + s + ' - msoverad:' + properties.lastMouseAwayAd + '=' + (s - properties.lastMouseAwayAd));
    writeLog(1, 'checkFocus: ad lost focus - away =' + adbox_last_focus_duration + ' max=(' + config.maxLastAdFocusMS+')');
//    writeLog(1, 'checkFocus: OverAd=' + mouseOverAdFlag + ', now=' + s + ' - msoverad:' + properties.lastMouseAwayAd + '=' + (s - properties.lastMouseAwayAd));

    clearInterval(gTimer);
    gTimer = 0;
    gclickTextFlag = 0;
    closeActiveAd();
    return;
   }
  }


  if (s - properties.lastMouseAwayAd > config.maxMouseAwayMS && properties.lastMouseAwayAd > 0)
  {
   var t = s - properties.lastMouseAwayAd;

   writeDebug3('auto close 2 suggested last=' + properties.lastMouseAwayAd + ' dur=' + t);
   writeLog(1, 'checkFocus: auto close 2, mouse away too long  away='+ t +' max=('+config.maxMouseAwayMS+')');

   clearInterval(gTimer);
   gTimer = 0;
   gclickTextFlag = 0;
   closeActiveAd();
   return;
  }



  if (properties.adpop_adclick == 1 || properties.adpop_pagetext_click ==1)
  {
   writeLog(1,'ad click detected...');

   if ((adbox_display_duration >= config.minAdBoxShowTimeMS && adbox_display_duration > 0)
        || properties.adpop_pagetext_click ==1)
   {
    writeDebug3('auto close 3 suggested');
    writeLog(1, 'checkFocus: auto close 3 suggested');
    gclickTextFlag = 0;
    var ptclick=0;
    if (properties.adpop_pagetext_click == 1) ptclick=1;
    properties.adpop_pagetext_click=0;
    //  alert('click jump ='+gclickTextFlag+'  --> '+properties.activeclick;
    var redirect = properties.activeclick;
    var ecb= properties.activeecb;
    closeActiveAd();
    gcloseAdEvent = 0;
    sendClickMessage(properties.activetitle, properties.activedomain, redirect);
    if (redirect.length > 0)
     {
      var tracking_redirect=build_clickthru(properties.page_domain, config.afid, ecb, ptclick, redirect);
      if (1==0 && tracking_redirect.length > 0 && tracking_redirect.length <= 2040)
       {
        window.location.href = tracking_redirect;
       }
      else
       {
        window.location.href = redirect;
       }
     }


   }
  }
  else
  {
   var mouseAwayDuration = s - properties.lastMouseAwayAd;

   if (adbox_display_duration >= properties.minAdBoxShowTimeMS
       && adbox_display_duration > 0 
       && mouseAwayDuration > config.maxMouseAwayMS && properties.lastMouseAwayAd > 0 
       && 1 == 1) // and mouse not over add for 1000ms 
    {
     writeLog(1, 'checkFocus: auto close 4 suggested, no mouse for ' + mouseAwayDuration);
     closeActiveAd();
     gcloseAdEvent = 0;
    }
  }



 }


 function setLastFocusTime()
 {
  var d = new Date();
  var s = d.getTime();

  properties.lastFocusTimestamp = s;

  checkMouseOverAdBox();
  writeDebug4('setting focus= ' + properties.lastFocusTimestamp);
 }



 function setAutoClose(x)
 {
  autoClose = x;
 }


 function setSpanClassBinding(spanid, keyword)
 {
  var c;
   
  try
   {
    c = document.getElementById(spanid);
   }
  catch(e)
  {
   writeLog(1, 'setSpanClassBinding('+spanid+'), cant get object reference.');
   return(-1);
  }

  // writeLog(1, 'setSpanClassBinding('+spanid+'), id='+c.id);
 

  // c.addEventListener("click", doMouseClickPageText, false);
  addEvent(c, "click", doMouseClickPageText);

  // c.addEventListener("mouseenter", doMouseOverPageText, false);
  if (properties.browser == 'chrome')
   addEvent(c, "mouseover", doMouseOverPageText);
  else if (properties.browser == 'safari')
   addEvent(c, "mouseover", doMouseOverPageText);
  else
   addEvent(c, "mouseenter", doMouseOverPageText);

 return(1);
 }


 function closeActiveAd()
 {
  var d = new Date();
  var s = d.getTime();

  writeLog(1, 'closeActiveAd()');

  gclickTextFlag = 0;
  gboxShowTime = 0;
  clearActiveClickThru();

  if (gTimer != 0)
  {
   clearInterval(gTimer);
   gTimer = 0;
  }

   if (state == states.polling || state == states.idle || state == states.error) return;

   adpop_span.style.display = 'none';
   properties.adbox_visible=0;
   properties.adbox_pagetext_span='';

   state = states.idle;
  
   properties.adpop_events_active=0;

  properties.activespan = '?';

  properties.activespan = '?';


  var adbox_display_duration=0;
  if (properties.adbox_display_timestamp > 0)
    adbox_display_duration = s - properties.adbox_display_timestamp;

  writeLog(1,'Adbox display duration = '+adbox_display_duration+' ms');

  properties.adbox_display_timestamp = 0;
  
  writeLog(1, '-------------------------------------------');
 }




 pub.closeAd = function (obj)
 {
  writeLog(1, 'closeAd(): user click X');

  state = states.adclosing;
  // alert('pub.closeAd() fired, state='+state);

  gclickTextFlag = 0;
  gcloseAdEvent = 1;
  closeActiveAd();
 }


 function setActiveClickThru(title, domain, url, bid, click2, ecb)
 {
  properties.activetitle= title;
  properties.activedomain= domain;
  properties.activeclick = url;
  properties.activebid= bid;

  properties.activeclick2= click2;
  properties.activeecb= ecb;

 }

 function clearActiveClickThru()
 {
  properties.activetitle  =  '';
  properties.activedomain =  '';
  properties.activeclick  =  '';
  properties.activebid    =  0;

  properties.activeclick2=  '';
  properties.activeecb   =  '';
 }

 pub.footerClick= function ()
  {
   writeLog(1,'footer click event');
   properties.footerClick=1;
  }

 function doMouseClickf862se3j7u8()
 {
  if (properties.adpop_events_active == 0) return;

  /*alert:  negate this if within footer region */
  if (properties.footerClick == 1)
   {
    properties.footerClick=0;
    writeLog(1,'footer click detected, resetting.');
    return;
   }

  gclickf862se3j7u8Flag = 1;
  writeLog(1,'Mouse: click on adbox text, redirect on close.');
  properties.adpop_adclick=1;
 }

 function doMouseClickPageText()
 {
  var query = this.textContent;

  // alert('doMouseClickPageText state='+state+' q='+query);

  writeLog(1,'Mouse: click on page text link, redirect on close.');

  // if (gcloseAdEvent == 0) properties.adpop_adclick=1;

  properties.adpop_adclick=1;
  properties.adpop_pagetext_click=1;

  if (properties.supportedMobileBrowser == 1)
   {
    mouseOverPageText(this);
   }

 }

 


 function doMouseOverPageText(e)
 {
  // this.style.backgroundColor = '#cc0000';

  properties.mouseOverPageTextX = Math.round(e.clientX);
  properties.mouseOverPageTextY = Math.round(e.clientY);

  writeLog(1, 'Mouse y= '+properties.mouseOverPageTextX+', y='+properties.mouseOverPageTextY);

  mouseOverPageText(this);
 }


 function mouseOverPageText(obj)
 {

  var spanid;

  if (obj.id)
   spanid=obj.id;
 else
  spanid=obj.event.toElement.id; // eg f862se3j7u8_3, f862se3j7u8_4, ... f862se3j7u8_13 

  var spanobj=document.getElementById(spanid);


  writeLog(1, 'doMouseOverText(): id=' + spanid + ', state=' + statetext[state] + ', active=' + properties.activespan+', adboxvis='+properties.adbox_visible);

  // if (state) return;
  if (state != states.idle)
  {
   if (state == states.ready && spanid != properties.activespan && properties.activespan != '?')
   {
    // alert: nothing here ?
   }
   else
    return;

  }

  //  check if existing ad is open... if so and idle then close

  if (properties.adbox_visible == 1)
   {
    if (properties.adbox_pagetext_span == spanid) 
     {
      return; //  box for page text span already open, do nothing 
     }

     writeLog(1,'other adbox visible, closing '+properties.adbox_pagetext_span);
     closeActiveAd();

   }

  properties.adbox_pagetext_span=spanid;


  if (adErrorCount >= maxErrorCount) return;

  state = states.polling;

  // var pos = getObjectPos(obj);
  // var left = pos.x; // - 4;
  // var top  = pos.y; // + 15;

  var rectpos=getClosestRect(spanid, properties.mouseOverPageTextX, properties.mouseOverPageTextY);
  var left = rectpos.x; 
  var top  = rectpos.y; 
  writeLog(1,'rect: idx='+rectpos.idx+' x='+rectpos.x+', y='+rectpos.y+', w='+rectpos.width+', h='+rectpos.height);

  if (rectpos.found <= 0 && !(properties.supportedMobileBrowser == 1 && properties.adpop_pagetext_click == 1)) /* alert: mobile/pagetext added 07/03 review (ah) */
   {
     writeLog(1,'rectangle: unable to determine closest rect, aborting');
     state = states.idle;
     return(-1);
   }

  var query = (spanobj.textContent || spanobj.innerText);

  properties.adbox_query_text=query;

  gcloseAdEvent = 0;

  showSpinner(spanobj, left, top, query);

  setAutoClose(0);


  // collect info about current focused link text
  properties.activespan = spanid;

  properties.adpos_left=left;
  properties.adpos_top=top;

  var scroll = GetScrollPositions(1);

  //properties.adpos_left+=parseInt(scroll.left);
  //properties.adpos_top+=parseInt(scroll.top);

  properties.adpos_top_adjusted=top;
  properties.adpos_left_adjusted=left;
  properties.adpos_boxlrstyle='left';
  properties.adpos_boxtbstyle='top';



  var sz=getObjectSize(spanid);

  properties.textlink_left=left+scroll.left;
  properties.textlink_top=top+scroll.top;

  properties.textlink_height= rectpos.height; // sz.height;
  properties.textlink_width=  rectpos.width;  // sz.width;


  
  properties.lastMouseAwayAd=0;
  properties.lastMouseOverAd=0; // alert: init to now?

  properties.adpop_adclick=0;
  properties.adpop_pagetext_click=0;

  properties.adpos_line_height=rectpos.height; // getLineHeight(obj);



  writeLog(1,'textlink:  line height = '+properties.adpos_line_height+', width='+properties.textlink_width+', height='+properties.textlink_height);

  processHoverEvent();

 }




 function doMouseExitText()
 {
  writeLog(1, 'doMouseExitText()');
  setAutoClose(1);

 }

 function doMouseEnterAdBox()
 {
  if (properties.adpop_events_active == 0) return;

  writeLog(1, 'doMouseEnterAdBox()');
  setAutoClose(0);
 }


 function doMouseMoveOverAdBox()
 {
  if (properties.adpop_events_active == 0) return;

  setLastFocusTime();
 }


 function doMouseExitAdBox()
 {
  writeLog(1, 'doMouseExitAdBox()');
  setAutoClose(1);
 }


 function doMouseOut()
 {
  writeLog(1, 'doMouseOut()');

  if (state == states.polling) return;

  state = states.idle;

  var divs = this.getElementsByTagName("div");
  writeDebug(0, 'div count=' + divs.length);

  try
  {
   this.removeChild(divs[0]);
  }
  catch (e)
  {}

  activeObj = 0;

  // this.style.backgroundColor = '#ffffff'; 
 }


 function getObjectPos(el)
 {
  //for (var lx = 0, ly = 0; el != null; lx += el.offsetLeft, ly += el.offsetTop, el = el.offsetParent) null;

 var rect = el.getBoundingClientRect(); 

 var lx=rect.left;
 var ly=rect.top;

  return { x: lx, y: ly };
 }


 function getObjectHeight(obj)
 {
  var rect=obj.getBoundingClientRect();

  var h=rect.bottom - rect.top;

  return(h); 
 }



 function getObjectSize(sid)
 {
  var obj=document.getElementById(sid);

  //for (var lx = 0, ly = 0; el != null; lx += el.offsetLeft, ly += el.offsetTop, el = el.offsetParent) null;

 var rect = obj.getBoundingClientRect();

 var h=rect.bottom - rect.top
 var w=rect.right  - rect.left;

  return { height: h, width: w };
 }



 function getClosestRect(sid, mX, mY)
 {
  var obj=document.getElementById(sid);

  var found=0, ridx=-1, x=-1,y=-1, width=0, height=0;

  var rects = obj.getClientRects()

  writeLog(1,'getClosestRect: sid='+sid+' obj.id='+obj.id+' rects.length='+rects.length+' mouse='+mX+','+ mY);

  for(var i=0; i<rects.length; i++)
   {
     var rect_height =Math.round(rects[i].bottom - rects[i].top);
     var rect_width  =Math.round(rects[i].right  - rects[i].left);
     var rect_left   =Math.round(rects[i].left);
     var rect_top    =Math.round(rects[i].top);
     if (withinRect(rect_left, rect_top, rect_width, rect_height, mX, mY) == 1)
      {
       writeLog(1,'r['+i+'] mouse '+mX+','+mY+' within x,y:'+rect_left+','+rect_top+' w:'+rect_width+', h:'+rect_height);
       x=rect_left;
       y=rect_top;
       height=rect_height;
       width=rect_width;
       found=1;
       ridx=i;
       break;
     }
    else
     {
       writeLog(1,'r['+i+'] mouse '+mX+','+mY+' outof  x,y:'+rect_left+','+rect_top+' w:'+rect_width+', h:'+rect_height);
     }
   }
  writeLog(1,'closestrect: found='+found+' x='+x+', y='+y);

  if (found == 1)
   return { found: 1, count: rects.length, idx: ridx, x: x,  y: y, width: width, height: height };      
  else
   return { found: 0, count: rects.length, idx: ridx, x: x,  y: y, width: width, height: height };      
}


function withinRect(left, top, width, height, x, y)
{
 if (x >= left && x <= left+width  && y >= top && y <= top+height)
  return(1)
 
 return(0);
     
}


 function GetScrollPositions(verbose)
 {
  var scrollLeft = 0;
  var scrollTop = 0;
  var zoomFactor = 1;

  if ('pageXOffset' in window) // all browsers, except IE before version 9
  {
   if (verbose) writeLog(1,'getscrollpos() pageXOffset support');
   scrollLeft = window.pageXOffset;
   scrollTop = window.pageYOffset;
  }
  else // Internet Explorer before version 9
  {
   if (verbose) writeLog(1,'getscrollpos() documentElement.scrollLeft support?');
   zoomFactor = 1; /* alert: find this GetZoomFactor(); */
   scrollLeft = Math.round(document.documentElement.scrollLeft / zoomFactor);
   scrollTop = Math.round(document.documentElement.scrollTop / zoomFactor);
  
   if (scrollTop == 0) 
    {
      if (document.body.scrollTop) scrollTop = document.body.scrollTop;
    }
   
   if (scrollLeft == 0) 
    {
      if (document.body.scrollLeft) scrollLeft= document.body.scrollLeft;
    }
  }


  return {
   left: scrollLeft,
   top: scrollTop
  };

 }

 function parseIntV2(obj)
 {
  var x= parseInt(obj) || 0;

  return(x);
 }

 function myHarvest(obj)
 {
  writeLog(1,'starting harvest()...');
  resetHarvest();

  // harvestText(obj);
  harvestTextV2(obj);

  writeLog(1,'harvest: gTextNodeList.length='+gTextNodeList.length+'  depth='+harvestDepth);

 }




function resetHarvest()
{

 gNodeList.length=0;
 gTextNodeList.length=0;

 nodes.length=0;

 harvestDepth=0;

 nodeLevel=0;
 nodeIndex=0;

}


function harvestTextV2(node)
{
  nodeLevel++;

  nodeIndex = nodeLevel - 1;
  var instance = [];
  var nodetype='', tagName='';
  nodes.push(null);

  var nt = { ELEMENT: 1, DOCUMENT: 9, TEXT: 3, COMMENT: 8 };

  try
   {
    nodeType = node.nodeType;
    tagName=node.tagName.toLowerCase();
   }
  catch (e)
   {
    // writeLog(1, 'error: nodeType='+nodeType+' tagName='+tagName);
   }

  var instance = nodes[nodeIndex];

  var insideAllowedNode = 1;
  // if (node.insideAllowedNode == 1) insideAllowedNode = 1;

  if ( isDeniedTag(tagName) == 1)
   {
    harvestDepth--;
    return(0);
   }

  // writeLog(1,'Depth='+harvestDepth+' NodeLevel '+nodeLevel+' node.nodeType='+node.nodeType+' tagName='+tagName+' allowed='+insideAllowedNode);

  switch (nodeType)
  {
  case nt.DOCUMENT:
  case nt.ELEMENT:

   // writeLog(1,'tagname='+tagName+' node.childNodes.length='+node.childNodes.length);
   for (var i = 0; i < node.childNodes.length; i++)
   {
    harvestDepth++;
    try
     {
       // node.childNodes[i].insideAllowedNode = insideAllowedNode;
       // writeLog(1,'subnode harvest ['+i+'] type='+node.childNodes[i].nodeType);
       harvestTextV2(node.childNodes[i])
     }
    catch(e)
     {
      // writeLog(1,'error fetch on child node '+i);
      // break;
     }
   }

   // if (insideAllowedNode == 1) { insideAllowedNode = null; }

   break;

  case nt.TEXT:
   // writeLog(1,'Text Node '+node.data);
   if (insideAllowedNode)
    {
     var text = node.data; // ut.string.trim(node.data).replace(/\s+/g, " ");
     if (text.length > 3)
     {
      gNodeList.push(node);
      gTextNodeList.push(node);
     }
    else
     {
     }
    }
   else
    {
    }
   break;

  case nt.COMMENT:
   break;

  default:
   break;
  } // end switch

  harvestDepth--;
  return(0);
}











 function sdepth(x)
 {
  var str = '';
  for (var i = 0; i < x * 10; i++)
   str += '-';
  return (str);
 }

 function harvestText(node)
 {
  nodeLevel++;

  nodeIndex = nodeLevel - 1;
  var instance = [];
  nodes.push(null);

  var nt = {
   ELEMENT: 1,
   DOCUMENT: 9,
   TEXT: 3,
   COMMENT: 8
  };

  var nodeType = node.nodeType;

  var instance = nodes[nodeIndex];

  var insideAllowedNode = 0;
  if (node.insideAllowedNode == 1) insideAllowedNode = 1;

  // hdiag+='NODE TYPE:'+nodeType+' v='+node.textContent+'<br>\n';
  // hdiag+='NODE TYPE:'+nodeType+' v='+node.innerText+'<br>\n';
  switch (nodeType)
  {
  case nt.DOCUMENT:
  case nt.ELEMENT:
   if ( // insideAllowedNode == 1 && 
   isDeniedTag(node.tagName.toLowerCase()) == 0)
   {
    insideAllowedNode = 1;
    // hdiag += sdepth(depth) + 'depth=' + depth + ' level=' + nodeLevel + ' ntype=' + nodeType + '/DOCELM inside=' + insideAllowedNode +' children='+node.childNodes.length+ '<br>\n';
   }
   else
    {
    // hdiag += sdepth(depth) + '(DENIED) depth=' + depth + ' level=' + nodeLevel + ' ntype=' + nodeType + '/DOCELM inside=' + insideAllowedNode +' children='+node.childNodes.length+ '<br>\n';
    }

   if (isDeniedTag(node.tagName.toLowerCase()) == 1)
    {
     insideAllowedNode = 0;
     depth--;
     return;
    }

   // hdiag+='node.childNodes.length='+node.childNodes.length+'<br>\n';
   for (var i = 0; i < node.childNodes.length; i++)
   {
    depth++;
    // hdiag+='SUB-NODE TYPE:'+node.childNodes[i].nodeType+'<br>\n';
    try
     {
      // hdiag+=' sub-node harvest pre: '+i+'<br>\n';
     // var n=node.childNodes[i];
      // n.insideAllowedNode=insideAllowedNode;
       node.childNodes[i].insideAllowedNode = insideAllowedNode;
      // hdiag+=' sub-node harvest post:'+i+'<br>\n';
//      if (depth <100)
       harvestText(node.childNodes[i])
     }
   catch(e)
     {
      //alert: review this 04/22 ah --  alert('Node Error on '+i+', depth='+depth);
//      hdiag+='error on child #'+i+'<br>\n';
      break;
      //return;
     }

   }

   if (insideAllowedNode == 1)
   {
    insideAllowedNode = null;
   }

   break;

  case nt.TEXT:
   // hdiag+='TEXT NODE<BR>\n';
   if (insideAllowedNode)
    {
     var text = node.data; // ut.string.trim(node.data).replace(/\s+/g, " ");
     if (text.length > 3)
     {
      gNodeList.push(node);
      gTextNodeList.push(node);
      // hdiag += sdepth(depth) + 'depth=' + depth + ' level=' + nodeLevel + ' ntype=' + nodeType + '/TEXT inside=' + insideAllowedNode + ' t=[' + text + ']<br>\n';
     }
    else
     {
      // hdiag += sdepth(depth) + 'depth=' + depth + ' level=' + nodeLevel + ' ntype=' + nodeType + '/TEXT inside=' + insideAllowedNode + ' t=[' + text + '] (**<3 min)<br>\n';
     }
    }
   else
    {
      // hdiag += sdepth(depth) + 'depth=' + depth + ' level=' + nodeLevel + ' ntype=' + nodeType + '/TEXT inside=' + insideAllowedNode + ' t=[' + text + '] (not allowed)<br>\n';
    }
   break;

  case nt.COMMENT:
   // hdiag+='COMMENT NODE<br>\n';
   break;

  default:
   // hdiag+='default<br>\n';
   break;
  } // end switch 

  depth--;
 }


 function isDeniedTag(tag)
 {
  var badTagTypes = {
   a: 1,
   b: 1,
   br: 1,
   dd: 1,
   dl: 1,
   embed: 1,
   fieldset: 1,
   h1: 1,
   h2: 1,
   h3: 3,
   h4: 1,
   iframe: 1,
   input: 1,
   label: 1,
   object: 1,
   param: 1,
   script: 1,
   noscript: 1,
   select: 1,
   option: 1,
   style: 1,
   textarea: 1,
   form: 1,
   th: 1,
   title: 1
  };

  if (badTagTypes[tag] == undefined)
  {
   return (0);
  }

  return (1);


 }

 function getNodeText()
 {
  /* alert: for later more precise text extraction prior to keyword analysis */ 
 }

 function getNodeTree(obj, ntype, keyword)
 {
  var obj = obj || document.getElementsByTagName('body')[0];
  var nodetext = '';
  var nodetype = obj.nodeName;
  var nodeTypes = {
   1: "ELEMENT",
   9: "DOCUMENT",
   3: "TEXT",
   8: "COMMENT"
  };

  var nodeTypes2 = {
   ELEMENT: 1,
   DOCUMENT: 9,
   TEXT: 3,
   COMMENT: 8
  };

  var badTagTypes = {
   a: 1,
   br: 1,
   dd: 1,
   dl: 1,
   embed: 1,
   fieldset: 1,
   h1: 1,
   h2: 1,
   h3: 3,
   h4: 1,
   iframe: 1,
   input: 1,
   label: 1,
   object: 1,
   param: 1,
   script: 1,
   noscript: 1,
   select: 1,
   style: 1,
   textarea: 1,
   th: 1,
   title: 1
  };

  var badAttributes = {
   href: 1,
   onclick: 1
  };

  try
  {
   nodetext = obj.textContent;
   if (nodetext.length > 150 && 1 == 0) nodetext = nodetext.substr(0, 150) + '...';
   if (obj.innerHTML.length > 0 && keyword.length > 0)
   {
    var html = obj.innerHTML;
    var p1 = html.indexOf(keyword);
    var p2 = html.indexOf("<a!x>");
    if (p1 > 0 && p2 < 0)
    {
     html = html.replace(/infantry/i, "<b>" + keyword + "<a!x></b>");
     obj.innerHTML = html;
     myAlert(0, obj.innerHTML);
    }

   }
  }
  catch (e)
  {}


  var str = "<ul style='margin-left:0; padding-left:20px;'>" + " <li><b>" + obj.tagName + '</b>: type=' + ntype + '/<b>' + nodeTypes[ntype] + '</b>, id=' + obj.id + ', prop=' + nodeProp(obj) + ' text=[' + nodetext + ']';
  if (obj.hasChildNodes())
  {
   var child = obj.firstChild;
   while (child)
   {
    // if ((child.nodeType == 1 || child.nodeType == 3) && child.parentNode.nodeName.toLowerCase().indexOf('script') == -1)
    if (1)
    {
     str += getNodeTree(child, child.nodeType, keyword)
    }
    child = child.nextSibling;
   }
  }
  str += "</li></ul>";
  return str;
 }

 function nodeProp(node)
 {
  var str = '<font color=#990000><b>';
  try
  {
   // if (node.getAttribute("onclick") ) str+='onclick,';
   var attr = node.attributes;
   str += attr.length + ':';
   for (var i = 0; i < attr.length; i++)
   {
    try
    {
     str += attr[i].name + ',';
    }
    catch (e)
    {}
   }
  }
  catch (e)
  {}

  str += '</b></font>';
  return (str);
 }


 function setLinks5(root, term)
 {
  d4text = '';
  // hdiag += '-----------------------------------------<br>\n';
  var hits = wrapSearchTermsInTextNode(root, term);

  return (hits);
 }


 function wrapSearchTermsInTextNode(n, term)
 {
  var echars = "abcdefghijklmnopqrstuvwxyz";
  var hits = 0, pos = 0, nlen = 0, pflag = 0;

  try
  {
   if (config.maxSpanCount > 0 && properties.spancount >= config.maxSpanCount) return(hits);

   while (1)
   {
    pos = n.nodeValue.toLowerCase().indexOf(term, pos);
    nlen = n.nodeValue.length;
    var precharok=0, postcharok=0;

    // hdiag += 'pos=' + pos + ', t=[' + term + '] ntext(' + nlen + ')=' + n.nodeValue.toLowerCase() + '<br>\n';
    var pf1=0, pf2=0, pf3=0, pf4=0,pfrag='';

    if (pos >= 0)
    {
     if (pos == 0)
      {
       precharok=1;
      } 
     else
      {
       pflag = echars.indexOf(n.nodeValue.toLowerCase().substr(pos -1, 1), 0); 
       if (pflag >= 0)
        precharok=0;
       else
        precharok=1;
      }

     if (pos+term.length == n.nodeValue.length)
      {
       postcharok=1;
      }
     else
      {
       pflag = echars.indexOf(n.nodeValue.toLowerCase().substr(pos + term.length, 1), 0);
       if (pflag >= 0)
        postcharok=0;
       else
        postcharok=1;
     
      }

     } 

    hdiag += 'pos=' + pos + ', t=[' + term + '] ntext(' + nlen + ')=' + n.nodeValue.toLowerCase() + ' pflag='+pflag
             +', prechar='+precharok+' , postchar='+postcharok+'<br>\n';

    // if (pos >= 0 && pflag == -1 && 1 == 1)
    if (pos >= 0 && precharok ==1 && postcharok == 1 && 1 == 1)
    {
     var prefix=term.substr(0,4)+'*';
     if (!wordlinks[term]) wordlinks[term]=1; else wordlinks[term]++;
     if (!wordlinks[prefix]) wordlinks[prefix]=1; else wordlinks[prefix]++;
     var lcount=wordlinks[term];
     var prefix_lcount=wordlinks[prefix];

     if (lcount > config.maxDuplicates) break;
     if (prefix_lcount > 1) break;
      

     properties.spancount++;
     // n.nodeValue=n.nodeValue+'('+lcount+')';
     var after = n.splitText(pos + term.length);
     var highlighted = n.splitText(pos);
     var span = document.createElement('span');
     span.className = 'f862se3j7u8';
     span.id = 'f862se3j7u8' + "_" + properties.spancount;
     span.name='f862se3j7u8' + "_" + properties.spancount; 
     span.appendChild(highlighted);
     after.parentNode.insertBefore(span, after);
     setSpanClassBinding(span.id, term);
     pos += term.length; // span.length;

     // hdiag += 'updated:  ntext(' + n.nodeValue.length + ')=' + n.nodeValue.toLowerCase() + '<br>\n';
     // writeLog(1, 'span '+ properties.spancount +':  ntext(' + n.nodeValue.length + ')=' + n.nodeValue.toLowerCase());

     hits++;
     if (config.maxSpanCount > 0 && properties.spancount >= config.maxSpanCount) break;
    }
    else
     break;

   } // end while loop 
  }
  catch (e)
  {}

  return (hits);
 }


 function buildSpanMap()
 {
  var mapstr='';

  try 
   {
     mapstr=screen.width+'x'+screen.height+'|';
    for(var i=0; i<properties.spancount; i++)
     {
      var sid='f862se3j7u8_'+(i+1);
      var obj= document.getElementById(sid);
      var rects = obj.getClientRects()
      if (rects.length > 0)
       {
        var x=Math.round(rects[0].left);
        var y=Math.round(rects[0].top);
        mapstr+=x+','+y+'|';
       }
     }
   }
  catch (e) {}

  properties.spanmap=mapstr; 
 }



 function getTagText(tagtype)
 {
  //  update to send list
  var elist = document.getElementsByTagName(tagtype);
  var text = tagtype + ":"
  for (var i = 0; i < elist.length; i++)
  {
   if (tagtype == 'img') text += elist[i].alt + "|";
   else text += (elist[i].textContent || elist[i].innerText) + "|";
  }
  return (text);
 }


 function setupAjax()
 {
  writeLog(1, 'setupAjax()');

  //  just a quickie 
  var myAJAX= ( function ()
  {

   if (!window.XMLHttpRequest) return function () {};
   var toParams, respond_to, Request;

   respond_to = function (o, f)
   {
    return !!(o != null && o[f]);
   }


   toParams = function (o)
   {
    if (typeof o === 'string')
    {
     return o;
    }
    if (typeof o !== 'object') return '';
    var pieces = [];
    for (var key in o)
    {
     pieces.push(encodeURIComponent(key) + '=' + encodeURIComponent(o[key]));
    }
    return pieces.join('&');
   }

   return function (params)
   {
    // var Request, requestPrepare;
    var requestPrepare;
    requestPrepare = function ()
    {
     if (window.XDomainRequest)
      {
       Request=new XDomainRequest();
      }
     else
      {
       Request = new XMLHttpRequest();
      }

     if (Request.overrideMimeType)
      {
       Request.overrideMimeType('text/html');
      }
     if (window.XDomainRequest)
      {
       Request.onload= function() { textStatus='success'; respond_to(params.success(Request.responseText, textStatus,''), 'success');}
      }
     else
      {
       Request.onreadystatechange = function (e)
        {
        if (Request.readyState === 1)
         {
          respond_to(params.load, 'call') && params.load();
         }
        else if (Request.readyState === 4)
         {
          var re = Request.responseText, textStatus;
          if (params.dataType === 'json')
           {
            try
            {
             re = JSON.parse(re);
            }
            catch (e)
            {
             re = Request.responseText;
            }
           }
          if ((Request.status > 199 && Request.status < 300) || Request.status === 304)
           {
            textStatus = 'success';
            respond_to(params.success, 'apply') && params.success(re, textStatus, Request);
           }
          else
           {
            textStatus = 'error';
            // alert('error: request.status='+Request.status+'/'+Request.statusText+'/'+Request.responseText); 
            respond_to(params.error, 'apply') && params.error(Request, textStatus, Request.statusText);
           }
          respond_to(params.complete, 'apply') && params.complete(Request, textStatus)
         }
        } /* end onreadystatechange */
       } /* end if xhr */
     }


    var headers = function (type)
    {
     // alert:  ie test thing restore Request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
     if (type)
     {
      if (Request.setRequestHeader)
       {
        Request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded;'); /* charset=' + (params.charset || 'utf-8')); */
       }
     }
    }

 
    ajaxcontrol.cancel= function ()
    {
      properties.last_polling_start_timestamp=0;
      if (window.XDomainRequest)
       {
        writeLog(1,'ajax: abort action');
        textStatus = 'error';

        respond_to(params.error, 'apply') && params.error(Request, textStatus, Request.statusText);
        return;
       }
      else
       {
        writeLog(1,'ajax: abort action');
        textStatus = 'error';
        respond_to(params.error, 'apply') && params.error(Request, textStatus, Request.statusText);
        return;
       }

    };


    params.data = toParams(params.data || {});
    params.async = !! params.async;
    params.type = respond_to(params.type, 'toUpperCase') ? params.type.toUpperCase() : 'GET';
    requestPrepare();
    if (params.type === 'POST')
    {
     Request.open('POST', params.url, params.async);
     headers(1);
    if (window.XDomainRequest)
     {
      Request.onprogress= function() { writeLog(1,'onprogress event'); return;};
      Request.ontimeout= function()  { writeLog(1,'ontimeout event');  return;};
      Request.onerror= function()
       { 
        writeLog(1,'onerror event');   
        textStatus = 'error';
        respond_to(params.error, 'apply') && params.error(Request, textStatus, Request.statusText);
        return;
       };
      Request.timeout=0;
      setTimeout(function() { try { Request.send(params.data);} catch(e) {} }, 500);
     }
    else
     {
       Request.send(params.data);
     }
    }
    else
    {
     Request.open('GET', params.url + (!params.data.firstChild ? (params.url.match(/\?/) ? '&' : '?') + params.data : ''), params.async);
     headers();
     Request.send();
    }
   }
  })()

  return (myAJAX);
 }



 function wordsort(a, b)
 {
  return (pagewordhash[b] - pagewordhash[a]);
 }

 function convertAssocToIndexedArray(iAssocArray)
 {
  var newArr = new Array();
  for (var property in iAssocArray)
  {
   // newArr[newArr.length] = iAssocArray[property]; 
   newArr[newArr.length] = property;
  }

  return newArr;
 }


 function cleanup_page_text(str)
 {

  // str = str.replace(/([^a-z0-9'_])/ig, " ");
  str = str.replace(/([^a-zA-z0-9'_\x80-\xff])/g, " ");
  str = str.replace(/\s+/g, " ");

  return (str);
 }

 function finalize_page_text(str, maxbytes)
 {
  // var text = str.replace(/([^a-zA-Z0-9'_])/g, " ");
  var text = str.replace(/([^a-zA-z0-9'_\x80-\xff])/g, " ");
  var words = text.split(" ");
  var t=''; 
  var bytes=0;
  for (var i = 0; i < words.length; i++)
   {
    if (words[i].length > 25) continue;

    t+= " "+words[i];
    bytes+=encodeURIComponent(" "+words[i]).length;
    
    if (bytes >= maxbytes-100) break;
   }

  return(t); 
 }



 function cleanup_misc_text(str)
 {

  str = str.replace(/([^a-z0-9'_\-])/ig, " ");
  str = str.replace(/\s+/g, " ");

  return (str);
 }

 function finalize_misc_text(str, maxbytes)
 {
  var text = str.replace(/([^a-zA-Z0-9'_])/g, " ");
  var words = text.split(" ");
  var t='';
  var bytes=0;
  for (var i = 0; i < words.length; i++)
   {
    if (words[i].length > 25) continue;

    t+= " "+words[i];
    bytes+=encodeURIComponent(" "+words[i]).length;

    if (bytes >= maxbytes-25) break;
   }

  return(t);
 }


 function parse_words(t)
 {
  var i, rows = 0, r = '';
  var valid_page_word_count=0;

  t = t.replace(/([^a-z0-9'_])/g, " ");
  var words = t.split(" ");
 
  for (i = 0; i < words.length; i++)
  {
   words[i] = words[i].replace(/\n/g, "");

   if (validword(words[i]) == 0) continue;

   if (pagewordhash[words[i]]) pagewordhash[words[i]]++;
   else pagewordhash[words[i]] = 1;
 
   valid_page_word_count++;
  }

  var p = convertAssocToIndexedArray(pagewordhash);

  var count = 0;
  p.sort(wordsort);


  for (var i in p)
  {
   var kwinfo = {
    term: '',
    freq: 0
   };
   kwinfo.term = p[i];
   kwinfo.freq = pagewordhash[p[i]];
   global_kwlist.push(kwinfo);
  }

  return (valid_page_word_count);

 }

 function myAlert(show, content)
 {
  if (debugMode == 0)
  {
   if (show == 1)
    alert(content);
   return;
  }
  alert(content);
 }

 function sendDiagMessage(msg)
 {
  var rnum = Math.floor(Math.random() * (1000 * 1000));
  if (1==1 && (properties.userip == '66.150.185.98' || properties.userip == '24.126.154.251') )
   {
    try
     {
      var img= new Image();
      img.src='http://'+config.coreDomain+'/util/intexteval.pl?op=msg&r='+rnum+'&appsig='+properties.appsig+'&msg='+encodeURIComponent(msg);
     }
    catch(e) {}
   }
 }

 function sendProcessPageMessage(msg)
 {
  sendProcessPageMessageV2(0, msg)
 }

 function sendProcessPageMessageV2(mode, msg)
 {
  var rnum = Math.floor(Math.random() * (1000 * 1000));
  if (1==0 || mode == 1)
   {
    try
     {
      var img= new Image();
      img.src='http://'+config.coreDomain+'/util/intexteval.pl?action=analyze&op=msg&r='+rnum+'&appsig='+properties.appsig+'&msg='+encodeURIComponent(msg);
     }
    catch(e) {}
   }
 }

 function sendClickMessage(title, domain, redirect)
 {
  var rnum = Math.floor(Math.random() * (1000 * 1000));
  if (1==0 && config.rms == 1)
   {
    try
     {
      var img= new Image();
      img.src='http://'+config.coreDomain+'/util/intexteval.pl?action=click&op=msg&r='+rnum+'&msg='+encodeURIComponent(domain);
     }
    catch(e) {}
   }

 }


 function sendDisplayMessage(msg)
 {
  var rnum = Math.floor(Math.random() * (1000 * 1000));
  if (1==0 && config.rms == 1)
   {
    try
     {
      var img= new Image();
      img.src='http://'+config.coreDomain+'/util/intexteval.pl?action=display&op=msg'
              +'&r='+rnum 
              +'&appsig='+properties.appsig
              +'&branduid='+properties.branduid
              +'&msg='+encodeURIComponent(msg);
     }
    catch(e) {}
   }
 }


 function sendStartupMessage(msg)
 {
  var rnum = Math.floor(Math.random() * (1000 * 1000));
  if (1==1 && config.rms == 1)
   {
    try
     {
      var img= new Image();
      img.src='http://'+config.coreDomain+'/util/intexteval.pl?action=startup&op=msg&r='+rnum +'&appsig='+properties.appsig+'&msg='+encodeURIComponent(msg);
     }
    catch(e) {}
   }
 }

 function sendAbortMessage(msg)
 {
  var rnum = Math.floor(Math.random() * (1000 * 1000));
  if (1==1 && config.rms == 1)
   {
    try
     {
      var img= new Image();
      img.src='http://'+config.coreDomain+'/util/intexteval.pl?action=abort&op=msg&r='+rnum +'&appsig='+properties.appsig+'&msg='+encodeURIComponent(msg);
     }
    catch(e) {}
   }
 }

 function writeLog(show, content)
 {
  if (debugMode == 0)
   {
    if (show == 1)
     {
      try
      {
      sendDiagMessage(content);
      d4count++;
      var text = document.getElementById('d4log').value; // innerHTML;
      document.getElementById('d4log').value= text+ d4count + ')' + content + "\r\n";
 
      var obj = document.getElementById('d4log');
      obj.scrollTop = obj.scrollHeight;
     }
    catch (e) {}
    return;
   }
  }
  try
  {
   d4count++;
   var text = document.getElementById('d4log').innerHTML;
   document.getElementById('d4log').innerHTML = text + d4count + ')' + content + '\n';
  }
  catch (e)
  {}

 }

 function writeDebug(show, content)
 {
  if (debugMode == 0)
  {
   if (show == 1)
    try
    {
     document.getElementById('debug').innerHTML = content;
   }
   catch (e)
   {}
   return;
  }
  try
  {
   document.getElementById('debug').innerHTML = content;
  }
  catch (e)
  {}

 }

 function writeDebug2(content)
 {
  try
  {
   document.getElementById('debug2').innerHTML = content;
  }
  catch (e)
  {}
 }


 function writeDebug3(content)
 {
  try
  {
   document.getElementById('debug3').innerHTML = content;
  }
  catch (e)
  {}
 }


 function writeDebug4(content)
 {
  try
  {
   document.getElementById('debug4').innerHTML = content;
  }
  catch (e)
  {}
 }


function build_clickthru(domain, afid, ecb, ptclickflag, url)
{
 var rnum = Math.floor(Math.random() * (1000 * 1000));
 
 var clickthru='http://'+config.coreDomain+'/util/click.pl'
               +'?op=click'
               +'&afid='+encodeURIComponent(afid)
               +'&dom='+encodeURIComponent(domain)
               +'&ecb='+encodeURIComponent(ecb)
               +'&ptc='+ptclickflag
               +'&r='+rnum
               +'&rd='+encodeURIComponent(url);

 return(clickthru);

}


 function buildAdPopHTML(title, desc, vurl, clickurl)
 {
  var html;

  writeLog(1, 'buildAdPopHTML() t=[' + title + ']');

  if (title == ':processing')
  {
   writeDebug(0, 'query=[' + desc + ']');
   html = "<b>Processing Query...</b> (" + desc + ")";
   return (html);
  }
  else
  {

   if (vurl.length > 25) vurl = vurl.substr(0, 20) + '...';


   if (title.length == 0 || desc.length == 0)
   {
    html = "<b>No Data From Query</b>";
    return (":nodata");
   }

   /*alert: clean this up,  this is a mess, exactly why i hate taking code from other people (ah) */
   /*       box header + box content needs to be one simple function()                            */
   /* ------------------------------------------------------------------------------------------- */
   // html = getBoxHeaderHTML() + getBoxContentHTML(title, desc, vurl, clickurl) + getBoxTrailerHTML();

    html = getBoxHeaderHTML() + getBoxContentHTML(title, desc, vurl, clickurl);
    html+='</div></div>';
    html = build_arrow_wrapper(html);
  }



  //var wrapper =  '<div style="margin:0;padding:0;border:0;outline:0;font:normal normal normal 13px trebuchet MS,Arial,sans-serif;'
  //             + 'vertical-align:baseline;background:transparent;list-style:none;text-decoration:none;text-align:left;float:none;'
  //            + 'line-height:12px;">'

  var z=getNextHighestZindex(adpop_span)+1;
  

  var wrapper = '<div class="adbox" style="text-decoration:none !important; z-index:'+z+'; overflow:visible;">'
              + '<div style="xposition: absolute; z-index: '+(z+2)+'; display: block; xoverflow: auto; background-color:#ffffff; ' 
              + ' xwidth:351px; xheight:201px; background-color:transparent;  xborder: 1px solid;' 
              + ' padding:0; margin:0; text-decoration:none; border:none;" ' 
              + ' id="f862se3j7u8_popin">' 
              + html 
              + '</div>'
              + '</div>';

  return (wrapper);
 }


 function getBoxHeaderHTML()
 {
  var html='';


  // no drop shadows 
  html = '<div id="intxt_bdy" class="intxt_bg" style="position: relative; xtop: 100px; xleft: 100px; width:314px; height:185px; z-index: 10000113; padding:0 !important; margin:0 !important;">'
          +'<div id="intxt_bdy_cntnt" class="intxt_bg" style="position: absolute; top: 0px; left: 0px; width: 314px; height: 185px; ">'
           +'<div class="intxt_bg" style="position:absolute; width:314px; height:33px; left:0; bottom:0; z-index:1; background-color:#cbcbce; border-bottom:3px solid #006699; border-left:1px solid #a7a9ab; border-right:1px solid #a7a9ab; -webkit-border-radius: 0px 0px 0px 0px; -moz-border-radius: 0px 0px 0px 0px; border-radius: 0px 0px 0px 0px; " onclick="$adtext.footerClick();"> <!-- bottom frame -->'
             +'<div id="intxt_bdy_logo" class="intxt_bg" style="position:absolute; top:10px; left:5px; bottom:10px; cursor:pointer; font-size:1px; ">        <a href="http://'+config.coreDomain+'" onclick="javascript:$adtext.closeAd(this); location=\'http://'+config.coreDomain+'\';"><img src="http://'+config.coreDomain+'/images/intxt_logo.png" width=85 height=11 border=0 /></a>&nbsp;<i><span style="font-family:arial; font-size:12px; color:#ffffff;">&nbsp;' + version + '</span></i></div>'
            +'<div class="intxt_bg" id="intxt_hlp" style="position:absolute; padding:0; margin:0; width:26px; height:25px; right:35px; bottom:2px; display:block; background-position:0 0; cursor:pointer; color:#006699; font-family: Arial,sans-serif; font-size:10px; line-height:12px; font-weight:bolder; border-radius: 2px; xbackground: #ffffff;"><center><a href="' + config.helpurl + '" onclick="javascript:$adtext.closeAd(this); location=\'' + config.helpurl + '\';" style="color:#006699; font-family:arial,sans-serif; font-weight:bolder; font-size:10px; line-height:12px; text-decoration:none;"><img src="http://'+config.coreDomain+'/images/intext-help5.png" width=26 height=25 border=0></a></center> </div>'
           +'<div class="intxt_bg" id="intxt_cls" style="position:absolute; width:26px; height:25px; right:5px; bottom:2px; background-position:-15px 0; cursor:pointer; color:#006699; font-family: Arial,sans-serif; font-size:10px; line-height:12px; font-weight:bolder; border-radius: 2px; xbackground: #ffffff;"> <center><span onclick="javascript:$adtext.closeAd(this);"><img src="http://'+config.coreDomain+'/images/intext-close5.png" width=26 height=25 border=0></span></center></div>'

         +'</div>';

 if (config.adbox_logo_blank == 1)
  {
  html = '<div id="intxt_bdy" class="intxt_bg" style="position: relative; xtop: 100px; xleft: 100px; width:314px; height:185px; z-index: 10000113;"> <div id="intxt_bdy_cntnt" class="intxt_bg" style="position: absolute; top: 0px; left: 0px; width: 314px; height: 185px; "> <div class="intxt_bg" style="position:absolute; width:314px; height:33px; left:0; bottom:0; z-index:1; background-color:#cbcbce; border-bottom:3px solid #006699; border-left:1px solid #a7a9ab; border-right:1px solid #a7a9ab; -webkit-border-radius: 0px 0px 0px 0px; -moz-border-radius: 0px 0px 0px 0px; border-radius: 0px 0px 0px 0px; " onclick="$adtext.footerClick();"> <!-- bottom frame --> <div id="intxt_bdy_logo" class="intxt_bg" style="position:absolute; top:10px; left:5px; bottom:10px; cursor:default; font-size:1px; "> <img src="http://'+config.coreDomain+'/images/dotclear.gif" width=85 height=11 border=0 />&nbsp;<i><span style="font-family:arial; font-size:12px; color:#ffffff;">&nbsp;' + version + '</span></i></div> <div class="intxt_bg" id="intxt_hlp" style="position:absolute; padding:0; margin:0; width:26px; height:25px; right:35px; bottom:2px; display:block; background-position:0 0; cursor:pointer; color:#006699; font-family: Arial,sans-serif; font-size:10px; line-height:12px; font-weight:bolder; border-radius: 2px; xbackground: #ffffff;"><center><a href="' + config.helpurl + '" onclick="javascript:$adtext.closeAd(this); location=\'' + config.helpurl + '\';" style="color:#006699; font-family:arial,sans-serif; font-weight:bolder; font-size:10px; line-height:12px; text-decoration:none;"><img src="http://'+config.coreDomain+'/images/intext-help5.png" width=26 height=25 border=0></a></center> </div> <div class="intxt_bg" id="intxt_cls" style="position:absolute; width:26px; height:25px; right:5px; bottom:2px; background-position:-15px 0; cursor:pointer; color:#006699; font-family: Arial,sans-serif; font-size:10px; line-height:12px; font-weight:bolder; border-radius: 2px; xbackground: #ffffff;"> <center><span onclick="javascript:$adtext.closeAd(this);"><img src="http://'+config.coreDomain+'/images/intext-close5.png" width=26 height=25 border=0></span></center></div></div>';
  }

 if (config.brand_title.length > 0)
  {
   var helpurl=config.helpurl;
   var privacyhtml='';

   if (config.brand_helpurl.length > 0)
    helpurl=config.brand_helpurl;


   if (config.brand_privacyurl.length > 0)
    {
     privacyhtml='<div id="intext_priv" style="position:absolute; cursor:pointer; text-align:right !important; padding:0; margin:0; width:45px; height:18px; right:65px; bottom:2px; display:block;"><a href="'+config.brand_privacyurl+'" style="color:#36353c; font-family:arial,sans-serif; font-weight:normal; font-size:11px; '
                +'line-height:12px; text-decoration:none;" onclick="javascript:$adtext.closeAd(this); location=\''+config.brand_privacyurl+'\';">Privacy</a></div>';
    }
    


  html = '<div id="intxt_bdy" class="intxt_bg" style="position: relative; xtop: 100px; xleft: 100px; width:314px; height:185px; z-index: 10000113;"> <div id="intxt_bdy_cntnt" class="intxt_bg" style="position: absolute; top: 0px; left: 0px; width: 314px; height: 185px; "> <div class="intxt_bg" style="position:absolute; width:314px; height:33px; left:0; bottom:0; z-index:1; background-color:#cbcbce; border-bottom:3px solid #006699; border-left:1px solid #a7a9ab; border-right:1px solid #a7a9ab; -webkit-border-radius: 0px 0px 0px 0px; -moz-border-radius: 0px 0px 0px 0px; border-radius: 0px 0px 0px 0px; " onclick="$adtext.footerClick();"> <!-- bottom frame --> <div id="intxt_bdy_logo" class="intxt_bg" style="position:absolute; top:10px; left:5px; bottom:10px; cursor:default; font-size:14px; font-weight:bold;color:#ffffff;">'+config.brand_title+'&nbsp;<i><span style="font-family:arial; font-size:12px; color:#ffffff;">&nbsp;' + version + '</span></i></div>'+privacyhtml+'<div class="intxt_bg" id="intxt_hlp" style="position:absolute; padding:0; margin:0; width:26px; height:25px; right:35px; bottom:2px; display:block; background-position:0 0; cursor:pointer; color:#006699; font-family: Arial,sans-serif; font-size:10px; line-height:12px; font-weight:bolder; border-radius: 2px; xbackground: #ffffff;"><center><a href="' + helpurl + '" onclick="javascript:$adtext.closeAd(this); location=\'' + helpurl + '\';" style="color:#006699; font-family:arial,sans-serif; font-weight:bolder; font-size:10px; line-height:12px; text-decoration:none;"><img src="http://'+config.coreDomain+'/images/intext-help5.png" width=26 height=25 border=0></a></center> </div> <div class="intxt_bg" id="intxt_cls" style="position:absolute; width:26px; height:25px; right:5px; bottom:2px; background-position:-15px 0; cursor:pointer; color:#006699; font-family: Arial,sans-serif; font-size:10px; line-height:12px; font-weight:bolder; border-radius: 2px; xbackground: #ffffff;"> <center><span onclick="javascript:$adtext.closeAd(this);"><img src="http://'+config.coreDomain+'/images/intext-close5.png" width=26 height=25 border=0></span></center></div></div>';
  }


  return (html);
 }

 function getBoxContentHTML(title, desc, vurl, redirect)
 {

  var clicktext="click here";

  if (config.afid == 'searchteam2')  { clicktext="Click To Search";}

  var html = '<div id="intxt_bdy" class="intxt_bg intxt_bdy_mn" style="position:absolute; top:0px; left:0; width:314px; height:152px; z-index:2; background-color:#ffffff !important; cursor: pointer; margin:0; padding:0; border-top:1px solid #9a9a9a; border-left:1px solid #9a9a9a; border-right:1px solid #9a9a9a; -webkit-border-radius: 0px 0px 0px 0px; -moz-border-radius: 0px 0px 0px 0px; border-radius: 0px 0px 0px 0px;  text-decoration:none !important; text-align:left !important;">'

             +'<div xclass="intxt_bg" style="border-bottom:none; border:1px solid #ffffff; color:#006699; font-family: Arial,sans-serif; font-size:20px; font-weight:bold; line-height:22px; margin-left:15px; margin-top:10px; margin-bottom:10px; margin-right:5px; max-height:24pt; text-decoration:none !important;  white-space:no-wrap; height:24px; width:275px; overflow:hidden;"> $TITLE </div>'

            +'<div class="intxt_bg" style="position:absolute; height:80px; width:312px; margin-top:5px"> <img class="intxt_bg" style="position:absolute; top:0; left:35px; width:48px; height:48px; background-color:#e8e8e8; margin-top:3px" src="http://'+config.coreDomain+'/images/intext-thdefault3.png" height="48" width="48">'

              +'<div class="intxt_bg" style="position:absolute; top:0; left:115px; width:168px; height:51px; overflow:hidden; color:#666666; font-family: Arial,sans-serif; font-size:10pt; font-weight:normal; line-height:17px;"> $DESC </div>'
              +'<div id="intxt_btn" class="intxt_bg" style="position:absolute; display:block; bottom:-13px; right:13px; width:102px; height:24px; font-family:Arial,sans-serif; font-size:10pt; font-weight:normal; cursor:pointer; text-align:center; line-height:24px; color:#ffffff; border-radius: 2px; background: #ac0b11; background: -webkit-gradient(linear, left top, left bottom, from(#da1f26), to(#ac0b11)); background: -moz-linear-gradient(top, #da1f26, #ac0b11); background: -webkit-linear-gradient(top, #da1f26, #ac0b11); background: -o-linear-gradient(top, #da1f26, #ac0b11); background: -ms-linear-gradient(top, #da1f26, #ac0b11); background: linear-gradient(top, #da1f26, #ac0b11); filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#da1f26\', endColorstr=\'#ac0b11\'); "> '+clicktext+' </div>'

           +'</div>'

           +'<div class="intxt_bg" style="position:absolute; bottom:12px; left:15px; width:280px; height:15px; color:#cc001c; font-family: Arial,sans-serif; line-height:10px; font-size:9pt; font-weight:normal; text-decoration:none; overflow:hidden;"> $VURL </div>'

          +'</div>';


  if (title.length >28) title=title.substr(0,28)+'...';

  html = html.replace(/\$TITLE/i, title);
  html = html.replace(/\$desc/i, desc);
  html = html.replace(/\$vurl/i, vurl);
  html = html.replace(/\$redirect/i, redirect);
  return (html);
 }

 function getBoxTrailerHTML()
 {
  var html = '</div>';

  /* not used anymore, much of this transform/filter stuff had issues with older versions of IE (ah) */


  if (properties.adpos_boxlrstyle == 'left' && properties.adpos_boxtbstyle == 'top')
  {
   html += '<div class="intxt_bg" style="position:absolute; top:-10px; left:10px; width:21px; height:16px; font-size:12px; line-height:12px; -webkit-transform: scaleY(-1); -moz-transform: scaleY(-1); -o-transform: scaleY(-1); transform: scaleY(-1); filter: FlipV; -ms-filter: "FlipV"; "><img src="http://'+config.coreDomain+'/images/intxt_arrow.png" width=21 height=16/></div></div>';
  }
  else if (properties.adpos_boxlrstyle == 'left' && properties.adpos_boxtbstyle == 'bottom')
  {
   html += '<div style="background:transparent; padding:0; border:0; position:absolute; bottom:-8px; left:10px; width:21px; height:16px; font-size:12px; line-height:12px; -webkit-transform: rotate(0deg); -moz-transform: rotate(0deg); -o-transform: rotate(0deg); transform: rotate(0deg); "><img src="http://'+config.coreDomain+'/images/intxt_arrow.png" width=21 height=16></div></div>';
  }
  else if (properties.adpos_boxlrstyle == 'right' && properties.adpos_boxtbstyle == 'top')
  {
   html += '<div class="intxt_bg" style="position:absolute; top:-10px; right:5px; width:21px; height:16px; font-size:12px; line-height:12px;  -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -o-transform: rotate(180deg); transform: rotate(180deg); "><img src="http://'+config.coreDomain+'/images/intxt_arrow.png" /></div></div>';
  }
  else if (properties.adpos_boxlrstyle == 'right' && properties.adpos_boxtbstyle == 'bottom')
  {
   html += '<div style="position:absolute; padding:0; border:0; bottom:-8px; right:5px; width:21px; height:16px; font-size:12px; line-height:12px; -webkit-transform: scaleX(-1); -moz-transform: scaleX(-1); -o-transform: scaleX(-1); transform: scaleX(-1); filter: FlipH; -ms-filter: "FlipH"; "><img src="http://'+config.coreDomain+'/images/intxt_arrow.png" /></div></div>';
  }


  return (html);
 }


function build_arrow_wrapper(boxHTML)
{
 var html='';

 /* why is everything  important?  crazy wordpress redefines everything (ah) */
 /* and older version of IE are just aweful... no joke!!! */

 var ie8='';

 if (properties.browserbase == 'ie' || properties.browserbase == 'msie')
  {
   if (properties.browserver < 10) 
     ie8="display:block;";
  }


 if (properties.adpos_boxlrstyle == 'left' && properties.adpos_boxtbstyle == 'top')
  {
html+='<div style="border:0 !important; padding:0 !important; margin:0 !important; width:314px; height:185px; text-align:top !important;">';
   html+='<div style="position:relative !important; background:transparent; padding:0 !important; margin:0 !important; margin-top: 0 !important; margin-bottom:0 !important; padding-top:0 !important; padding-bottom:0 !important; height:11px !important; vertical-align:top !important; text-align:left !important;">';
   html+='<img src="http://'+config.coreDomain+'/images/box-arrow-lt2.png" width=16 height=11 border=0 style="'+ie8+' padding:0 !important; margin:0 !important; border:0 !important; height:11px; width:16px; vertical-align:top !important;">';
   html+='</div>';
   html+=boxHTML;
   html+='</div>';
  }
 else if (properties.adpos_boxlrstyle == 'right' && properties.adpos_boxtbstyle == 'top')
  {
   html+='<div style="border:0 !important; padding:0 !important; margin:0 !important; width:314px; height:185px; text-align:right !important;">';
   html+='<div style="position:relative !important; background:transparent; padding:0 !important; margin:0 !important; margin-top: 0 !important; margin-bottom:0 !important; padding-top:0 !important; height:11px; vertical-align:top !important; text-align:right !important;"><img src="http://'+config.coreDomain+'/images/box-arrow-rt2.png" width=16 height=11 border=0 style="'+ie8+' padding:0 right:0px; !important; margin:0 !important; border:0 !important; height:11px; vertical-align:top !important; text-align:right !important;"></div>';
   html+=boxHTML;
   html+='</div>';
  }
 else if (properties.adpos_boxlrstyle == 'left' && properties.adpos_boxtbstyle == 'bottom')
  {
   html+='<div style="border:0 !important; padding:0 !important; margin:0 !important;">';
   html+=boxHTML;
   html+='<div style="position:relative !important; background:transparent; padding:0 !important; margin:0 !important; margin-top: 0 !important; margin-bottom:0 !important; padding-top:0 !important; height:11px; vertical-align:top !important; text-align:left !important;"><img src="http://'+config.coreDomain+'/images/box-arrow-lb2.png" width=16 height=11 border=0 style="'+ie8+' padding:0 !important; margin:0 !important; border:0 !important; height:11px; vertical-align:top !important; text-align:left !important;"></div>';
   html+='</div>';
  }
 else if (properties.adpos_boxlrstyle == 'right' && properties.adpos_boxtbstyle == 'bottom')
  {
   html+='<div style="border:0 !important; padding:0 !important; margin:0 !important;">';
   html+=boxHTML;
   html+='<div style="position:relative !important; background:transparent; padding:0 !important; margin:0 !important; margin-top: 0 !important; margin-bottom:0 !important; padding-top:0 !important; height:11px; vertical-align:top !important; text-align:right !important;"><img src="http://'+config.coreDomain+'/images/box-arrow-rb2.png" width=16 height=11 border=0 style="'+ie8+' padding:0 !important; margin:0 !important; border:0 !important; height:11px; vertical-align:top !important; text-align:right !important;"></div>';
   html+='</div>';
  }

 return(html);
}





 function findPosX(obj)
 {
  var curleft = 0;
  if (obj.offsetParent) while (1)
   {
    curleft += obj.offsetLeft;
    if (!obj.offsetParent) break;
    obj = obj.offsetParent;
  }
  else if (obj.x) curleft += obj.x;
  return curleft;
 }

 function findPosY(obj)
 {
  var curtop = 0;
  if (obj.offsetParent) while (1)
   {
    curtop += obj.offsetTop;
    if (!obj.offsetParent) break;
    obj = obj.offsetParent;
  }
  else if (obj.y) curtop += obj.y;
  return curtop;
 }


 function init()
 {
  writeLog(1, 'starting initialization');

  initflag = 1;
  autoClose = 0;
  gclickTextFlag = 0;
  depth=0;

  properties.adpop_events_active=0;

  load_stopwords();

  setupf862se3j7u8CSS();


  properties.spancount=0;
 
  adpop_spinner_span = document.createElement('div');
  adpop_spinner_span.id = 'f862se3j7u8spinner';
  adpop_spinner_span.style.display = 'none';
  adpop_spinner_span.style.position = 'absolute';
  adpop_spinner_span.style.zindex = 10*1024*1024;
  adpop_spinner_span.style.left = '0px';
  adpop_spinner_span.style.width= '20px';
  adpop_spinner_span.style.height= '20px';

  adpop_spinner_span.innerHTML = '<img id="intext_spinner_default"   src="http://'+config.coreDomain+'/images/spinner-ani48.gif" width=20 height=20 border=0>';

  document.body.appendChild(adpop_spinner_span);



  adpop_span = document.createElement('div');

  adpop_span.id = 'f862se3j7u8pop';
  adpop_span.style.display = 'none';

  adpop_span.style.position = 'absolute';
  adpop_span.style.zIndex = 10*1024*1024; /* alert: was 'zindex', cap I for chrome review !! (ah) */
  adpop_span.style.left = 400 + 'px';
  adpop_span.style.top = 400 + 'px';

  document.body.appendChild(adpop_span);

  // setup adbox events
  // adpop_span.addEventListener("click",      doMouseClickf862se3j7u8,   false);
  addEvent(adpop_span, "click", doMouseClickf862se3j7u8);

  // adpop_span.addEventListener("mousemove",  doMouseMoveOverAdBox, false);
  addEvent(adpop_span, "mousemove", doMouseMoveOverAdBox);

  // adpop_span.addEventListener("mouseenter", doMouseEnterAdBox,    false); 
  addEvent(adpop_span, "mouseenter", doMouseEnterAdBox);


  setupPageMouse();
  setupPageScroll();

  writeLog(1,'init complete.');
 }


 function addEvent(obj, event, fx)
 {
   if (obj.addEventListener)
    {
     // writeLog(1, 'event: addEventListener Supported');
     obj.addEventListener(event, fx, false);
    }
   else
    {
     if (obj.attachEvent)
      {
       //writeLog(1,'event: attachEvent Supported');
       obj.attachEvent("on"+event, fx);
     }
    else
     {
      // alert: if fail... disable script for page 
      writeLog(1,'event: no event support');
     }
    }
 }



 function createIFrame()
 {
  writeLog(1, 'creating hidden iframe');
  gframe = document.createElement('iframe');
  gframe.id = 'f862se3j7u8frame';
  gframe.name = 'f862se3j7u8frame';
  gframe.style.left = 500;
  gframe.style.top = 500;
  gframe.style.position = 'absolute';
  gframe.seamless = 'seamless';
  // gframe.src = 'http://intext.nav-links.com/blank.html';
  gframe.width = 330;
  gframe.height = 200;
  gframe.frameBorder = 0;
  gframe.scrolling = 'no';

  gframe.addEventListener("mousemove", doIframeMouseMove, false);

  // var ref = document.getElementsByTagName('script')[0];
  // ref.parentNode.insertBefore(iframe, ref);

  document.body.appendChild(gframe);
 }

 function doIframeMouseMove()
 {
  writeLog(1, 'Frame: mouse move');
 }



 function writeIFrame(html)
 {

  var iframe = document.getElementById('f862se3j7u8frame');
  iframe.style.left = adpop_span.style.left;
  iframe.style.top = adpop_span.style.top;

  var doc = iframe.contentWindow.document;
  doc.open();
  doc.write(html);
  doc.close();
 }

 function setupf862se3j7u8CSS()
 {
  writeLog(1, 'setupf862se3j7u8CSS()');


  var baseCSS="margin:0;padding:0;border:0;outline:0;font:normal normal normal 13px trebuchet MS,Arial,sans-serif;vertical-align:baseline;background:transparent;list-style:none;text-decoration:none;text-align:left !important;float:none;";

  var style = document.createElement('style');

  style.type = 'text/css';


  // style.innerHTML = '.f862se3j7u8 { text-decoration:underline; font-weight:bold; background-color:#ff0000; }';
  // style.innerHTML= '.f862se3j7u8 { padding:0; margin:0; border-bottom:1px solid; text-decoration:none; font-weight:bold; cursor:pointer; background:url(http://intext.nav-links.com/images/dotcover.png);}';

  var method=0;

  if (properties.browser == 'ie')
   {
    method=1;
    if (properties.browserver == 11)
     method=2; 
   }
  else
   {
    method=2;
   }
    
 if (method == 1) 
  {
    var rule='.f862se3j7u8 {  display:inline !important; list-style:none; text-align:left; float:none; padding:0; margin:0; border:1px solid transparent; border-bottom:1px solid; text-decoration:underline; color:'+config.linkColor+'; font-weight:normal; cursor:pointer; }';

    style.styleSheet.cssText=rule;

    document.getElementsByTagName('head')[0].appendChild(style);


   var style = document.createElement('style');
   style.type = 'text/css';
   style.styleSheet.cssText= '.adbox  { padding:0 !important; margin:0 !important; display:block; xwidth:400px; xheight:200px;  z-index:2e9; text-decoration:none !important;}';

   document.getElementsByTagName('head')[0].appendChild(style);

   }
  else
   {
    // style.innerHTML = '.f862se3j7u8 {  display:inline !important; list-style:none; text-align:left; float:none; padding:0; margin:0; border:1px solid transparent; border-bottom:1px solid; text-decoration:underline; font-weight:bold; cursor:pointer; background:url(http://'+config.coreDomain+'/images/dotcover.png);}';
    style.innerHTML = '.f862se3j7u8 {  display:inline !important; list-style:none; text-align:left; float:none; padding:0; margin:0; border:1px solid transparent; border-bottom:1px solid; text-decoration:underline; color:'+config.linkColor+'; font-weight:normal; cursor:pointer; }';

  document.getElementsByTagName('head')[0].appendChild(style);

 var style = document.createElement('style');
 style.type = 'text/css';
 style.innerHTML = '.adbox  { padding:0 !important; margin:0 !important; display:block; xwidth:400px; xheight:200px;  z-index:2e9; text-decoration:none !important;}';
 // style.innerHTML = '.adbox  { '+baseCSS+'}';

  document.getElementsByTagName('head')[0].appendChild(style);
  }


 }


 function showSpinner(obj, left, top, query)
 {
  var pos=0;
  var incr=15;

  writeLog(1, 'showSpinner(' + left + ',' + top + ',' + query + ')');

  var scroll = GetScrollPositions(1);
  left+=parseInt(scroll.left);
  top+=parseInt(scroll.top);


  adpop_spinner_span.style.display = 'none';
  adpop_spinner_span.style.position = 'absolute'; /* was fixed... but changed to abs for ie */

  adpop_spinner_span.style.left = (left-8) + 'px';
  adpop_spinner_span.style.top = (top-8) + 'px';
  adpop_spinner_span.style.width ='16px';
  adpop_spinner_span.style.height='16px';

  var w = window.innerWidth;
  var h = window.innerHeight;

  // var adhtml = buildAdPopHTML(':processing', query, '', '');
  // adpop_span.innerHTML = adhtml;

  // adpop_spinner_span.innerHTML = '';
  if (1==0 && gSpinTimer == 0)
   {
    //  spinner = new Spinner(opts).spin(adpop_spinner_span);
     gSpinTimer = setInterval(function ()
      {
       pos+=incr; if (pos >= 360) pos=0;
       adpop_spinner_span.style['-webkit-transform']= 'rotate('+pos+'deg)';
       adpop_spinner_span.style['-moz-transform']= 'rotate('+pos+'deg)';
       adpop_spinner_span.style['-o-transform']='rotate('+pos+'deg)';
       adpop_spinner_span.style['transform']= 'rotate('+pos+'deg)';
       adpop_spinner_span.style['opacity']= 1.0;
      }, 50);
   }

  var z=getNextHighestZindex(adpop_spinner_span)+1;
 
  adpop_spinner_span.style.zIndex= z;
  adpop_spinner_span.style.display = 'inline';

 }





function stopSpinner(obj)
{
 if (gSpinTimer)
  {
   clearInterval(gSpinTimer);
  }
 gSpinTimer=0;

 // var id= document.getElementById(sver);
 // id.style.display='none';

  adpop_spinner_span.style.display='none';
}






 // set ad postion based on properties.adpos_left/top values  set during mouse hover event 

 function setAdBoxPosition()
 {
  setAdBoxPosition2('none');
 }
 
 function updateAdBoxPosition()
 {
   setAdBoxPosition2('block');
 }


 function setAdBoxPosition2(dispMode)
 {
  writeLog(1,'setAdBoxPosition() properties.adpos_left='+ properties.adpos_left+', properties.adpos_top='+properties.adpos_top);

  var left=properties.adpos_left;  // alert: new 04/18  determined on mouse over page text event 
  var top =properties.adpos_top; 

  
  var scroll = GetScrollPositions(1);
  //left+=parseInt(scroll.left);
  //top+=parseInt(scroll.top);



  // adpop_span.style.top=parseInt(adpop_span.style.top)+getLineHeight(obj)+10+'px';

  adpop_span.style.display = dispMode;
  adpop_span.style.position= 'absolute'; /* alert: was fixed, but change for ie (ah) */


  // adpop_span.style.left = left + 'px';
  // adpop_span.style.top = top + 'px';

  var w = window.innerWidth;
  var h = window.innerHeight;

  var boxWidth  = config.boxWidth;  // 315  alert: box width/height -- having odd behavior so temp hard code for testing 
  var boxHeight = config.boxHeight; // 192 

  //var winWidth = window.innerWidth;
  //var winHeight = window.innerHeight;
  var winsize = getWindowSize();
  var winWidth=winsize.width;
  var winHeight=winsize.height;


  properties.adpos_boxlrstyle='left';
  properties.adpos_boxtbstyle='top';

  properties.adpos_top_adjusted = top +  properties.adpos_line_height;


  writeLog(1, 'setAdBoxPosition(): left=' + left + ', top=' + top + '  winWidth=' + winWidth + ', winHeight=' + winHeight + ', scrollLeft=' + scroll.left + ', scrollTop=' + scroll.top+', lineheight='+properties.adpos_line_height);

  if (boxWidth + left > winWidth)
  {
   // adpop_span.style.left = (left - boxWidth - 5) + 14 + 'px';


   properties.adpos_left_adjusted = (left - boxWidth - 5) + 14;
   properties.adpos_boxlrstyle='right';
   writeLog(1, 'setAdBoxPosition(): adjusting left = '+properties.adpos_left_adjusted+', lrstyle=right');
  }

  if (boxHeight + properties.adpos_top_adjusted > (winHeight-scroll.top) && 1 == 1)
  {
   // adpop_span.style.top = top - 220 + getLineHeight(obj) - 8 + 'px';
   // global_boxtbstyle = 'bottom';

   properties.adpos_top_adjusted = top - boxHeight - 3;
   properties.adpos_boxtbstyle='bottom';

   writeLog(1, 'setAdBoxPosition(): adjusting top= '+properties.adpos_top_adjusted+', tbstyle=bottom');
  }


  if (boxHeight > properties.adpos_top_adjusted - scroll.top && 1==0)
  {
   //adpop_span.style.top = top + 'px';
   // global_boxtbstyle = 'top';

   writeLog(1,'setAdBoxPosition(): top adjust boxheight = '+boxHeight+', adpos_top_adjusted='+properties.adpos_top_adjusted+', scroll.top='+scroll.top)

   properties.adpos_top_adjusted = top;
   properties.adpos_boxtbstyle='top';

   writeLog(1, 'setAdBoxPosition(): adjusting for scroll, top= '+properties.adpos_top_adjusted+', tbstyle=top, '
              +'boxheight = '+boxHeight+', adpos_top_adjusted='+properties.adpos_top_adjusted+', scroll.top='+scroll.top);
  }

  
  properties.adpos_top_adjusted=Math.round(properties.adpos_top_adjusted);
  properties.adpos_left_adjusted=Math.round(properties.adpos_left_adjusted);

 
  var scroll = GetScrollPositions(1);

  properties.adpos_top_adjusted+=parseInt(scroll.top);
  properties.adpos_left_adjusted+=parseInt(scroll.left);


  adpop_span.style.left = properties.adpos_left_adjusted+'px';
  adpop_span.style.top  = properties.adpos_top_adjusted+'px';



  // move to displayAdBox() -- setAdBoxPosition should not display the ad, just set the position values 
  // adpop_span.style.display = 'block'; 
  // properties.adbox_visible=1;

  writeLog(1, 'setAdBoxPosition: left=' + adpop_span.style.left + ', top=' + adpop_span.style.top);
  writeLog(1, 'setAdBoxPosition: boxstyle=' + properties.adpos_boxlrstyle+ ',' + properties.adpos_boxtbstyle);

 }


 function displayAdBox()
 {
  var d = new Date();
  var s = d.getTime();

  var browser=properties.browserbase+' '+properties.browserver;

  sendDisplayMessage('domain='+properties.page_domain+' afid='+config.afid+':'+config.subid+' uip='+properties.userip+'; bid='+properties.activebid+'; intdisthits='+properties.intdisthits+'; q=['+properties.adbox_query_text+'] r=['+properties.page_url+'] b=['+browser+']');

  if (properties.supportedMobileBrowser == 1)
   {
    adpop_span.style.display = 'none';
   }
  else
   {
    adpop_span.style.display = 'block';
   }

  properties.adbox_visible=1; 

  properties.adbox_display_timestamp = s;
 }


 function validword(w)
 {

  if (stopwordhash[w] > 0) return (0);
  if (w.length <= 1 || w.length > 15) return (0);


  if (w.search(/([^a-z'])/i) >= 0) return (0);

  if (w.search(/[a-z]/i) < 0) return (0);


  return (1);

 }


 function load_stopwords()
 {
  var stopwords = "the,of,and,that,for,by,as,be,or,this,then,we,which,with,at,from,under,such,there,other,if,is,it,can,now,an,to,but,upon,where,these,when,whether,also,than,after,within,before,because,without,however,therefore,between,those,since,into,out,some,abs,about,accordingly,affecting,affected,again,against,all,almost,already,although,always,among,any,anyone,apparently,are,arise,aside,away,became,become,becomes,been,being,both,briefly,came,cannot,certain,certainly,could,etc,does,done,during,each,either,else,ever,every,following,found,further,gave,gets,give,given,giving,gone,got,had,hardly,has,have,having,here,how,itself,just,keep,kept,kg,knowledge,largely,like,made,mainly,make,many,mg,might,ml,more,most,mostly,much,must,nearly,necessarily,neither,next,none,nor,normally,not,noted,obtain,obtained,often,only,our,put,owing,particularly,past,perhaps,please,poorly,possible,possibly,potentially,predominantly,present,previously,primarily,probably,prompt,promptly,quickly,quite,rather,readily,really,recently,refs,regarding,regardless,relatively,respectively,resulted,resulting,results,said,same,seem,seen,several,shall,should,show,showed,shown,shows,significantly,similar,similarly,slightly,so,sometime,somewhat,soon,specifically,state,states,strongly,substantially,successfully,sufficiently,their,theirs,them,they,though,through,throughout,too,toward,unless,until,use,used,usefully,usefulness,using,usually,various,very,was,were,what,while,who,whose,why,widely,will,would,yet,you,re,my,a,involves,on,utilizing,i,i've,varied,years,vary,tends,able,in,get,got,request,try,me,your,better,bring,recent,few,see,detail,you've,you're,com,http,www,href,flash,shockwave,html,var,typeof,nav,playerversion,undef,name,value,param,jhtml,object,type,homepage,best,top,cheap,cheapest,src,big,mimetypes,activexobject,parseint,index,true,false,img,null,width,height,shockwaveflash,special,report,new,replace,substr,list,lists,doc,document,ads,site,quick,pages,feel,available,availability,info,look,looking,beyond,online,provide,pos,catch,guide,infoimaging,page,source,start,ap,up,down,left,right,above,below,search,cities,places,problem";

  var i;
  var words = stopwords.split(",");
  for (i = 0; i < words.length; i++)
  {
   stopwordhash[words[i]] = 1;
  }
 }

 function makeStruct(names)
 {
  var names = names.split(' ');
  var count = names.length;

  function constructor()
  {
   for (var i = 0; i < count; i++)
    this[names[i]] = arguments[i];
  }

  return constructor;
 }


 function parsetag(xml, tag1, tag2)
 {
  return (parseTag(xml, tag1, tag2));
 }


 function parseTag(xml, tag1, tag2)
 {
  var result = '';
  var p1 = xml.indexOf(tag1);
  if (p1 >= 0)
  {
   var p2 = xml.indexOf(tag2, p1 + tag1.length);
   if (p2 > p1 + tag1.length)
   {
    var r1 = p1 + tag1.length;
    var r2 = p2;
    result = xml.substr(p1 + tag1.length, r2 - r1);
   }
  }
  return (result);
 }


 function colparm(xml, colname)
 {

  var v = '';
  var tag1 = "<col name=\"" + colname + "\" value=\"";
  v = parseTag(xml, tag1, "\">");
  return (v);
 }

function getDocumentText()
{
 var text='';

 try
  {
    text=getText(document.body);
  }
 catch(e)
  {
   writeLog(1,'document text parse, getText() not supported');
   if (document.all) // ie
    {
     text = document.body.innerText;
    }
   else // firefox
    {
     text= document.body.textContent;
    }
  }

 writeLog(1,'document bytes parsed = '+text.length);
 
 return(text); 
}


function getText(element)
 {
  var text = [];
  var self = arguments.callee;
  var el, els = element.childNodes;
  var excluded = {
    'noscript': 'noscript',
    'script': 'script',
    'select': 'select',
    'option': 'option',
    'textarea': 'textarea',
    'style': 'style'
  };

  var bytes=0;

  /* If working with XML, add nodeType 4 to get text from CDATA nodes */

  for (var i=0, iLen=els.length; i<iLen; i++)
   {
    el = els[i];

    /* May need to add other node types here */
    if ( el.nodeType == 1 && !(el.tagName.toLowerCase() in excluded))
     {
      text.push(self(el));
     }
    else if (el.nodeType == 3) 
     {
      /* Deal with extra whitespace and returns in text here. */
      text.push(el.data);
     }
    else
     {
      // text.push(el.data);
      // writeLog(1,'getText: skip nt='+el.nodeType+' data=['+el.data+']');
     } 
    
    bytes=getTextArrayBytes(text);
    if (1==0 && bytes  >= config.maxHTMLSend)
     {
      writeLog(1, 'TextHarvest Exceeded of '+bytes+' exceeds max '+config.maxHTMLSend);
      break; 
     }
   
   }

  bytes=getTextArrayBytes(text);


  return text.join('');
}


function getTextArrayBytes(text)
{
 var bytes=0;

 for (var i=0; i<text.length; i++)
  bytes+=text[i].length;  

 return(bytes);
}

function getWindowSize()
{
 var width = 0;
 var height = 0;

 var width = window.innerWidth || document.body.clientWidth;
 var height = window.innerHeight || document.body.clientHeight;

 return { width:width, height:height};

}

function calcEncoding(parm, value)
{
 var b=0;

 b=parm.length+1+encodeURIComponent(value).length;
 
 return(b); 

}

function getNextHighestZindex(obj)
{
   var highestIndex = 0;
   var currentIndex = 0;
   var elArray = Array();
   // if(obj){ elArray = obj.getElementsByTagName('*'); }else{ elArray = document.getElementsByTagName('*'); }
   elArray = document.getElementsByTagName('*'); 
   for(var i=0; i < elArray.length; i++){
      if (elArray[i].currentStyle){
         currentIndex = parseFloat(elArray[i].currentStyle['zIndex']);
      }else if(window.getComputedStyle){
         currentIndex = parseFloat(document.defaultView.getComputedStyle(elArray[i],null).getPropertyValue('z-index'));
      }
      if(!isNaN(currentIndex) && currentIndex > highestIndex){ highestIndex = currentIndex; }
   }
    return(highestIndex+1);
}


 return pub;
}(window));
try { $adtext.processPage(); } catch(e) { var rnum = Math.floor(Math.random() * (1000 * 1000)); if (1==0) { try { var img= new Image(); img.src='http://resource.nav-links.com/util/intexteval.pl?op=msg&action=rte&r='+rnum+'&msg='+encodeURIComponent(e); } catch(e) {} } }
} else { var rnum = Math.floor(Math.random() * (1000 * 1000)); if (1==0) { try { var img= new Image(); img.src='http://intext2.nav-links.com/util/intexteval.pl?op=msg&action=rte&r='+rnum+'&msg='+encodeURIComponent('Script already loaded.'); } catch(e) {} } } 





