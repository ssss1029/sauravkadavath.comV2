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
									<p>Some stuff here</p>
								</header>
								<a href="about.php" class="image main"><img src="images/berkeley.jpg" alt="" /></a>
								<ul class="actions">
									<li><a href="about.php" class="button big">Keep Reading</a></li>
								</ul>
							</article>

						<!-- Posts -->
							<section class="posts">
								<article>
									<header>
										<span class="date">August 17, 2017</span>
										<h2><a href="#">Setting up AWS and FIFO SQS with Python and Boto3</a></h2>
									</header>
									<a href="awssqspythonboto3.php" class="image fit"><img src="images/pic03.jpg" alt="" /></a>
									<p> Some stuff here </p>
									<ul class="actions">
										<li><a href="awssqspythonboto3.php" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">August 12, 2017</span>
										<h2><a href="#">Newssight</a></h2>
									</header>
									<a href="newssight.php" class="image fit"><img src="images/newssight.png" alt="" /></a>
									<p>A new type of news aggreagator that is able to intelligently classify articles, letting people easily understand the news that they are consuming. This is my personal spinoff off of <a href="#">Polisight</a>, and I've been working on this extensively this summer.</p>
									<ul class="actions">
										<li><a href="newssight.php" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">November 13, 2016</span>
										<h2><a href="#">Polisight</a></h2>
									</header>
									<a href="polisight.php" class="image fit"><img src="images/polisight.jpg" alt="" /></a>
									<p>A web app that I co-developed in 24 hours at <a target="_blank" href="https://calhacks.io/"> CalHacks</a>.</p>
									<ul class="actions">
										<li><a href="polisight.php" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">August 21, 2015</span>
										<h2><a href="#">Rummage</a></h2>
									</header>
									<a href="rummage.php" class="image fit"><img src="images/rummagelogo.png" alt="" /></a>
									<p>A Google Chrome Extension that extends the capabilities of the Google search engine.</p>
									<ul class="actions">
										<li><a href="rummage.php" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">August 12, 2017</span>
										<h2><a href="#">About Me</a></h2>
									</header>
									<a href="about.php" class="image fit"><img src="images/berkeley.jpg" alt="Berkeley" /></a>
									<p>Some stuff here</p>
									<ul class="actions">
										<li><a href="about.php" class="button">Full Story</a></li>
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