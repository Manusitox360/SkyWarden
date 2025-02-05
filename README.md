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
- MySQL/MariaDB.

### **Frameworks**:
- Laravel

### **Herramientas**: 
- Postman (API testing)
- Jira (gestión de tareas)
-PHPUnit (tests).

### **Server**:
- XAMPP
- Apache
- Node.js

---

## Configuración Inicial ⚙️

### Requisitos
- PHP ≥ 8.2, Composer, MySQL.
- Extensiones PHP: `mbstring`, `openssl`, `pdo`, `tokenizer`.

### Pasos
1. **Clonar el Repositorio**:
   ```bash
   git clone https://github.com/tu-usuario/SkyWarden.git
   cd SkyWarden
2. **Instalar Dependencias**:
   ```bash
    composer install
3. **Configurar Entorno**:

4. **Migraciones**:

5. **Iniciar Servidor**:
## Uso de la API 🌐
### Planes
#### Obtener Todos Los Aviones
- **GET** `/api/planes`
- **Respuesta**: JSON con lista de aviones.
#### Obtener Avion por ID
- **GET** `/api/planes/{id}`
- **Respuesta**: JSON con detalles del avion.
#### Crear Nuevo avion
- **POST** `/api/planes`
- **Cuerpo de la Solicitud**: JSON con datos del avion.
- **Respuesta**: JSON con detalles del avion creado.
#### Actualizar Avion
- **PUT** `/api/planes/{id}`
- **Cuerpo de la Solicitud**: JSON con datos actualizados del avion.
- **Respuesta**: JSON con detalles del avion actualizado.
#### Eliminar Avion
- **DELETE** `/api/planes/{id}`
- **Respuesta**: JSON con mensaje de confirmación.


## Testing y Cobertura ✅
### Ejecutar tests (PHPUnit/Pest)
 php artisan test
![Test](https://res.cloudinary.com/dkhuqpgam/image/upload/v1738722776/jhutn2d81mzr78zjrmk6.png)

### Generar reporte de cobertura (75%)
php artisan test --coverage
![Coverage](https://res.cloudinary.com/dkhuqpgam/image/upload/v1738723175/dgcw4ozhknafl2umkod6.png)





## Licencia 📄
MIT License. Ver LICENSE para más detalles.

## Contribución 🤝

- **Manuel Espinosa:**  [![GitHub](https://img.shields.io/badge/GitHub-Perfil-black?style=flat-square&logo=github)](https://github.com/Manusitox360)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-Perfil-blue?style=flat-square&logo=linkedin)](https://www.linkedin.com/in/manuel-espinosa-guillén-950781294/)
[![Correo](https://img.shields.io/badge/Email-Contacto-red?style=flat-square&logo=gmail)](mailto:espinosaguillenmanuel@gmail.com)