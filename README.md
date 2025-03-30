# SkyWarden ✈️🔒

**Sistema de Gestión de Aerolínea**  
*Gestiona usuarios, vuelos, reservas y destinos con seguridad y eficiencia.*

---

## Características Principales 🚀
- **Autenticación JWT**: Acceso seguro con roles de usuario (Admin, User, Guest).
- **Gestión de Vuelos**: 
  - CRUD de aviones y vuelos (solo Admin).
  - Cambio automático de estado a "cerrado" cuando no hay plazas o la fecha expira.
- **Reservas Inteligentes**:
  - Verificación en tiempo real de plazas disponibles.
  - Una reserva por usuario/vuelo.

---

## Tecnologías Utilizadas 🛠️
### **Languages**:
- PHP

### **Backend**: 
- Laravel 11
- PHP 8.2
- MySQL/MariaDB

### **Frameworks**:
- Laravel

### **Herramientas**: 
- Postman (API testing)
- Jira (gestión de tareas)
- PHPUnit (tests)

### **Server**:
- XAMPP
- Apache
- Node.js

---

## Configuración Inicial ⚙️

### Requisitos  
- PHP ≥ 8.2, Composer y MySQL.  
- Extensiones PHP necesarias: `mbstring`, `openssl`, `pdo`, `tokenizer`.  

### Pasos  

1. **Clonar el Repositorio**  
   ```bash
   git clone https://github.com/tu-usuario/SkyWarden.git
   cd SkyWarden
   ```

2. **Instalar Dependencias**  
   ```bash
   composer install
   ```

3. **Configurar Entorno**  
   - Copia el archivo `.env.example` y renómbralo a `.env`.  
     ```bash
     cp .env.example .env
     ```
   - Genera la clave de la aplicación:  
     ```bash
     php artisan key:generate
     ```
   - Configura la base de datos en el archivo `.env`:  
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=skywarden
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Migraciones**  
   - Ejecuta las migraciones para crear la estructura de la base de datos:  
     ```bash
     php artisan migrate --seed
     ```
   - El parámetro `--seed` permite llenar la base de datos con datos de prueba.  

5. **Iniciar Servidor**  
   - Levanta el servidor local de Laravel:  
     ```bash
     php artisan serve
     ```
   - Accede a la aplicación en: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Estructura de la BBDD
![SQLDiagram](https://res.cloudinary.com/dkhuqpgam/image/upload/f_auto,q_auto/SQL%20Diagram%20Of%20SkyWarden)

# Documentación de la API ✈️

Esta es la documentación de la API del sistema de gestión de aerolíneas **SkyWarden**.

## Autenticación 🔐
### Registrar Usuario
**POST** `/auth/register`
- **Descripción:** Permite a los usuarios registrarse.
- **Cuerpo de la solicitud:**
  ```json
  {
    "name": "Example user",
    "email": "test@example.com",
    "password": "password123"
  }
  ```
- **Respuesta:**
  ```json
  {
      201
    "message": "User created successfully",
    "user": "Example User"
  }
  ```

### Iniciar Sesión
**POST** `/auth/login`
- **Descripción:** Permite a los usuarios autenticarse.
- **Cuerpo de la solicitud:**
  ```json
  {
    "email": "test@example.com",
    "password": "password123"
  }
  ```
- **Respuesta:**
  ```json
  {
    "access_token": "jwt_token",
    "token_type": "bearer"
  }
  ```

### Cerrar Sesión
**POST** `/auth/logout`
- **Descripción:** Cierra la sesión del usuario.
- **Respuesta:**
  ```json
  {
    "message": "Logged out successfully"
  }
  ```

### Refrescar Token
**POST** `/auth/refresh`
- **Descripción:** Genera un nuevo token JWT.
- **Respuesta:**
  ```json
  {
    "access_token": "jwt_token",
    "token_type": "bearer"
  }
  ```

### Obtener Usuario Autenticado
**GET** `/auth/me`
- **Descripción:** Retorna la información del usuario autenticado.
- **Respuesta:**
  ```json
  {
    "id": 1,
    "name": "Example User",
    "email": "test@example.com"
  }
  ```

## Vuelos ✈️
### Listar Vuelos Disponibles
**GET** `/Flights`
- **Descripción:** Devuelve una lista de vuelos disponibles.

### Obtener Detalles de un Vuelo
**GET** `/Flights/{id}`
- **Descripción:** Retorna la información de un vuelo específico.

### Crear Vuelo *(Admin)*
**POST** `/Flights`
- **Descripción:** Permite a un administrador crear un vuelo.

### Actualizar Vuelo *(Admin)*
**PUT** `/Flights/{id}`
- **Descripción:** Modifica los datos de un vuelo específico.

### Eliminar Vuelo *(Admin)*
**DELETE** `/Flights/{id}`
- **Descripción:** Borra un vuelo del sistema.

## Ubicaciones 🌍
### Listar Ubicaciones
**GET** `/Location`
- **Descripción:** Obtiene todas las ubicaciones disponibles.

### Obtener Detalles de una Ubicación
**GET** `/Location/{id}`
- **Descripción:** Retorna información detallada de una ubicación específica.

### Crear Ubicación *(Admin)*
**POST** `/Location`
- **Descripción:** Permite a un administrador agregar una nueva ubicación.

### Actualizar Ubicación *(Admin)*
**PUT** `/Location/{id}`
- **Descripción:** Modifica la información de una ubicación.

### Eliminar Ubicación *(Admin)*
**DELETE** `/Location/{id}`
- **Descripción:** Elimina una ubicación del sistema.

## Reservas 🎟️
### Listar Reservas
**GET** `/Reservations`
- **Descripción:** Retorna todas las reservas realizadas por los usuarios autenticados.

### Crear Reserva
**POST** `/Reservation`
- **Descripción:** Permite a un usuario reservar un vuelo.

### Obtener Detalles de una Reserva
**GET** `/Reservation/{id}`
- **Descripción:** Devuelve los detalles de una reserva específica.

### Modificar Reserva
**PUT** `/Reservation/{id}`
- **Descripción:** Permite actualizar los datos de una reserva.

### Cancelar Reserva
**DELETE** `/Reservation/{id}`
- **Descripción:** Elimina una reserva realizada por un usuario.

## Gestión de Aviones ✈️ *(Admin)*
### Listar Aviones
**GET** `/planes`
- **Descripción:** Obtiene una lista de todos los aviones disponibles.

### Obtener Información de un Avión
**GET** `/planes/{id}`
- **Descripción:** Retorna los detalles de un avión específico.

### Crear Avión
**POST** `/planes`
- **Descripción:** Permite registrar un nuevo avión en el sistema.

### Modificar Avión
**PUT** `/planes/{id}`
- **Descripción:** Modifica la información de un avión.

### Eliminar Avión
**DELETE** `/planes/{id}`
- **Descripción:** Elimina un avión del sistema.

## Gestión de Usuarios 👤 *(Admin)*
### Listar Usuarios
**GET** `/Users`
- **Descripción:** Retorna la lista de usuarios registrados en el sistema.

### Obtener Detalles de un Usuario
**GET** `/Users/{id}`
- **Descripción:** Devuelve los datos de un usuario específico.

### Crear Usuario
**POST** `/Users`
- **Descripción:** Permite registrar un nuevo usuario en el sistema.

### Modificar Usuario
**PUT** `/Users/{id}`
- **Descripción:** Modifica la información de un usuario.

### Eliminar Usuario
**DELETE** `/Users/{id}`
- **Descripción:** Elimina un usuario del sistema.

---

📌 **Nota:** Algunas rutas requieren autenticación JWT o permisos de administrador.



## Testing y Cobertura ✅
### Ejecutar tests (PHPUnit/Pest)
 php artisan test
![Test](https://res.cloudinary.com/dkhuqpgam/image/upload/f_auto,q_auto/Test%20of%20SkyWarden)

### Generar Un Reporte De Dobertura (78'69%)
php artisan test --coverage-html=storage/coverage-report
![Coverage Report](https://res.cloudinary.com/dkhuqpgam/image/upload/f_auto,q_auto/Coverage%20Report%20of%20SkyWarden)







## Licencia 📄
MIT License. Ver LICENSE para más detalles.

## Contribución 🤝

- **Manuel Espinosa:**  [![GitHub](https://img.shields.io/badge/GitHub-Perfil-black?style=flat-square&logo=github)](https://github.com/Manusitox360)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-Perfil-blue?style=flat-square&logo=linkedin)](https://www.linkedin.com/in/manuel-espinosa-guillén-950781294/)
[![Correo](https://img.shields.io/badge/Email-Contacto-red?style=flat-square&logo=gmail)](mailto:espinosaguillenmanuel@gmail.com)
