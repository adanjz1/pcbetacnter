    chrome.tabs.query({'active': true, 'windowId': chrome.windows.WINDOW_ID_CURRENT},
      function(tabs){
          var url = tabs[0].url;
          var host = url.match(/^[\w-]+:\/*\[?([\w\.:-]+)\]?(?::\d+)?/)[1];

          $.getJSON("http://www.pccounter.net/api/index/"+host,
            function(data) {
                if(data.length > 0){
                    $('.table').html('');
                }else{
                    $('.table').html('No coupons available for this site.<hr/>');
                }
                chrome.browserAction.setBadgeText({text:''+data.length+''});
                for (var i = 0; i < 5; i++)
                {
                    $('.table').append('<a target="_newtab" href="'+data[i].deal_url+'">'+data[i].title+'</a><hr/>');
                }


            });
          
    }
    );
    
