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

				<!-- Main -->
					<div id="main">

						<!-- Post -->
							<section class="post">
								<header class="major">
									<span class="date">April 25, 2017</span>
									<h1>Making a queuing system in AWS</h1>
									<p>Coming Soon!</p>
								</header>
								<!-- No image for this one
								<div class="image main"><img src="images/pic01.jpg" alt="" /></div>
								-->
								<p>So for one of my projects at <a href="http://codebase.berkeley.edu">CodeBase</a>, we had to create a queuing system to handle large amounts of incoming requests for one of out clients. We decided to use a bunch of instances of AWS's brand-new FIFO SQS implementation + an Elastic Beanstalk Worker Environment to keep track of and process requests, while we used an Elastic Beanstalk Web Server environment running Django to handle web requests from clients and feed them to the SQS instances. While I was playing around with these services, I found that there was alot of good documentation about each service but relatively little when it came to starting from scratch (basically, I found all the documentation impossible to navigate as a novice developer) so I made this guide, noob-stlye. I'm writing this after going through the entire process, so its definitely possible that I missed steps. If that's the case, shoot me a message at sauravkadavath@berkeley.edu.</p>
								<h3> Setting up our development environment </h3>
								<p>We're going to be deploying <a href="https://aws.amazon.com/elasticbeanstalk/">AWS Elastic Beanstalk</a>, which is essentially a fancy web server that Amazon provides, and scales automatically and stuff. Here's a cool diagram of what it is basically from the AWS website:</p>
								<div class="image main"><img src="images/aeb-architecture2.png"/></div>
								<p>The blue outline is an <i>environment</i>. We'll get back to those later. Since each EB instance is essentially a self-contained computer, we'll see need to be careful to make sure whatever code that we push onto Elastic Beanstalk has all of its dependencies enumerated and listed or bundled with the package. In order to do this, we'll need to keep track of all the dependencies that we use on our computer, and we'll use something called <b>virtual environments</b> for this purpose (not to be confused with the EB environments that I mentioned before). We'll be using an environment manager called <code>virtualenv</code>, that comes with <code>pip</code>. For those who don't know what <code>pip</code> is, it's just a package manager for Python (i.e. It keeps track of all of the external Python libraries and packages that you use - one of which is Django). If you have Anaconda installed (from something like EE16A) uninstall it and all of its dependent files, and if you are on Windows, clear all of the environment vairables related to it. After alot of headaches, I figured out that <code>virtualenv</code> and Anaconda don't like to play together, and I couldn't get them to cooperate. If manage to get them to work together, lmk. Given that you don't have Anaconda on your machine and you have Python <b>2.7</b> installed, here's how to keep going:</p>
								<ol>
									<li>
										Install <code>pip</code> and <code>virtualenv</code> if you don't already have them:
										<ul>
										<li> To download pip, download <a href="https://bootstrap.pypa.io/get-pip.py"> get-pip.py </a> and run <code>python get-pip.py</code> </li>
										<li> To install <code>virtualenv</code>, run <code>pip install virtualenv</code> </li>
										</ul>
									</li>
									<li>
										Now, let's make a virtual environment for our project to live in. Run <code>virtualenv &lt; path_to_environment_folder &gt; </code>. You can choose where to save all of the environment dependency files. For example, I chose to run <code>virtualenv C:/eb-env</code>, and all of my 
									</li>
								</ol>
								<p>More Coming Soon!</p>
							</section>

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