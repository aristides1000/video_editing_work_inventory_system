/* Cuenta atras 5 segundos */

let cuenta = 5;
const contador = document.getElementById('contador');
contador.textContent = cuenta;

const intervalo = setInterval(function() {
  cuenta--;
  contador.textContent = cuenta;

  if (cuenta <= 0) {
    clearInterval(intervalo);
  }
}, 1000);

/* Fin cuenta atras 5 segundos */
