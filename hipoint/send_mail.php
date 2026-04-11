<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$messageStatus = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'neelshah6892@gmail.com'; // YOUR EMAIL
        $mail->Password = 'ksfccktjcyqswdzk';   // NOT your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email
        $mail->setFrom('yourgmail@gmail.com', 'Neel Website');
        $mail->addAddress('neelshah6892@gmail.com');

        $mail->Subject = "Mail From Website Form";
        $mail->Body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";

        $mail->send();
        $messageStatus = "✅ Email sent successfully!";
    } catch (Exception $e) {
        $messageStatus = "❌ Error: " . $mail->ErrorInfo;
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
          <form class="contact-form" method="POST">
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
          <p><?php echo $messageStatus; ?></p>
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