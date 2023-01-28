const alertNotice = document.querySelector("#notice_alert");
console.log(alertNotice);
if (alertNotice) {
  setTimeout(() => alertNotice.remove(), 2000);
}
console.log("good morning");
// ===== Scroll to Top ====
$(window).scroll(function () {
  if ($(this).scrollTop() >= 50) {
    // If page is scrolled more than 50px
    $("#return-to-top").fadeIn(200); // Fade in the arrow
  } else {
    $("#return-to-top").fadeOut(200); // Else fade out the arrow
  }
});
$("#return-to-top").click(function () {
  // When arrow is clicked
  $("body,html").animate(
    {
      scrollTop: 0, // Scroll to top of body
    },
    500
  );
});
// ===== Toggle Medias ====
function toggleMedias() {
  var x = document.getElementById("medias");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
