<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8">

		<?php
			require_once('httpful.phar');
			$uri = "http://wchamilton2015.bentleyhoke.webfactional.com/wp-json/posts?type[]=page&filter[author]=3&filter[orderby]=menu_order&filter[order]=ASC&filter[posts_per_page]=1";
			$response = \Httpful\Request::get($uri)
			    ->expectsJson()
			    ->sendIt();
			$pages = $response->body;
			foreach($pages as $page) {
				$presotitle = $page->title;
			}
		?>

		<title><?php echo $presotitle ?></title>

		<meta name="description" content="Bentley Hoke: WordCamp Hamilton 2015 Presentation - WP-API">
		<meta name="author" content="Bentley Hoke">

		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">

		<link rel="stylesheet" href="css/reveal.css">
		<link rel="stylesheet" href="css/theme/white.css" id="theme">

		<!-- Code syntax highlighting -->
		<link rel="stylesheet" href="lib/css/zenburn.css">

		<!-- Printing and PDF exports -->
		<script>
			var link = document.createElement( 'link' );
			link.rel = 'stylesheet';
			link.type = 'text/css';
			link.href = window.location.search.match( /print-pdf/gi ) ? 'css/print/pdf.css' : 'css/print/paper.css';
			document.getElementsByTagName( 'head' )[0].appendChild( link );
		</script>

		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
	</head>

	<body>

		<div class="reveal">

			<!-- Any section element inside of this container is displayed as a slide -->

			<div class="slides">

				<?php
					require_once('httpful.phar');

					$uri = "http://wchamilton2015.bentleyhoke.webfactional.com/wp-json/posts?type[]=page&filter[author]=3&filter[orderby]=menu_order&filter[order]=ASC&filter[posts_per_page]=1000";

					$response = \Httpful\Request::get($uri)
					    ->expectsJson()
					    ->sendIt();

					$pages = $response->body;

					#print_r($pages);

					$aSections = array();

					foreach($pages as $page) {
						$thispage = array();
						$thispage['id'] = $page->ID;
						$thispage['title'] = $page->title;
						$thispage['content'] = $page->content;
						$thispage['parent'] = $page->parent;
						$thispage['menu_order'] = $page->menu_order;
						$thispage['children'] = array();
						if ($page->parent == '') {
							array_push($aSections, $thispage);
						} else {
							foreach($aSections as $key => $section) {
								if ($section['id'] == $page->parent) {
									array_push($aSections[$key]['children'], $thispage);
									break;
								}
							}
						}
					}
				?>

				<?php foreach ($aSections as $section): ?>

					<section>
						
						<?php echo count($section['children']) > 0 ? '<section>' :'' ?>
						
						<h2><?php echo $section['title'] ?></h2>
						<?php echo $section['content'] ?>

					</section>

				<?php endforeach; ?>
				

		</div>

		<script src="lib/js/head.min.js"></script>
		<script src="js/reveal.js"></script>

		<script>

			// Full list of configuration options available at:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,

				transition: 'slide', // none/fade/slide/convex/concave/zoom

				// Optional reveal.js plugins
				dependencies: [
					{ src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
					{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/highlight/highlight.js', async: true, condition: function() { return !!document.querySelector( 'pre code' ); }, callback: function() { hljs.initHighlightingOnLoad(); } },
					{ src: 'plugin/zoom-js/zoom.js', async: true },
					{ src: 'plugin/notes/notes.js', async: true }
				]
			});

		</script>

	</body>
</html>
