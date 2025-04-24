# Sistema de Gestión Hotelera (Laravel + React)

  

Este proyecto está dividido en dos partes principales:

  

-  `backend/`: API RESTful construida con **Laravel 10**

-  `frontend/`: Interfaz de usuario construida con **React 18**

  
---
  

## ✅ Requisitos previos

  
Antes de comenzar, asegúrate de tener instalado en tu máquina:

  
- [PHP 8.2 o superior](https://www.php.net/)

- [Composer](https://getcomposer.org/)

- [PostgreSQL 14 o superior](https://www.postgresql.org/)

- [Node.js 18 o superior](https://nodejs.org/)

- [NPM](https://www.npmjs.com/)
  

---

  
## 📦 Clonar el repositorio
  

```
git  clone  https://github.com/wallshapel/prueba-decameron
cd  prueba-decameron
```
    

📂  **Configuración  del  backend (Laravel)**

Ve  al  directorio  del  backend:

 ```
 cd  backend
 ```

**Instala  las  dependencias  de  PHP:** 

    composer  install

Copia  el  archivo  .env.example  a  .env y  Asegúrate  de  tener  una  base  de  datos  PostgreSQL  llamada  hotels  creada  manualmente.  Luego  configura  tu  archivo  .env  con  los  datos  q  están  en  el  .env.example. Si  ya  posees  un  usuario  y  una  contraseña  propias en tu motor de PostgreSQL,  entonces  configúralos  en  el  .env

**Ejecuta las migraciones**: para q se puedan crear las tablas, relaciones etc.. en la base de datos:

    php  artisan  migrate

**Ejecuta  los  seeders**: (opcional si  deseas  poblar  datos  de  ejemplo): 

    php  artisan  db:seed

**Inicia  el  servidor  de  desarrollo:**

      php  artisan  serve

El  backend  estará  disponible  por  defecto  en:  http://127.0.0.1:8000/api/v1/<los endpoints>


**Ver  documentación  de  la  api  con  scramble:**

    php  artisan  vendor:publish  --provider="Dedoc\Scramble\ScrambleServiceProvider"  --tag="scramble-config"

acceder  en  el  navegador  a:  http://localhost:8000/docs/api/#/

  ### TESTS 

Ejecutar  Test.  se  hicieron  tests  unitarios  y  de  integración/funcionalidad:

    ./vendor/bin/pest

  ---
  

### 💻  Configuración  del  frontend (React)

Desde la raíz del proyecto clonado inicialmente, ve  al  directorio  del  frontend:
cd  front

**Instala  las  dependencias  de  Node:**

    npm  install
 

Asegúrate  de  que  el  backend  ya  está  funcionando  en  http://127.0.0.1:8000

  

## Inicia  el  servidor  de  desarrollo:

    npm  run  dev

El  frontend  estará  disponible  en:  http://localhost:5173  o  en  el  puerto  que  la  consola  indique

  
🧪  Verificación  rápida

Visita  http://127.0.0.1:8000/api  para  probar  el  backend.
Visita  http://localhost:5173  para  probar  la  interfaz.

📌  Notas  importantes

Levanta  siempre  primero  el  backend  antes  del  frontend.
Si  algo  falla,  asegúrate  de  que  los  .env  estén  correctamente  configurados.
Verifica  que  las  versiones  de  PHP,  Node  y  PostgreSQL  sean  las  requeridas.
La  base  de  datos  hotels  debe  estar  creada  antes  de  ejecutar  las  migraciones.