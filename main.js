/* Styles dark mode */

$('.tdnn').click(function () {
  $(".moon").toggleClass('sun');
  $(".tdnn").toggleClass('day');
  let $htmlTag = $('html');
  if ($htmlTag.attr('data-bs-theme') === 'dark') {
    $htmlTag.attr('data-bs-theme', 'light');
  } else {
    $htmlTag.attr('data-bs-theme', 'dark');
  }
});

/* End Styles dark mode */

/* countdown 5 seconds */

let count = 5;
const counter = document.getElementById('counter');
if (counter) {
  counter.textContent = count;

  const interval = setInterval(function() {
    count--;
    counter.textContent = count;

    if (count <= 0) {
      clearInterval(interval);
    }
  }, 1000);
}

/* End countdown 5 seconds */
