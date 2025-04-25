
  

# Sistema de Gestión Hotelera (Laravel + React)

  

Este proyecto está dividido en dos partes principales:

  

-  `backend/`: API RESTful construida con **Laravel 12**

-  `frontend/`: Interfaz de usuario construida con **React 19**

  

----------

  

## ✅ Requisitos previos

  

Antes de comenzar, asegúrate de tener instalado en tu máquina:

  

- [PHP 8.4.6 o superior](https://www.php.net/)

- [Composer 2.8.8 o superior](https://getcomposer.org/)

- [PostgreSQL 14 o superior](https://www.postgresql.org/)

- [Node.js 18.20.6 o superior](https://nodejs.org/)

- [NPM](https://www.npmjs.com/)

- [Docker](https://www.docker.com/) y Docker Compose

  

----------

### APP EN LA NUBE

http://162.243.161.219:3000/


----------

  

## 📦 Clonar el repositorio

  

```

git clone https://github.com/wallshapel/prueba-decameron

cd prueba-decameron

```

  

----------

  

## 🐳 Opción 1: Levantar con Docker (recomendado para evitar configuraciones manuales)

  

### ⚠️ Importante sobre `.env`

  

1. Copia el archivo `.env.example` y renómbralo a `.env`. Si no existe, créalo.

2. El archivo `.env` tiene dos configuraciones para la conexión a la base de datos:

  

```

# Para entorno local (fuera de Docker)

# DB_HOST=127.0.0.1

  

# Para entorno Docker (docker-compose)

DB_HOST=db

```

  

-  **Si usas Docker**, **descomenta**  `DB_HOST=db` y comenta `DB_HOST=127.0.0.1`.

-  **Si usas Laravel localmente**, **haz lo contrario**.

  

### 🚀 Ejecutar contenedores

  

Desde la raíz del proyecto:

  

```

docker-compose up -d

```

  

Esto levantará automáticamente los servicios de Laravel, PostgreSQL y React (si está configurado).



**Ejecutar seeders (Opcional)**

La aplicación de entrada no incluye ningún hotel, pero permite agregarlos 1 a uno. Si deseas que de entrada  hayan algunos hoteles, entonces ejecuta los seeders dentro del contenedor

```

docker exec -it prueba-decameron-backend-1 bash
php artisan db:seed
exit

```
  
  

----------

  

## 💡 Opción 2: Configuración manual del backend (Laravel)

  

### 📂 Backend (Laravel)

  

```

cd hotels

```

  

**Instalar dependencias PHP:**

  

```

composer install

```

  

**Copiar archivo**  `**.env**`  **y configurar:**

  

```

cp .env.example .env

```

  

- Crea una base de datos PostgreSQL llamada `hotels`.

- Ajusta en `.env` el usuario y contraseña de PostgreSQL si es necesario.

  

**Ejecutar migraciones:**

  

```

php artisan migrate

```

  

**(Opcional) Ejecutar seeders:**

  

```

php artisan db:seed

```

  

**Levantar servidor:**

  

```

php artisan serve

```

  

Por defecto, el backend estará disponible en: `http://127.0.0.1:8000/api/v1/...`

  

**Ver documentación de la API con Scramble:**

  

```

php artisan vendor:publish --provider="Dedoc\Scramble\ScrambleServiceProvider" --tag="scramble-config"

```

  

Abrir navegador en: `http://localhost:8000/docs/api/#/`

  

### 🧪 Ejecutar tests

  

```

./vendor/bin/pest

```

  

----------

  

## 💻 Configuración del frontend (React)

  

Desde la raíz del proyecto clonado:

  

```

cd front

```

  

**Instalar dependencias:**

  

```

npm install

```

  

Asegúrate de que el backend esté corriendo en `http://127.0.0.1:8000`

  

**Iniciar servidor de desarrollo:**

  

```

npm run dev

```

  

Frontend estará disponible en `http://localhost:5173` o el puerto indicado por consola.

  

----------

  

## ✅ Verificación rápida

  

- Backend: http://127.0.0.1:8000/api

- Frontend: http://localhost:5173 (local)

  

- Frontend: http://localhost:3000 (docker)

  

----------

  

## 📌 Notas importantes

  

- Levanta **primero** el backend antes del frontend.

- Asegúrate de configurar correctamente `.env` según el entorno (Docker o local).

- Verifica las versiones requeridas de PHP, Node.js y PostgreSQL.

- La base de datos `hotels` debe existir **antes** de ejecutar migraciones.

- Si usas Docker, el frontend se levantará en el puerto 3000 y no en el 5173:

  

----------

  

¡Listo! Ahora puedes trabajar de manera local o usar Docker sin complicaciones 🚀