# directorio de revistas cientificas

proyecto delfin 2026 - Universidad Autonoma de Nayarit

## estructura de carpetas

```
directorio-revistas/
├── index.php               punto de entrada y router
├── .htaccess               reescritura de URLs
├── img/                    logos e imagenes
│   ├── logo_UAN.png
│   ├── logo_unidad_economia.png
│   ├── logo_delfin.png
│   ├── logo_upa.png
│   ├── logo_udenar.png
│   ├── logo_teccol.png
│   └── logo_TESSFP.png
├── css/
│   └── styles.css          estilos principales
├── js/
│   └── main.js             scripts del frontend
├── controllers/
│   ├── HomeController.php
│   ├── BuscarController.php
│   └── RevistaController.php
├── models/
│   └── Revista.php
├── views/
│   ├── partials/
│   │   ├── head.php
│   │   ├── navbar.php
│   │   ├── footer.php
│   │   ├── sidebar-filtros.php
│   │   ├── card-revista.php
│   │   └── paginacion.php
│   └── pages/
│       ├── home.php
│       ├── buscar.php
│       ├── detalle.php
│       ├── acerca.php
│       └── 404.php
├── config/
│   ├── app.php             configuracion general y key de Gemini
│   ├── database.php        conexion a MySQL
│   └── seed.sql            10 revistas de muestra para pruebas
└── routes/
    └── web.php             definicion de rutas

```

## stack

- frontend: HTML + CSS + Bootstrap 5 + JS vanilla
- backend: PHP 8+
- base de datos: MySQL snake_case
- IA para busqueda: Gemini API gratuita

## pasos para instalar

1. subir todos los archivos al servidor
2. crear la base de datos MySQL
3. importar config/seed.sql en phpMyAdmin
4. editar config/app.php con la URL real y la key de Gemini
5. editar config/database.php con usuario y password de MySQL
6. reemplazar los PNG de img/ con los logos reales
