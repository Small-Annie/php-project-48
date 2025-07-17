### Hexlet tests and linter status:
[![Actions Status](https://github.com/Small-Annie/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Small-Annie/php-project-48/actions)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Small-Annie_php-project-48&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=Small-Annie_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Small-Annie_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=Small-Annie_php-project-48)

# Описание

"Вычислитель отличий" – программа, определяющая разницу между двумя структурами данных. Это популярная задача, для решения которой существует множество онлайн-сервисов, например: http://www.jsondiff.com/. Подобный механизм используется при выводе тестов или при автоматическом отслеживании изменении в конфигурационных файлах.

Возможности утилиты:

* Поддержка разных входных форматов: yaml и json
* Генерация отчета в виде stylish (по умолчанию), plain text и json

# Description

"Generate Diff" is a program that generates a diff between two data structures. This is a common task, and many online services, such as http://www.jsondiff.com/, offer similar functionality. The tool is useful for displaying test results or automatically tracking changes in configuration files.

Features of the utility:

* Supports multiple input formats: YAML and JSON
* Generates a report in stylish (default), plain text, and JSON formats
# Требования \ Requirements

* Mac / Linux
* Php ^8.3
* Composer

# Установка

```
// to install dependencies
make install
```

# Запуск 

Generate diff for JSON files (flat arrays)
[![asciicast](https://asciinema.org/a/5kqr8nqR0ivqbWVhmHkxaUjDF.svg)](https://asciinema.org/a/5kqr8nqR0ivqbWVhmHkxaUjDF)

Generate diff for YAML files (flat arrays)
[![asciicast](https://asciinema.org/a/jak30kQ4amtS4PHox4JAapn84.svg)](https://asciinema.org/a/jak30kQ4amtS4PHox4JAapn84)

Generate diff for JSON and YAML files (nested arrays)
[![asciicast](https://asciinema.org/a/D5FFtYBao7L3sF7NzlUkQM6Pi.svg)](https://asciinema.org/a/D5FFtYBao7L3sF7NzlUkQM6Pi)

### License

MIT