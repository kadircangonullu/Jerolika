var OS_Analytics = {
    
    // States
    analyticsId : "",
    pageTracker : null,
    


    /**
     *
     * Load & Commit all necessary operations at once with a single array.
     *
     */
    singleTransaction : function (transactionData){
        
        // Start Transaction.
        OS_Analytics.startTransaction(
            transactionData['purchaseId'], 
            transactionData['storeName'], 
            transactionData['sanilAmount'], 
            transactionData['tax'], 
            transactionData['shipping'], 
            transactionData['city'], 
            transactionData['state'], 
            transactionData['country']);
        
        // Loop products, and add them to collection.
        for(var i in transactionData['products']){
            OS_Analytics.addItemToTransaction(
                transactionData['products'][i]['purchaseId'], 
                transactionData['products'][i]['productKey'], 
                transactionData['products'][i]['productName'], 
                transactionData['products'][i]['productCategory'], 
                transactionData['products'][i]['sanilAmount'], 
                transactionData['products'][i]['quantity']);
        }
        
        // Commit to analytics.
        OS_Analytics.commitTransaction();
    },
    
    /**
     * Start transaction.
     */
    startTransaction : function (purchaseId,storeName,sanilAmount,tax,shipping,city,state,country) {

        if (OS_Analytics.pageTracker == null){
            // If pageTracker is null, then get _gat global variable.
            // (_gat global variable has to be created by standard google analytics tracker code inside of any page.)
            // _gat means Google Analytics Tracker
            // _gaq means Google Analytics Query (usually used for asynchronous js calls.)
            OS_Analytics.pageTracker = _gat._getTracker(OS_Analytics.analyticsId);
        }
        
        // Use this when you need to track page.
        // OS_Analytics.pageTracker._trackPageview();
        
        OS_Analytics.pageTracker._addTrans(
            purchaseId, //"1234", // order ID - required
            storeName,//"Bakkal", // affiliation or store name
            sanilAmount,//"1200", // total - required
            tax,//"0", //no need. (0)
            shipping,//no need. (0)
            city,// Sannari
            state,// no need. ('')
            country// Sanalika Turkey
            );
                
        // Log.
        console.log('Transaction started: '+purchaseId);
    },
    
    /**
     * add item might be called for every item in the shopping cart
     * where your ecommerce engine loops through each item in the cart and
     * prints out _addItem for each
     */
    addItemToTransaction : function (purchaseId,productKey,productName,productCategory,sanilAmount,quantity){
        // add item might be called for every item in the shopping cart
        // where your ecommerce engine loops through each item in the cart and
        // prints out _addItem for each
        OS_Analytics.pageTracker._addItem(
            purchaseId,
            productKey, // m_13
            productName, // yoyo etc.
            productCategory,// kirmizi etc.
            sanilAmount,
            quantity
            );
              
        // Log.
        console.log('Item added to Transaction : '+productKey);
                
    },
    
    /**
     * submits transaction to the Analytics servers
     */
    commitTransaction : function (){
        OS_Analytics.pageTracker._trackTrans(); 
        
        // Log.
        console.log('Transaction commit.');
    },
    
    /**
     * tracks an event.
     * 
     * https://developers.google.com/analytics/devguides/collection/gajs/eventTrackerGuide
     */
    trackEvent : function (category,action,opt_label,opt_value,opt_noninteraction){
        if (OS_Analytics.pageTracker == null){
            // If pageTracker is null, then get _gat global variable.
            // (_gat global variable has to be created by standard google analytics tracker code inside of any page.)
            // _gat means Google Analytics Tracker
            // _gaq means Google Analytics Query (usually used for asynchronous js calls.)
            OS_Analytics.pageTracker = _gat._getTracker(OS_Analytics.analyticsId);
        }
        
        OS_Analytics.pageTracker._trackEvent(
            category,
            action,
            opt_label,
            opt_value,
            opt_noninteraction
        );
            
    },
    
    /**
     * tracks page view
     * 
     * https://developers.google.com/analytics/devguides/collection/gajs/methods/gaJSApiBasicConfiguration
     */
    trackPageview : function (name){
        if (OS_Analytics.pageTracker == null){
            // If pageTracker is null, then get _gat global variable.
            // (_gat global variable has to be created by standard google analytics tracker code inside of any page.)
            // _gat means Google Analytics Tracker
            // _gaq means Google Analytics Query (usually used for asynchronous js calls.)
            OS_Analytics.pageTracker = _gat._getTracker(OS_Analytics.analyticsId);
        }
        
        OS_Analytics.pageTracker._trackPageview(
            name
        );
       
    },
    
    /**
     * track page request
     * 
     * http://www.kontagent.com/docs/technical-leads/api-sdk-spec/social/pgr/
     */
    trackPageRequest: function(){
      $.ajax({
        type: "POST",
        url: "track-page-request",
        //data: "pa=" + pa,
        async: true,
        success: function(res){},
        error: function(res){}
      });
    }
    
};
