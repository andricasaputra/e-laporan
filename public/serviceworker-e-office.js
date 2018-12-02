const version = 'e-office-2018-01::';

// Caches for different resources
const coreCacheName = version + 'core';
const pagesCacheName = version + 'pages';
const assetsCacheName = version + 'assets';
const apiCacheName = version + 'apis';

const coreCacheUrls = [
    '/',
    'css/animate.min.css',
    'css/app.css',
    'css/bootstrap.min.css',
    'css/bootstrap-notifications.min.css',
    'css/datatables.min.css',
    'css/ikm.css',
    'css/magnific-popup.css',
    'css/main.css',
    'css/owl.carousel.min.css',
    'css/reveal.css',
    'css/style.css',
    'css/style.min.css',
    'css/util.css',
    'css/swiper.min.css',
    'font-awesome/css/font-awesome.min.css',
    'js/app-style-switcher.js',
    'js/app.js',
    'js/bootstrap.bundle.min.js',
    'js/Chart.min.js',
    'js/contactform.js',
    'js/custom.js',
    'js/dashboard.js',
    'js/datatables.min.js',
    'js/datatables_operasional.js',
    'js/easing.min.js',
    'js/highcharts-more.js',
    'js/highcharts.js',
    'js/hoverIntent.js',
    'js/jquery-migrate.min.js',
    'js/jquery.min.js',
    'js/magnific-popup.min.js',
    'js/misc.js',
    'js/owl.carousel.min.js',
    'js/progressbar.min.js',
    'js/pusher.min.js',
    'js/reveal.js',
    'js/sticky.js',
    'js/superfish.min.js',
    'js/swiper.min.js',
    'js/wow.min.js',
    'offline.html',
    'images/favicon-32x32.png',
    'images/offline.png',
    'images/web-sumbawa1x.png',
    'images/web-sumbawa2x.png',
    'images/web-sumbawa3x.png',
    'images/web-sumbawa4x.png'
]; 

// Remove old caches that done't match current version
function clearCaches() { 
  return caches.keys().then(function(keys) {
    return Promise.all(keys.filter(function(key) {
        return key.indexOf(version) !== 0;
      }).map(function(key) { 
        return caches.delete(key);
      })
    );
  });
}

// Trim specified cache to max size
function trimCache(cacheName, maxItems) {
  caches.open(cacheName).then(function(cache) {
    cache.keys().then(function(keys) {
      if (keys.length > maxItems) {
        cache.delete(keys[0]).then(trimCache(cacheName, maxItems));
      }
    });
  });
}

self.addEventListener('message', event => {
  if (event.data.command == 'trimCaches') {
    trimCache(pagesCacheName, 30);
    trimCache(assetsCacheName, 30);
  }
});

/*Install ServiceWorker And Add Files to Cache*/
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(version + 'begin').then(cache => {
      return cache.addAll(coreCacheUrls);
    })
  );
});


/*Delete Cache*/
self.addEventListener('activate', event => {
  event.waitUntil(
    clearCaches().then( () => { 
      return self.clients.claim(); 
    })
  );
});


/*Fetching...*/
self.addEventListener('fetch', event => {

  let request = event.request,
  acceptHeader = request.headers.get('Accept');

  /*HTML Requests only or pages*/
  if (acceptHeader.indexOf('text/html') !== -1) {

    /*Try network first*/
    /*Fresh Data*/
    event.respondWith(
      fetch(request).then( res => {
        return caches.open(pagesCacheName).then( cache => {   
            /*save the response for future*/
            cache.put(request.url, res.clone());  
            return res; 
        });
      /*fallback mechanism */  
      }).catch(function(){
          return caches.match(request).then( response => {
            if (response) {
                return response;
            }
            return caches.match('images/offline.png');
          });                    
      })
    );
 
  }else{
     
    if(request.url.indexOf('https') > -1){

        event.respondWith(
          caches.match(request)
            .then( response => { 
                /*if valid response is found in cache return it*/  
                if (response) {
                  return response;  
                /*else fetch from internet*/  
                } else {
                  return fetch(request).then( res => {
                    return caches.open(assetsCacheName).then( cache => {   
                        /*save the response for future*/
                        cache.put(request.url, res.clone());  
                        return res; 
                    });
                  /*fallback mechanism */  
                  }).catch(function(){
                      return caches.match(request).then( response => {
                        if (response) {
                            return response;
                        }
                        return caches.match('images/offline.png');
                      });                    
                  });         
                }
          })
        );
        
    }
        
  }
});

