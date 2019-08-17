# NESTOR

*Inteligent groceries shopping list manager*

[![Build Status](https://travis-ci.com/Lionel-D/nestor.svg?branch=develop)](https://travis-ci.com/Lionel-D/nestor)
[![Maintainability](https://api.codeclimate.com/v1/badges/8d90efd4e9207c3ea6f1/maintainability)](https://codeclimate.com/github/Lionel-D/nestor/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8d90efd4e9207c3ea6f1/test_coverage)](https://codeclimate.com/github/Lionel-D/nestor/test_coverage)

---

#### Requirements

- **[PHP](https://www.php.net/)**
- **[MySQL](https://www.mysql.com/)**
- **[Composer](https://getcomposer.org/)**
- **[Yarn](https://yarnpkg.com)**
- **[Symfony client](https://symfony.com/download)**

---

#### Install

- rename `.env.dist` to `.env` and set values for your local environment.
- `composer install` to get the framework dependencies.
- `yarn install` to get the assets dependencies.
- `php bin/console doctrine:database:create` to create database.
- `php bin doctrine:migrations:migrate` to setup database structure.
- `php bin/console doctrines:fixtures:load` to load data.

---

#### Run

- `yarn encore dev --watch` to launch webpack.
- `symfony server:start` to launch local server.

---

#### Tests

- duplicate `phpunit.xml.dist` to `phpunit.xml`
- add the following to your local `phpunit.xml` file, under `<php>` :
    - `<env name="BOOTSTRAP_LOCAL_TEST_ENV" value="test"/>` to force execution in test environment.
    - `<env name="DATABASE_URL" value="mysql://user:password@127.0.0.1:3306/nestor_test"/>` with your local MySQL credentials to run tests with a dedicated database.
- `./bin/phpunit` to execute tests.
