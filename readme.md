# Github users #

For this project [docker](https://docs.docker.com/install/), [docker-compose](https://docs.docker.com/compose/install/) and make (this package you will need to find your own.)) needed to be install.

For run project do the next:
1. clone repository;
2. copy file .env.example to .env. In this file you need to fill git credentials, otherwise you will be able to get only 60 requests per hour from git api;
3. copy file project/.env.example to project/.env;
4. finally run command ``` make start ```.

After docker deploying will be better to give some directories full writes, but it needed only if you on unix system. For macos it's not necessary.

```bash
    sudo chmod -R 777 project/storage
    sudo chmod -R 777 project/bootstrap/cache
```

Next you will need to go to laravel container and run migration like this

```bash
    make exec
    php artisan migrate
``` 

I think, that's all.

Project will be able on port 80 and adminer for database will be waiting on port 8080.
For api testing use next links:
 - /api/git_users - GET - list of users;
 - /api/git_users/{id} - GET - concrete user;
 - /api/git_users/{ID} - PUT - update user;
 - /api/git_users - POST - create user;
 - /api/git_users - DELETE - delete users, but I disabled access for this action. It's available onl from admin panel.
 
Git user entity contain next fields:
 - github_user_id - id from github user;)
 - login - from github;
 - node_id - description string field;
 - image_path - github user avatar;
 - description - it's not github field, it belongs to admin panel.