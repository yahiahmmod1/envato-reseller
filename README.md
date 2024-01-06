## Install auth

composer require laravel/ui
php artisan ui bootstrap --auth
npm install
npm run dev

feat:
migration

## One account one IP

## Laravel Request Process
$data = $request->all();
$name = $request->input('name');
$name = $request->input('name', 'Sally');
$request->name;

Using the collect method, you may retrieve all of the incoming request's input data as a collection:

$input = $request->collect();
