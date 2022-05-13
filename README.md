# Blog PHP

## Database setup
```SQL
CREATE TABLE account(
    username varchar(50) NOT NULL, 
    password varchar(50) NOT NULL,
    PRIMARY KEY (username)
);

CREATE TABLE blogpost(
    id SERIAL,
    postTime timestamp,
    poster varchar(50) NOT NULL,
    content varchar(1000) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (poster) REFERENCES account(username)
);
```
> for postgres, just change datetime to timestamp

> for the sake of simplicity, we store the password in the database but pls don't

## Database queries
#### Insert account
```SQL
INSERT INTO account (username, password) 
    VALUES ( "","" );
```

> for postgres; use ' instead of "

#### Insert Blog
```SQL
INSERT INTO blogpost (poster, content, postTime) 
    VALUES ( "", "", "yyyy-mm-dd hh:mm:ss" );
```

#### View Blog Feed
```SQL
SELECT * FROM php_blog.blogpost 
    ORDER BY postTime DESC;
```

## API Endpoints
|||
|-|-|
|**account**||
|`GET /api/accounts/`|gets all accounts' usernames|
|`GET /api/account/user/`|gets account with username=*user*|
|`POST /api/accounts/ username="user" pass="pass" confirmpass="pass"`|creates account with username=*user* and password=*pass*|
|<sub>requires BasicAuth</sub><br>`DELETE /api/account/`|deletes authenticated account|
|||
|**blogpost**||
|`GET /api/blogposts/`|gets all blogposts|
|`GET /api/blogposts/user/`|gets all blogposts from user|
|<sub>requires BasicAuth</sub><br>`POST /api/blogposts/ content=""`|creates a blogpost with<br>poster=*author* and<br>content=*content*|