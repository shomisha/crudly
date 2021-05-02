# Crudly

[![Latest Stable Version](https://img.shields.io/packagist/v/shomisha/crudly)](https://packagist.org/packages/shomisha/crudly)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)

Crudly is a command line tool for generating a fully featured CRUD mechanism 
supporting both API and web base CRUD using a single console-based wizard.

All you have to do is run `php artisan crudly:model`, go through the wizard, and voilà, you're set.

Here's how you can run it:

```bash
shomisha@shomisha crudly % php artisan crudly:model

 Enter the name of your model:
 > Post

Define model properties:

 Enter property name:
 > id

 Choose property type:
  [0 ] boolean
  [1 ] string
  [2 ] email
  [3 ] text
  [4 ] integer
  [5 ] big integer
  [6 ] tiny integer
  [7 ] float
  [8 ] date
  [9 ] datetime
  [10] timestamp
  [11] json
 > big integer

 Should this field be unsigned? (yes/no) [yes]:
 > 

 Should this field be auto-increment? (yes/no) [yes]:
 > 

 Should this field be unique? (yes/no) [no]:
 > 

 Should this field be nullable? (yes/no) [no]:
 > 

 Should this field be the primary key? (yes/no) [yes]:
 > 

 Should this field be a foreign key? (yes/no) [no]:
 > 

 Do you want to add a model property? (yes/no) [yes]:
 > 

 Enter property name:
 > title

 Choose property type:
  [0 ] boolean
  [1 ] string
  [2 ] email
  [3 ] text
  [4 ] integer
  [5 ] big integer
  [6 ] tiny integer
  [7 ] float
  [8 ] date
  [9 ] datetime
  [10] timestamp
  [11] json
 > string

 Should this field be unique? (yes/no) [no]:
 > 

 Should this field be nullable? (yes/no) [no]:
 > 

 Should this field be a foreign key? (yes/no) [no]:
 > 

 Do you want to add a model property? (yes/no) [yes]:
 > 

 Enter property name:
 > body

 Choose property type:
  [0 ] boolean
  [1 ] string
  [2 ] email
  [3 ] text
  [4 ] integer
  [5 ] big integer
  [6 ] tiny integer
  [7 ] float
  [8 ] date
  [9 ] datetime
  [10] timestamp
  [11] json
 > text

 Should this field be unique? (yes/no) [no]:
 > 

 Should this field be nullable? (yes/no) [no]:
 > 

 Should this field be a foreign key? (yes/no) [no]:
 > 

 Do you want to add a model property? (yes/no) [yes]:
 > 

 Enter property name:
 > published_at

 Choose property type:
  [0 ] boolean
  [1 ] string
  [2 ] email
  [3 ] text
  [4 ] integer
  [5 ] big integer
  [6 ] tiny integer
  [7 ] float
  [8 ] date
  [9 ] datetime
  [10] timestamp
  [11] json
 > datetime

 Should this field be unique? (yes/no) [no]:
 > 

 Should this field be nullable? (yes/no) [no]:
 > 

 Do you want to add a model property? (yes/no) [yes]:
 > no

 Do you want soft deletion for this model? (yes/no) [no]:
 > yes

 No 'deleted_at' column found. Please choose column for soft deletion:
  [0] published_at
  [1] Create new column
 > 1

 Enter column name:
 > archived_at

 Do you want timestamps for this model? (yes/no) [no]:
 > 

 Should this model have web pages for CRUD actions? (yes/no) [yes]:
 > 

 Should web CRUD actions be authorized? (yes/no) [yes]:
 > 

 Do you want web CRUD tests? (yes/no) [yes]:
 > 

 Should this model have API endpoints for CRUD actions? (yes/no) [yes]:
 > 

 Should API CRUD endpoints be authorized? (yes/no) [yes]:
 > 

 Do you want API CRUD tests? (yes/no) [yes]:
 > 

shomisha@shomisha crudly %
```

Head on to the [Post Examples folder](https://github.com/shomisha/crudly/tree/chore/examples/Examples/Post) to check out the CRUD structure this wizard would generate.

Make sure to check out [the Wiki pages](https://github.com/shomisha/crudly/wiki) where you can find out what Crudly does and does not do, and also learn how to use it to speed up your development process.
