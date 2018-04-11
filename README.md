Dibi mocking helpers for PHPUnit
================================

[![Build Status](https://travis-ci.org/czukowski/phpunit-mock-dibi.svg?branch=master)](https://travis-ci.org/czukowski/phpunit-mock-dibi)

A mock-object library for database queries testing, without having to initialize in-memory
database from fixtures. Rather, every query executed by a tested code can be set to return
a pre-defined result set, affected rows count or last insert ID. All with a familiar interface
similar to PHPUnit Mock Objects.

This is an adapted version of [czukowski/phpunit-mock-db] package for uses of [Dibi Database
Abstraction Library][dibi] by David Grudl.

Installation
------------

Pick your version! Version numbering follows Dibi version numbers, so for a given Dibi N.x.y
version, the installation command would look like this:

```sh
composer require --dev czukowski/phpunit-mock-dibi "~N.x.0"
```

Usage
-----

Use `Cz\PHPUnit\MockDibi\MockTrait` trait in a test case class, this will enable methods for
creating database mock instances.

Note: this trait doesn't consider more than one database connection to be in use. If it is required
to have multiple database connections mocked, a custom implementation should be used instead, that
either picks a correct database instance to assign the mock instance to, or one that doesn't assign
the mock instance to anywhere and leaves it up to the test method.

Usage examples can be found in [czukowski/phpunit-mock-db] readme file.

License
-------

This work is released under the MIT License. See LICENSE.md for details.

 [czukowski/phpunit-mock-db]: https://packagist.org/packages/czukowski/phpunit-mock-db
 [dibi]: https://dibiphp.com/en/
