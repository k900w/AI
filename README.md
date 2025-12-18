# TEX-K WordPress Theme

Кастомная тема WordPress для сайта TEX-K - сільгосптехніка KUHN.

## Установка

1. Скопируйте папку темы `tex-k` в `wp-content/themes/`
2. Активируйте тему в админ-панели WordPress: Внешний вид → Темы
3. Установите плагин Advanced Custom Fields (ACF) Pro
4. Импортируйте ACF JSON конфигурацию из папки `acf-json/`

## Структура темы

```
tex-k/
├── assets/
│   ├── css/          # Стили
│   ├── js/           # JavaScript файлы
│   ├── images/       # Изображения
│   └── fonts/        # Шрифты
├── acf-json/         # ACF JSON конфигурация
├── template-parts/   # Части шаблонов
├── style.css         # Основной файл темы
├── functions.php     # Функции темы
├── header.php        # Шапка сайта
├── footer.php        # Подвал сайта
├── front-page.php    # Главная страница
├── index.php         # Основной шаблон
├── single-product.php # Шаблон товара
├── archive-product.php # Архив товаров
└── taxonomy-product_category.php # Шаблон категории
```

## Импорт данных из Битрикс

1. Настройте параметры подключения к БД Битрикс в файле `import-bitrix-to-wp.php`
2. Откройте файл в браузере: `http://ваш-сайт.com/import-bitrix-to-wp.php`
3. Нажмите кнопку "Начать импорт"

## Настройка меню

Создайте меню в админ-панели:
- Внешний вид → Меню
- Создайте меню и назначьте его в:
  - Primary Menu (главное меню)
  - Top Menu (верхнее меню)
  - Footer Menu (меню в подвале)

## Кастомные поля (ACF)

Тема использует следующие группы полей:

1. **Поля товара** (`group_product.json`)
   - Ціна (product_price)
   - Валюта (product_currency)
   - Артикул (product_sku)
   - Характеристики (product_characteristics)
   - Галерея (product_gallery)
   - Документи (product_documents)

2. **Поля главной страницы** (`group_home_page.json`)
   - Баннеры слайдера (home_banners)
   - Переваги (advantages)
   - О компании (about_*)

3. **Поля категории товара** (`group_product_category.json`)
   - Изображение категории (category_image)
   - Фоновое изображение (category_background)
   - Иконка (category_icon)

## Копирование ресурсов

Скопируйте следующие файлы из `tex-k.com.ua/`:

1. **Шрифты**: `local/templates/kdteam/fonts/` → `assets/fonts/`
2. **Изображения**: `local/templates/kdteam/images/` → `assets/images/`
3. **JavaScript**: `local/templates/kdteam/js/` → `assets/js/`

## Требования

- WordPress 5.0+
- PHP 7.4+
- Advanced Custom Fields Pro
- WooCommerce (опционально, для корзины)

## Поддержка

При возникновении проблем проверьте:
1. Активирована ли тема
2. Установлен ли плагин ACF
3. Правильно ли настроены меню
4. Скопированы ли все ресурсы (шрифты, изображения)




