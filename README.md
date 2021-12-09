<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About the Project
This Laravel API project is prepared for a software company based in UK in consideration with the backend web developer recruitment process.
A user can register and login the system by filling out the necessary credentials to get API token for authentication. After the successful
authentication process user can list all appointments registered on the system, create a new appointment, update formerly created appointment
or delete an appointment. The API will automatically calculate the distance between user's predefined location and the location 
where the appointment will be held. Together with the distance calculation, API also gives expected departure time to the appointment's location
and arrival time to the predefined location after appointment finished. To do so, this API interacts two outsource services: [Postcodes.io](#) and 
[Google Distance Matrix API](#).

## Features
- [JWT Authentication](https://jwt-auth.readthedocs.io/en/develop/) system with bearer token
- 'Repository Pattern' as a layer abstraction implemented instead of Laravel's default 'Active Record Pattern'
- Interacting two different APIs
  - <a href="https://developers.google.com/maps/documentation/distance-matrix/overview" target="_blank">Google's Distance Matrix API</a>
  - <a href="https://postcodes.io/" target="_blank">Postcodes.io's Postcode and Geolocation API for the UK</a>

## Installing Project
- Clone the git repository: `git clone git@github.com:furkanmeraloglu/iceberg-digital-backend-test.git`
- Modify the `.env` file configure your database settings.
- Attach a fresh application key to the project with `php artisan key:generate`
- Install project dependencies with `composer install` and update if necessary `composer update`
- Generate the secret JWT key for initial auth token `php artisan jwt:secret`
- Run the migrations and seed the database `php artisan migrate --seed`

## Associated Links
- [For the project's Postman Collection](https://www.postman.com/galactic-flare-427401/workspace/public/collection/15711465-bcecf1b9-47ba-4078-89e9-8b0159674c91)
- [For the project's Heroku deployment](https://whispering-ravine-51058.herokuapp.com)

## API Documentation
### Resource Description and API Endpoints

`Base URL: https://whispering-ravine-51058.herokuapp.com/api`

### User Register

		POST				/auth/register

***Body Form-Data Parameters***

| Key | Type | Value |
| ----------- | ----------- | ---------|
| name |string | Furkan Meraloğlu |
| email |email | furkanmeraloglu@gmail.com |
| password |password | furkanmeraloglu | 
| password_confirmation |password | furkanmeraloglu |

Example: `https://whispering-ravine-51058.herokuapp.com/api/auth/register`

```json
{
    "message": "Agent successfully registered",
    "user": {
        "name": "Furkan Meraloğlu",
        "email": "furkanmeraloglu@gmail.com",
        "updated_at": "2021-12-07T00:36:54.000000Z",
        "created_at": "2021-12-07T00:36:54.000000Z",
        "id": 6
    }
}
```

### User Login

    	POST				/auth/login
***Body Form-Data Parameters***

| Key | Type | Value |
| ----------- | ----------- | ---------- | 
| email |email | furkanmeraloglu@gmail.com |
| password |password | furkanmeraloglu |

Example: `https://whispering-ravine-51058.herokuapp.com/api/auth/login`

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2Mzg4MzgwMTAsImV4cCI6MTYzODg0MTYxMCwibmJmIjoxNjM4ODM4MDEwLCJqdGkiOiJNV0V1QU83WVFmWlpqYXUwIiwic3ViIjo2LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.2cc8MqoWk7cnNzqu0Fqrfx1moibwAuQbqwC45QuvObQ",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 6,
        "name": "Furkan Meraloğlu",
        "email": "furkanmeraloglu@gmail.com",
        "email_verified_at": "2021-12-07T00:36:26.000000Z",
        "is_admin": 0,
        "created_at": "2021-12-07T00:36:54.000000Z",
        "updated_at": "2021-12-07T00:36:54.000000Z"
    }
}
```

### User Token Refresh

    	POST				/auth/refresh

Example: `https://whispering-ravine-51058.herokuapp.com/api/auth/refresh`

```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvYXV0aFwvcmVmcmVzaCIsImlhdCI6MTYzODgzODAxMCwiZXhwIjoxNjM4ODQxNjYxLCJuYmYiOjE2Mzg4MzgwNjEsImp0aSI6Ik5VU3BTWGVpVklMNmJlTHoiLCJzdWIiOjYsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.UHvUB4yYdcqNHhz8jNqMqt4e6WsjE4Uywugs9ixGu2g",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 6,
        "name": "Furkan Meraloğlu",
        "email": "furkanmeraloglu@gmail.com",
        "email_verified_at": "2021-12-07T00:36:26.000000Z",
        "is_admin": 0,
        "created_at": "2021-12-07T00:36:54.000000Z",
        "updated_at": "2021-12-07T00:36:54.000000Z"
    }
}
```

### User Logout
		POST				/auth/logout

Example: `https://whispering-ravine-51058.herokuapp.com/api/auth/logout`

```json
{
    "message": "User successfully signed out"
}
```

### User Information
		GET					/auth/user-profile

Example: `https://whispering-ravine-51058.herokuapp.com/api/auth/user-profiel`

```json
{
    "id": 6,
    "name": "Furkan Meraloğlu",
    "email": "furkanmeraloglu@gmail.com",
    "email_verified_at": "2021-12-07T00:36:26.000000Z",
    "is_admin": 0,
    "created_at": "2021-12-07T00:36:54.000000Z",
    "updated_at": "2021-12-07T00:36:54.000000Z"
}
```

### List Appointments
 		GET					/appointments

***URL Parameters***

| Key | Type | Value |
| ----------- | ----------- | -------- |
| filter |string | asc |
| filter |desc | desc |

Example: `https://whispering-ravine-51058.herokuapp.com/api/appointments?filter=asc`

```json
{
    "appointments": [
        {
            "id": 1,
            "user_id": 1,
            "contact_id": 1,
            "postcode": "ox495nu",
            "home_postcode": "cm27pj",
            "distance": "142 km",
            "planned_at": "2021-12-27 12:30:00",
            "duration": "60",
            "should_depart_at": "10:51",
            "should_arrive_at": "15:08",
            "created_at": "2021-12-06T20:35:44.000000Z",
            "updated_at": "2021-12-06T20:41:53.000000Z"
        },
        {
            "id": 2,
            "user_id": 1,
            "contact_id": 2,
            "postcode": "m320jg",
            "home_postcode": "cm27pj",
            "distance": "359 km",
            "planned_at": "2021-12-25 15:45:00",
            "duration": "60",
            "should_depart_at": "11:53",
            "should_arrive_at": "20:36",
            "created_at": "2021-12-06T20:43:03.000000Z",
            "updated_at": "2021-12-06T20:43:03.000000Z"
        }
    ]
}
```

### Create Appointment
		POST				/appointments

***Body Form-Data Parameters***

| Key | Type | Value |
| ----------- | ----------- | ---------- |
| name |string | Contact Name |
| phone |string | Contact Phone |
| email |email | Contact Email |
| postcode |string | Appointment Email |
| planned_at |dateTime (YYYY-MM-DD HH:MM | Appointment Date |

Example: `https://whispering-ravine-51058.herokuapp.com/api/appointments`

```json
{
    "message": "Appointment successfully created",
    "appointment": {
        "contact_id": 7,
        "user_id": 6,
        "distance": "359 km",
        "should_depart_at": "11:53",
        "should_arrive_at": "20:36",
        "postcode": "m320jg",
        "planned_at": "2021-12-25 15:45:00",
        "updated_at": "2021-12-07T00:58:31.000000Z",
        "created_at": "2021-12-07T00:58:31.000000Z",
        "id": 4
    }
}
```
### Update Appointment

		PUT					/appointments/{appointment_id}

***URL Parameters***

| Key | Type | Value |
| ----------- | ----------- | ---------- |
| id |integer | Appointment Id |

***Body 'x-www-form-urlencoded' Parameters***

| Key | Type | Value |
| ----------- | ----------- | ---------- |
| name |string | Contact Name |
| phone |string | Contact Phone |
| email |email | Contact Email |
| postcode |string | Appointment Email |
| planned_at |dateTime (YYYY-MM-DD HH:MM | Appointment Date |

Example: `https://whispering-ravine-51058.herokuapp.com/api/appointments/1`

```json
{
    "message": "Appointment successfully created",
    "appointment": {
        "contact_id": 7,
        "user_id": 6,
        "distance": "359 km",
        "should_depart_at": "11:53",
        "should_arrive_at": "20:36",
        "postcode": "m320jg",
        "planned_at": "2021-12-25 15:45:00",
        "updated_at": "2021-12-07T00:58:31.000000Z",
        "created_at": "2021-12-07T00:58:31.000000Z",
        "id": 4
    }
}
```

### Delete Appointment

		DELETE				/appointments/{appointment_id}

***URL Parameters***

| Key | Type | Value |
| ----------- | ----------- | ---------- |
| id |integer | Appointment Id |

Example: `https://whispering-ravine-51058.herokuapp.com/api/appointments/1`

```json
{
    "message": "Appointment successfully deleted"
}
```
