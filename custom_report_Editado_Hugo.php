<?php
// Incluir header
require_once __DIR__ . '/../partials/header.php';

// Asegurar que $report está definido
$report = $report ?? [];
$startDate = $startDate ?? date('Y-m-d', strtotime('-30 days'));
$endDate = $endDate ?? date('Y-m-d');
$selectedTechnician = $selectedTechnician ?? '';
$selectedCategory = $selectedCategory ?? '';
$selectedStatus = $selectedStatus ?? '';
?>

<style>
    :root {
        --color-primary: #3498db;
        --color-primary-dark: #2c3e50;
        --color-bg: #f8f9fa;
        --color-text: #343a40;
        --color-card: #ffffff;
        --color-border: #dee2e6;
        --color-success: #28a745;
        --color-danger: #dc3545;
        --color-warning: #ffc107;
        --color-info: #3498db;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
    }

    body.dark-mode {
        --color-primary: #ff8c42;
        --color-primary-dark: #2c3e50;
        --color-bg: #121212;
        --color-text: #f8f9fa;
        --color-card: #1e1e1e;
        --color-border: #444;
        --shadow-sm: 0 2px 4px rgba(255,255,255,0.1);
        --shadow-md: 0 4px 6px rgba(255,255,255,0.1);
        --shadow-lg: 0 10px 15px rgba(255,255,255,0.1);
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--color-bg);
        color: var(--color-text);
        transition: all 0.3s ease;
    }

    body.dark-mode {
        --color-primary: #ff8c42;
        --color-primary-dark: #2c3e50;
        --color-bg: #121212;
        --color-text: #f8f9fa;
        --color-card: #1e1e1e;
        --color-border: #444;
        --shadow-sm: 0 2px 4px rgba(255,255,255,0.1);
        --shadow-md: 0 4px 6px rgba(255,255,255,0.1);
        --shadow-lg: 0 10px 15px rgba(255,255,255,0.1);
    }

    body.dark-mode .card-header h6 {
        color: var(--color-primary);
    }

    body.dark-mode .form-group label,
    body.dark-mode .form-group .form-label {
        color: #f8f9fa !important;
    }

    .report-container {
        background-color: var(--color-card);
        border-radius: 15px;
        padding: 35px;
        box-shadow: var(--shadow-lg);
        transition: all 0.3s ease;
        border: 1px solid var(--color-border);
        margin-bottom: 40px;
    }

    .h3 {
        color: #000000 !important;
        font-weight: 600;
    }

    .h3 i,
    .h3 .fas {
        color: #000000 !important;
    }

    .h3 .text-primary {
        color: #000000 !important;
    }

    body.dark-mode .h3 {
        color: #f8f9fa !important;
    }

    body.dark-mode .h3 i,
    body.dark-mode .h3 .fas {
        color: #f8f9fa !important;
    }

    body.dark-mode .h3 .text-primary {
        color: #f8f9fa !important;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-control {
        padding: 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .card {
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        background-color: var(--color-card);
        border-left: 5px solid var(--color-primary);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid var(--color-border);
        overflow: hidden;
    }

    .table-responsive {
        margin-top: 30px;
        overflow-x: auto;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background-color: var(--color-primary);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
    }

    .table td {
        padding: 15px;
        vertical-align: middle;
    }

    .card {
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        background-color: var(--color-card);
        border-left: 5px solid var(--color-primary);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid var(--color-border);
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--color-primary);
    }

    .card-header {
        padding: 15px;
        border-bottom: 1px solid var(--color-border);
    }

    .card-header h6 {
        color: var(--color-primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    body.dark-mode .card-header h6 {
        color: #ff8c42 !important;
    }

    .btn-primary {
        background-color: var(--color-primary);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 1rem;
        box-shadow: var(--shadow-md);
    }

    .btn-primary:hover {
        background-color: var(--color-primary-dark);
        transform: translateY(-3px);
        color: white;
        box-shadow: var(--shadow-lg);
    }

    .btn-primary i {
        font-size: 1.2rem;
        margin-right: 8px;
    }

    .btn-secondary {
        background-color: var(--color-bg);
        color: var(--color-text);
        border: 1px solid var(--color-border);
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
    }

    .btn-secondary i {
        color: var(--color-text);
        transition: all 0.3s ease;
    }

    .btn-secondary:hover i {
        color: white;
    }

    .h3 {
        color: var(--color-primary);
        font-weight: 600;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-chart-bar me-2"></i>
            Informes Personalizados
        </h1>
        <a href="index.php?controller=report&action=index" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Volver a Reportes
        </a>
    </div>
    
    <!-- Filtros de Informe Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-filter me-2"></i>
            Filtros de Informe
        </h6>
    </div>
        <div class="card-body">
            <form method="post" action="index.php?controller=report&action=custom" id="reportForm">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="start_date">Fecha Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                value="<?php echo $startDate; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="end_date">Fecha Fin</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                value="<?php echo $endDate; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="technician">Técnico</label>
                            <select class="form-control" id="technician" name="technician">
                                <option value="">Todos</option>
                                <?php foreach ($technicians as $tech): ?>
                                <option value="<?php echo $tech['id']; ?>" <?php echo ($selectedTechnician == $tech['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($tech['username']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="category">Categoría</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Todas</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($selectedCategory == $cat['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Todos</option>
                                <option value="open" <?php echo ($selectedStatus == 'open') ? 'selected' : ''; ?>>Abierto</option>
                                <option value="in_progress" <?php echo ($selectedStatus == 'in_progress') ? 'selected' : ''; ?>>En Progreso</option>
                                <option value="resolved" <?php echo ($selectedStatus == 'resolved') ? 'selected' : ''; ?>>Resuelto</option>
                                <option value="closed" <?php echo ($selectedStatus == 'closed') ? 'selected' : ''; ?>>Cerrado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Generar Informe
                </button>
            </form>
        </div>
    </div>

    <?php if (!empty($report)): ?>
    <!-- Resultados del Informe Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-chart-line me-2"></i>
            Resultados del Informe
        </h6>
            <div class="dropdown no-arrow">
                <a href="index.php?controller=report&action=export&format=csv&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>&technician=<?php echo $selectedTechnician; ?>&category=<?php echo $selectedCategory; ?>&status=<?php echo $selectedStatus; ?>" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Exportar CSV
                </a>
                <a href="index.php?controller=report&action=export&format=pdf&start_date=<?php echo $startDate; ?>&end_date=<?php echo $endDate; ?>&technician=<?php echo $selectedTechnician; ?>&category=<?php echo $selectedCategory; ?>&status=<?php echo $selectedStatus; ?>" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                </a>
                <a href="index.php?controller=report&action=performance" class="btn btn-sm btn-primary">
                    <i class="bi bi-graph-up"></i> Ver Gráficos
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="reportTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Categoría</th>
                            <th>Creado</th>
                            <th>Actualizado</th>
                            <th>Cliente</th>
                            <th>Técnico</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report as $ticket): ?>
                        <tr>
                            <td><?php echo $ticket['id']; ?></td>
                            <td><?php echo htmlspecialchars($ticket['title']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $this->getStatusColor($ticket['status']); ?>">
                                    <?php echo $this->getStatusLabel($ticket['status']); ?>
                                </span>
                            </td>
                            <td><?php echo ucfirst($ticket['priority']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['category_name']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ticket['created_at'])); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ticket['updated_at'])); ?></td>
                            <td><?php echo htmlspecialchars($ticket['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($ticket['technician_name'] ?? 'Sin asignar'); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="index.php?controller=report&action=export&format=csv&ticket_id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-success" title="Exportar a CSV">
                                        <i class="bi bi-file-earmark-excel"></i>
                                    </a>
                                    <a href="index.php?controller=report&action=export&format=pdf&ticket_id=<?php echo $ticket['id']; ?>" class="btn btn-sm btn-danger" title="Exportar a PDF">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-info">
            No se encontraron resultados para los filtros seleccionados.
        </div>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function() {
        $('#reportTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
            },
            order: [[0, 'desc']]
        });
    });
</script>

<?php
// Incluir footer
require_once __DIR__ . '/../partials/footer.php';
?>
