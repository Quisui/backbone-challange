# Challenge
## Local deployment
1) composer installation
2) npm install
3) npm run build
4) create db and connect
5) php artisan config: cache
6) docker compose --build
7) for testing change in the .env file app_env = testing
8) php artisan test and verify success
9) change back app_env = local
10) php artisan config: cache
11) Composer dump-autoload

## Try the api = http://54.161.253.149/api/zip-codes/{zip_code} [api](http://54.161.253.149/api/zip-codes/)
### First step
- What I mainly did was download the file that contained all the codes and information I needed to carry out the challenge
- Read the file with the phpoffice/phpspreadsheet library
   - Apply a **factory** pattern with the aim that in the future we can read or support various types of files and extensions
      - Patron of the structure:
        - Reading files and object instance that allows us to find what type we are going to read [Link](https://github.com/Quisui/backbone-challange/blob/develop/app/Services/Api/V1/DocumentReader/ReadDocument .php)
        - File system contains the supported files [link](https://github.com/Quisui/backbone-challange/blob/develop/config/filereader.php)
        - This class reads the excel file and takes the first row of the file as the keys that we are going to use in our database migration and later make a seed with the data [link](https://github.com/Quisui/ backbone-chalange/blob/develop/app/Services/Api/V1/DocumentReader/ExcelDocumentReader.php)
    - Reading, seed and migration
      - we read the file, we take the columns and with that we form the zipcodes table
        - [view](https://github.com/Quisui/backbone-challange/blob/develop/database/migrations/2023_02_19_005640_create_zip_codes_table.php)
      - Later we proceed to seed the table
          - [see](https://github.com/Quisui/backbone-challange/blob/develop/database/seeders/DatabaseSeeder.php)

### Second step
   We create the resource for the api which we will use to create a custom structure of our response [see](https://github.com/Quisui/backbone-challange/blob/develop/app/Http/Resources/Api/V1/ZipCodeResource .php)
 
### Third step
   I have two types of tests
      - Feature for the only endpoint that we are going to use in this challenge [see](https://github.com/Quisui/backbone-challange/blob/develop/tests/Feature/Api/V1/ZipCodeTest.php)
      - Unit for testing reading files of any type supported so far [see](https://github.com/Quisui/backbone-challange/blob/develop/tests/Unit/DocumentReaderTest.php)

### Fourth step
  #Ci/CD
    Workflow Actions
      1) test to know that the app works [check](https://github.com/Quisui/backbone-challange/blob/master/.github/workflows/laravel.yml)
      2) If successful, git pull the ec2 instance [check](https://github.com/Quisui/backbone-challange/blob/master/.github/workflows/aws.yml)
