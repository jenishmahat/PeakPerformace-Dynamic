<?php $page_title = "Contact Us - Peak Performance"; ?>
<?php include 'header.php'; ?>


  <section class="hero-banner">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Contact Us</h1>
      <p>We’d love to hear from you! Use the form below to send us a message.</p>
    </div>
  </section>

  <!-- Contact Section with two-column responsive layout -->
  <section class="contact-wrapper">
    <div class="contact-container">
      
      <!-- Contact Info -->
      <div class="contact-info">
        <h2>Get in Touch</h2>
        <p><strong>Email:</strong> <a href="mailto:info@peakperformance.com">info@peakperformance.com</a></p>
        <p><strong>Phone:</strong> +61 123 456 789</p>
        <p><strong>Address:</strong> 123 Fitness Blvd, Newcastle, NSW</p>
        <p><strong>Follow Us:</strong>
          <a href="https://facebook.com" target="_blank">Facebook</a> |
          <a href="https://instagram.com" target="_blank">Instagram</a> |
          <a href="https://twitter.com" target="_blank">Twitter</a>
       </p>
      </div>

      <!-- Contact Form -->
      <form class="contact-form" id="contactForm">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required minlength="3" placeholder="Enter your full name" />

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email" />

        <label for="message">Your Message:</label>
        <textarea id="message" name="message" rows="5" required placeholder="Write your message here..."></textarea>

        <button type="submit" class="btn">Send Message</button>
        <p id="form-message" class="form-feedback"></p>
      </form>

    </div>
  </section>

 

<?php include 'footer.php'; ?>