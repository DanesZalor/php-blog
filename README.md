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
|**`/api/account/`**||
|`GET /api/account/ username=""`|gets account with username=*param*|
|<sub>requires BasicAuth</sub><br>`DELETE /api/account/`|deletes authenticated account|
||||
|**`/api/accounts/`**||
|`GET /api/accounts/`|gets all accounts' usernames|
|`POST /api/accounts/ username="" pass="" confirmPass=""`|creates account with the body credentials|
|||
|**`/api/blogpost/`**||
|`GET /api/blogpost/ id=""`|gets blogpost details of blogpost with id=*id*|
|<sub>requires BasicAuth, Owner</sub><br>`DELETE /api/blogpost/ id=""`|deletes blogpost with id=*id*|
|||
|**`/api/blogposts/`**||
|`GET /api/blogposts/`|gets all blogposts|
|`GET /api/blogposts/ fromAuthor=`|gets all blogposts from *fromAuthor*|
|<sub>requires BasicAuth</sub><br>`POST /api/blogposts/ content=""`|creates a blogpost with<br>poster=*auth_user* and<br>content=*content*|

## Running
Host `src/`