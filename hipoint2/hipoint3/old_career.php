<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer (PHPMailer + dotenv)
require __DIR__ . '/vendor/autoload.php';

// Load .env from outside www (WAMP path)
//$dotenv = Dotenv\Dotenv::createImmutable('C:/wamp64/config');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();

$messageStatus = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize inputs
    $name  = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);

    if (!$email) {
        $messageStatus = "❌ Invalid email format.";
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

            // Email setup
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Career Page');
            $mail->addAddress($_ENV['SMTP_USERNAME']);

            // Handle file upload
            if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {

                $fileTmpPath = $_FILES['resume']['tmp_name'];
                $fileName = $_FILES['resume']['name'];
                $fileSize = $_FILES['resume']['size'];
                $fileType = $_FILES['resume']['type'];

                // Max size 5MB
                if ($fileSize > 5 * 1024 * 1024) {
                    throw new Exception("File must be less than 5MB.");
                }

                // Allowed MIME types
                $allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ];

                if (!in_array($fileType, $allowedTypes)) {
                    throw new Exception("Only PDF or Word files allowed.");
                }

                // Rename file (security)
                $newFileName = uniqid() . '-' . basename($fileName);

                $mail->addAttachment($fileTmpPath, $newFileName);

            } else {
                throw new Exception("Resume upload failed.");
            }

            // Email content
            $mail->Subject = "New Job Application";
            $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone";

            $mail->send();
            $messageStatus = "✅ Application sent successfully!";

        } catch (Exception $e) {
            $messageStatus = "❌ Error: " . $e->getMessage();
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
  <title>Career - Hi-Point Services (I) Pvt. Ltd.</title>
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
          <li class="has-submenu">
            <a href="#">About Us</a>
            <ul class="submenu">
              <li><a href="our-history.html">Our History</a></li>
            </ul>
          </li>
          <li><a href="products.html">Products</a></li>
          <li><a href="network.html">Network</a></li>
          <li><a class="active" href="career.php">Career</a></li>
          <li><a href="contact.html">Contact Us</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section class="section">
      <div class="container">
        <div class="contact-card">
          <h2>Career Form</h2>
          <form class="contact-form" action="career.php" method="POST" enctype="multipart/form-data">
            <label>
              <span>Name</span>
              <input type="text" name="name" placeholder="Your name">
            </label>
            <label>
              <span>Email</span>
              <input type="email" name="email" placeholder="name@example.com">
            </label>
            <label>
              <span>Contact Number</span>
              <input type="text" name="subject" placeholder="Your Contact Number">
            </label>
            <label>
              <span>Upload Resume (Max 5MB)</span>
              <input type="file" name="attachment" accept=".pdf,.doc,.docx" required>
            </label>
            <button class="btn btn-primary" type="submit">Send Message</button>
          </form>
          <!-- MESSAGE HERE -->
            <?php if (!empty($messageStatus)): ?>
              <p class="form-message">
            <?php echo $messageStatus; ?>
              </p>
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
            <!--<h3 class="footer-nav-title">Navigation</h3>-->
            <ul class="footer-nav muted-light">
              <li><a href="index.html">Home</a></li>
              <li><a href="our-history.html">Our History</a></li>
              <li><a href="system-integrators.html">System Integrators</a></li>
              <li><a href="manufacturers.html">Manufacturers</a></li>
              <li><a href="network.html">Network</a></li>
              <li><a href="career.php">Career</a></li>
              <li><a href="contact.html">Contact Us</a></li>
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
            <!--<h2 class="footer-title">Interested in working together?</h2>
            <p class="muted-light">Vivamus integer non suscipit taciti mus etiam at primis tempor sagittis euismod libero facilisi aptent elementum felis blandit cursus gravida sociis erat ante eleifend lectus.</p>-->
            <img class="mii" src="img/make-in-india.png" alt="Make in India Logo" style="width: 50%; height: auto;">
            <br>
            <img class="mii" src="img/LRQA_UKAS.jpg" alt="LRQA Logo" style="width: 50%; height: auto;">
            <br>
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
  <script>
    document.querySelector('.contact-form').addEventListener('submit', function(e) {
  const file = document.querySelector('input[name="attachment"]').files[0];

  if (file && file.size > 5 * 1024 * 1024) {
    alert("File size must be less than 5MB");
    e.preventDefault();
  }
});
  </script>
  <script src="assets/main.js"></script>
</body>
</html>
