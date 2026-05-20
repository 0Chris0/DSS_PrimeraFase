<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mi Perfil</title>

<link rel="stylesheet" href="../../../public/css/pacientes.css">
<link rel="stylesheet" href="../../../public/css/registrospacientes.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

.profile-container{
    margin-top: 20px;
}

/* CARD */

.profile-card{
    background: #fff;
    border-radius: 10px;
    border: 1px solid #d9d9d9;
    box-shadow: 0 4px 10px rgba(0,0,0,.06);
    overflow: hidden;
}

/* HEADER */

.profile-header{
    background: linear-gradient(135deg,#1d72f3,#0ea5e9);
    padding: 35px 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

/* FOTO */

.profile-avatar{
    width: 95px;
    height: 95px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    color: #1d72f3;
    flex-shrink: 0;
}

/* INFO */

.profile-info h2{
    color: white;
    font-size: 28px;
    margin-bottom: 6px;
}

.profile-info p{
    color: rgba(255,255,255,.9);
    font-size: 14px;
    margin: 3px 0;
}

/* BODY */

.profile-body{
    padding: 25px;
}

/* GRID */

.profile-grid{
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 20px;
}

/* ITEM */

.profile-item{
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 18px;
}

/* TITULO */

.profile-item span{
    display: block;
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 6px;
}

/* TEXTO */

.profile-item h4{
    font-size: 16px;
    color: #1450b8;
    font-weight: 600;
}

/* BOTONES */

.profile-actions{
    margin-top: 25px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    flex-wrap: wrap;
}

/* BOTON */

.btn-profile{
    border: none;
    border-radius: 6px;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

/* EDITAR */

.btn-edit{
    background: #1450b8;
    color: white;
}

/* PASSWORD */

.btn-password{
    background: #f59e0b;
    color: white;
}

/* RESPONSIVE */

@media(max-width:768px){

    .profile-grid{
        grid-template-columns: 1fr;
    }

    .profile-header{
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .profile-actions{
        flex-direction: column;
    }

    .btn-profile{
        width: 100%;
        justify-content: center;
    }

}

</style>

</head>

<body>

<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/sidebarPaciente.php'; ?>

<div class="main-content">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        Inicio / <strong>Mi Perfil</strong>
    </div>

    <!-- TITULO -->
    <h1 class="page-title">
        Mi Perfil
    </h1>

    <!-- CONTENEDOR -->
    <div class="profile-container">

        <div class="profile-card">

            <!-- HEADER -->
            <div class="profile-header">

                <div class="profile-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="profile-info">

                    <h2>Carlos Gómez</h2>

                    <p>Paciente</p>

                    <p>
                        <i class="fa-solid fa-envelope"></i>
                        carlos@gmail.com
                    </p>

                    <p>
                        <i class="fa-solid fa-phone"></i>
                        7777-7777
                    </p>

                </div>

            </div>

            <!-- BODY -->
            <div class="profile-body">

                <div class="profile-grid">

                    <div class="profile-item">
                        <span>DUI</span>
                        <h4>01234567-8</h4>
                    </div>

                    <div class="profile-item">
                        <span>Fecha de Nacimiento</span>
                        <h4>15/08/1998</h4>
                    </div>

                    <div class="profile-item">
                        <span>Dirección</span>
                        <h4>San Salvador, El Salvador</h4>
                    </div>

                    <div class="profile-item">
                        <span>Tipo de Sangre</span>
                        <h4>O+</h4>
                    </div>

                </div>

                

            </div>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../layouts/scriptsPacientes.php'; ?>

</body>
</html>