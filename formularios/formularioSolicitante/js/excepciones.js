//Limita lentras y num, segun el tipo letrao num, maximo de caracteres.
function excepDatos(event, tipo, maxLength) {
    var input = event.target;
    var keyCode = event.keyCode || event.which;
    var keyValue = String.fromCharCode(keyCode);
    var regex;

    if (tipo === 'letras') {
        regex = /^[a-zA-Z\s]+$/;//letras y spaces
    } else if (tipo === 'numeros') {
        regex = /^[0-9]+$/;//numeros noma
    }

    // Permitir teclas de control como "backspace", "delete", "flechas"
    if (keyCode === 8 || keyCode === 46 || keyCode === 37 || keyCode === 39) {
        return true;
    }

    //maximo de caracteres
    if (input.value.length >= maxLength) {
        event.preventDefault(); //detiene el ingreso de caracteres
        return false;
    }

    if (!regex.test(keyValue)) {
        event.preventDefault();
        return false;
    }
}

//limita caracteres, para correos, y domicilio, codigo modular
function maxDigitos(event, maxLength) {
    var input = event.target;

    // Permitir teclas de control como "backspace", "delete", "flechas"
    var keyCode = event.keyCode || event.which;
    if (keyCode === 8 || keyCode === 46 || keyCode === 37 || keyCode === 39) {
        return true;
    }

    if (input.value.length >= maxLength) {
        event.preventDefault();
        return false;
    }
}