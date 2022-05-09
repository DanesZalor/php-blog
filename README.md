# Blog PHP

## Database setup
```SQL
CREATE TABLE account(
    username varchar(50), 
    password varchar(50),
    PRIMARY KEY (username)
);

CREATE TABLE blogpost(
    postTime datetime,
    poster varchar(50),
    content varchar(1000),
    PRIMARY KEY (postTime, poster)
);
```

> for the sake of simplicity, we store the password in the database but pls don't

## Database queries
#### Insert account
```SQL
INSERT INTO account (username, password) 
    VALUES ( "","" );
```

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