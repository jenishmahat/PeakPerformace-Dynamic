<?php $page_title = "Activities - Peak Performance"; ?>
<?php include 'header.php'; ?>

  <section class="hero-banner">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Our Activities</h1>
      <p>Explore a variety of programs to stay active, energized, and connected.</p>
    </div>
  </section>
  
  

  <section class="activities-list">
    <div class="activity-card" onclick="toggleDetail(this)">
      <img src="images/yoga.jpg" alt="Yoga Class">
      <h3>Yoga & Meditation</h3>
      <p>Improve flexibility, posture, and peace of mind through guided sessions.</p>
      <div class="detail-text hidden">
        <p>Our yoga programs include Vinyasa, Hatha, and Restorative Yoga styles, led by certified instructors. You'll develop greater mobility, reduce stress, and improve breathing through meditation and breathwork. Perfect for all ages and fitness levels, with classes held in a peaceful studio atmosphere.</p>
      </div>
    </div>
  
    <div class="activity-card" onclick="toggleDetail(this)">
      <img src="images/cardio.jpg" alt="Cardio Workout">
      <h3>Cardio Training</h3>
      <p>Elevate your heart health and energy with high-intensity workouts.</p>
      <div class="detail-text hidden">
        <p>Choose from treadmill intervals, spin cycling, rowing, and HIIT sessions that push your endurance while burning fat. Our cardio zone features top-tier equipment and energizing group classes to keep motivation high. Trainers are available to tailor your workouts to match your fitness goals.</p>
      </div>
    </div>
  
    <div class="activity-card" onclick="toggleDetail(this)">
      <img src="images/weight.jpg" alt="Weight Training">
      <h3>Weight Training</h3>
      <p>Develop strength, tone your body, and improve functional fitness.</p>
      <div class="detail-text hidden">
        <p>Our weight training area includes free weights, squat racks, cable systems, and benches. You'll receive guidance on proper form, personalized routines, and progressive overload strategies to build muscle safely and efficiently. From beginners to powerlifters, everyone is welcome to lift with confidence.</p>
      </div>
    </div>
  
    <div class="activity-card" onclick="toggleDetail(this)">
      <img src="images/zumba.jpg" alt="Zumba Class">
      <h3>Zumba & Dance</h3>
      <p>Burn calories and boost your mood with upbeat dance classes.</p>
      <div class="detail-text hidden">
        <p>Dance your way to fitness with Zumba, hip hop cardio, and Latin-inspired group sessions. These classes combine fun choreography, energizing music, and full-body cardio movement — no dance experience required! It's an exciting way to stay fit and connect with others in a high-vibe environment.</p>
      </div>
    </div>
  </section>
  


<?php include 'footer.php'; ?>