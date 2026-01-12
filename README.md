# 🚌 Central Camionera "Vía Real"

Sistema web integral para la gestión operativa y venta de boletos de una terminal de autobuses. Este proyecto implementa una arquitectura Cliente-Servidor utilizando PHP y MySQL, con un enfoque en la seguridad y la eficiencia.

## 📋 Descripción del Proyecto

El sistema está dividido en dos módulos principales para cubrir las necesidades tanto de los usuarios finales como de la administración de la empresa:

### 1. 🌎 Portal Público (Front-Office)

#### Diseñado para los clientes que desean viajar.

* Consulta de Viajes: Visualización automática de las próximas salidas programadas, filtrando solo fechas futuras.

* Detalle de Viajes: Información clara sobre hora de salida, origen, destino y modelo de autobús.

* Selección de Asientos: Interfaz gráfica para elegir asientos disponibles.
 
* Compra de Boletos: Registro de pasajeros con validación de CURP y selección de tarifas (Regular, Niño, etc.).

* Historial: Módulo "Mis Boletos" para que los usuarios consulten sus compras pasadas.

### 2. 🛡️ Panel de Administración (Back-Office)

* Diseñado para el personal operativo de la central.

* Gestión de Inventario: CRUD completo para autobuses (Unidades) y personal (Conductores).

* Logística: Programación de nuevos viajes asignando rutas, horarios, conductores y unidades.

* Monitoreo: Visualización en tiempo real de la ocupación de cada viaje (boletos vendidos vs. capacidad total).

* Seguridad: Acceso restringido mediante autenticación robusta.

## 🛠️ Stack Tecnológico

Este proyecto fue desarrollado utilizando tecnologías web estándar y herramientas modernas para entornos PHP:

* Lenguaje: PHP 8.x

* Base de Datos: MySQL (Alojada en InfinityFree)

* Frontend: HTML5, CSS3 (Diseño responsivo), Google Fonts (Montserrat).

### Seguridad Implementada:

* Hashing: Contraseñas almacenadas con algoritmo SHA-256.

* Anti-SQL Injection: Uso de Consultas Preparadas a través del ORM.

* Sesiones: Control de acceso estricto en todas las páginas administrativas.

##🗄️ Modelo de Base de Datos

La base de datos sigue las reglas de normalización (3FN) para garantizar la integridad de los datos.

### Tablas Principales:

* Viaje: Rutas y horarios.

* Boleto: Registro de ventas (relaciona Viaje, Pasajero y Asiento).

* Autobus: Capacidad y modelos.

* Conductor: Información del personal.

* Pasajero: Datos personales de los clientes.

* Tarifa: Tipos de boletos y precios.

*admin_usuarios: Credenciales de acceso al sistema

### Desarrollado por: Victor Francisco Lima Cordova

ci
admin_usuarios: Credenciales de acceso al sistema.
