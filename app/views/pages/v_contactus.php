<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>
<div class="contact-us-section">
    <div class="contact-container">
    <h1 class="contactus-title">CONTACT US</h1>
        <!-- Page Title -->
        <div class="contact-header">
            
            <p>We’d love to hear from you! Whether you have a question, feedback, or a partnership opportunity, feel free to get in touch.</p>
        </div>

        <!-- Contact Details -->
        <div class="contact-details">
            <div class="contact-info">
                <i class="fa fa-phone"></i>
                <h3>Phone</h3>
                <p>+94 71 958 9692</p>
            </div>
            <div class="contact-info">
                <i class="fa fa-envelope"></i>
                <h3>Email</h3>
                <p>info@musebookstore.com</p>
            </div>
            <div class="contact-info">
                <i class="fa fa-map-marker"></i>
                <h3>Address</h3>
                <p>38/3, Highlevel Road, Maharagama</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-container">
            <h2>Send Us a Message</h2>
            <form id="contactForm" action="#" method="POST" class="contact-form">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>

    </div>
</div>


<?php require APPROOT.'/views/inc/footer.php';?>

