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
                        <!-- Content goes here -->
                        <!-- Post -->
                        <section class="post">
                            <header class="major">
                                <span class="date">April 25, 2017</span>
                                <h1>Polisight</h1>
                                <p>A new type of news aggregator</p>
                            </header>
                            <div class="image main"><img src="images/polisight.jpg" alt="" /></div>
                            <p>Polisight is essentially a new type of news aggregator. It was developed at <a href="https://calhacks.io/">CalHacks</a> 3.0. Here is an outline of the project, taken from out <a href="https://devpost.com/software/polisight">DevPost</a>. </p>

							<h3>Inspiration</h3>

							<p>This app idea came to us on November 9th, the day after the 2016 presidential election. In a retrospective moment, I realized the importance, and sometimes the pitfalls, of the media. Coming from a very liberal area, I had been constantly bombarded with liberal rhetoric and liberally-biased stories. We realized that this skewed our perspectives on world events - this was an instance of division in understanding between various political and ideological groups due to a sensationalist media. This was the issue that we decided to tackle: How can we bridge this gap, and allow people to understand different sides of this divide?</p>

							<h3>What it does</h3>

							<p><span class="image left"><img src="images/polisightchart.jpg" alt=""></span>PoliSght is an app that enables the user to analyze differnet news sources. It's homepage includes trending articles from news sources such as BBC, CNN, The Washington Post, The Guardian, USA Today, Google News and Time. It displays the newest and most trending articles at the top, and for each article, it give the user an option to quickly analyze the emotional and positive/negative sentiments that the article that the article gives. The app also includes a comparison function, which enables the user to compare top articles from two news sources of their choosing. Together, these functionalities enable the user to make for themselves a custom  experience, which alleviates problems of bias for their daily dose of news.</p>

							<h3>How I built it</h3>
							<p>PoliSight was built using Meteor.js, Bootstrap, Javascript, and Blaze. We implemented the News API and IBM Watson's AlchemyLanguage API in order to speed up web scraping and language processing.</p>

							<h3>Challenges I ran into</h3>

							<p>We had trouble deciding on which framework/languages to use for this app, as there were many viable ones. We decided on Meteor.js because it looked like it had the most potential for expansion. As a team, we were not that strong at Meteor.js going into the hackathon, but I think we came out better Meteor developers. In particular, it was hard to understand how to work simultaneuosly work together. (e.g. developing the back-end with no front-end and vice versa.)</p>

							<h3>Accomplishments that I'm proud of</h3>

							<p><span class="image right"><img src="images/polisighthomepage.jpg" alt=""></span>We were able to make a functioning and visually appealing website in under 36 hours. Much of the code is also modular, so we will be able to expand on the site's capabilities in the future. </p>

							<h3>What I learned</h3>

							<p>We learned how to use lazy-loading in order to maximize the performance of our site. In order to do this, we utilized some of the very powerful communication paradigm that Meteor.js provides. This let us save on seconds of loading time and on AlchemyLanguage's transactions for each API call.
							What's next for PoliSight</p>

							<h3>What's next for PoliSight</h3>

							<p>Expanding upon this app can make it much more powerful. Moving forward, our next step is to implement a search function, which can search for multiple news articles on the same subject, and allow the user to compare analytics on these articles. Also, we plan to implement an algorithm that will be able to give the  user a range of news articles that cover a wide range of points of view on any select issue. With the addition of more news sources from a wide range of perspectives, PoliSight has the potential to become a full-fledged news source, changing the way the world takes in news.</p>
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