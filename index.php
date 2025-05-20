<?php $page_title = "Home - Peak Performance"; ?>
<?php include 'header.php'; ?>

<section class="hero-banner">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Elevate Your Game</h1>
      <p>Join Peak Performance Sports Club — where fitness meets community and champions are built.</p> <br>
      <a href="login.php" class="btn">Join Now</a>
      <br>
      <p class="para-dec">     Our mission is to inspire healthy living through expert guidance, community driven workouts, and stateof the art equipment. Whether you're a beginner or a seasoned athlete, we provide the support you need to achieve your personal fitness goals.
      </p>
    </div>
  </section>
  

  <section class="features">
    <div class="feature-box" onclick="toggleDetail(this)">
      <img src="images/gym.jpg" alt="Gym Area">
      <h3>Modern Facilities</h3>
      <p>State-of-the-art equipment to support all levels of training.</p>
      <div class="detail-text hidden">
        <p>Our gym features free weights, strength machines, treadmills, and cardio zones with 24/7 access. Everything is maintained daily for a clean, safe experience.</p>
      </div>
    </div>
  
    <div class="feature-box" onclick="toggleDetail(this)">
      <img src="images/trainer.jpg" alt="Trainers">
      <h3>Expert Trainers</h3>
      <p>Certified professionals helping you achieve your fitness goals.</p>
      <div class="detail-text hidden">
        <p>Our personal trainers are nationally certified and create personalized workout plans to suit every fitness level — from beginner to pro.</p>
      </div>
    </div>
  
    <div class="feature-box" onclick="toggleDetail(this)">
      <img src="images/groupworkout.jpg" alt="Group Workout">
      <h3>Community Events</h3>
      <p>Regular events and challenges to stay motivated together.</p>
      <div class="detail-text hidden">
        <p>Join fitness bootcamps, monthly challenges, yoga weekends, and club runs to build community and boost consistency through fun group activities.</p>
      </div>
    </div>
  </section>

 
<?php include 'footer.php'; ?>