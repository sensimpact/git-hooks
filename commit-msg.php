<?php
$sCommitText = str_replace('commit-text=', '', $argv[1]); // Текст коммита

// Проверка направления
$arDirections = ['TS', 'HR', 'TK', 'BP', 'CR', 'ID', 'MP', 'CP', 'EC', 'OR'];
$sDirections = implode('|', $arDirections);
preg_match("/^($sDirections)[#|\.]/", $sCommitText, $arMatches);
if (empty($arMatches) or !in_array($arMatches[1], $arDirections)):
  echo "Направление указано неверно!\n";
  echo "Возможные направления: $sDirections\n";
  echo "Формат коммита: DR#taskId. type: Commit text";
  exit(1);
endif;

// Узнаем нужно ли указывать ID задачи
preg_match('/\s(breaking|feat):/', $sCommitText, $arMatches);
$bNeedTaskId = (!empty($arMatches));

// Проверка типов коммита
$arTypes = ['breaking', 'feat', 'fix', 'refactor', 'config', 'docs'];
$sTypes = implode('|', $arTypes);
preg_match("/\s($sTypes):/", $sCommitText, $arMatches);
if (empty($arMatches)):
  echo "Тип коммита указан неверно!\n";
  echo "Возможные типы: $sTypes\n";
  echo "Формат коммита: DR#taskId. type: Commit text";
  exit(2);
endif;

// Проверка задачи
preg_match('/#(\d+).\s/', $sCommitText, $arMatches);
if ($bNeedTaskId and (empty($arMatches) or empty((int)$arMatches[1]))):
  echo "Неверно указан номер задачи\n";
  echo "Формат коммита: DR#taskId. type: Commit text";
  exit(3);
endif;

// Проверка количества символов
if (mb_strlen($sCommitText,'UTF-8') > 72):
  echo "Количество символов в коммите более 72";
  exit(4);
endif;

// Проверка написания текста коммита с большой буквы
preg_match('/:\s(.)/u', $sCommitText, $arMatches);
if (empty((int)$arMatches[1]) and $arMatches[1] != mb_strtoupper($arMatches[1])):
  echo "Первая буква коммита не является заглавной";
  exit(5);
endif;

// Проверка текста коммита на пустоту
preg_match('/:\s(.+)/u', $sCommitText, $arMatches);
if (empty($arMatches) or empty(trim($arMatches[1]))):
  echo "Не указан текст коммита";
  exit(6);
endif;
