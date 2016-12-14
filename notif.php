<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<script type="text/javascript">
  
  // request permission on page load
document.addEventListener('DOMContentLoaded', function () {
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.'); 
    return;
  }

  if (Notification.permission !== "granted")
    Notification.requestPermission();
});

function notifyMe() {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    var notification = new Notification('Notification title', {
      icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
      body: "Woyy!! Ada pemberitahuan Noh !!!",
    });

    notification.onclick = function () {
      window.open("http://biroglos.com/testing/index.php/home/index");      
    };

  }

}


</script>

<button onclick="notifyMe()">Notify me!</button>

</body>
</html>