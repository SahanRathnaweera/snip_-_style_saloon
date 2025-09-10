document.getElementById("bookingForm").addEventListener("submit", function(e){
  e.preventDefault();
  var valid = true;
  document.querySelectorAll(".error-message").forEach(function(el){ el.innerText = ""; });
  var fullname = document.getElementById("fullname").value.trim();
  var phone = document.getElementById("phone").value.trim();
  var email = document.getElementById("email").value.trim();
  var service = document.getElementById("service").value;
  var date = document.getElementById("date").value;
  var time = document.getElementById("time").value;
  var feedback = document.getElementById("feedback").value.trim();
  var namePattern = /^[A-Za-z\s]+$/;
  if (fullname.length < 5 || !namePattern.test(fullname)) {
    document.getElementById("fullnameError").innerText = "Enter a valid full name";
    valid = false;
  }
  if (!/^[0-9]{10}$/.test(phone)) {
    document.getElementById("phoneError").innerText = "Phone must be 10 digits";
    valid = false;
  }
  if (!/^[^ ]+@[^ ]+\.[a-z]{2,}$/.test(email)) {
    document.getElementById("emailError").innerText = "Enter a valid email";
    valid = false;
  }
  if (service === "") {
    document.getElementById("serviceError").innerText = "Select a service";
    valid = false;
  }
  if (!date) {
    document.getElementById("dateError").innerText = "Select date";
    valid = false;
  } else {
    var today = new Date(); today.setHours(0,0,0,0);
    var sel = new Date(date);
    if (sel < today) {
      document.getElementById("dateError").innerText = "Date must be today or later";
      valid = false;
    }
  }
  if (!time) {
    document.getElementById("timeError").innerText = "Select time";
    valid = false;
  }
  if (feedback.length < 5) {
    document.getElementById("feedbackError").innerText = "Feedback at least 5 chars";
    valid = false;
  }
  if (valid) {
    this.submit();
  }
});