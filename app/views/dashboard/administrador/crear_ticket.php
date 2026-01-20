<link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/dashboard/tickets/tickets.css">

<main class="admin-main-content">
    <div class="ticket-container">
        <div class="ticket-header">
            <h2>Panel Administrativo: Nuevo Reporte</h2>
            <p>Utiliza este formulario para registrar incidentes técnicos, errores de sistema o sugerencias de mejora.</p>
        </div>

        <form action="/aventura_go/administrador/guardar-ticket" method="POST" class="ticket-form">
            
            <div class="form-group">
                <label for="asunto">Asunto de la Ocurrencia</label>
                <input type="text" id="asunto" name="asunto" class="form-control" 
                       placeholder="Ej: Error en el reporte de proveedores" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoría del Reporte</label>
                <select id="categoria" name="categoria" class="form-control" required>
                    <option value="" disabled selected>Seleccione el tipo de reporte</option>
                    <option value="ERROR">Error Crítico (Sistema)</option>
                    <option value="SOPORTE">Soporte Técnico Interno</option>
                    <option value="SUGERENCIA">Sugerencia de Mejora</option>
                    <option value="QUEJA">Queja de Usuario</option>
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción Detallada</label>
                <textarea id="descripcion" name="descripcion" class="form-control" 
                          placeholder="Describe detalladamente el problema para el equipo técnico..." required></textarea>
            </div>

            <div class="actions">
                <button type="submit" class="btn-ticket-submit">
                    Registrar Reporte Administrativo
                </button>
            </div>
            
        </form>
    </div>
</main>