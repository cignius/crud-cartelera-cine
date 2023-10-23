# CRUD Cartelera

## Tabla de contenidos

- [Requerimientos](https://github.com/cignius/crud-cartelera-cine/edit/main/README.md#requerimientos- "- Requerimientos")
- [Configuracion](https://github.com/cignius/crud-cartelera-cine/edit/main/README.md#instalaci%C3%B3n- "- Configuracion")
- [Instalación](https://github.com/cignius/crud-cartelera-cine/edit/main/README.md#extras- "- Instalación")
- [Extras](https://github.com/cignius/crud-cartelera-cine/edit/main/README.md#extras- "Extras")
- [Api](https://github.com/cignius/crud-cartelera-cine/edit/main/README.md#api "- Api")

### Requerimientos 📋

* GIT [Link](https://git-scm.com/downloads)
* Entorno de servidor local, Ej: [Laragon](https://laragon.org/download/), [XAMPP](https://www.apachefriends.org/es/index.html) o [LAMPP](https://bitnami.com/stack/lamp/installer).
* PHP Version >= 7.4  [Link](https://www.php.net/downloads.php).
* Manejador de dependencias de PHP [Composer](https://getcomposer.org/download/).

### Instalación 🔧

1. Copía el proyecto git a tu servidor
```
git clone  https://github.com/cignius/crud-cartelera-cine.git 
```
2. Dentro del proyecto, instala composer
```
composer install
```
3. Crea el archivo `.env`  a partir del archiv `.env.example` Ajusta los parametros necesarios en el archivo:  **APP_URL ** ,  **APP_NAME ** , ** DB_DATABASE ** , **DB_USERNAME ** ,  **DB_PASSWORD**
4. Dentro del proyecto, ejecutar el siguiente comando para generar el **APP_KEY**
 ```bash
php artisan key:generate
```
5. Generar la base de datos, a través de las migraciones y seeders laravel, ejecutar el comando:
```bash
php artisan migrate --seed
```
6. Asignación de permisos

   6.1 Para ubuntu (servidor)
   Con el usuario administrador, asignar los siguientes permisos a:
    ```bash
    	sudo chown -R user.www-data storage
    	sudo chown -R user.www-data bootstrap/cache
    ```
    Usuario normal
    ```bash
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    ```

    6.2 Para windows
Automaticamente el proyecto estará funcionando

7. Creación de la carpeta movies para el almacenamiento de imagenes

   7.1 Usuarios ubuntu (dentro de la carpeta public)
 	```bash
       mkdir tickets
       chmod -R 777 movies
    ```

    7.2 Usuarios Windows
    Crea la carpeta movies dentro de public

8. Configuración de la carpeta public
Para ambos SO, apunta la visibilidad hacia la carpeta public. 

### Extras 🔧
Configura el archivo `cors.php` dentro de la carpeta **config** para proteger las peticiones a la api a urls determinadas **allowed_origins**

### API

#### Todas los elementos
Metodos de consulta  (ejemplo localhost): `/api/peliculas`
```bash
curl http://localhost:8080/api/peliculas -H 'Accept: application/json'

```
Metodos de consulta  (ejemplo vhost):
```bash
curl http://domain.com/api/peliculas -H 'Accept: application/json'

```
Salida:
```json
{
  "current_page": 1,
  "data": [
    {
      "title": "Test",
      "director": "Test",
      "duration": "1h 23m",
      "classification": "a",
      "image": "http://domain.com/movies/e7dd8df5bac8de0269ace4463dd79deda97a456f.png",
      "start_exhibition": "2023-10-19 00:00:00",
      "finish_exhibition": "2023-11-01 23:59:59",
      "token": "e7dd8df5bac8de0269ace4463dd79deda97a456f",
      "status": "En cartelera"
    },
    {
      "title": "Alias provident repudiandae voluptas rerum eos ad molestias aliquam.",
      "director": "Erick Block",
      "duration": "9h 17m",
      "classification": "b15",
      "image": "http://domain.com/movies/L7MfVUs9j8rfRmAymdvw4NeKcAG2bewZMQTWqqIT.jpg",
      "start_exhibition": "2023-11-08 09:01:18",
      "finish_exhibition": "2023-11-29 22:45:27",
      "token": "L7MfVUs9j8rfRmAymdvw4NeKcAG2bewZMQTWqqIT",
      "status": "Preestreno"
    },
    {
      "title": "Aut possimus aut quia et voluptatum dicta sequi.",
      "director": "Ali Feest",
      "duration": "0h 33m",
      "classification": "aa",
      "image": "http://domain.com/movies/DpH1gczbTvDbfDrWD8Nn0VcywgjlqJRmOKzMpKXI.jpg",
      "start_exhibition": "2023-10-29 18:32:37",
      "finish_exhibition": "2024-01-10 23:12:57",
      "token": "DpH1gczbTvDbfDrWD8Nn0VcywgjlqJRmOKzMpKXI",
      "status": "Preestreno"
    }
  ],
  "first_page_url": "http://crud-cartelera.com/api/peliculas?page=1",
  "from": 1,
  "last_page": 11,
  "last_page_url": "http://crud-cartelera.com/api/peliculas?page=11",
  "links": [
    {
      "url": null,
      "label": "&laquo; Previous",
      "active": false
    },
    {
      "url": "http://crud-cartelera.com/api/peliculas?page=1",
      "label": "1",
      "active": true
    },
    {
      "url": "http://crud-cartelera.com/api/peliculas?page=2",
      "label": "2",
      "active": false
    },
    {
      "url": "http://crud-cartelera.com/api/peliculas?page=2",
      "label": "Next &raquo;",
      "active": false
    }
  ],
  "next_page_url": "http://crud-cartelera.com/api/peliculas?page=2",
  "path": "http://crud-cartelera.com/api/peliculas",
  "per_page": 3,
  "prev_page_url": null,
  "to": 3,
  "total": 31
}

```

#### Consultar un elemento
Metodos de consulta  (ejemplo localhost): `/api/pelicula/{token}`
```bash
curl http://localhost:8080/api/pelicula/{token} -H 'Accept: application/json'

```
Metodos de consulta  (ejemplo vhost):
```bash
curl http://domain.com/api/pelicula/{token} -H 'Accept: application/json'

```
Salida:

```json
{
  "title": "Alias provident repudiandae voluptas rerum eos ad molestias aliquam.",
  "director": "Erick Block",
  "duration": "9h 17m",
  "classification": "b15",
  "image": "http://domain.com/movies/L7MfVUs9j8rfRmAymdvw4NeKcAG2bewZMQTWqqIT.jpg",
  "start_exhibition": "2023-11-08 09:01:18",
  "finish_exhibition": "2023-11-29 22:45:27",
  "status": "Preestreno",
  "token": "L7MfVUs9j8rfRmAymdvw4NeKcAG2bewZMQTWqqIT"
}
```
