<?php
$formMessage = '';
$formStatus = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = 'neelshah6892@gmail.com';
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $subject === '' || $message === '') {
        $formStatus = 'error';
        $formMessage = 'Please fill in all fields before submitting the form.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formStatus = 'error';
        $formMessage = 'Please enter a valid email address.';
    } else {
        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safeEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        $safeSubject = preg_replace('/[
]+/', ' ', $subject);

        $emailSubject = 'Website Contact: ' . $safeSubject;
        $emailBody = "Name: {$safeName}
" .
                     "Email: {$safeEmail}

" .
                     "Message:
{$message}
";

        $headers = [
            'From: no-reply@' . ($_SERVER['SERVER_NAME'] ?? 'localhost'),
            'Reply-To: ' . $safeEmail,
            'Content-Type: text/plain; charset=UTF-8',
        ];

        if (@mail($to, $emailSubject, $emailBody, implode("
", $headers))) {
            $formStatus = 'success';
            $formMessage = 'Thank you! Your message has been sent successfully.';
            $_POST = [];
        } else {
            $formStatus = 'error';
            $formMessage = 'Sorry, we could not send your message right now. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Responsive contact page matching the supplied coaching website design.">
  <title>Contact - Hi-Point Services (I) Pvt. Ltd.</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <header class="site-header">
    <div class="container nav-wrap">
      <a class="brand" href="index.html"><img src="img/logo.jpg"><img src="img/companyname.jpg"></a>
      <button class="nav-toggle" data-nav-toggle aria-expanded="false" aria-label="Open navigation">Menu</button>
      <nav>
        <ul class="nav-menu" data-nav-menu>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a class="active" href="contact.html">Contact</a></li>
          <li><a href="service-network.html">Network</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section class="section">
      <div class="container contact-grid">
        <div>
          <div class="hero-line">
            <h2 class="contact-title">Contact Us</h2>
          </div>
          <br>
          <h2>Head Office: </h2>
          <p class="intro-text" style="max-width:38rem; margin-top:2rem;">310, Gokul Arcade,
 	 	 	C.S.T No. 173- A,
 	 	 	Swami Nitynand Road,
 	 	 	Vile Parle (East)
 	 	 	Mumbai - 400 057. INDIA</p>
          <div class="contact-details" style="margin-top:2rem;">
            <p>Tel No.: (+91-22) 4002 2114 | Fax: (+91-22) 4964 9224</p>
            <p>Email: info@hipointservices.com</p>
          </div>
          <br>
          <h2>Sales Office: </h2>
          <p class="intro-text" style="max-width:38rem; margin-top:2rem;">Everest Grande,
 	 	 	B-308, Mahakali Caves Road,
 	 	 	Andheri East,
 	 	 	Mumbai - 400093.</p>
          <div class="contact-details" style="margin-top:2rem;">
            <p>Tel No.: (+91-22) 4002 4279 / 97 | Fax: (+91-22) 4976 5365</p>
            <p>Email: info@hipointservices.com | sales@hipointservies.com</p>
          </div>
          <div class="socials">
            <a class="social" href="#" aria-label="LinkedIn">in</a>
            <a class="social" href="#" aria-label="Twitter">t</a>
            <a class="social" href="#" aria-label="YouTube">▶</a>
          </div>
          <div style="margin-top:4rem; max-width:34rem;">
            <div class="quote-mark">“</div>
            <p>Working with Elise was a pleasure and we are very happy with the end result. We now have a foundation we can build upon.</p>
            <p><em>– Name @company</em></p>
          </div>
        </div>
        <div class="contact-card">
          <h2>Contact Form</h2>
          <form class="contact-form">
            <label>
              <span>Name</span>
              <input type="text" name="name" placeholder="Your name">
            </label>
            <label>
              <span>Email</span>
              <input type="email" name="email" placeholder="name@example.com">
            </label>
            <label>
              <span>Subject</span>
              <input type="text" name="subject" placeholder="How can I help?">
            </label>
            <label>
              <span>Message</span>
              <textarea name="message" placeholder="Tell me about your project"></textarea>
            </label>
            <button class="btn btn-primary" type="submit">Send Message</button>
          </form>
          <?php if ($messageStatus != ""): ?>
            <p><?php echo $messageStatus; ?></p>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="footer-inner">
      <div class="container">
        <div class="footer-columns">
          <div>
            <h2 class="footer-title">Interested in working together?</h2>
            <p class="muted-light">Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante eleifend lectus.</p>
            <a class="btn" href="contact.html">Contact Us</a>
          </div>
          <div>
            <!--<h3 class="footer-nav-title">Navigation</h3>-->
            <ul class="footer-nav muted-light">
              <li><a href="index.html">Home</a></li>
              <li><a href="about.html">About</a></li>
              <li><a href="services.html">Services</a></li>
              <li><a href="contact.html">Contact</a></li>
              <li><a href="service-network.html">Network</a></li>
            </ul>
          </div>
          <div>
            <h3 class="footer-nav-title">Connect</h3>
            <div class="socials footer-socials">
              <a class="social" href="#" aria-label="LinkedIn">in</a>
              <a class="social" href="#" aria-label="Twitter">t</a>
              <a class="social" href="#" aria-label="YouTube">▶</a>
            </div>
          </div>
        </div>
        <div class="footer-bottom muted-light">
          <p>© Your Copyright Message</p>
          <div class="footer-legal">
            <!--<a href="styles.html">Privacy Policy</a>
            <a href="styles.html">Terms of Service</a>-->
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="assets/main.js"></script>
</body>
</html>

