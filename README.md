### Hexlet tests and linter status:
[![Actions Status](https://github.com/Small-Annie/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Small-Annie/php-project-48/actions)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Small-Annie_php-project-48&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=Small-Annie_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Small-Annie_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=Small-Annie_php-project-48)

# Описание

"Вычислитель отличий" – программа, определяющая разницу между двумя структурами данных.

Возможности CLI утилиты:

* Поддержка разных входных форматов: YAML и JSON
* Генерация отчёта в виде stylish (по умолчанию), plain text и JSON

# Description

"Differ" is a program that generates a diff between two data structures.

Features of the CLI utility:

* Supports multiple input formats: YAML and JSON
* Generates a report in stylish (default), plain text, and JSON formats

# Требования \ Requirements

* Mac / Linux
* Php ^8.3
* Composer
* Make
* Xdebug (требуется для генерации отчёта покрытия тестов)

# Установка и настройка \ Installation and setup

```
git clone git@github.com:Small-Annie/php-project-48.git
cd php-project-48

make install
```

# Примеры использования \ Usage examples

Generate diff for JSON files in stylish format (flat arrays)
[![asciicast](https://asciinema.org/a/5kqr8nqR0ivqbWVhmHkxaUjDF.svg)](https://asciinema.org/a/5kqr8nqR0ivqbWVhmHkxaUjDF)

Generate diff for YAML files in stylish format (flat arrays)
[![asciicast](https://asciinema.org/a/jak30kQ4amtS4PHox4JAapn84.svg)](https://asciinema.org/a/jak30kQ4amtS4PHox4JAapn84)

Generate diff for JSON and YAML files in stylish format (nested arrays)
[![asciicast](https://asciinema.org/a/D5FFtYBao7L3sF7NzlUkQM6Pi.svg)](https://asciinema.org/a/D5FFtYBao7L3sF7NzlUkQM6Pi)

Generate diff for JSON and YAML files in plain text format
[![asciicast](https://asciinema.org/a/TyLyCVBDIOMnl9UTHZl1Zlslk.svg)](https://asciinema.org/a/TyLyCVBDIOMnl9UTHZl1Zlslk)

Generate diff for JSON and YAML files in JSON format
[![asciicast](https://asciinema.org/a/HOjjzFEX3cVIetODF8zFW6KFT.svg)](https://asciinema.org/a/HOjjzFEX3cVIetODF8zFW6KFT)

### License

MIT