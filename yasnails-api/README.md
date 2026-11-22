# Yas Nails API MVC (PHP + MySQL)

API REST desarrollada en PHP con arquitectura MVC y base de datos MySQL para el proyecto academico PA4 de Programacion Web Basica.

Incluye seis recursos con operaciones CRUD: categorias, servicios, clientes, profesionales, reservas y pagos.

## 1. Requisitos

- Windows.
- XAMPP con Apache, MySQL/MariaDB y PHP 8.0 o superior.
- Extension PHP `pdo_mysql` habilitada.
- Postman.

## 2. Instalacion

1. Descomprime el proyecto.
2. Copia la carpeta `yasnails-api` dentro de `C:\xampp\htdocs\`.
3. Abre el panel de XAMPP e inicia **Apache** y **MySQL**.
4. Abre `http://localhost/phpmyadmin`.
5. En phpMyAdmin, abre la pestaña **SQL** y ejecuta el archivo `database/yasnails.sql`. El script crea la base de datos `yasnails`, sus seis tablas, relaciones y carga los registros de prueba incluidos.
   - Si ya existe una base de datos `yasnails` con información que quieras conservar, realiza primero una exportación de respaldo.
6. En la carpeta `yasnails-api`, copia `.env.example` y renombra la copia como `.env`.
7. Abre `.env` y configura la conexión. Para una instalación local estándar de XAMPP:

   ```env
   APP_ENV=local
   APP_DEBUG=true
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_NAME=yasnails
   DB_USER=root
   DB_PASS=
   CORS_ORIGIN=http://localhost:5173
   ```

   Si tu usuario `root` tiene contraseña, escríbela en `DB_PASS`. Si MySQL utiliza otro puerto, actualiza `DB_PORT`.

8. Abre `http://localhost/yasnails-api/`. La API debe responder con un JSON que indique que está funcionando.
9. Abre `http://localhost/yasnails-api/api/categorias` para comprobar que se listan las categorías.

## 3. Estructura del proyecto

```text
yasnails-api/
├── app/
│   ├── Controllers/
│   ├── Core/
│   └── Models/
├── database/
│   └── yasnails.sql
├── evidencias/
│   ├── categorias/
│   ├── servicios/
│   ├── clientes/
│   ├── profesionales/
│   ├── reservas/
│   ├── pagos/
│   └── errores/
├── postman/
│   └── Yas-Nails-API.postman_collection.json
├── routes/
│   └── api.php
├── .env.example
├── .gitignore
├── .htaccess
└── index.php
```

## 4. Probar con Postman

1. Abre Postman.
2. Selecciona **Import**.
3. Importa `postman/Yas-Nails-API.postman_collection.json`.
4. La colección utiliza esta URL base:

   `http://localhost/yasnails-api`

5. Ejecuta las solicitudes de cada recurso. La colección contiene:

| Método | Endpoint | Función |
|---|---|---|
| GET | `/api/{recurso}` | Listar registros |
| GET | `/api/{recurso}/{id}` | Consultar un registro |
| POST | `/api/{recurso}` | Crear un registro |
| PUT | `/api/{recurso}/{id}` | Actualizar el registro |
| PATCH | `/api/{recurso}/{id}` | Actualizar parcialmente |
| DELETE | `/api/{recurso}/{id}` | Eliminar un registro |

Los recursos disponibles son `categorias`, `servicios`, `clientes`, `profesionales`, `reservas` y `pagos`.

Para `POST`, `PUT` y `PATCH`, selecciona **Body → raw → JSON** y envía los campos requeridos por el recurso. Para crear servicios y reservas, utiliza identificadores de categorías, clientes, profesionales y servicios que existan en la base de datos. Para crear pagos, utiliza un `id_reserva` existente.

## 5. Códigos de respuesta HTTP

- `200`: operación correcta (consulta, actualización o eliminación).
- `201`: registro creado correctamente.
- `400`: datos o solicitud inválidos.
- `404`: endpoint o registro no encontrado.
- `405`: método HTTP no permitido para el endpoint.
- `409`: conflicto con una relación o dato duplicado.
- `500`: error interno del servidor.

Durante el desarrollo, `APP_DEBUG=true` permite incluir detalles del error en la respuesta. Para un entorno publicado, utiliza `APP_DEBUG=false`.

## 6. Validaciones y relaciones

- Los servicios están relacionados con categorías.
- Las reservas están relacionadas con clientes, profesionales y servicios.
- Los pagos están relacionados con reservas.
- Las claves foráneas protegen la integridad referencial. No se pueden eliminar registros que estén siendo utilizados por otros registros relacionados.
- La fecha de fin de una reserva debe ser posterior a la fecha de inicio.
- El estado de una reserva debe ser uno de los valores permitidos por el modelo.
- Los campos y valores se validan en los modelos/controladores antes de ejecutar las operaciones.

## 7. Evidencias

La carpeta `evidencias/` contiene capturas de Postman organizadas por recurso y pruebas de errores HTTP. Estas imágenes documentan las solicitudes y respuestas de la API.


