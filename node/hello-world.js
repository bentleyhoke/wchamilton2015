var http = require("http");
var express = require('express');
var app = express();
app.use(express.static('public'));
app.set('views', __dirname);
app.set('view engine', 'jade');
var WP = require( 'wordpress-rest-api' );
var wp = new WP({ endpoint: 'http://wchamilton2015.bentleyhoke.webfactional.com/wp-json' });

app.get('/post/:id', function(req, res) {
  var id = req.params.id;
  wp.posts().id(id).get(function( err, data ) {
    if ( err ) {
      res.status(500).send("An error has occurred" + err);
    } else {
      res.render('post.jade', {
        post: data
      }, function(err, html) {
        res.status(200).send(html)
      });
    }
  });
});

app.get('/posts', function(req, res) {
  wp.posts().filter( 'posts_per_page', 100 ).get(function( err, data ) {
    if ( err ) {
      res.status(500).send("An error has occurred" + err);
    } else {
      res.render('posts.jade', {
        posts: data
      }, function(err, html) {
        res.status(200).send(html)
      });
    }
  });
});

//listen on port 8080 for webserver:
app.listen(29704);
