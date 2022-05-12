# Blog PHP

## Database setup
```SQL
CREATE TABLE account(
    username varchar(50) NOT NULL, 
    password varchar(50) NOT NULL,
    PRIMARY KEY (username)
);

CREATE TABLE blogpost(
    postTime datetime,
    poster varchar(50) NOT NULL,
    content varchar(1000) NOT NULL,
    PRIMARY KEY (postTime, poster),
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
|Request|Response|
|-|-|
|`GET /api/accounts/`|gets all accounts|
|`GET /api/account/user/`|gets account with username=*user*|
|`POST /api/accounts/ username="user" pass="pass"`|creates account with username=*user* and password=*pass*|
|`DELETE /api/account/user/`|deletes account with username=*user*|