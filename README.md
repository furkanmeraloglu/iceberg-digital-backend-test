<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

### About the Project
This Laravel API project is prepared for a software company based in UK in consideration with the backend web developer recruitment process.
A user can register and login the system by filling out the necessary credentials to get API token for authentication. After the successful
authentication process user can list all appointments registered on the system, create a new appointment, update formerly created appointment
or delete an appointment. The API will automatically calculate the distance between user's predefined location and the location 
where the appointment will be held. Together with the distance calculation, API also gives expected departure time to the appointment's location
and arrival time to the predefined location after appointment finished. To do so, this API interacts two outsource services: [Postcodes.io](#) and 
[Google Distance Matrix API](#).
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
- Generate the secret JWT key for initial auth token `php artisan jwt:secret`
- Run the migrations and seed the database `php artisan migrate --seed`

### Associated Links
- [For the project's Postman Collection](https://go.postman.co/workspace/My-Workspace~cf6eba9b-ab34-4d49-84d8-9f5415340bad/collection/15711465-bcecf1b9-47ba-4078-89e9-8b0159674c91)
- [For the project's Heroku deployment](https://whispering-ravine-51058.herokuapp.com)

### API Documentation
### <span style="color:grey">Resource Description</span>
<strong>Base URL: https://whispering-ravine-51058.herokuapp.com/api </strong>
<div style="padding: 0.5rem">
    <h4 style="color:grey">User Register</h4>
    <span style="color:lightgreen">POST</span> /auth/register
    <h6 style="color:grey">Body Form-Data Parameters</h6>
    <p>'name'  => Name and surname. Must be type of string.</p>
    <p>'email' => User email. Must be type of email. </p>
    <p>'password'  => Password</p>
    <p>'password_confirmation'  => Password confirmation must be matched with user's initial pre-filled password. </p>
<p>Example: https://whispering-ravine-51058.herokuapp.com/api/auth/register</p>
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">User Login</h4>
    <span style="color:lightgreen">POST</span> /auth/login
    <h6 style="color:grey">Body Form-Data Parameters</h6>
    <p>'email' => E-mail address for login. Must be type of email. </p>
    <p>'password' => Password for login. Password credential must match with user's email address. </p>
    <p>Example: https://whispering-ravine-51058.herokuapp.com/api/auth/login</p>
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">User Token Refresh</h4>
    <span style="color:lightgreen">POST</span> /auth/refresh
    <p>Example: https://whispering-ravine-51058.herokuapp.com/api/auth/refresh</p>
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">User Logout</h4>
    <span style="color:lightgreen">POST</span> /auth/logout
    <p>Example: https://whispering-ravine-51058.herokuapp.com/api/auth/logout</p>
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">User Information</h4>
    <span style="color:green">GET</span> /auth/user-profile
    <p>Example: https://whispering-ravine-51058.herokuapp.com/api/auth/user-profiel</p>
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">List Appointments</h4>
    <span style="color:green">GET</span> /appointments
    <h6 style="color:grey">URL Parameters</h6>
    <p>Key: filter | Value: asc</p>
    <p>Key: filter | Value: desc</p>
    Example: https://whispering-ravine-51058.herokuapp.com/api/appointments?filter=asc
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">Create Appointment</h4>
    <span style="color:lightgreen">POST</span> /appointments
    <h6 style="color:grey">Body Form-Data Parameters</h6>
    <p>'name' => Contact's name belongs appointment. This value will be stored in Contacts table and must be a string value for data validation.</p>
    <p>'phone' => Contact's phone number belongs to appointment. This value will be stored in Contacts table and must be a string value and at least 11 characters for data validation. </p>
    <p>'email' => Contact's email address belongs to appointment. This value will be stored in Contacts table and must be type of email for data validation. </p>
    <p>'postcode' => Postcode of the place where the appointment will be held. Must be a string value and belongs to UK postcode system.</p>
    <p>'planned_at' => Date and time of the appointment. Must be type of DateTime and in ISO8601 format for global standards.  (YYYY-MM-DD HH:MM)</p>
    Example: https://whispering-ravine-51058.herokuapp.com/api/appointments?filter=asc
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">Update Appointment</h4>
    <span style="color:yellow">PUT</span> /appointments/{appointment_id}
    <h6 style="color:grey">Body 'x-www-form-urlencoded' Parameters</h6>
    <p>Key: id | Value: integer</p>
    <p>'name' => Contact's name belongs appointment. This value will be stored in Contacts table and must be a string value for data validation.</p>
    <p>'phone' => Contact's phone number belongs to appointment. This value will be stored in Contacts table and must be a string value and at least 11 characters for data validation. </p>
    <p>'email' => Contact's email address belongs to appointment. This value will be stored in Contacts table and must be type of email for data validation. </p>
    <p>'postcode' => Postcode of the place where the appointment will be held. Must be a string value and belongs to UK postcode system.</p>
    <p>'planned_at' => Date and time of the appointment. Must be type of DateTime and in ISO8601 format for global standards.  (YYYY-MM-DD HH:MM)</p>
    Example: https://whispering-ravine-51058.herokuapp.com/api/appointments/1
</div>
<div style="padding: 0.5rem">
    <h4 style="color:grey">Delete Appointment</h4>
    <span style="color:red">DELETE</span> /appointments/{appointment_id}
    <h6 style="color:grey">URL Parameters</h6>
    <p>Key: id | Value: integer</p>
    Example: https://whispering-ravine-51058.herokuapp.com/api/appointments/1
</div>


