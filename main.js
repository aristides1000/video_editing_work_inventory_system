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
