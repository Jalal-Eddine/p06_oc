const alertNotice = document.querySelector("#notice_alert");
console.log(alertNotice);
if (alertNotice) {
  setTimeout(() => alertNotice.remove(), 2000);
}
