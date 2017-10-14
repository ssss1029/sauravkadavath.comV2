<?php 

/**
* The common footer for all the pages
*/

echo('					
    <footer id="footer">
        <section>
            <form method="post" action="none">
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" />
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" />
                </div>
                <div class="field">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" rows="3"></textarea>
                </div>
                <ul class="actions">
                    <li><input type="submit" id="footerSubmitButton" value="Send Message" /></li>
                </ul>
            </form>
        </section>
        <section class="split contact">
            <section class="alt">
                <h3>Resume</h3>
                <p><a href="SK_resume_v4.pdf" target="_blank">Download Here</a></p>
            </section>
            <section>
                <h3>Phone</h3>
                <p><a>(978) 337-3285</a></p>
            </section>
            <section>
                <h3>Email</h3>
                <p><a href="#">sauravkadavath@berkeley.edu</a></p>
            </section>
            <section>
                <h3>Social</h3>
                <ul class="icons alt">
                    <li><a href="https://github.com/ssss1029" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
                    <li><a href="https://www.linkedin.com/in/saurav-kadavath-808b07132/" class="icon alt fa-linkedin"><span class="label">LinkedIn</span></a></li>
                </ul>
            </section>
        </section>
    </footer>
')

?>