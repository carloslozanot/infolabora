<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Módulo de Vacaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f8f9fa;
      padding: 2rem;
    }

    .dashboard-card {
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      background: white;
    }

    .info-box {
      background: #e9f7f9;
      border-radius: 12px;
      padding: 1rem 1.5rem;
      text-align: center;
    }

    .info-box i {
      font-size: 2rem;
      color: #0d6efd;
    }

    .btn-vacaciones {
      border-radius: 30px;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2 class="mb-4 text-center">Panel de Vacaciones</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="info-box">
          <i class="fas fa-plane-departure"></i>
          <h5 class="mt-2">Días Disponibles</h5>
          <p class="fs-4 text-success fw-bold">12</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <i class="fas fa-calendar-check"></i>
          <h5 class="mt-2">Solicitudes Aprobadas</h5>
          <p class="fs-4 fw-bold">3</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <i class="fas fa-file-alt"></i>
          <h5 class="mt-2">Historial de Solicitudes</h5>
          <p class="fs-4">Ver Detalles</p>
        </div>
      </div>
    </div>

    <div class="text-center mt-5">
      <a href="#" class="btn btn-primary btn-lg btn-vacaciones me-3">
        <i class="fas fa-file-signature me-2"></i>Solicitar Vacaciones
      </a>
      <a href="#" class="btn btn-outline-secondary btn-lg btn-vacaciones">
        <i class="fas fa-clipboard-list me-2"></i>Historial de Solicitudes
      </a>
    </div>
  </div>
</body>

</html>
