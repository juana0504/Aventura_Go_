
let currentStep = 1;

function changeStep(direction) {
    const newStep = currentStep + direction;
    
    if (newStep < 1 || newStep > 4) return;
    
    // Ocultar paso actual
    document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.remove('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
    
    // Marcar como completado
    if (direction === 1) {
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('completed');
    }
    
    // Mostrar nuevo paso
    currentStep = newStep;
    document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.add('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
    
    updateButtons();
    
    if (currentStep === 4) {
        showPreview();
    }
}

function updateButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
    
    if (currentStep === 4) {
        nextBtn.innerHTML = '<i class="fas fa-check"></i> Confirmar Registro';
        nextBtn.onclick = submitForm;
    } else {
        nextBtn.innerHTML = 'Siguiente <i class="fas fa-arrow-right"></i>';
        nextBtn.onclick = () => changeStep(1);
    }
}

function showPreview() {
    document.getElementById('prev-empresa').textContent = document.getElementById('empresa').value || '-';
    document.getElementById('prev-nit').textContent = document.getElementById('nit').value || '-';
    document.getElementById('prev-representante').textContent = document.getElementById('representante').value || '-';
    document.getElementById('prev-email').textContent = document.getElementById('email').value || '-';
    document.getElementById('prev-capacidad').textContent = document.getElementById('capacidad').value || '-';
    
    const checkboxes = document.querySelectorAll('.form-check-input:checked');
    const actividades = Array.from(checkboxes).map(cb => cb.value).join(', ') || '-';
    document.getElementById('prev-actividades').textContent = actividades;
    
    const ubicacion = `${document.getElementById('ciudad').value || ''}, ${document.getElementById('departamento').value || ''}`;
    document.getElementById('prev-ubicacion').textContent = ubicacion;
}

function submitForm() {
    alert('¡Formulario enviado con éxito!');
}
