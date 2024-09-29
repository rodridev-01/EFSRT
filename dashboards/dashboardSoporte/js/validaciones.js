function soloNumeros(event) {
  var numeros = event.target;
  numeros.value = numeros.value.replace(/\D/g, "");
}

function soloLetras(event) {
  const input = event.target;
  input.value = input.value.replace(/[^a-zA-Z\s]/g, "");
}