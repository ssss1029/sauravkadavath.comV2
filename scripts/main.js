$(document).ready(function() {

	console.log(window.location.pathname)

	// Start a lil bit down if not the home page
	// Production
	if (window.location.pathname != '/index.php' && window.location.pathname != '/' && window.scrollY < 5) {
		window.scrollBy(0, 350)
	}

	// Development Fix
	if ((window.location.pathname == '/sokadv.comv2/' || window.location.pathname == '/sokadv.comv2/index.php') && window.scrollY < 400) {
		window.scrollBy(0, -350)
	}

	// Will be the form at the bottom, with the footer.
	$('form').submit(function(event) {
		event.preventDefault();
		console.log("Prevented form submission");

		// Begin checking
		var name = $("#name").val();
		var email = $("#email").val();
		var message = $("#message").val();

		if (name == "") {
			alert("Please enter your name");
			return;
		} else if (email == "") {
			alert("Please enter your e-mail address");
			return;
		} else if (message == "") {
			alert("Please enter a message");
			return;
		}

		if (validateEmail(email) == false) {
			alert("Please enter a valid email");
			return;
		}

		// Okay to send message
		var payload = {
			"name": name, 
			"time": new Date().getTime() / 1000,
			"email" : email,
			"message" : message
		}

		$.post( "processMessageSend.php", payload)
		  .done(function( data ) {
		  	if (JSON.parse(data).msg_status == "ok"){
		    	alert("Thanks for the message! I'll get back you as soon as I can.");
			}
		  })
		  .fail(function(err) {
		  	console.log(err);
		    alert( "There was an error. Please contact me at sauravkadavath@berkeley.edu with you message, and I'd love to get back to you!" );
  		  })
  		  .always(function() {
    		console.log( "finished" );
		  });
	});

	$('.sectionizer').each(function() {
		$(this).attr("display", "none");
	})

	// Make everything open in a new tab
	$('a').each(function() {
	//	$(this).attr("target", "_blank");
	})
});

// Creds to https://stackoverflow.com/questions/46155/how-to-validate-email-address-in-javascript
function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}
