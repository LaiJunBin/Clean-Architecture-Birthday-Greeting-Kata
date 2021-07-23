# Clean-Architecture-Birthday-Greeting-Kata

## Skill
* Framework: Laravel
* Database: Mysql + MongoDB
* Deploy: Heroku
* Other: CircleCI, PHPUnit

---
## Database init records:
> iota 為任一整數 n

id | first_name  | last_name | gender | date_of_birthday | email
------|-----|-----|----|----|----
iota|Robert|Yen|Male|1975/8/8|robert.yen@linecorp.com
iota+1|Cid|Change|Male|1990/10/10|cid.change@linecorp.com
iota+2|Miki|Lai|Female|1993/4/5|miki.lai@linecorp.com
iota+3|Sherry|Chen|Female|1993/8/8|sherry.lai@linecorp.com
iota+4|Peter|Wang|Male|1950/12/22|peter.wang@linecorp.com

---
## Main Endpoint

ServerUrl: https://birthday-greeting-kata.herokuapp.com

Method | URI  | Action | Default Response Type
------|-----|-----|-----
GET | /api/members      | Get all members. | json
POST     | /api/members      | Create a member. | json
DELETE   | /api/members/{id} | Delete a member. | json
GET | /api/versions/1   | Version 1 | text
GET | /api/versions/2   | Version 2 | text
GET | /api/versions/3   | Version 3 | text
GET | /api/versions/4-1 | Version 4-1 | text
GET | /api/versions/5   | Version 5 | text

每個 `version` 都有屬於自己的分支，而 `main` 分支整合了除了 `version 4-2` (使用另一個資料庫外)，額外加入了對 `members` 的 `CRD`，方便測試使用。

> CRD: Create, Read, Delete

<b>注意</b>: `members` 與 `version 5` 相關的 `api` ，可以設定回傳格式，透過以下其中一種方式：
* GET params: ?format=(text|json|xml)
* headers: Accept: (text/plain|application/json|application/xml)

<b>* `headers` 優先權大於 `GET params`</b>
<b>* `member` 優先權大於 `GET params`</b>

---
## Example

### Get all members.

> 基本使用方式
```json
Request:
    Method: GET
    Endpoint: /api/members

Response:
{
    "data": [
        {
            "id": 1,
            "first_name": "Robert",
            "last_name": "Yen",
            "gender": "Male",
            "date_of_birthday": "1975-08-08",
            "email": "robert.yen@linecorp.com",
            "created_at": "2021-07-23T18:01:38.000000Z",
            "updated_at": "2021-07-23T18:01:38.000000Z"
        },
        {
            "id": 2,
            "first_name": "Cid",
            "last_name": "Change",
            "gender": "Male",
            "date_of_birthday": "1990-10-10",
            "email": "cid.change@linecorp.com",
            "created_at": "2021-07-23T18:01:38.000000Z",
            "updated_at": "2021-07-23T18:01:38.000000Z"
        },
        {
            "id": 3,
            "first_name": "Miki",
            "last_name": "Lai",
            "gender": "Female",
            "date_of_birthday": "1993-04-05",
            "email": "miki.lai@linecorp.com",
            "created_at": "2021-07-23T18:01:38.000000Z",
            "updated_at": "2021-07-23T18:01:38.000000Z"
        },
        {
            "id": 4,
            "first_name": "Sherry",
            "last_name": "Chen",
            "gender": "Female",
            "date_of_birthday": "1993-08-08",
            "email": "sherry.lai@linecorp.com",
            "created_at": "2021-07-23T18:01:38.000000Z",
            "updated_at": "2021-07-23T18:01:38.000000Z"
        },
        {
            "id": 5,
            "first_name": "Peter",
            "last_name": "Wang",
            "gender": "Male",
            "date_of_birthday": "1950-12-22",
            "email": "peter.wang@linecorp.com",
            "created_at": "2021-07-23T18:01:38.000000Z",
            "updated_at": "2021-07-23T18:01:38.000000Z"
        }
    ]
}
```

> 修改回傳格式 XML
```xml
Request:
    Method: GET
    Endpoint: /api/members
    Headers:
        Accept: application/xml

Response:
<?xml version="1.0" encoding="UTF-8"?>
<root>
    <data>
        <wrapper>
            <id>1</id>
            <first_name>Robert</first_name>
            <last_name>Yen</last_name>
            <gender>Male</gender>
            <date_of_birthday>1975-08-08</date_of_birthday>
            <email>robert.yen@linecorp.com</email>
            <created_at>2021-07-23T18:01:38.000000Z</created_at>
            <updated_at>2021-07-23T18:01:38.000000Z</updated_at>
        </wrapper>
        <wrapper>
            <id>2</id>
            <first_name>Cid</first_name>
            <last_name>Change</last_name>
            <gender>Male</gender>
            <date_of_birthday>1990-10-10</date_of_birthday>
            <email>cid.change@linecorp.com</email>
            <created_at>2021-07-23T18:01:38.000000Z</created_at>
            <updated_at>2021-07-23T18:01:38.000000Z</updated_at>
        </wrapper>
        <wrapper>
            <id>3</id>
            <first_name>Miki</first_name>
            <last_name>Lai</last_name>
            <gender>Female</gender>
            <date_of_birthday>1993-04-05</date_of_birthday>
            <email>miki.lai@linecorp.com</email>
            <created_at>2021-07-23T18:01:38.000000Z</created_at>
            <updated_at>2021-07-23T18:01:38.000000Z</updated_at>
        </wrapper>
        <wrapper>
            <id>4</id>
            <first_name>Sherry</first_name>
            <last_name>Chen</last_name>
            <gender>Female</gender>
            <date_of_birthday>1993-08-08</date_of_birthday>
            <email>sherry.lai@linecorp.com</email>
            <created_at>2021-07-23T18:01:38.000000Z</created_at>
            <updated_at>2021-07-23T18:01:38.000000Z</updated_at>
        </wrapper>
        <wrapper>
            <id>5</id>
            <first_name>Peter</first_name>
            <last_name>Wang</last_name>
            <gender>Male</gender>
            <date_of_birthday>1950-12-22</date_of_birthday>
            <email>peter.wang@linecorp.com</email>
            <created_at>2021-07-23T18:01:38.000000Z</created_at>
            <updated_at>2021-07-23T18:01:38.000000Z</updated_at>
        </wrapper>
    </data>
</root>
```

> 修改回傳格式 Text
```text
Request:
    Method: GET
    Endpoint: /api/members?format=text

Response:
1
Robert
Yen
Male
1975-08-08
robert.yen@linecorp.com
2021-07-23T18:01:38.000000Z
2021-07-23T18:01:38.000000Z
2
Cid
Change
Male
1990-10-10
cid.change@linecorp.com
2021-07-23T18:01:38.000000Z
2021-07-23T18:01:38.000000Z
3
Miki
Lai
Female
1993-04-05
miki.lai@linecorp.com
2021-07-23T18:01:38.000000Z
2021-07-23T18:01:38.000000Z
4
Sherry
Chen
Female
1993-08-08
sherry.lai@linecorp.com
2021-07-23T18:01:38.000000Z
2021-07-23T18:01:38.000000Z
5
Peter
Wang
Male
1950-12-22
peter.wang@linecorp.com
2021-07-23T18:01:38.000000Z
2021-07-23T18:01:38.000000Z
```

---

### Create a member.

```json
Request:
    Method: POST
    Endpoint: /api/members
    Payload: {
        "first_name": "User",
        "last_name": "Test",
        "gender": "Male",
        "date_of_birthday": "1944/7/24",
        "email": "testuser@test.com"
    }
Response:
{
    "id": 6
}
```

### Create a member but duplicate email.

```json
Request:
    Method: POST
    Endpoint: /api/members
    Payload: {
        "first_name": "User",
        "last_name": "Test",
        "gender": "Male",
        "date_of_birthday": "1944/7/24",
        "email": "testuser@test.com"
    }

Response:
{
    "email": [
        "The email has already been taken."
    ]
}
```

--- 

### Delete a member

```json
Request:
    Method: DELETE
    Endpoint: /api/members/{id}
 
Response:
// success
{
    "data": true
}
---
// not found.
{
    "message": "The member not found."
}

```

---
### Version 1

```text
Request:
    Method: GET
    Endpoint: /api/versions/1
 
Response:
// success
Subject: Happy birthday!
Happy birthday, dear User!
---
// not found.
No results.

```

### Version 2

```text
Request:
    Method: GET
    Endpoint: /api/versions/2
 
Response:
Male
Subject: Happy birthday!
Happy birthday, dear User!
We offer special discount 20% off for the following items:
White Wine, iPhone X

Female
No results.
```


### Version 3

```text
Request:
    Method: GET
    Endpoint: /api/versions/3
 
Response:
Subject: Happy birthday!
Happy birthday, dear `User`!
<img src='https://picsum.photos/200' alt='Greeting Elder Picture'>
```

### Version 4-1

```text
Request:
    Method: GET
    Endpoint: /api/versions/4-1
 
Response:
Subject: Happy birthday!
Happy birthday, dear Test, User!
```


### Version 4-2

<b>*注意: 4-2 API僅在分支 version-4-2 可以使用，資料庫改使用MongoDB。</b>

```text
Request:
    Method: GET
    Endpoint: /api/versions/4-2
 
Response:
Subject: Happy birthday!
Happy birthday, dear Test, User!
```


### Version 5

預設格式: Text

```text
Request:
    Method: GET
    Endpoint: /api/versions/5
 
Response:
Subject: Happy birthday!
Happy birthday, dear User!
```

使用格式: json

```json
Request:
    Method: GET
    Endpoint: /api/versions/5?format=json
 
Response:
[
    {
        "title": "Subject: Happy birthday!",
        "content": "Happy birthday, dear User!"
    }
]
```

使用格式: xml

```xml
Request:
    Method: GET
    Endpoint: /api/versions/5?format=xml
 
Response:
<?xml version="1.0" encoding="UTF-8"?>
<root>
    <wrapper>
        <title>Subject: Happy birthday!</title>
        <content>Happy birthday, dear User!</content>
    </wrapper>
</root>
```