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
    $name  = htmlspecialchars(trim($_POST['name']  ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']  ?? '')); // ← matches input name="phone"

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

            // Send FROM the SMTP account, TO the company inbox
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Career Page');
            $mail->addAddress('jobs@hipointservices.com', 'Hi-Point Services');
            $mail->addReplyTo($email, $name); // so you can reply directly to applicant

            // Handle file upload — name="resume" in the form below
            if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {

                $fileTmpPath = $_FILES['resume']['tmp_name'];
                $fileName    = $_FILES['resume']['name'];
                $fileSize    = $_FILES['resume']['size'];
                $fileType    = mime_content_type($fileTmpPath); // use server-side MIME, not client-supplied

                // Max size 5 MB
                if ($fileSize > 5 * 1024 * 1024) {
                    throw new Exception("File must be less than 5 MB.");
                }

                // Allowed MIME types
                $allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ];

                if (!in_array($fileType, $allowedTypes)) {
                    throw new Exception("Only PDF or Word (.doc/.docx) files are allowed.");
                }

                // Prefix with unique ID to avoid filename collisions / path-traversal
                $safeFileName = uniqid() . '-' . basename($fileName);
                $mail->addAttachment($fileTmpPath, $safeFileName);

            } else {
                throw new Exception("Resume upload failed or no file was selected.");
            }

            // Email content
            $mail->isHTML(true);
            $mail->Subject = "New Job Application from $name";
            $mail->Body    = "
                <table style='font-family:Arial,sans-serif; font-size:15px; color:#333; border-collapse:collapse;'>
                    <tr><td style='padding:6px 16px 6px 0; font-weight:bold; white-space:nowrap;'>Name</td>
                        <td style='padding:6px 0;'>$name</td></tr>
                    <tr><td style='padding:6px 16px 6px 0; font-weight:bold; white-space:nowrap;'>Email</td>
                        <td style='padding:6px 0;'><a href='mailto:$email'>$email</a></td></tr>
                    <tr><td style='padding:6px 16px 6px 0; font-weight:bold; white-space:nowrap;'>Phone</td>
                        <td style='padding:6px 0;'>$phone</td></tr>
                </table>
            ";
            $mail->AltBody = "Name:  $name\r\nEmail: $email\r\nPhone: $phone";

            $mail->send();
            $messageStatus = "✅ Application sent successfully! We will get back to you soon.";

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
  <meta name="description" content="Career page – Hi-Point Services (I) Pvt. Ltd.">
  <title>Career - Hi-Point Services (I) Pvt. Ltd.</title>
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
          <li><a class="active" href="career.php">Career</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section class="section">
      <div class="container">
        <div class="contact-card">
          <h2>Career Form</h2>

          <form class="contact-form" method="POST" enctype="multipart/form-data">
            <label>
              <span>Name <span aria-hidden="true">*</span></span>
              <input type="text" name="name" placeholder="Your full name" required
                     value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
            </label>
            <label>
              <span>Email <span aria-hidden="true">*</span></span>
              <input type="email" name="email" placeholder="name@example.com" required
                     value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </label>
            <label>
              <span>Contact Number <span aria-hidden="true">*</span></span>
              <!-- name="phone" — matches $_POST['phone'] in the PHP above -->
              <input type="tel" name="phone" placeholder="Your contact number" required
                     value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
            </label>
            <label>
              <span>Upload Resume (PDF / DOC / DOCX – max 5 MB) <span aria-hidden="true">*</span></span>
              <!-- name="resume" — matches $_FILES['resume'] in the PHP above -->
              <input type="file" name="resume" accept=".pdf,.doc,.docx" required>
            </label>
            <button class="btn btn-primary" type="submit">Submit Application</button>
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

  <script>
    // Client-side file size guard (backup to server-side check)
    document.querySelector('.contact-form').addEventListener('submit', function (e) {
      const file = document.querySelector('input[name="resume"]').files[0];
      if (file && file.size > 5 * 1024 * 1024) {
        alert('File size must be less than 5 MB.');
        e.preventDefault();
      }
    });
  </script>
  <script src="assets/main.js"></script>
</body>
</html>
