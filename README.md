<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

### About the Project
This Laravel API project is prepared for a software company based in UK in consideration with the backend web developer recruitment process.
### Features
- [JWT Authentication](https://jwt-auth.readthedocs.io/en/develop/) system with bearer token
- 'Repository Pattern' as a layer abstraction implemented instead of Laravel's default 'Active Record Pattern'
- Interacting two different APIs 
  - <a href="https://developers.google.com/maps/documentation/distance-matrix/overview" target="_blank">Google's Distance Matrix API</a>
  - <a href="https://postcodes.io/" target="_blank">Postcodes.io's Postcode and Geolocation API for the UK</a>
### Installing Project
- Clone the git repository: `git clone git@github.com:furkanmeraloglu/iceberg-digital-backend-test.git`
- Modify the `.env` file configure your database settings.
- Attach a fresh application key to the project with `php artisan key:generate`
- Install project dependencies with `composer install` and update if necessary `composer update`
- Run the migrations and database seeding `php artisan migrate --seed`
### Associated Links
- [For the project's Postman Collection](#)
- [For the project's Heroku deployment](#)


