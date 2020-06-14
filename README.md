## Searchable Triagrams 

This package get  super powers from "spatie/searchable" and includes a custom search using trigrams, this feature it's provided from postgresql for this reason you must enable it from psql using the command:

```psql
CREATE EXTENSION pg_trgm;
```

Trigrams are formed by breaking a string into groups of three consecutive letters. For example, the string "hello" would be represented by the following set of trigrams:

" h", " he", "hel", "ell", "llo", "lo "

### Installation
___

You can install the package via composer:
```sh
composer require delarocha/searchable-trigrams
```

### Preparing your models
___

For a better performance in your searches include a migration file indexing all files will you use to your searches in the following way.
```php
public function up()
{
   DB::statement('CREATE INDEX users_name_trigram ON users USING GIST(name  gist_trgm_ops);');      
}
```

```php
public function down()
{
    DB::statement('DROP INDEX IF EXISTS users_name_trigram');
}
```



### Usage
___

Searchable trigrams is basically a custom search aspect to "spatie/searchable" for this reason, go to their github repository to read general instructions.
* [Searchable](https://github.com/spatie/laravel-searchable#usage) - Usage 


### Searching models

With the models prepared you can search them like this:

```php
use Searchable\Fuzzy\Search;

$searchResults = (new Search())
   ->registerSearchMethod(User::class, 'name')
   ->search('john');
```

You can include an extra parameter to specify you are using your search as autocomplete 

```php
use Searchable\Fuzzy\Search;

$searchResults = (new Search())
   ->registerSearchMethod(User::class, 'name', true)
   ->search('john');
```
