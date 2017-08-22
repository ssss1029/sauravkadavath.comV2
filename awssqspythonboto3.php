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
									<span class="date">August 22, 2017</span>
									<h1>Setting up a queueing system on aws</h1>
									<p>A system that goes uses an AWS SQS FIFO Queue to store jobs and an AWS EB Webserver as a worker.</p>
								</header>
								<!-- No image for this one
								<div class="image main"><img src="images/pic01.jpg" alt="" /></div>
								-->
								<p>So for one of my projects at <a href="http://codebase.berkeley.edu">CodeBase</a>, we had to create a queuing system to handle large amounts of incoming requests for one of out clients. We decided to use a bunch of instances of AWS's brand-new FIFO SQS implementation + an Elastic Beanstalk Worker Environment to keep track of and process requests, while we used an Elastic Beanstalk Web Server environment running Django to handle web requests from clients and feed them to the SQS instances. While I was playing around with these services, I found that there was a lot of good documentation about each service but relatively little when it came to starting from scratch (basically, I found all the documentation impossible to navigate as a novice developer) so I made this guide, noob-style. I'm writing this after going through the entire process, so it's definitely possible that I missed steps. If that's the case, or if you spot any errors, shoot me a message at sauravkadavath@berkeley.edu.</p>
								<h3>Contents:</h3>
								<ul>
									<li>
										Setting up your local computer for developing on Django / AWS
									</li>
									<li>
										Setting up an AWS Elastic Beanstalk Web server running Python 2.7 and deploy a sample Django app on it from the AWS Elastic Beanstalk CLI
									</li>
									<li>
										Creating a FIFO queue with Amazon SQS and communicating with it
									</li>
									<li>
										Setting up an AWS Elastic Beanstalk Web Server Environment as a worker process with a python daemon wun with <code>supervisord</code>
									</li>
								</ul>

								<p>After this, it should be easy to pull data from your SQS queue with your EB worker.</p>

								<h3> Setting up our development environment </h3>
								<p>We're going to be deploying <a href="https://aws.amazon.com/elasticbeanstalk/">AWS Elastic Beanstalk</a>, which is essentially a fancy web server that Amazon provides, and scales automatically and stuff. Here's a cool diagram of what it is basically from the AWS website:</p>
								<div class="image main"><img src="images/aeb-architecture2.png"/></div>
								<p>The blue outline is an <i>environment</i>. We'll get back to those later. Since each EB instance is essentially a self-contained computer, we'll see need to be careful to make sure whatever code that we push onto Elastic Beanstalk has all of its dependencies enumerated and listed or bundled with the package. In order to do this, we'll need to keep track of all the dependencies that we use on our computer, and we'll use something called <b>virtual environments</b> for this purpose (not to be confused with the EB environments that I mentioned before). We'll be using an environment manager called <code>virtualenv</code>, that comes with <code>pip</code>. For those who don't know what <code>pip</code> is, it's just a package manager for Python (i.e. It keeps track of all of the external Python libraries and packages that you use - one of which is Django). If you have Anaconda installed (from something like EE16A) uninstall it and all of its dependent files, and if you are on Windows, clear all of the environment variables related to it. After a lot of headaches, I figured out that <code>virtualenv</code> and Anaconda don't like to play together, and I couldn't get them to cooperate. If manage to get them to work together, lmk. Given that you don't have Anaconda on your machine and you have Python <b>2.7</b> installed, here's how to keep going:</p>
								<ol>
									<li>
										Install <code>pip</code> and <code>virtualenv</code> if you don't already have them:
										<ul>
										<li> To download pip, download <a href="https://bootstrap.pypa.io/get-pip.py"> get-pip.py </a> and run <code>python get-pip.py</code> </li>
										<li> To install <code>virtualenv</code>, run <code>pip install virtualenv</code> </li>
										</ul>
									</li>
									<li>
										Now, let's make a virtual environment for our project. Run <code>virtualenv &lt;path_to_environment_folder&gt; </code>. You can choose where to save all of the environment dependency files. For example, I chose to run <code>virtualenv C:/eb-env</code>, and all of my virtual environment files were saved in <code>C:/eb-env</code>. If you take a look inside the folder that you chose as your environment folder, you can find a fresh install of tools like python and <code>pip</code>. For the following steps, I'll use <code>C:/eb-env</code> when referring to the virtual environment path.
									</li>
									<li>
										Activate your virtual environment. Inside the environment that you made, there is a script called <code>activate</code>. We'll need to run this with the <code>source</code> command. For example, I ran: <code>source C:/eb-env/Scripts/activate</code>. For Mac or Linux users, the script is probably going to live inside a <code>bin/</code> folder in your virtual environment folder. What running this script will do is change the <code>python</code> and <code>pip</code> commands on your terminal to temporarily use the files in the virtual environment, not from your global install. Thus, whenever you want to use the virtual environment, you have to run <code>source C:/eb-env/Scripts/activate</code> <b>each time you open a new terminal.</b>
									</li>
									<li>
										<code>pip install django</code>. Remember, this is the <code>pip</code> running from the virtual environment
									</li>
									<li>
										Set up a Django dummy project that we can push to Elastic Beanstalk. Navigate to the folder in which you want your project to live and run <code>django-admin startproject eb-django-proj-1</code>. This is just a 'default' project that does nothing. In order to run it, <code>cd eb-django-proj-1</code> and then <code>python manage.py runserver</code> and then go to the <code>http://127.0.0.1:8000</code>. I found <a href="https://www.youtube.com/watch?v=qgGIqRFvFFk&list=PL6gx4Cwl9DGBlmzzFcLgDhKTTfNLfX1IK">these</a> Django tutorials super helpful.
									</li>
									<li>
										To verify that Django has been installed, type in <code>pip freeze</code>. You should see that Django is installed, and maybe a small amount of its dependencies. The main thing is that you should not see the same massive list of dependencies that you would see if you typed in <code>pip freeze</code> from your global environment. To exit out of your virtual environment, type in <code>deactivate</code>.
									</li>
								</ol>
								<h3>Setting up an AWS Elastic Beanstalk Web Server</h3>
								So now, we basically have all the tool on our computer to develop self-contained Django apps. Now, let's work on moving our work into AWS. If you're the one making the AWS resources yourself, keep reading. Otherwise, if you are an <a href="http://docs.aws.amazon.com/IAM/latest/UserGuide/id_users.html">IAM User</a>, ask your AWS system administrator to give you an access key and access secret, and skip to step 3.
								<ol>
									<li>
										Make an Elastic Beanstalk application for Python. When doing this, you must make sure that there is a key pair associated with this instance. In order to do this, make sure you have a key pair selected in the EC2 Key Pair dropdown menu: 
										<div class="image main"><img src="images/ec2keypair.png"></div>
										If this isn't there, make a new key pair and keep this file safe. Navigate to the AWS dashboard (cube on the top left, and choose EC2), and click on key pairs.
										<div class="image main"><img src="images/keypairs.png"></div>
										Keep stepping through the menus, and this will set up a default EB environment for Python. Wait for the system to show a green checkmark, and visit the application to make sure you have the default AWS Sample Application running properly
									</li>
									<li>
										In order to deploy our app from our local machine to AWS, we're going to need an access key and secret. Go to the top right of your Elastic Beanstalk dashboard and click on your name, on from the dropdown, click "My Security Credentials". Here, you can set up an access key/secret for yourself. Be sure to keep these safe, as you only get to see them once.
										<br />
										Note: If you have other people that you want to be able to deploy to your EB environments, you can create <a href="http://docs.aws.amazon.com/IAM/latest/UserGuide/id_users.html">IAM Users</a> for each person, and give them their own access keys and secrets.
									</li>
									<li>
										On your local machine, make sure that you are on your global environment, and run <code>pip install awsebcli</code>. This is the <a href="https://en.wikipedia.org/wiki/Command-line_interface">CLI</a> that lets us talk to our EB instances. After you do this, you should be able to find the AWS CLI configuration file – located at <code> ~/.aws/config </code> on Linux and OS X systems or <code>C:\Users\USERNAME\.aws\config</code> on Windows systems. Go into this file and paste the following code in:
										<pre><code>
[profile eb-cli]
aws_access_key_id = &lt;YOUR_AWS_ACCESS_KEY&gt;
aws_secret_access_key = &lt;YOUR_AWS_ACCESS_KEY_SECRET&gt;

[default]
aws_access_key_id = &lt;YOUR_AWS_ACCESS_KEY&gt;
aws_secret_access_key = &lt;YOUR_AWS_ACCESS_KEY_SECRET&gt;

[default]
region=us-west-2
										</code></pre>
										Save this stuff, and open a new terminal for the following steps.
									</li>
									<li>
										Navigate to where your Django project is located. Run <code>eb init</code>. This should give you a series of questions to answer. Your EB apps and environments that you set up already should come up, so you can choose those. For example, I got something like this (I have multiple environments for my project right now):
										<pre><code>
C:/Saurav/djangotuts$ eb init

Select a default region
1) us-east-1 : US East (N. Virginia)
2) us-west-1 : US West (N. California)
3) us-west-2 : US West (Oregon)
4) eu-west-1 : EU (Ireland)
5) eu-central-1 : EU (Frankfurt)
6) ap-south-1 : Asia Pacific (Mumbai)
7) ap-southeast-1 : Asia Pacific (Singapore)
8) ap-southeast-2 : Asia Pacific (Sydney)
9) ap-northeast-1 : Asia Pacific (Tokyo)
10) ap-northeast-2 : Asia Pacific (Seoul)
11) sa-east-1 : South America (Sao Paulo)
12) cn-north-1 : China (Beijing)
13) us-east-2 : US East (Ohio)
14) ca-central-1 : Canada (Central)
15) eu-west-2 : EU (London)
(default is 3): 3

Select an application to use
1) django-tutorial
2) [ Create new Application ]
(default is 2): 1
Select the default environment.
You can change this later by typing "eb use [environment_name]".
1) my-worker-env
2) my-env
(default is 1): 1
Cannot setup CodeCommit because there is no Source Control setup, continuing with initialization
										</code></pre>

									</li>
									<li>
										Now, if you run <code>eb open</code>, youll open the same default website as before. Now, lets push our own site.
									</li>
									<li>
										First, remember the reason that we created a virtualenv at the beginning - to make sure we could keep track of all the requirements of the project. We'll write all of those requirements into a file that EB can read when we puch it. Run the following:
										<pre><code>source C:/eb-env/Scripts/activate</code></pre>
										<pre><code>cd &lt;YOUR_PROJ_DIRECTORY&gt;</code></pre>
										<pre><code>pip freeze &gt; requirements.txt</code></pre>
									</li>
									<li>
										Now, we need to add a simple configuration file for our app so EB can actually run it properly. Make a directory called <code>.ebextensions</code> in your project folder, and create a file called <code>django.config</code> in it. Paste the following contents into the file:
										<pre><code>
option_settings:
  aws:elasticbeanstalk:container:python:
    WSGIPath: PATH_TO_WSGI.PY/wsgi.py
										</code></pre>
										Make sure to replace the path with the correct path to your <code>wsgi.py</code> file.
									</li>
									<li>
										Now, run 
										<pre><code>eb deploy</code></pre>
										<pre><code>eb open</code></pre>
										You should see your pushed website live on elastic beanstalk!
									</li>
								</ol>
								<h3>Setting up AWS SQS and communicating with it with boto3</h3>
								<p>This is by far the easiest section. I found navigating SQS and Boto3 docs really easy</p>
								<ol>
									<li>
										Head over to the AWS dashboard and select SQS. From there, you'll be able to make new queues. For this, I'll have made a queue called <code>test-queue1.fifo</code>. Note this is a <a href="http://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/FIFO-queues.html">FIFO Queue</a>. FIFO queues are only available in certain regions (outlined in the docs). When you first make a queue, only your AWS account will have permissions for it. To give other accounts permissions, you can add users at the SQS queue dashboard:
									</li>
									<div class="image main"><img src="images/sqs-user-permissions.png"/></div>
									<li>
										Now that we have our queue set up and waiting for messages on the cloud, let's try sending it some messages. The way that we're going to be doing this is using <a href="https://boto3.readthedocs.io/en/latest/">Boto3</a> on the Python interactive shell. Note that doing this will be equivalent to executing the same commands in any Python file - for example in Django. First, we need to install Boto3: <code>pip install boto3</code>. Note that if you need to push code that relies on Boto3 onto EB, you'll need to run this install in your virtual environment and make sure that your <code>requirements.txt</code> is updated properly.
									</li>
									<li>
										We need to configure Boto3 because we need to make sure that it knows who we are when we begin talking to AWS SQS. There are several ways to do this, and they're all explained very well <a href="https://boto3.readthedocs.io/en/latest/guide/quickstart.html#configuration">HERE</a> and <a href="https://boto3.readthedocs.io/en/latest/guide/configuration.html#configuring-credentials">HERE</a>. I personally like adding environment variables for Boto3 to work off of with Python at the top of my main file: 
										<pre><code>
import os

os.environ["AWS_ACCESS_KEY_ID"] = "YOUR_AWS_ACCESS_KEY_ID"
os.environ["AWS_SECRET_ACCESS_KEY"] = "YOUR_AWS_SECRET_ACCESS_KEY"
										</code></pre>
										Note that these are the same keys that we used before. (They are tied to our account, and are recognized across all AWS services.)
									</li>
									<li>
										Now, we can start attempting to communicate with SQS. These examples are pulled straight off of the <a href="https://boto3.readthedocs.io/en/latest/guide/sqs.html">Boto3 Documentation</a> - which is <i>really</i> good. Open up a python shell, and here is some code to start us off:
										<pre><code>
# Configuration
>>> import os
>>> os.environ["AWS_ACCESS_KEY_ID"] = "YOUR_AWS_ACCESS_KEY_ID"
>>> os.environ["AWS_SECRET_ACCESS_KEY"] = "YOUR_AWS_SECRET_ACCESS_KEY"								

# Get the service resource
>>> sqs = boto3.resource('sqs')

# Get the queue. This returns an <a href="https://boto3.readthedocs.io/en/latest/reference/services/sqs.html#queue">SQS.Queue</a> instance
>>> queue = sqs.get_queue_by_name(QueueName='test-queue1.fifo')

# You can now access identifiers and attributes
>>> print(queue.url)
>>> print(queue.attributes.get('DelaySeconds'))

# Create a new message
# FIFO queues require <a href="http://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/sqs-queue-message-identifiers.html">MessageGroupId</a>s
>>> queue.send_message(MessageBody='Hello, World! (0)', MessageGroupId='0')
>>> queue.send_message(MessageBody='Hello, World! (1)', MessageGroupId='0')
>>> queue.send_message(MessageBody='Hello, World! (2)', MessageGroupId='0')

# Receive the message from the queue
>>> message = queue.receive_messages(MaxNumberOfMessages=1)
>>> print(message.body)
Hello, World! (0)

# Delete the message from the queue
>>> message.delete()
										</code></pre>
										More information can be found <a href="https://boto3.readthedocs.io/en/latest/guide/sqs.html">here</a>.
									</li>
								</ol>

								<h3>Setting up an AWS Elastic Beanstalk Worker</h3>
								<p>This was probably the most confusing part of this whole ordeal (maybe because of the lack of documentation for some things on AWS, maybe because of my ignorance :P). What we're going to attempt to do here is set up an AWS Elastic Beanstalk Web Server Environment running Python (a separate environment from the one we set up in the second section). The goal will be to run a Python <a href="https://en.wikipedia.org/wiki/Daemon_(computing)">daemon</a> in the background using <a href="http://supervisord.org/">supervisord</a>. We won't go into actually making this daemon poll our SQS queue, but at the end, it should be pretty apparent how to make this work (see the boto3 setup and guide above).</p> 

								<p>If the end goal involves making the Environment dynamically change the number of EC2 instances running based on the size of the SQS queue, we can do that using AWS CloudWatch Alarms. Instructions can be found <a href="http://docs.aws.amazon.com/autoscaling/latest/userguide/as-using-sqs-queue.html">here</a>. </p>

								<p>Alright; let's get into setting up a simple worker</p>
								<ol>
									<li>
										Spin up a new EB environment. For now, we're going to make a single EC2 instance inside it (as opposed to an auto-scaling group). Make sure you select the right key pair so that we can <code>ssh</code> into it.
									</li>
									<li>
										Let's make the simple python process that we want to run forever. Here's mine: <br /> I called the file <code>sqsd_v2.py</code> and saved it in some directory in my local machine
										<pre><code>
import time # time is a built-in package

the_time = 0 
print("Starting sqsd_v2.py")
while(1):
	print("Time = " + str(the_time))
	time.sleep(5) # Sleep for 5 seconds
	the_time = the_time + 5
										</code></pre>
									</li>
									<li>
										AWS EB comes pre-installed with a program called <code><a href="http://supervisord.org/">supervisord</a></code>. What it lets us do here is make sure that our python script keeps running (i.e. restart it) even if something were to cause it to unexpectedly crash. This file needs a configuration file to run, so make a file called <code>supervisord.conf</code>. Put <a href="supervisord.conf" target="_blank">this</a> content into that file. This is the default file that is provided from the <a href="http://supervisord.org/configuration.html"><code>supervisord</code> website</a>. I modified a few lines under the <code>[program:sqsd_v2]</code> heading for our needs. Here are the highlights:
										<ul>
											<li>
												The name of the program that we are running is <code>sqsd_v2</code>. You can tell from the title of the heading.
											</li>
											<li>
												The actual command we are telling <code>supervisord</code> to execute is <code>python -u sqsd.py</code>. The <code>-u</code> flag is to provide unbuffered binary stdout and stderr output (i.e. it will force  stdin, and stdout to be totally unbuffered). This is necessary for us to view the <code>print()</code> outputs of our script.
											</li>
											<li>
												We have also specified log files: <code>stdout_logfile=~/logs/stdout_logs.log</code> and <code>stderr_logfile=~/logs/stderr_logs.log</code>. These are the files to which our program will output its <code>print()</code> statements. 
											</li>
										</ul>
									</li>
									<li>
										Remember the log files from the last step? We actually need to make them for supervisor to be able to use them. So, make two empty files called <code>stdout_logs.log</code> and <code>stderr_logs.log</code> on your machine. We will now push all of these files to the EB machine. 
									</li>
									<li>
										Let's first make the folder for the logs on the EB machine. SSH into it with <code>eb ssh</code> and once you're in, <code>mkdir logs</code>. <code>ls</code> to verify that it has been created and type in <code>exit</code> to exit out of the machine.
									</li>
									<li>
										Now, lets push our files up onto the machine. Run the following commands from where you have the 4 files we just made:
										<pre><code>scp -i path\to\your\keypair.pem sqsd_v2.py ec2-user@IP_ADDRESS:~/</code></pre>
										<pre><code>scp -i path\to\your\keypair.pem supervisord.conf ec2-user@IP_ADDRESS:~/</code></pre>
										<pre><code>scp -i path\to\your\keypair.pem stdout_logs.log ec2-user@IP_ADDRESS:~/logs/</code></pre>
										<pre><code>scp -i path\to\your\keypair.pem stderr_logs.log ec2-user@IP_ADDRESS:~/logs/</code></pre>
										Protip: You can copy/paste the key components of this command from the output of <code>eb ssh</code>:
										<div class="image main"><img src="images/ebssh.png"/></div>
										Try to <code>eb ssh</code> into the instance. If you <code>ls</code>, you should be able to find all of the files that we transferred.
									</li>
									<li>
										Now, let's try running the program. <code>eb ssh</code> into your instance. Type in the command to start <code>supervisord:</code>
										<pre><code>supervisord --configuration="supervisord.conf" --nodaemon</code></pre>
										You should see that the process <code>sqsd_v2</code> is starting. After like 10-15 seconds, Ctrl+c to stop supervisord and check the log file to make sure that we have some stuff in there from the program: <code>vim logs/stdout_logs.log</code>. You should see the <code>print()</code> output from the script. Some notes about what we did:
										<ul>
											<li>
												We ran <code>supervisord</code> with the <code>--nodaemon</code> flag. In production, you would run this without this flag (making the program run in the background) so that the program does not exit when you <code>eb ssh</code> out. You would use <code><a href="http://supervisord.org/introduction.html#supervisor-components">supervisorctl</a></code> to start, stop, and restart processes. More info and advanced usage can be found at the supervisor docs.
											</li>
											<li>
												When running without the <code>--nodaemon</code> option, we can set the log output for <code>supervisord</code> itself with the <code>--logfile=FILE</code> option. 
											</li>
											<li>
												<code>supervisord</code> is a complicated beast - docs are <a href="http://supervisord.org">here</a>.
											</li>
										</ul>
									</li>
								</ol>
								<p>
									Congrats! We've set up a lot of stuff:
									<ul>
										<li>Our dev environment</li>
										<li>A Django-powered AWS Elastic Beanstalk Web Server Environment</li>
										<li>An AWS SQS FIFO Queue</li>
										<li>Boto3 so that Python can communicate with SQS</li>
										<li>A very simple worker on an AWS Elastic Beanstalk Web Server Environment using Supervisor </li>
									</ul>
									Next steps:
									<ul>
										<li>Making the worker communicate with the SQS queue to process whatever tasks you may have on there</li>
										<li>Perhaps storing results in an <a href="https://aws.amazon.com/s3/">AWS S3</a> Bucket?</li>
									</ul>
								</p>
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