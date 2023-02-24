## To-do List App
A Laravel 9 based backend and React.js based frontend application to manage items on a to-do list. An item has a title, description, status and a photo.

## App Characteristics
<li>Add an item</li>
<li>View the details of an item (click on the title of the item)</li>
<li>Being able to edit an item</li>
<li>A photo uploaded with the item</li>
<li>The option to mark an item as active (in progress)</li>
<li>The option to mark an item as complete</li>
<li>Remove an item from the list</li>
<li>Search Item based on item title</li>
<li>View only completed items</li>
<li>View only active (in progress)</li>
<li>view only pending (not completed or in progress) items</li>


## Installation

### Backend setup
```
git clone the repo
cd to your project root from the console
copy the .env.example file to .env (cp .env.example .env).

#Setup database 
Create your local database
Enter your database information in the .env file as required

Run composer install or php composer.phar install
Run php artisan key:generate
Run php artisan migrate
Run php artisan serve

#Seeding 
Run the command below to create 10 fake items (This is optional) 
php artisan migrate:refresh --seed

```

```
You can access the app via localhos:8000 or any port specified when running serve command
You will be greeted with the default laravel welcome page.
Run php artisan route:list to see all the routes (add "--path=api" flag to see just api/ routes). 
```
### Testing and code coverage
```
php artisan test or vendor/bin/phpunit
```

```
vendor/bin/phpunit --coverage-text
```
## Notice
Errors are checked at each level and the code includes 100% test coverage of the controllers.<br/>
No security is implemented on this,  Laravel Sanctum can be easily integrated for the API Authentication and Token management.
I will be adding that soon

## License

The To-do list app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
