<?php


require 'includes/db_connect.php';
 require 'phpmailer/mail.php';

  $email_error = "";
  $subject_error = "";
  $body_error = "";

  if(isset($_POST['send']))
  {
    $to = "oi474085@gmail.com";
    $email = mysqli_real_escape_string($connect,trim($_POST['email']));
    $subject = mysqli_real_escape_string($connect,trim(wordwrap($_POST['subject'], 70)));
    $body = mysqli_real_escape_string($connect,trim($_POST['body']));
    $errors = false;

    if(empty($email))
    {
      $email_error = "Email is Required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $email_error = "Invalid email format";
      $errors = true;
    }
   

    if(empty($subject))
    {
      $subject_error = "The Subject is Required"; 
      $errors = true;
    }

    if(empty($body))
    {
      $body_error = "The Message Field Could not Be Empty";
      $errors = true;
    }

  if (!$errors) {
    try {
        // Use the mail object from mail.php
        $mail->setFrom('oa8019724@gmail.com', 'Contact Form User');
        $mail->addReplyTo($email, 'Contact Form User'); // User's email as the reply-to address
        $mail->addAddress('oa8019724@gmail.com'); // Replace with your recipient email
        $mail->Subject = $subject;
        $mail->Body    = nl2br(htmlspecialchars($body)); // Convert newlines to <br>
        $mail->AltBody = strip_tags($body); // Plain text version

        if ($mail->send()) {
            $success_message = "Your email has been sent successfully!";
        } else {
            $success_message = "Failed to send the email. Please try again.";
        }
      
  } // try 
  catch (Exception $e) {
    $success_message = "Mailer Error: {$mail->ErrorInfo}";
}
  } // not error
} // post method
?>

    <div class="contact-form" id="contact">
      <h2>Contact Us</h2>
       <!-- Display success message -->
       <?php if(!empty($success_message)):?>
                <p><?php echo $success_message;?></p>
                <?php endif;?>


<form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Your Email" autocomplete="off" required>
        <span class="error"><?php echo htmlspecialchars($email_error); ?></span>

        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" autocomplete="off" placeholder="Subject" required>
        <span class="error"><?php echo htmlspecialchars($subject_error); ?></span>

        <label for="message">Message:</label>
        <textarea id="message" name="body" rows="5" autocomplete="off" placeholder="Your Message" required></textarea>
        <span class="error"><?php echo htmlspecialchars($body_error); ?></span>

        <button type="submit" name="send">Submit</button>
</form>

<?php if (!empty($success_message)): ?>
    <p><?php echo htmlspecialchars($success_message); ?></p>
<?php endif; ?>

    </div>
  </div>
