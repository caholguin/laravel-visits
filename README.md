# 🗺️ Sistema de Gestión de Visitas

Sistema desarrollado en Laravel 10 para la gestión de visitas con visualización en mapa interactivo.

## 📋 Tabla de Contenidos

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración de Base de Datos](#configuración-de-base-de-datos)
- [Configuración del Proyecto](#configuración-del-proyecto)
- [Migraciones y Seeders](#migraciones-y-seeders)
- [Ejecutar el Proyecto](#ejecutar-el-proyecto)
- [Usuarios de Prueba](#usuarios-de-prueba)
- [Comandos Útiles](#comandos-útiles)
- [Documentación API](#Documentación API)

## 🔧 Requisitos

Antes de instalar, asegúrate de tener instalado:

- **PHP >= 8.1**
- **Composer >= 2.0**
- **Node.js >= 22** (para el frontend)
- **MySQL >= 8.0** o **MariaDB >= 10.3**
- **Git**

## 🚀 Instalación

### 1. Clonar el Repositorio
```bash
git https://github.com/caholguin/laravel-visits.git
cd laravel-visits
```

### 2. Instalar Dependencias de PHP
```bash
composer install
```

### 3. Instalar Dependencias de Node.js (si aplica)
```bash
npm install
# o si usas yarn
yarn install
# o si usas bun
bun install
```

## 🗄️ Configuración de Base de Datos

### 1. Crear Base de Datos
```sql
-- Conectar a MySQL
mysql -u root -p

-- Crear la base de datos
CREATE DATABASE visits CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario (opcional pero recomendado)
CREATE USER 'visitas_user'@'localhost' IDENTIFIED BY 'tu_password_seguro';
GRANT ALL PRIVILEGES ON sistema_visitas.* TO 'visitas_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2. Configurar Variables de Entorno
```bash
# Copiar archivo de configuración
cp .env.example .env
```

Edita el archivo `.env` con tu configuración:
```env
APP_NAME="Laravel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

# Configuración de Base de Datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visits
DB_USERNAME=visitas_user
DB_PASSWORD=tu_password_seguro

# Configuración de Email (opcional)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## ⚙️ Configuración del Proyecto

### 1. Generar Clave de Aplicación
```bash
php artisan key:generate
```

## 🗃️ Migraciones y Seeders

### 1. Ejecutar Migraciones
```bash
# Ejecutar todas las migraciones
php artisan migrate
```

### 2. Ejecutar Seeders
```bash
# Ejecutar todos los seeders
php artisan db:seed

# O ejecutar seeder específico
php artisan db:seed --class=UserSeeder
```

### 3. Resetear y Poblar Base de Datos (Desarrollo)
```bash
# ⚠️ CUIDADO: Esto borrará todos los datos existentes
php artisan migrate:fresh --seed
```

## 🎯 Ejecutar el Proyecto

### 1. Iniciar Servidor de Desarrollo
```bash
php artisan serve
```

### 2. Compilar Assets (si aplica)
```bash
# Desarrollo
npm run dev

# Producción
npm run build

# Modo watch (desarrollo)
npm run watch
```

### 3. Acceder a la Aplicación
- **URL Principal:** http://127.0.0.1:8000

## 👤 Usuarios de Prueba

Después de ejecutar los seeders, tendrás acceso a estos usuarios:

### 🔐 Administrador
- **Email:** `admin@ejemplo.com`
- **Contraseña:** `12345678`

## 🛠️ Comandos Útiles

### Comandos de Base de Datos
```bash
# Ver estado de migraciones
php artisan migrate:status

# Rollback última migración
php artisan migrate:rollback

# Rollback todas las migraciones
php artisan migrate:reset

# Refrescar migraciones con seeders
php artisan migrate:refresh --seed
```

### Comandos de Cache
```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Comando Personalizado para Visitas
```bash
# Crear nueva visita (comando personalizado)
php artisan visit:create
```

### Documentación API

En la carpeta Api-Postman encontraras un archivo json donde se encuentra la documentacion en postman para ser importada y ejecutar los endpoint creados


