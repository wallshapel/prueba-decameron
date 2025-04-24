
# Sistema de Gestión Hotelera (Laravel + React)

Este proyecto está dividido en dos partes principales:

-   `hotels/`: API RESTful construida con **Laravel 12**
    
-   `front/`: Interfaz de usuario construida con **React 19**
    

----------

## ✅ Requisitos previos

Asegúrate de tener instalados en tu sistema:

-   [PHP 8.4.6 o superior](https://www.php.net/)
    
-   [Composer 2.8.8 o superior](https://getcomposer.org/)
    
-   [PostgreSQL 14 o superior](https://www.postgresql.org/)
    
-   [Node.js 18.20.6 o superior](https://nodejs.org/)
    
-   [NPM](https://www.npmjs.com/)
    

----------

## 📦 Clonar el repositorio

```
git clone https://github.com/wallshapel/prueba-decameron
cd prueba-decameron
```

----------

## 📂 Configuración del Backend (Laravel)

**1.  Entra al directorio `hotels`:**
    

```
cd hotels
```

**2.  Instala las dependencias de PHP:**
    

```
composer install
```

**3.  Copia el archivo `.env.example` a `.env`:**
    

```
cp .env.example .env
```

**4.  Asegúrate de tener creada la base de datos PostgreSQL llamada `hotels`.**
    
**5.  Configura el archivo `.env` con las credenciales de acceso a tu base de datos PostgreSQL. Puedes usar los datos de `.env.example` como referencia.**
    
**6.  Ejecuta las migraciones para crear las tablas y relaciones:**
    

```
php artisan migrate
```

**7.  Ejecuta los seeders si deseas poblar la base de datos con datos de prueba:**
    

```
php artisan db:seed
```

**8.  Inicia el servidor de desarrollo:**
    

```
php artisan serve
```

Por defecto, la API estará disponible en:

```
http://127.0.0.1:8000/api/v1/
```

### 🖋️ Documentación de la API

Para acceder a la documentación de la API generada por **Scramble**:

```
php artisan vendor:publish --provider="Dedoc\Scramble\ScrambleServiceProvider" --tag="scramble-config"
```

Luego abre en el navegador:

```
http://localhost:8000/docs/api/#/
```

### 📚 Pruebas (Tests)

Para ejecutar los tests unitarios y funcionales:

```
./vendor/bin/pest
```

----------

## 💻 Configuración del Frontend (React)

**1.  Desde la raíz del repositorio, entra al directorio del frontend:**
    

```
cd front
```

**2.  Instala las dependencias de Node:**
    

```
npm install
```

**3.  Asegúrate de que el backend esté funcionando en `http://127.0.0.1:8000`**
    
**4.  Inicia el servidor de desarrollo:**
    

```
npm run dev
```

La aplicación estará disponible en:

```
http://localhost:5173
```

o en el puerto que indique la consola.

----------

## 🤎 Verificación rápida

-   Backend: [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api)
    
-   Frontend: [http://localhost:5173](http://localhost:5173)
    

----------

## 📌 Notas importantes

-   Levanta **siempre primero el backend**, luego el frontend.
    
-   Verifica que los archivos `.env` estén correctamente configurados.
    
-   Revisa que tienes las versiones requeridas de PHP, Node y PostgreSQL.
    
-   La base de datos `hotels` debe existir antes de ejecutar las migraciones.
    
-   Usa `php artisan migrate:fresh --seed` para reiniciar y poblar la base de datos.
    

----------

## 📄 Estructura del proyecto

```
prueba-decameron/
├── hotels/        # Backend (Laravel 12)
│   └── .env
├── front/         # Frontend (React 19)
    └── .env
```

----------

## 📧 Soporte

Si encuentras errores o deseas proponer mejoras, abre un issue en el repositorio.