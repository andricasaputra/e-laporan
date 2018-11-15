const version = 'e-ikm-2018-01::';
// Caches for different resources

const coreCacheName = version + 'core';
const pagesCacheName = version + 'pages';
const assetsCacheName = version + 'assets';
const adminCacheName = version + 'admin';

const coreCacheUrls = [
    '/',
    'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700',
    'css/animate.min.css',
    'css/bootstrap.min.css',
    'css/datatables.min.css',
    'css/font-awesome.min.css',
    'css/ikm.css',
    'css/ionicons.min.css',
    'css/magnific-popup.css',
    'css/main.css',
    'css/materialdesignicons.min.css',
    'css/owl.carousel.min.css',
    'css/reveal.css',
    'css/style.css',
    'css/util.css',
    'css/swiper.min.css',
    'font-awesome/css/font-awesome.min.css',
    'js/app.js',
    'js/bootstrap.bundle.min.js',
    'js/Chart.min.js',
    'js/contactform.js',
    'js/dashboard.js',
    'js/datatables.min.js',
    'js/datatables_operasional.js',
    'js/easing.min.js',
    'js/hoverIntent.js',
    'js/jquery-migrate.min.js',
    'js/jquery.min.js',
    'js/magnific-popup.min.js',
    'js/material-components-web.min.js',
    'js/material.js',
    'js/misc.js',
    'js/owl.carousel.min.js',
    'js/progressbar.min.js',
    'js/reveal.js',
    'js/sticky.js',
    'js/superfish.min.js',
    'js/wow.min.js',
    'js/swiper.min.js',
    'offline.html',
    'images/favicon-32x32.png',
    'images/offline.png',
    'images/web-sumbawa1x.png',
    'images/web-sumbawa2x.png',
    'images/web-sumbawa3x.png',
    'images/web-sumbawa4x.png'
]; 

function addToCache(cacheName, request, response) {
  caches.open(cacheName)
    .then( cache => cache.put(request, response) );
}

// Check if request is something SW should handle

function shouldFetch(event) {
    
  let request = event.request.referrer;
  
  if (request.indexOf('admin') !== -1){
      return false;
  }else{
      return true;
  }
  

}

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
    trimCache(pagesCacheName, 25);
    trimCache(assetsCacheName, 40);
  }
});

/*Install ServiceWorker And Add Files to Cache*/
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(version + 'landing-page').then(cache => {
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

    if (shouldFetch(event)) {
        
      /*Try network first*/
          /*Fresh Data*/
          event.respondWith(
            fetch(request)
              .then(response => {
                if (response.ok) 
                  addToCache(pagesCacheName, request, response.clone());
                return response;
            })
      
            // Try cache second with offline fallback
            .catch( () => {
              return caches.match(request).then(response => {
                  if (response) {
                      return response;
                  }
                  return caches.match('offline.html');
              });
            })
          );

    }
    
  }else{
     
    if (shouldFetch(event)) {
        
        if((request.url.indexOf('https') > -1)){
    
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
                            return caches.match('offline.html');
                          });                    
                      });         
                    }
              })
            );
            
        }
        
    }
        
  }
});