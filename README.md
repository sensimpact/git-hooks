Создать или скопировать файл `.git/hooks/commit-msg` со следующим содержимым:
```shell
#!/bin/bash
message=`cat $1`
php -f commit-msg.php -- "commit-text=${message}"
```

Файл нужно сделать исполняемым ` chmod +x .git/hooks/commit-msg`

Скопировать файл `commit-msg.php` в корень вашего репозитория если его там нет
