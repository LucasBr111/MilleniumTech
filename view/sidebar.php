<?php
require_once 'model/categorias.php';
$categoria = new categorias();
$categorias_planas = $categoria->listar();

$categorias_agrupadas = [];
foreach ($categorias_planas as $cat) {
    if (!isset($categorias_agrupadas[$cat->grupo])) {
        $grupo = new stdClass();
        $grupo->titulo = $cat->grupo;
        $grupo->icono = $cat->icono;
        $grupo->items = [];
        $categorias_agrupadas[$cat->grupo] = $grupo;
    }
    $item = new stdClass();
    $item->id = $cat->id_categoria;
    $item->nombre = $cat->nombre_categoria;
    $item->icono = $cat->icono;
    $categorias_agrupadas[$cat->grupo]->items[] = $item;
}

$categorias = $categorias_agrupadas;
?>

<div id="sidebar-container" class="custom-sidebar">
    <nav id="sidebar" class="sidebar p-3">
        <div class="sidebar-title">
            <span>CATEGORÍAS</span>
        </div>
        <hr class="sidebar-divider">

        <ul class="list-unstyled sidebar-menu categories-list">
            <?php foreach ($categorias_agrupadas as $grupo): ?>
                <li class="nav-item">
                    <a href="#<?= str_replace(' ', '', $grupo->titulo) ?>Menu"
                       data-bs-toggle="collapse"
                       class="dropdown-toggle nav-link">
                        <i class="<?= $grupo->icono ?> me-2"></i>
                        <span><?= $grupo->titulo ?></span>
                    </a>
                    <ul class="collapse list-unstyled" id="<?= str_replace(' ', '', $grupo->titulo) ?>Menu">
                        <?php foreach ($grupo->items as $item): ?>
                            <li>
                                <a href="index.php?c=producto&a=listar&id_categoria=<?= $item->id ?>" class="nav-link sub-link">
                                    <i class="<?= $item->icono ?> me-2"></i><span><?= $item->nombre ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>

<style>
/* Variables de color de la navbar */
:root {
    --blanco-marmol: #F8F9FA;
    --dorado-elegante: #D4AF37;
    --bordo-profundo: #520017;
    --verde-jade: #006B54;
    --negro-futurista: #121212; /* Un negro más suave */
}

/* Contenedor principal de la card (nueva) */
.custom-sidebar {
    background-color: var(--blanco-marmol);
    width: 300px;
    height: calc(100vh - 85px); /* Espacio con la navbar */
    position: fixed;
    top: 125px; /* Altura de la navbar + espacio */
    left: -250px; /* Posición inicial, oculta */
    z-index: 1000;
    transition: all 0.4s ease-in-out; /* Transición más fluida */
    border-radius: 8px; /* Esquinas menos redondeadas */
    /* Sombra para el efecto de profundidad */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25), 0 0 40px rgba(212, 175, 55, 0.1);
    margin-left: 10px; /* Margen para separar de la izquierda */
    overflow-y: auto; /* Scroll si el contenido es muy largo */
}

.custom-sidebar.active {
    left: 0;
}

/* Ocultar la barra de scroll */
.custom-sidebar::-webkit-scrollbar {
    display: none;
}

.custom-sidebar {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}

/* Estilos de la sidebar interna (la que contiene el menú) */
.sidebar {
    padding: 1.5rem !important;
}

.sidebar-divider {
    border-top: 1px solid rgba(212, 175, 55, 0.2);
    margin: 1rem 0;
}

/* Título de la sección de categorías */
.sidebar-title {
    color: var(--dorado-elegante);
    font-family: 'Cinzel', serif; /* o 'Playfair Display' */
    font-size: 1rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-align: left;
    margin: 1.5rem 0 1rem;
}

/* Estilos de los enlaces de la sidebar */
.sidebar-menu .nav-link {
    font-family: 'Poppins', 'Montserrat', sans-serif;
    font-weight: 500;
    color: var(--negro-futurista) !important;
    transition: all 0.3s ease;
    padding: 12px 15px;
    border-radius: 4px; /* Bordes más sutiles en los enlaces */
    margin-bottom: 5px;
}

.sidebar-menu .nav-link:hover {
    background-color: transparent;
    color: var(--dorado-elegante) !important;
    box-shadow: inset 3px 0 0 var(--dorado-elegante); /* Efecto de línea */
}

.sidebar-menu .nav-link i {
    color: var(--negro-futurista); /* Color inicial de íconos */
    transition: all 0.3s ease;
}

.sidebar-menu .nav-link:hover i {
    color: var(--dorado-elegante);
}

.sidebar-menu .nav-link.dropdown-toggle::after {
    color: var(--dorado-elegante);
    float: right;
    margin-top: 8px;
    transform: rotate(0deg);
    transition: transform 0.3s ease;
}

/* Estilo para los sub-menús desplegables */
.sidebar-menu .collapse.show {
    background-color: rgba(0, 0, 0, 0.05); /* Fondo gris claro para los submenús */
    border-left: 2px solid var(--dorado-elegante);
    border-radius: 4px;
    padding: 5px 0;
    margin-top: 5px;
}

.sidebar-menu .sub-link {
    padding-left: 3.5rem; /* Aumenta el indentado para la jerarquía visual */
    font-size: 0.95rem;
    font-weight: 400; /* Ligeramente más delgado */
}

.sidebar-menu .sub-link i {
    color: var(--negro-futurista);
}

.sidebar-menu .sub-link:hover {
    background-color: transparent;
    box-shadow: none;
}

.sidebar-menu .sub-link:hover span {
    color: var(--bordo-profundo); /* Un toque de burdeos al pasar el cursor */
}

/* Alineación y desplazamiento del contenido con sidebar */
#content {
    transition: margin-left 0.4s ease-in-out;
}

#content.with-sidebar {
    margin-left: 260px;
}

/* Sidebar visible por defecto en desktop y contenido desplazado */
@media (min-width: 992px) {
    .custom-sidebar {
        left: 0;
    }
    #content {
        margin-left: 260px;
    }
}
</style>