<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
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
      background-color: #f9f9f9;
    "
  >
    <!-- start include the header.php -->
    <?php  include('header.php') ?>
    <!-- end include the header.php -->

    <header class="other-page-header about-page-header">
      <h1>About Us</h1>
    </header>
    <main>
      <section>
        <article>
          <div class="about-page-container">
            <div class="about-page-intro">
              <h1>Welcome to Our Dealership</h1>
              <p>
                Your trusted partner in finding the perfect car. We bring
                quality, trust, and reliability to your car buying experience.
              </p>
            </div>

            <div class="about-page-values">
              <div class="about-page-value">
                <h3>Quality</h3>
                <p>
                  We ensure that every car we sell meets the highest quality
                  standards.
                </p>
              </div>
              <div class="about-page-value">
                <h3>Integrity</h3>
                <p>
                  We are committed to transparency and honesty in all our
                  dealings.
                </p>
              </div>
              <div class="about-page-value">
                <h3>Customer Satisfaction</h3>
                <p>Your satisfaction is our top priority.</p>
              </div>
            </div>

            <h2>Who We Are</h2>
            <p>
              We are a dedicated team of car enthusiasts bringing you the best
              car deals and services.
            </p>
            <h2>Our Mission</h2>
            <p>
              To connect buyers and sellers with exceptional service and trust
              in the automotive industry.
            </p>
            <h2>Our Vision</h2>
            <p>
              To be the leading car dealership platform in the region, offering
              a seamless buying and selling experience.
            </p>
          </div>
        </article>
      </section>
    </main>
    <!-- start include the footer.php -->
    <?php include('footer.php')  ?>
    <!-- end include the footer.php -->
  </body>
</html>
