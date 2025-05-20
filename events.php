<?php $page_title = "Events - Peak Performance"; ?>
<?php include 'header.php'; ?>
<script src="calender.js"></script>


  <section class="hero-banner">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Upcoming Events</h1>
      <p>Stay motivated with these exciting fitness events!</p>
    </div>
  </section>

  <!-- Calendar Navigation -->
  <div class="calendar-wrapper">
    <div class="calendar-header">
      <button id="prevMonth">&laquo;</button>
      <h2 id="calendar-month">Month Year</h2>
      <button id="nextMonth">&raquo;</button>
    </div>

    <!-- Calendar Grid -->
    <div id="calendar" class="calendar"></div>

    <!-- Clicked Event Detail -->
    <div id="eventDetails" class="event-details"></div>
  </div>

  <!-- Pre-listed Event Cards -->
  <section class="calendar-grid">
    <div class="event-card">
      <h3>🏃‍♂️ 5K Club Run</h3>
      <p><strong>Date:</strong> April 20, 2025</p>
      <p>Join our monthly run and enjoy scenic routes.</p>
    </div>
    <div class="event-card">
      <h3>🧘 Yoga & Mindfulness</h3>
      <p><strong>Date:</strong> April 25, 2025</p>
      <p>Unwind with yoga and wellness sessions.</p>
    </div>
    <div class="event-card">
      <h3>🏋️ Strength Challenge</h3>
      <p><strong>Date:</strong> May 2, 2025</p>
      <p>Join our bench press and squats contest.</p>
    </div>
  </section>


<?php include 'footer.php'; ?>