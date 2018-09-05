Dibi mocking helpers for PHPUnit
================================

[![Build Status](https://travis-ci.org/czukowski/phpunit-mock-dibi.svg?branch=master)](https://travis-ci.org/czukowski/phpunit-mock-dibi)

A mock-object library for database queries testing, without having to initialize in-memory
database from fixtures. Rather, every query executed by a tested code can be set to return
a pre-defined result set, affected rows count or last insert ID. All with a familiar interface
similar to PHPUnit Mock Objects.

This is an adapted version of [czukowski/phpunit-mock-db] package for uses of [Dibi - smart database
layer for PHP][dibi] by David Grudl. Dibi is a database connection library that includes a powerful
query builder and supports a variety of relational database systems.

Installation
------------

Pick your version! Version numbering follows Dibi version numbers, so for a given Dibi N.x
version, the installation command would look like this:

```sh
composer require --dev czukowski/phpunit-mock-dibi "~N.0"
```

Dibi versions starting from 3.0 are supported.

Usage
-----

Use `Cz\PHPUnit\MockDibi\MockTrait` trait in a test case class, this will enable methods for
creating database mock instances. Just call `createDatabaseMock` method passing a `Dibi\Connection`
instance that uses one of the mock drivers provided in this package, and a mock object will be added
to it and registered to the test case class.

Usage examples can be found in [czukowski/phpunit-mock-db] readme file.

License
-------

This work is released under the MIT License. See LICENSE.md for details.

 [czukowski/phpunit-mock-db]: https://packagist.org/packages/czukowski/phpunit-mock-db
 [dibi]: https://github.com/dg/dibi
