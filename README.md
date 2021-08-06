Yii 2 Test Project
---

Installation:
```

composer install
./yii migrate

```


Usage
---

Yii 2.0 default URL endpoints, like:

```
GET https://yii2-test-project.test/api/tasks
POST https://yii2-test-project.test/api/tasks
PUT https://yii2-test-project.test/api/tasks/1
DELETE https://yii2-test-project.test/api/tasks/1

GET https://yii2-test-project.test/api/tasks?user_id=102
```

Use JSON for POST/PATCH requests.

User IDs are: 1, 101, 102 (see app\models\User class)
