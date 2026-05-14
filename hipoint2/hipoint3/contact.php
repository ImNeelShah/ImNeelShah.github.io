<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer (PHPMailer + dotenv)
require __DIR__ . '/vendor/autoload.php';

// Load .env from outside www
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();

$messageStatus = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize inputs
    $name    = htmlspecialchars(trim($_POST['name']    ?? ''));
    $email   = filter_var(trim($_POST['email']  ?? ''), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']  ?? ''));
    $message = htmlspecialchars(trim($_POST['message']  ?? ''));

    if (!$email) {
        $messageStatus = "❌ Invalid email format.";
    } elseif (empty($name) || empty($subject) || empty($message)) {
        $messageStatus = "❌ Please fill in all required fields.";
    } else {

        $mail = new PHPMailer(true);

        try {
            // SMTP using .env
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USERNAME'];
            $mail->Password   = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
            $mail->Port       = $_ENV['SMTP_PORT'];

            // Send FROM the SMTP account, TO the company inbox
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Contact Page');
            $mail->addAddress('info@hipointservices.com', 'Hi-Point Services');
            $mail->addReplyTo($email, $name); // lets staff reply directly to the enquirer

            // Email content
            $mail->isHTML(true);
            $mail->Subject = "Website Contact Form Enquiry: $subject";
            $mail->Body    = "
                <table style='font-family:Arial,sans-serif; font-size:15px; color:#333; border-collapse:collapse;'>
                    <tr><td style='padding:6px 16px 6px 0; font-weight:bold; white-space:nowrap;'>Name</td>
                        <td style='padding:6px 0;'>$name</td></tr>
                    <tr><td style='padding:6px 16px 6px 0; font-weight:bold; white-space:nowrap;'>Email</td>
                        <td style='padding:6px 0;'><a href='mailto:$email'>$email</a></td></tr>
                    <tr><td style='padding:6px 16px 6px 0; font-weight:bold; white-space:nowrap;'>Subject</td>
                        <td style='padding:6px 0;'>$subject</td></tr>
                    <tr><td style='padding:6px 16px 6px 0; font-weight:bold; white-space:nowrap; vertical-align:top;'>Message</td>
                        <td style='padding:6px 0;'>" . nl2br($message) . "</td></tr>
                </table>
            ";
            $mail->AltBody = "Name:    $name\r\nEmail:   $email\r\nSubject: $subject\r\n\r\nMessage:\r\n$message";

            $mail->send();
            $messageStatus = "✅ Message sent successfully! We will get back to you soon.";

        } catch (Exception $e) {
            $messageStatus = "❌ Error: " . $mail->ErrorInfo ?: $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Contact page – Hi-Point Services (I) Pvt. Ltd.">
  <title>Contact - Hi-Point Services (I) Pvt. Ltd.</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <header class="site-header">
    <div class="container nav-wrap">
      <a class="brand" href="index.html"><img src="img/Hipoint_Logo.png"></a>
      <button class="nav-toggle" data-nav-toggle aria-expanded="false" aria-label="Open navigation">Menu</button>
      <nav>
        <ul class="nav-menu" data-nav-menu>
          <li><a href="index.html">Home</a></li>
          <li class="has-submenu">
            <a href="#">About Us</a>
            <ul class="submenu">
              <li><a href="our-history.html">Our History</a></li>
            </ul>
          </li>
          <li class="has-submenu">
            <a href="#">Products</a>
            <ul class="submenu">
              <li><a href="system-integrators.html">System Integrators</a></li>
              <li><a href="manufacturers.html">Manufacturers</a></li>
            </ul>
          </li>
          <li><a href="network.html">Network</a></li>
          <li><a href="career.php">Career</a></li>
          <li><a class="active" href="contact.php">Contact Us</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section class="section">
      <div class="container contact-grid">

        <!-- Left: address & info -->
        <div>
          <div class="hero-line">
            <h2 class="contact-title">Contact Us</h2>
          </div>
          <br>
          <h2>Head Office:</h2>
          <p class="intro-text" style="max-width:38rem; margin-top:2rem;">
            310, Gokul Arcade,<br>
            C.S.T No. 173-A,<br>
            Swami Nityanand Road,<br>
            Vile Parle (East),<br>
            Mumbai – 400 057. INDIA
          </p>
          <div class="contact-details" style="margin-top:2rem;">
            <p>Tel No.: <a href="tel:+912240022114">(+91-22) 4002 2114</a> | Fax: (+91-22) 4964 9224</p>
            <p>Email: <a href="mailto:info@hipointservices.com">info@hipointservices.com</a></p>
          </div>
          <br>
          <h2>Sales Office:</h2>
          <p class="intro-text" style="max-width:38rem; margin-top:2rem;">
            Everest Grande,<br>
            B-308, Mahakali Caves Road,<br>
            Andheri East,<br>
            Mumbai – 400 093.
          </p>
          <div class="contact-details" style="margin-top:2rem;">
            <p>Tel No.: <a href="tel:+912240024279">(+91-22) 4002 4279 / 97</a> | Fax: (+91-22) 4976 5365</p>
            <p>
              Email: <a href="mailto:info@hipointservices.com">info@hipointservices.com</a>
              | <a href="mailto:sales@hipointservices.com">sales@hipointservices.com</a>
            </p>
          </div>
          <div class="socials">
            <a class="social" href="#" aria-label="LinkedIn">in</a>
            <a class="social" href="#" aria-label="Twitter">t</a>
            <a class="social" href="#" aria-label="YouTube">▶</a>
          </div>
        </div>

        <!-- Right: contact form -->
        <div class="contact-card">
          <h2>Contact Form</h2>

          <form class="contact-form" method="POST">
            <label>
              <span>Name <span aria-hidden="true">*</span></span>
              <input type="text" name="name" placeholder="Your name" required
                     value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
            </label>
            <label>
              <span>Email <span aria-hidden="true">*</span></span>
              <input type="email" name="email" placeholder="name@example.com" required
                     value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </label>
            <label>
              <span>Subject <span aria-hidden="true">*</span></span>
              <input type="text" name="subject" placeholder="How can we help?" required
                     value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
            </label>
            <label>
              <span>Message <span aria-hidden="true">*</span></span>
              <textarea name="message" placeholder="Tell us about your enquiry" required><?php
                echo htmlspecialchars($_POST['message'] ?? '');
              ?></textarea>
            </label>
            <button class="btn btn-primary" type="submit">Send Message</button>
            <?php if (!empty($messageStatus)): ?>
              <p class="form-message" style="margin-top:1rem;"><?php echo $messageStatus; ?></p>
            <?php endif; ?>
          </form>
        </div>

      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="footer-inner">
      <div class="container">
        <div class="footer-columns">
          <div>
            <ul class="footer-nav muted-light">
              <li><a href="index.html">Home</a></li>
              <li><a href="our-history.html">Our History</a></li>
              <li><a href="system-integrators.html">System Integrators</a></li>
              <li><a href="manufacturers.html">Manufacturers</a></li>
              <li><a href="network.html">Network</a></li>
              <li><a href="career.php">Career</a></li>
              <li><a href="contact.php">Contact Us</a></li>
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
          <div>
            <img class="mii" src="img/make-in-india.png" alt="Make in India Logo" style="width:50%;height:auto;">
            <br>
            <img class="mii" src="img/LRQA_UKAS.jpg" alt="LRQA Logo" style="width:50%;height:auto;">
          </div>
        </div>
        <div class="footer-bottom muted-light">
          <p>© Your Copyright Message</p>
          <div class="footer-legal"></div>
        </div>
      </div>
    </div>
  </footer>

  <script src="assets/main.js"></script>
</body>
</html>
