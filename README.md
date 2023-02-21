# Challange
## Despliegue local
1) composer install
2) npm install
3) npm run build
4) crear db y conectar
5) php artisan config:cache
6) docker compose up --build
7) para testing cambiar en el archivo .env app_env = testing
8) php artisan test y verificar success
9) cambiar de nuevo app_env = local
10) php artisan config:cache
11) composer dump-autoload

## Prueba la api = http://54.161.253.149/api/zip-codes/{zip_code} [api](http://54.161.253.149/api/zip-codes/)
### Primer paso
- Lo que hice principalmente fue descargar el archivo que contenia todos los codigos e informacion que necesitaba para llevar a cabo el challange
- Leer el archivo con la libreria phpoffice/phpspreadsheet
 - Aplique un patron **factory** con el objectivo que en un futuro podemos leer o soportar varios tipos de archivos y extensiones 
    - Estructura patron:
      - Lectura De archivos e instancia de objecto que nos permite buscar que tipo vamos a leer [Link](https://github.com/Quisui/backbone-challange/blob/develop/app/Services/Api/V1/DocumentReader/ReadDocument.php)
      - File system contiene los archivos soportados [link](https://github.com/Quisui/backbone-challange/blob/develop/config/filereader.php)
      - Esta clase lee el archivo excel y toma la primer fila del archivo como las keys que vamos a utilizar en nuestra migracion de base de datos y posteriormente hacerle un seed con los datos [link](https://github.com/Quisui/backbone-challange/blob/develop/app/Services/Api/V1/DocumentReader/ExcelDocumentReader.php)
  - Lectura, seed y migracion
    - leemos el archivo, tomamos las columnas y con eso formamos la tabla zipcodes
      -  [ver](https://github.com/Quisui/backbone-challange/blob/develop/database/migrations/2023_02_19_005640_create_zip_codes_table.php)
    -  Posteriormente procedemos a hacerle seed a la tabla 
        -  [ver](https://github.com/Quisui/backbone-challange/blob/develop/database/seeders/DatabaseSeeder.php)

### Segundo paso
 Creamos el resource para la api el cual utilizaremos para crear una estructura personalizada de nuestro response [ver](https://github.com/Quisui/backbone-challange/blob/develop/app/Http/Resources/Api/V1/ZipCodeResource.php)
 
### Tercer paso
 Tengo dos tipos de tests
    - Feature para el unico endpoint que vamos a utilizar en este challange [ver](https://github.com/Quisui/backbone-challange/blob/develop/tests/Feature/Api/V1/ZipCodeTest.php)
    - Unit para testing de lectura de archivos de cualquier tipo admitido hasta el momento [ver](https://github.com/Quisui/backbone-challange/blob/develop/tests/Unit/DocumentReaderTest.php)

### Cuarto Paso
    ## Ci/CD
    Workflow actions 
    1) testing para saber que la app funciona [revisa](https://github.com/Quisui/backbone-challange/blob/master/.github/workflows/laravel.yml)
    2) Si fue success hace git pull en la instancia ec2 [revisa](https://github.com/Quisui/backbone-challange/blob/master/.github/workflows/aws.yml)
