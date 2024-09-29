document.addEventListener('DOMContentLoaded', function() {
  const departamentoSelect = document.getElementById('departamento');
  const provinciaSelect = document.getElementById('provincia');
  const distritoSelect = document.getElementById('distrito');

  fetch('php/cargar_departamentos.php')
    .then(response => response.text())
    .then(data => {
      const options = data.split(',').map(d => `<option value="${d}">${d}</option>`).join('');
      departamentoSelect.innerHTML += options;
    });

  departamentoSelect.addEventListener('change', function() {
    const departamento = this.value;
    fetch('php/cargar_provincias.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `departamento=${departamento}`
    })
    .then(response => response.text())
    .then(data => {
      const options = data.split(',').map(p => `<option value="${p}">${p}</option>`).join('');
      provinciaSelect.innerHTML = `<option value="">Seleccione una provincia</option>` + options;
      distritoSelect.innerHTML = `<option value="">Seleccione un distrito</option>`;
    });
  });

  provinciaSelect.addEventListener('change', function() {
    const provincia = this.value;
    fetch('php/cargar_distritos.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `provincia=${provincia}`
    })
    .then(response => response.text())
    .then(data => {
      const options = data.split(',').map(d => `<option value="${d}">${d}</option>`).join('');
      distritoSelect.innerHTML = `<option value="">Seleccione un distrito</option>` + options;
    });
  });

  distritoSelect.addEventListener('change', function() {
    // Habilitar el campo de especialidad
    document.getElementById('codigoEspecialidad').disabled = false;
});



});