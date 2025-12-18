# Агроблог - WordPress Templates & Import

## Описание
Кастомные шаблоны для Агроблога, полностью соответствующие оригинальному дизайну Bitrix24.

## Созданные файлы

### Шаблоны (в `/wp-content/themes/tex-k/`)

| Файл | Назначение |
|------|------------|
| `template-agroblog.php` | Шаблон страницы архива блога (Template Name: Агроблог) |
| `single.php` | Шаблон отдельной статьи блога |
| `archive.php` | Шаблон архива категорий/тегов блога |
| `home.php` | Шаблон главной страницы записей |
| `index.php` | Основной шаблон для записей |

### Стили (в `/wp-content/themes/tex-k/assets/css/`)

| Файл | Назначение |
|------|------------|
| `blog.css` | Все стили для страниц блога |

### Изображения (в `/wp-content/themes/tex-k/assets/images/blog/`)

Скопированы из оригинальной темы Bitrix:
- `blog_first_bg.jpg/webp` - фон баннера архива блога
- `article_first_bg.jpg/webp` - фон баннера статьи
- `blog-item__image.jpg/webp` - placeholder для карточек
- Иконки: `idea.svg`, `newspaper.svg`, `student.svg`, `video-camera.svg`

## Дизайн

### Архив блога (Агроблог)
- Баннер с заголовком "Агроблог" на синем фоне
- Сетка карточек блога (3 колонки на desktop, 2 на tablet, 1 на mobile)
- Карточка содержит: изображение, дату, заголовок, ссылку "Детальніше"
- Пагинация внизу страницы

### Страница статьи
- Баннер с заголовком статьи на затемнённом фоне
- Контент статьи по центру (8 колонок из 12)
- Секция "Читайте також" с похожими статьями

## Как использовать

### Вариант 1: Страница с шаблоном
1. Создайте страницу в WordPress `/novosti-sobytiya/`
2. В атрибутах страницы выберите шаблон "Агроблог"
3. Сохраните страницу

### Вариант 2: Настройка постоянных ссылок
1. Перейдите в Settings → Permalinks
2. Установите структуру: `/%postname%/`
3. Записи будут использовать шаблоны `single.php`, `archive.php`, `home.php`

### Вариант 3: Страница записей
1. Settings → Reading
2. Выберите "A static page" для Homepage displays
3. В Posts page выберите страницу "Агроблог"

## Импорт блога из Bitrix

### Через веб-интерфейс
1. Откройте `http://localhost/import/bitrix/web-import.php`
2. Войдите как администратор WordPress
3. Выберите iblock "9 - Блог (Агроблог)"
4. Отметьте "Blog posts"
5. Нажмите "Start Import"

### Через CLI
```bash
cd c:/WORK/xam/htdocs
php import/bitrix/import.php --blog --iblock=9
```

## Файлы конфигурации

В `import/bitrix/config.php`:
```php
define('IBLOCK_BLOG', 9);  // Blog (Агроблог)
```

## Соответствие дизайну Bitrix24

### Классы CSS (оригинал → WordPress)
- `.inner-page-banner` - баннер на внутренних страницах
- `.section__titles--bg-blue` - заголовок с синим фоном
- `.blog-item` - карточка статьи блога
- `.blog-item__image-inner` - обёртка изображения
- `.blog-item__date` - дата публикации
- `.blog-item__title` - заголовок статьи
- `.blog-item__read-more` - ссылка "Детальніше"
- `.article-content` - контент статьи
- `.section_grey` - серая секция "Читайте також"
- `.pagenavigation` - пагинация

## Адаптивность

| Breakpoint | Колонки | Описание |
|------------|---------|----------|
| > 991px | 3 колонки | Desktop |
| 768-991px | 2 колонки | Tablet |
| < 768px | 1 колонка | Mobile |

## SEO

Шаблоны поддерживают:
- Yoast SEO meta fields
- Open Graph tags
- Canonical URLs
- Breadcrumbs (если включены)

## Связанные файлы Bitrix

Оригинальные шаблоны находятся в:
```
bitrix_original/kdteam/components/bitrix/news.list/kdteam_agroblog_page/template.php
bitrix_original/kdteam/components/bitrix/news.detail/kdteam_news_detail/template.php
bitrix_original/kdteam/web-pages/desktop/blog/blog.min.css
```
