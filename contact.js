<script>
  document.getElementById("contact-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var message = document.getElementById("message").value;

    // Create a data object to send via email
    var data = {
      name: name,
      email: email,
      message: message
    };

    // Send the data via email using a service like EmailJS
    Email.send({
      SecureToken: "PfBhUcoZ3KQITcFFn",
      To: "mayvanassa@gmail.com",
      From: "sender@example.com",
      Subject: "New Contact Form Submission",
      Body: JSON.stringify(data)
    }).then(function(response) {
      if (response === "OK") {
        // Success message or redirect to a thank you page
        alert("Thank you! Your message has been sent.");
        // window.location.href = "thankyou.html";
      } else {
        // Error message
        alert("Oops! Something went wrong. Please try again later.");
      }
    });
  });
</script>
