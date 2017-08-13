<!DOCTYPE HTML>
<html>
	<head>
		<?php include("heading.php") ?>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper" class="fade-in">

				<!-- Intro -->
				<?php include('intro.php') ?>

				<!-- Header -->
				<?php include('header.php') ?>

				<!-- Nav -->
				<?php include('nav.php') ?>


				<!-- Main -->
					<div id="main">

						<!-- Featured Post -->
							<article class="post featured">
								<header class="major">
									<h2><a href="#">About Me</a></h2>
									<p>Aenean ornare velit lacus varius enim ullamcorper proin aliquam<br />
									facilisis ante sed etiam magna interdum congue. Lorem ipsum dolor<br />
									amet nullam sed etiam veroeros.</p>
								</header>
								<a href="#" class="image main"><img src="images/berkeley.jpg" alt="" /></a>
								<ul class="actions">
									<li><a href="#" class="button big">Keep Reading</a></li>
								</ul>
							</article>

						<!-- Posts -->
							<section class="posts">
								<article>
									<header>
										<span class="date">August 12, 2017</span>
										<h2><a href="#">Newssight</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/newssight.png" alt="" /></a>
									<p>A new type of news aggreagator that is able to intelligently classify articles, letting people easily understand the news that they are consuming. This is my personal spinoff off of <a href="#">Polisight</a>, and I've been working on this extensively this summer.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">November 13, 2016</span>
										<h2><a href="#">Polisight</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/polisight.jpg" alt="" /></a>
									<p>A web app that I co-developed in 24 hours at <a target="_blank" href="https://calhacks.io/"> CalHacks</a>.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">August 21, 2015</span>
										<h2><a href="#">Rummage</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/rummage.png" alt="" /></a>
									<p>A Google Chrome Extension that extends the capabilities of the Google search engine.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
							</section>

						<!-- Footer -->
							<footer>
								<div class="pagination">
									<!--<a href="#" class="previous">Prev</a>-->
									<a class="page active">1</a>
									<span class="extra">&hellip;</span>
									<span class="extra next">Next</span>
								</div>
							</footer>

					</div>

				<!-- Footer -->
				<?php include('footer.php') ?>

				<!-- Copyright -->
				<?php include('copyright.php') ?>

			</div>

		<!-- Scripts -->
		<?php include('scripts.php') ?>
	</body>
</html>