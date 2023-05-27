# my_symfony
# Given the attached MySQL database schema, please write a simple JSON API that can find users by `is_active`, `is_member`, `last_login_at` (range), `user_type` (multiple values)

# Please use Symfony framework (version 6.1) and Doctrine bundle (ORM)
# Please use PHP 8.1
# Authentication is NOT necessary
# Commit message (if has) should be in English
# Comments in the code should be in English

api url: http://127.0.0.1:8000/test/users
      example: http://127.0.0.1:8000/test/users?is_active=1&last_login_from=2022-01-01&last_login_to=2022-12-31&user_types=1,2,3,4
      
unit test:
cd my_symfony
run: php ./vendor/bin/phpunit ./tests/controller/TestUsersControllerTest.php
