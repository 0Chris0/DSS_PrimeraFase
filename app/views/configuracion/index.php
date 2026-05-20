<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Cuenta</title>

    <link rel="stylesheet" href="../../../public/css/registrospacientes.css">
    <link rel="stylesheet" href="../../../public/css/pacientes.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .main-content {
            padding: 24px;
            width: 100%;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Forzar modelo de caja */
        .main-content *, 
        .main-content *::before, 
        .main-content *::after {
            box-sizing: border-box;
        }

        .breadcrumb {
            font-size: 13px;
            color: #8a94a6;
            margin-bottom: 8px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #0b6aa8;
            margin-bottom: 20px;
        }

        /* CONTENEDOR DE CONFIGURACIÓN */
        .config-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #d7d7d7;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            padding: 28px;
            width: 100%;
        }

        .config-section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1450b8;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .config-section-title i {
            font-size: 20px;
        }

        /* FORMULARIO EN MALLA (GRID) */
        .config-form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #596882;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            height: 44px;
            border: 1px solid #cfcfcf;
            border-radius: 4px;
            padding: 0 14px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: #4d5c74;
            outline: none;
            background-color: #ffffff;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus, 
        .form-group select:focus {
            border-color: #0b6aa8;
        }

        /* DIVISOR DE SECCIONES */
        .config-divider {
            width: 100%;
            height: 1px;
            background: #e2e8f0;
            margin: 30px 0;
        }

        /* BOTONES DE ACCIÓN */
        .config-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-cancelar {
            background: #fff;
            border: 1px solid #cfcfcf;
            color: #7d8798;
            height: 42px;
            padding: 0 24px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .btn-cancelar:hover {
            background: #f8fafc;
        }

        .btn-guardar {
            background: #14833b; /* El mismo verde de tu botón Enviar */
            border: none;
            color: white;
            height: 42px;
            padding: 0 24px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .btn-guardar:hover {
            background: #0f662e;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }

            .config-card {
                padding: 20px;
            }

            .config-form-grid {
                grid-template-columns: 1fr; /* Una sola columna en celulares */
                gap: 16px;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .config-buttons {
                flex-direction: column-reverse; /* Botón de guardar arriba en móviles */
                gap: 10px;
            }

            .btn-guardar, 
            .btn-cancelar {
                width: 100%;
                justify-content: center;
                height: 46px;
            }
        }
    </style>
</head>

<body>

    <?php include __DIR__ . '/../layouts/header.php'; ?>
    <?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

    <div class="main-content">

        <div class="breadcrumb">
            Inicio / <strong>Configuración</strong>
        </div>

        <h1 class="page-title">Configuración de Cuenta</h1>

        <div class="config-card">
            <form action="#" method="POST">
                
                <div class="config-section-title">
                    <i class="fa-solid fa-user-gear"></i>
                    <span>Información Personal</span>
                </div>

                <div class="config-form-grid">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" value="María Pérez" required>
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" value="maria.perez@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Número de Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" value="+503 7123-4567">
                    </div>

                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select id="genero" name="genero">
                            <option value="Femenino" selected>Femenino</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Otros">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="config-divider"></div>

                <div class="config-section-title">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Seguridad y Contraseña</span>
                </div>

                <div class="config-form-grid">
                    <div class="form-group">
                        <label for="pass_actual">Contraseña Actual</label>
                        <input type="password" id="pass_actual" name="pass_actual" placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label for="pass_nueva">Nueva Contraseña</label>
                        <input type="password" id="pass_nueva" name="pass_nueva" placeholder="Mínimo 8 caracteres">
                    </div>
                </div>

                <div class="config-buttons">
                    <button type="button" class="btn-cancelar">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </button>
                    <button type="submit" class="btn-guardar">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                    </button>
                </div>

            </form>
        </div>

    </div>

    <?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>

</html>