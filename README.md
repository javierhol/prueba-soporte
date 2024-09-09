# Prueba Técnica - Sistema de Gestión de Tareas

## Descripción del Proyecto

Este proyecto es un sistema básico de gestión de tareas desarrollado con Laravel y Vue.js. El objetivo de esta prueba técnica es identificar y corregir errores en el código tanto en el backend como en el frontend. El sistema permite a los usuarios crear, actualizar, eliminar y visualizar tareas.

## Objetivo de la Prueba

El objetivo principal de esta prueba es evaluar tus habilidades para depurar y corregir errores en un proyecto existente que utiliza Laravel, PHP, JavaScript, y Vue.js. Deberás:

- Identificar y corregir errores en el backend relacionado con la creación, actualización, eliminación y validación de tareas.
- Corregir problemas en el frontend que afectan la visualización y manejo de la lista de tareas.
- Asegurarte de que las tareas se gestionen correctamente en la interfaz de usuario.

Además, deberás agregar una funcionalidad extra para filtrar las tareas completadas y pendientes.

## Instrucciones de Instalación

Sigue los siguientes pasos para configurar el proyecto en tu entorno local:


1. **Clona el repositorio:**

       Prueba-Soporte
   
2. **Instala las dependencias de PHP y Node.js:**

   .Composer: Para instalar las dependencias de PHP, ejecuta:
   
        composer install

   .NPM: Para instalar las dependencias de Node.js, ejecuta:

        npm install
        npm run dev

3. **Configura el archivo de entorno .env:**

   .Copia el archivo .env.example a .env:

       cp .env.example .env
   
   .Genera la clave de la aplicación:

       php artisan key:generate
   
   .Configura la base de datos en el archivo .env. Asegúrate de tener una base de datos MySQL disponible y configurada.
   
4. **Ejecuta las migraciones para crear las tablas necesarias:**

       php artisan migrate

5. **Compilar Recursos de Frontend:**

   .Compila los archivos de frontend utilizando Laravel Mix:

       npm run dev

6. **Iniciar el Servidor:**

   .Inicia el servidor de desarrollo de Laravel:

       php artisan serve

       
**Objetivo de la Prueba**

El proyecto contiene errores tanto en el backend (Laravel/PHP) como en el frontend (JavaScript). Tu objetivo es:

 1.Identificar los errores en el código.
 2.Corregir los errores para que la aplicación funcione correctamente.
 3.Probar la aplicación después de realizar las correcciones para asegurarte de que todo funcione como se espera.
 
**Entrega**

Sube el código corregido a un repositorio de GitHub y envíanos el enlace. Asegúrate de describir los problemas que encontraste y cómo los solucionaste en este archivo README.md.

**Notas**

Puedes añadir cualquier comentario adicional sobre las decisiones que tomaste al corregir el código.
Recuerda que el objetivo es demostrar tu capacidad para depurar y mejorar código existente.

¡Buena suerte!
   
**Solución**


- El primer problema que encontré fue el de creación de un usuario, el cual después de depurar el código me di cuenta de que en el modelo se estaba haciendo referencia a la tabla Users y la cual era User.

- Al momento de renderizar las tareas, tenía el problema de que no se pintaban, porque el método no estaba creado en el TaskList y tampoco en el store. Aparte, en el modelo tampoco creé el método e hice un filtrado para extraer el email relacionado al user asignado en la tarea.

- Otro de los problemas el cual me tomo un buen rato poderlo identificar era cuando se duplicaba el contenedor donde iba la información de la Task. Me di de cuenta que el redirect del controller hacía que se me duplicara ya que se estaba manejando como tributo en la respuesta. Lo que hice fue que lo converti en una entidad y lo retorné como JSON.

- El método de eliminar también estaba fallando por algo similar y lo que hice fue también retornarlo como un JSON.

- El método de update no llegaba la información, por lo que no se estaba llamando con el nombre correcto en el TaskList. Lo que hice fue coregir el nombre y aparte enviar toda la task de nuevo, ya que se estaba enviando el task.id. Luego de validarlos hice un array para extraer el campo completed y ponerlo en 1 que sería true y así quedaría funcionando correctamente.

- La función de filtrar, lo primero que realice fue inicializar una variable en el state del store, luego de ello cree una acción la cual me permite consultar a la base de datos el valor filtrado que sería con el completed, luego de ello en el TaskList cree 3 botones los cuales me permiten filtrar por: complete, incomplete, all. Lo que hice fue crear una función que dentro de cada botón va un estado, siendo 1 true y 0 false, y así poder filtrar el completed, y está el all que me trae todas las tareas creadas y utilicé el método que había creado inicialmente.

Me entretuve mucho haciendo la prueba, estare atento...
