<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us</title>
    <link rel="stylesheet" href="./CSS/style.css" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
  </head>
  <body
    style="
      background-image: url(./Resource/Images/logIn.png);
      background-repeat: no-repeat;
      height: 600px;
      background-position: center;
      background-size: cover;
    "
  >
    <!-- start include the header.php -->
    <?php  include('header.php') ?>
    <!-- end include the header.php -->
    <header class="other-page-header page-header">
      <h1>Contact Us</h1>
    </header>
    <main>

      <p>Fill out the form to reach us.</p>
      <section class="contact-wrapper">
        <div class="discuss">
          <h2>let's discuss on something cool together</h2>

          <a href="#"
            ><i class="fa fa-envelope" aria-hidden="true"></i
            >Example@email.com </a
          ><br />
          <button>
            <i class="fa fa-phone" aria-hidden="true"></i> +2519 235689875
          </button>
          <br />
          <a href="#"
            ><i class="fa-solid fa-location-dot location-icon"></i> addis Ababa </a
          ><br />
          <div class="social-media">
            <a href="#"
              ><i class="fa-brands fa-instagram social-icon instagram-icon"></i
            ></a>
            <a href="#"
              ><i class="fa-brands fa-facebook social-icon facebook"></i
            ></a>
            <a href="#" target="_blank">
              <i class="fa-brands fa-twitter social-icon x"></i
            ></a>
            <a href="#" target="_blank">
              <i class="fa-brands fa-linkedin social-icon x"></i
            ></a>
          </div>
        </div>
        <form action="#">
          <fieldset>
            <button class="contact-button" type="button" onclick="selectOption(this)">service</button>
            <button class="contact-button" type="button" onclick="selectOption(this)">Model</button>
            <button class="contact-button" type="button" onclick="selectOption(this)">complains</button>
            <button class="contact-button" type="button" onclick="selectOption(this)">Equiry</button>
            <button class="contact-button" type="button" onclick="selectOption(this)">other</button>
            
            <br />
            <input
              class="contact-input"
              type="text"
              name="name"
              placeholder="your name" required
            /><br />
            <input
              class="contact-input"
              type="email"
              name="email"
              placeholder="your email" required
            /><br />
            <input
              class="contact-input"
              type="message"
              name="message"
              placeholder="your message" required
            /><br />
            <input class="contact-button" type="submit" value="Send message" />
          </fieldset>
        </form>
      </section>
    
    </main>
    <!-- start include the footer.php -->
    <?php include('footer.php')  ?>
    <!-- end include the footer.php -->
    <script src="./JS/script.js">    </script>
  </body>
</html>
