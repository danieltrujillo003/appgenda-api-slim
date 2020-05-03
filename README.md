# APPGENDA API

Api designed to manage appointments.

## SETUP

Since this project uses Slim as a Composer dependency, composer must be installed:

```
curl -sS https://getcomposer.org/installer | php
```

Then, dependencies must be installed:

```
php composer.phar install
```

Lastly, there is a dummy database `appgenda.sql` inside `./src/config`, It can be imported into the database engine for the API to operate with it.

All set, enjoy.

## ENDPOINTS

- Read (GET): `/api/appointments`
- Read single (GET): `/api/appointment/{id}`
- Create (POST): `/api/appointment/add`
- Update (PUT): `/api/appointment/update/{id}`
- Delete (DELETE): `/api/appointment/delete/{id}`