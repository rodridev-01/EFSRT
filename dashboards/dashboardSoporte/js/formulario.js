document.addEventListener("DOMContentLoaded", function () {
  const tipoPersonal = document.getElementById('tipoPersonal');
  const personalForm = document.getElementById('personalForm');
  
  const camposHabilitados = [
    'apellidoPaterno', 'apellidoMaterno', 'nombresPersonal',
    'tipoDocumento', 'nroDocumento', 'telefono',
    'celular', 'correoJosePardo', 'correoPersonal',
    'departamento', 'provincia', 'distrito', 'direccion',
    'codigoPlaza', 'estadoPersonal'
  ];

  const camposDocenteCoordinador = [
    'codigoEspecialidad', 'estable'
  ];

  const camposNombrado = [
    'anioNombramiento', 'anioCese'
  ];

  const camposContratado = [
    'anioContrato', 'inicioContrato', 'finContrato'
  ];

  function habilitarCampos() {
    camposHabilitados.forEach(campo => {
      const campoElem = document.getElementById(campo);
      campoElem.disabled = true;
      campoElem.required = false;
    });

    camposDocenteCoordinador.forEach(campo => {
      const campoElem = document.getElementById(campo);
      campoElem.disabled = true;
      campoElem.required = false;
    });

    camposNombrado.forEach(campo => {
      const campoElem = document.getElementById(campo);
      campoElem.disabled = true;
      campoElem.required = false;
    });

    camposContratado.forEach(campo => {
      const campoElem = document.getElementById(campo);
      campoElem.disabled = true;
      campoElem.required = false;
    });

    if (tipoPersonal.value) {
      camposHabilitados.forEach(campo => {
        const campoElem = document.getElementById(campo);
        campoElem.disabled = false;
        campoElem.required = true;
      });

      if (tipoPersonal.value === "DOCENTE" || tipoPersonal.value === "COORDINADOR") {
        camposDocenteCoordinador.forEach(campo => {
          const campoElem = document.getElementById(campo);
          campoElem.disabled = false;
          campoElem.required = true;
        });
      }
    }
  }

  function habilitarCamposEspecificos() {
    if (document.getElementById('estable').value === "S") {
      camposNombrado.forEach(campo => {
        const campoElem = document.getElementById(campo);
        campoElem.disabled = false;
        campoElem.required = true;
      });
      camposContratado.forEach(campo => {
        const campoElem = document.getElementById(campo);
        campoElem.disabled = true;
        campoElem.required = false;
      });
    } else if (document.getElementById('estable').value === "N") {
      camposContratado.forEach(campo => {
        const campoElem = document.getElementById(campo);
        campoElem.disabled = false;
        campoElem.required = true;
      });
      camposNombrado.forEach(campo => {
        const campoElem = document.getElementById(campo);
        campoElem.disabled = true;
        campoElem.required = false;
      });
    } else {
      camposNombrado.forEach(campo => {
        const campoElem = document.getElementById(campo);
        campoElem.disabled = true;
        campoElem.required = false;
      });
      camposContratado.forEach(campo => {
        const campoElem = document.getElementById(campo);
        campoElem.disabled = true;
        campoElem.required = false;
      });
    }
  }

  function validarFormulario(event) {
    for (const campo of camposHabilitados) {
      const campoElem = document.getElementById(campo);
      if (!campoElem.disabled && !campoElem.value) {
        event.preventDefault();
        alert(`Por favor, complete el campo: ${campoElem.previousElementSibling.innerText}`);
        return;
      }
    }
  }

  tipoPersonal.addEventListener('change', habilitarCampos);
  document.getElementById('estable').addEventListener('change', habilitarCamposEspecificos);
  personalForm.addEventListener('submit', validarFormulario);
});

// Añadiendo validaciones
function soloNumeros(event) {
  var numeros = event.target;
  numeros.value = numeros.value.replace(/\D/g, "");
}

function soloLetras(event) {
  const input = event.target;
  input.value = input.value.replace(/[^a-zA-Z\s]/g, "");
}