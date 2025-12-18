<?php
/**
 * WooCommerce Category Template
 * Работает с кастомной таксономий product_category
 *
 * @package TEX-K
 */

get_header();

// Получаем текущий термин
$current_term = get_queried_object();

// Определяем таксономию и термин
$taxonomy = $current_term->taxonomy;
$term = $current_term;

// Если это product_cat, ищем соответствующий термин в product_category
if ($taxonomy === 'product_cat') {
    $product_category_term = get_term_by('slug', $current_term->slug, 'product_category');
    if ($product_category_term) {
        $taxonomy = 'product_category';
        $term = $product_category_term;
    }
}
?>
<style>
    .product-card__price {
        display: none !important;   
        
    }
    
    /* Стили для поиска по товарам */
    .products-search {
        max-width: 600px;
        margin: 30px 0 20px;
    }
    
    .products-search__form {
        width: 100%;
    }
    
    .products-search__wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .products-search__input {
        width: 100%;
        padding: 12px 50px 12px 16px;
        border: 2px solid #e30f1b;
        border-radius: 4px;
        font-size: 16px;
        outline: none;
        transition: all 0.3s ease;
    }
    
    .products-search__input:focus,
    .products-search__input.has-text {
        padding: 10px 45px 10px 14px;
        font-size: 15px;
    }
    
    .products-search__input:focus {
        border-color: #c00e18;
        box-shadow: 0 0 0 3px rgba(227, 15, 27, 0.1);
    }
    
    .products-search__input::placeholder {
        color: #999;
    }
    
    .products-search__hint {
        font-size: 12px;
        color: #666;
        margin-top: 8px;
        display: block;
    }
    
    .products-search__button {
        position: absolute;
        right: 8px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e30f1b;
        transition: color 0.3s ease;
    }
    
    .products-search__button:hover {
        color: #c00e18;
    }
    
    .products-search__button svg {
        width: 20px;
        height: 20px;
    }
    
    /* Скрытие товаров при поиске */
    .product-card.hidden {
        display: none;
    }
    
    .products-empty-search {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }
    
    .products-empty-search__text {
        font-size: 18px;
        margin: 0;
    }
    
    /* Стили для фильтра категории техника */
    .filter-caterory-wrap {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 4px;
        margin: 30px 0 20px;
    }
    
    .category_filter-wrap {
        width: 100%;
    }
    
    .select-with-label {
        display: flex;
        flex-direction: column;
    }
    
    .select-with-label label {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }
    
    .select {
        position: relative;
        width: 100%;
    }
    
    .select-styled {
        background: #fff;
        padding: 12px 40px 12px 16px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        position: relative;
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
        min-height: 44px;
        display: flex;
        align-items: center;
    }
    
    .select-styled::after {
        content: '';
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%) rotate(0deg);
        border: 6px solid transparent;
        border-top-color: #e30f1b;
        transition: 0.3s;
    }
    
    .select.active .select-styled::after {
        transform: translateY(-50%) rotate(180deg);
    }
    
    .select-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 10;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-top: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: none;
        border-radius: 0 0 4px 4px;
        max-height: 300px;
        overflow-y: auto;
    }
    
    .select.active .select-options {
        display: block;
    }
    
    .select-options li {
        padding: 12px 16px;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .select-options li:hover {
        background: #f5f5f5;
    }
    
    .select-options li.active {
        background-color: #fafafa;
        font-weight: 500;
    }
    
    .select-hidden {
        display: none;
    }
    
    .filter-category__btn {
        background: #e0e0e0;
        color: #333;
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s ease;
        margin-bottom: 10px;
    }
    
    .filter-category__btn:hover {
        background: #d0d0d0;
    }
    
    .refresh {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: #333;
        font-size: 14px;
        transition: color 0.3s ease;
    }
    
    .refresh:hover {
        color: #e30f1b;
    }
    
    .refresh__icon--white {
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .refresh__icon--white svg {
        width: 16px;
        height: 16px;
        fill: #e30f1b;
    }
    
    .refresh__text {
        font-size: 14px;
    }
    
    .align-self-center {
        align-self: center;
    }
    
    /* Стили для слайдера товаров техники */
    .category-products-slider {
        margin: 20px 0;
    }
    
    .category__item_slider_item {
        position: relative;
    }
    
    .category__item_slider_item img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .category__item_slider_item a {
        display: block;
    }
    
    .category__item_slider_item--placeholder {
        width: 100%;
        height: 300px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }
    
    .category__item_slider_item--placeholder svg {
        width: 64px;
        height: 64px;
        color: #ccc;
    }
    
    .owl-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        display: flex;
        justify-content: space-between;
        pointer-events: none;
    }
    
    .owl-nav-prev,
    .owl-nav-next {
        pointer-events: all;
        width: 40px;
        height: 40px;
        background: #e30f1b;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        cursor: pointer;
        font-size: 24px;
        line-height: 1;
        transition: background 0.3s ease;
    }
    
    .owl-nav-prev:hover,
    .owl-nav-next:hover {
        background: #c00e18;
    }
    
    .owl-nav-prev {
        left: -20px;
    }
    
    .owl-nav-next {
        right: -20px;
    }

  .section--category-header {
    padding: 0;
}

.category-header {
    width: 100vw;
    margin-left: calc(-50vw + 50%);
    background-size: cover;
    background-position: center;
    position: relative;
    min-height: 320px;
    padding: 40px 0;
}

.category-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
}
    .category-header__title {
    color: #fff;
    background-color: #e30f1b;
    padding-left: .5rem;
    padding-right: .5rem;
    max-width: 468px;
    font-family: "Proxima Nova Th", sans-serif !important;
    font-size: 41px;
}

.category-header__title,
.category-header__description {
    position: relative;
    color: #fff;
}
.main-wrap {
margin-top:134px;
}
.category-header__description {
    max-width: 500px;
}
</style>

<?php
$category_bg = get_field('category_background', $taxonomy . '_' . $term->term_id);

// если ACF Image возвращает массив
$category_bg_url = is_array($category_bg) ? $category_bg['url'] : $category_bg;
?>
<section class="section section--category-header">

    <div class="category-header"
        <?php if ($category_bg_url) : ?>
            style="background-image: url('<?php echo esc_url($category_bg_url); ?>');"
        <?php endif; ?>
    >
    <div class="container">
    <!-- Хлебные крошки -->
    <nav class="breadcrumbs-category">
        <a href="<?php echo esc_url(home_url('/')); ?>">Головна</a>
        <span>›</span>
        <?php
        // Получаем родительские категории
        $ancestors = get_ancestors($term->term_id, $taxonomy);
        $ancestors = array_reverse($ancestors);
        foreach ($ancestors as $ancestor_id) {
            $ancestor = get_term($ancestor_id, $taxonomy);
            if ($ancestor) {
                $term_link = get_term_link($ancestor, $taxonomy);
                echo '<a href="' . esc_url($term_link) . '">' . esc_html($ancestor->name) . '</a>';
                echo '<span>›</span>';
            }
        }
        ?>
        <span class="current"><?php echo esc_html($term->name); ?></span>
    </nav>
</div>
        <div class="container">
            <h1 class="category-header__title">
                <?php echo esc_html($term->name); ?>
            </h1>

            <?php if ($term->description) : ?>
                <div class="category-header__description">
                    <?php echo esc_html($term->description); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>
<style>
/* ===== CATALOG SUBCATEGORIES ===== */
.catalog-subcats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 60px 40px;
    margin-top: 30px;
}

/* item */
.catalog-subcats__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #000;
}

/* image */
.catalog-subcats__image-wrap {
    width: 100%;
    height: 170px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
}

.catalog-subcats__image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

/* hover image */
.catalog-subcats__item:hover .catalog-subcats__image {
    transform: translateY(-6px);
}

/* title row */
.catalog-subcats__title-wrap {
    display: inline-flex;
    align-items: flex-start;
    gap: 12px;
    align-content: flex-start;
}
/* title */
.catalog-subcats__title {
    font-size: 16px;
    font-weight: 500;
    line-height: 1.3;
}

/* arrow */
.catalog-subcats__arrow {
    width: 16px;
    height: 16px;
    border: 1px solid #e30f1b;
    border-radius: 50%;
    color: #e30f1b;
    font-size: 14px;
    padding: 3px;
    font-weight: 200;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

/* === Черно-белые изображения подкатегорий === */
.catalog-subcats__image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;

    /* ЧБ по умолчанию */
    filter: grayscale(100%);
    transition: 
        filter 0.35s ease,
        transform 0.3s ease;
}

/* Цвет при наведении */
.catalog-subcats__item:hover .catalog-subcats__image {
    filter: grayscale(0%);
    transform: translateY(-6px);
}

/* hover arrow */
.catalog-subcats__item:hover .catalog-subcats__arrow {
    background: #e30f1b;
    color: #fff;
}
@media (max-width: 1200px) {
    .catalog-subcats {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .catalog-subcats {
        grid-template-columns: repeat(2, 1fr);
        gap: 40px 30px;
    }
}

@media (max-width: 480px) {
    .catalog-subcats {
        grid-template-columns: 1fr;
    }

    .catalog-subcats__image-wrap {
        height: 140px;
    }
}

</style>

<section class="section">
    <div class="container">
        <!-- Заголовок категории -->
        <?php
        // Получаем подкатегории
        $subcategories = get_terms(array(
            'taxonomy' => $taxonomy,
            'parent' => $term->term_id,
            'hide_empty' => false,
        ));

        if ($subcategories && !is_wp_error($subcategories) && count($subcategories) > 0) :
            ?>
      <h2 class="section__subtitle" style="margin-bottom: 20px;">Підкатегорії</h2>

<div class="catalog-subcats">
    <?php foreach ($subcategories as $subcat) :
        $category_image = get_field('category_image', $taxonomy . '_' . $subcat->term_id);
        $img_url = is_array($category_image) ? $category_image['url'] : $category_image;
    ?>
        <a href="<?php echo esc_url(get_term_link($subcat, $taxonomy)); ?>"
           class="catalog-subcats__item">

            <div class="catalog-subcats__image-wrap">
                <?php if ($img_url) : ?>
                    <img
                        src="<?php echo esc_url($img_url); ?>"
                        alt="<?php echo esc_attr($subcat->name); ?>"
                        class="catalog-subcats__image"
                        loading="lazy"
                    >
                <?php endif; ?>
            </div>

            <div class="catalog-subcats__title-wrap">
                <span class="catalog-subcats__title">
                    <?php echo esc_html($subcat->name); ?>
                </span>
                <span class="catalog-subcats__arrow">→</span>
            </div>

        </a>
    <?php endforeach; ?>
</div>




        <?php endif; ?>

        <?php
        // Вывод товаров категории
        if (have_posts()) :
            ?>
            <!-- Поиск по товарам -->
            <div class="products-search" style="margin: 30px 0 20px;">
                <form class="products-search__form" id="products-search-form">
                    <div class="products-search__wrapper">
                        <input 
                            type="text" 
                            class="products-search__input" 
                            id="products-search-input" 
                            placeholder="Название модели или артикул запчасти" 
                            autocomplete="off"
                        />
                        <button type="submit" class="products-search__button" aria-label="Поиск">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                            </svg>
                        </button>
                    </div>
                    <span class="products-search__hint">Введіть мінімум 3 символи для пошуку</span>
                </form>
            </div>
            
            <?php
            // Проверяем, является ли это категорией "техника" (по slug или названию)
            $is_technika = false;
            $term_slug = strtolower($term->slug);
            $term_name = strtolower($term->name);
            
            // Проверяем slug или название категории
            if (strpos($term_slug, 'technika') !== false || 
                strpos($term_slug, 'tehnika') !== false ||
                strpos($term_slug, 'tehn') !== false ||
                strpos($term_name, 'техника') !== false ||
                strpos($term_name, 'техніка') !== false ||
                strpos($term_name, 'техн') !== false) {
                $is_technika = true;
            } else {
                // Проверяем все родительские категории
                $ancestors = get_ancestors($term->term_id, $taxonomy);
                foreach ($ancestors as $ancestor_id) {
                    $ancestor = get_term($ancestor_id, $taxonomy);
                    if ($ancestor && !is_wp_error($ancestor)) {
                        $ancestor_slug = strtolower($ancestor->slug);
                        $ancestor_name = strtolower($ancestor->name);
                        if (strpos($ancestor_slug, 'technika') !== false || 
                            strpos($ancestor_slug, 'tehnika') !== false ||
                            strpos($ancestor_slug, 'tehn') !== false ||
                            strpos($ancestor_name, 'техника') !== false ||
                            strpos($ancestor_name, 'техніка') !== false ||
                            strpos($ancestor_name, 'техн') !== false) {
                            $is_technika = true;
                            break;
                        }
                    }
                }
            }
            
            // Показываем фильтр только для категории "техника"
            // Для отладки можно временно заменить на: if (true) :
            if ($is_technika) :
            ?>
            <!-- Фильтр для категории техника -->
            <form id="filter-category" class="filter-caterory-wrap filter-category" style="margin: 30px 0 20px;">
                <div class="wrap-cols">
                    <div class="col col--3 col--md-6 mb--sm-1 mb--md-1">
                        <div class="category_filter-wrap">
                            <div class="select-with-label">
                                <label for="MODEL1">Модель</label>
                                <div class="select">
                                    <select class="custom_select select-hidden" id="MODEL1" name="MODEL1">
                                        <option value="null">Не выбрано</option>
                                        <option value="diskovye">Дисковые</option>
                                        <option value="ankernye">Анкерные</option>
                                        <option value="seyalka-kultivator">Сеялка-культиватор</option>
                                    </select>
                                    <div class="select-styled">Не выбрано</div>
                                    <ul class="select-options" style="display: none;">
                                        <li rel="null">Не выбрано</li>
                                        <li rel="diskovye">Дисковые</li>
                                        <li rel="ankernye">Анкерные</li>
                                        <li rel="seyalka-kultivator">Сеялка-культиватор</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col--3 col--md-6 mb--sm-1 mb--md-1">
                        <div class="category_filter-wrap">
                            <div class="select-with-label">
                                <label for="TYPE">Тип</label>
                                <div class="select">
                                    <select class="custom_select select-hidden" id="TYPE" name="TYPE">
                                        <option value="null">Не выбрано</option>
                                        <option value="ovoshhnye">Овощные</option>
                                        <option value="propashnye-tochnogo-vyseva">Пропашные (Точного высева)</option>
                                        <option value="zernovye">Зерновые</option>
                                        <option value="sploshnogo-poseva-pryamogo-poseva">Сплошного посева (Прямого посева)</option>
                                        <option value="sternevye-noutilnye">Стерневые (Ноутильные)</option>
                                        <option value="sternevye">Стерневые</option>
                                    </select>
                                    <div class="select-styled">Не выбрано</div>
                                    <ul class="select-options" style="display: none;">
                                        <li rel="null">Не выбрано</li>
                                        <li rel="ovoshhnye">Овощные</li>
                                        <li rel="propashnye-tochnogo-vyseva">Пропашные (Точного высева)</li>
                                        <li rel="zernovye">Зерновые</li>
                                        <li rel="sploshnogo-poseva-pryamogo-poseva">Сплошного посева (Прямого посева)</li>
                                        <li rel="sternevye-noutilnye">Стерневые (Ноутильные)</li>
                                        <li rel="sternevye">Стерневые</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col--3 col--md-6 mb--sm-1 mb--md-1">
                        <div class="category_filter-wrap">
                            <div class="select-with-label">
                                <label for="AGREGATIROVANIE">Агрегатирование</label>
                                <div class="select">
                                    <select class="custom_select select-hidden" id="AGREGATIROVANIE" name="AGREGATIROVANIE">
                                        <option value="null">Не выбрано</option>
                                        <option value="navesnye">Навесные</option>
                                        <option value="priczepnye">Прицепные</option>
                                        <option value="polupriczepnye">Полуприцепные</option>
                                    </select>
                                    <div class="select-styled">Не выбрано</div>
                                    <ul class="select-options" style="display: none;">
                                        <li rel="null">Не выбрано</li>
                                        <li rel="navesnye">Навесные</li>
                                        <li rel="priczepnye">Прицепные</li>
                                        <li rel="polupriczepnye">Полуприцепные</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col--3 col--md-6 mb--sm-1 mb--md-1">
                        <div class="category_filter-wrap">
                            <div class="select-with-label">
                                <label for="KOLICHESTVORYADOV">Количество рядов (шт):</label>
                                <div class="select">
                                    <select class="custom_select select-hidden" id="KOLICHESTVORYADOV" name="KOLICHESTVORYADOV">
                                        <option value="null">Не выбрано</option>
                                        <option value="6">6</option>
                                        <option value="12">12</option>
                                        <option value="48">48</option>
                                        <option value="64">64</option>
                                        <option value="80">80</option>
                                        <option value="96">96</option>
                                        <option value="112">112</option>
                                        <option value="40">40</option>
                                    </select>
                                    <div class="select-styled">Не выбрано</div>
                                    <ul class="select-options" style="display: none;">
                                        <li rel="null">Не выбрано</li>
                                        <li rel="6">6</li>
                                        <li rel="12">12</li>
                                        <li rel="48">48</li>
                                        <li rel="64">64</li>
                                        <li rel="80">80</li>
                                        <li rel="96">96</li>
                                        <li rel="112">112</li>
                                        <li rel="40">40</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col--3 col--md-6 mb--sm-1 mb--md-1">
                        <div class="category_filter-wrap">
                            <div class="select-with-label">
                                <label for="RASSTOYANIEMEZHDURYADAMI">Расстояние между рядами (см):</label>
                                <div class="select">
                                    <select class="custom_select select-hidden" id="RASSTOYANIEMEZHDURYADAMI" name="RASSTOYANIEMEZHDURYADAMI">
                                        <option value="null">Не выбрано</option>
                                        <option value="70">70</option>
                                        <option value="76">76</option>
                                        <option value="15">15</option>
                                        <option value="19">19</option>
                                        <option value="19,5">19,5</option>
                                        <option value="25">25</option>
                                    </select>
                                    <div class="select-styled">Не выбрано</div>
                                    <ul class="select-options" style="display: none;">
                                        <li rel="null">Не выбрано</li>
                                        <li rel="70">70</li>
                                        <li rel="76">76</li>
                                        <li rel="15">15</li>
                                        <li rel="19">19</li>
                                        <li rel="19,5">19,5</li>
                                        <li rel="25">25</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col--3 col--md-6 align-self-center">
                        <button id="button-submit" type="submit" class="btn btn--gray filter-category__btn btn--small btn--box-shadow">
                            Применить
                        </button>
                        <div id="refresh" class="refresh">
                            <span class="refresh__notsel refresh__icon--white">
                                <svg viewBox="0 0 365.696 365.696" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M243.188 182.86L356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0"></path>
                                </svg>
                            </span>
                            <span class="text refresh__text">
                                Сбросить фильтры
                            </span>
                        </div>
                    </div>
                </div>
            </form>
            <?php endif; ?>
            
            <h2 class="section__subtitle" style="margin: 30px 0 20px;">Товари в категорії</h2>
            <?php if ($is_technika) : ?>
                <!-- Слайдер для категории техника -->
                <div class="category-products-slider owl-carousel">
            <?php else : ?>
                <!-- Обычная сетка для других категорий -->
                <div class="products-flex">
            <?php endif; ?>
                <?php
                while (have_posts()) : the_post();
                    $original_price = get_field('product_price');
                    $original_currency = get_field('product_currency') ?: 'UAH';
                    
                    // Конвертируем цену в UAH для товаров категории "Запчасти"
                    if (function_exists('texk_convert_price_to_uah')) {
                        $price_data = texk_convert_price_to_uah($original_price, $original_currency, get_the_ID());
                        $price = $price_data['price'];
                        $currency = $price_data['currency'];
                    } else {
                        $price = $original_price;
                        $currency = $original_currency;
                    }
                    
                    $subtitle = get_field('product_subtitle');
                    $sku = get_field('product_sku');
                    
                    // Получаем данные для фильтрации (если это категория техника)
                    $model = get_field('product_model') ?: '';
                    $type = get_field('product_type') ?: '';
                    $agregatirovanie = get_field('product_agregatirovanie') ?: '';
                    $kolich_estvoryadov = get_field('product_kolich_estvoryadov') ?: '';
                    $rasstoyaniemezhdu_ryadami = get_field('product_rasstoyaniemezhdu_ryadami') ?: '';
                    ?>
                    <?php if ($is_technika) : ?>
                        <!-- Структура для слайдера техники -->
                        <div class="category__item_slider_item" 
                            data-sku="<?php echo esc_attr($sku ?: ''); ?>"
                            data-model="<?php echo esc_attr($model); ?>"
                            data-type="<?php echo esc_attr($type); ?>"
                            data-agregatirovanie="<?php echo esc_attr($agregatirovanie); ?>"
                            data-kolich-estvoryadov="<?php echo esc_attr($kolich_estvoryadov); ?>"
                            data-rasstoyaniemezhdu-ryadami="<?php echo esc_attr($rasstoyaniemezhdu_ryadami); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php 
                                    $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                    ?>
                                    <img class="owl-lazy" data-src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" src="<?php echo esc_url($thumb_url); ?>">
                                </a>
                            <?php else : ?>
                                <div class="category__item_slider_item--placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>

                    <style>
.product-card--horizontal {
    display: flex;
    gap: 30px;
    background: #fff;
    padding: 0px;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
    margin-bottom: 40px;
    max-height:238px;
    flex-direction: row;
}

/* Левая часть */
.product-card__media {
    flex: 0 0 40%;
    max-width: 40%;
}

.product-card__image {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
}

/* Правая часть */
.product-card__body {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Заголовок */
.product-card__title a {
    color: #e30f1b;
    font-size: 20px;
    font-weight: 700;
    text-decoration: none;
}

.product-card__title a:hover {
    text-decoration: underline;
}

/* Подзаголовок / описание */
.product-card__subtitle,
.product-card__excerpt {
    margin-top: 10px;
    color: #444;
    font-size: 14px;
}

/* Нижний блок */
.product-card__actions {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    padding:20px;
}

/* Чекбоксы */
.product-card__checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    cursor: pointer;
}

.product-card__checkbox input {
    width: 18px;
    height: 18px;
    accent-color: #e30f1b;
}

/* Кнопка */
.product-card__btn {
    margin-left: auto;
    background: #e30f1b;
    color: #fff;
    padding: 12px 30px;
    text-decoration: none;
    font-weight: 600;
    border-radius: 2px;
    transition: background .3s;
}

.product-card__btn:hover {
    background: #c00e18;
}
@media (max-width: 768px) {
    .product-card--horizontal {
        flex-direction: column;
    }

    .product-card__media {
        max-width: 100%;
    }

    .product-card__btn {
        margin-left: 0;
        width: 100%;
        text-align: center;
    }
}


/* ===== PRODUCT SLIDER ===== */
.product-slider {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100%;
    min-height: 280px;
}

.product-slider__track {
    display: flex;
    transition: transform 0.4s ease;
    height: 100%;
}

.product-slider__slide {
    min-width: 100%;
    height: 100%;
}

.product-slider__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Навигация */
.product-slider__nav {
    position: absolute;
    top: 44%;
    transform: translateY(-50%);
    width: 42px;
    height: 42px;
    border-radius: 0px;
    background: rgba(227, 15, 27, 0.95);
    color: #fff;
    border: none;
    font-size: 26px;
    line-height: 42px;
    cursor: pointer;
    z-index: 2;
    transition: background 0.3s, opacity 0.3s;
}

.product-slider__nav:hover {
    background: #c00e18;
}

.product-slider__nav--prev {
    left: 0px;
}

.product-slider__nav--next {
    right: 0px;
}

/* Скрываем стрелки если один слайд */
.product-slider[data-slides="1"] .product-slider__nav {
    display: none;
}
.woocommerce img, .woocommerce-page img {
    height: 238px;
    max-width: 100%;
}
/* Mobile */
@media (max-width: 768px) {
    .product-slider {
        min-height: 220px;
    }
}

                    </style>
                   

                        <!-- Обычная структура карточки для других категорий -->
                   <article class="product-card product-card--horizontal"
    data-sku="<?php echo esc_attr($sku ?: ''); ?>"
    data-model="<?php echo esc_attr($model); ?>"
    data-type="<?php echo esc_attr($type); ?>"
    data-agregatirovanie="<?php echo esc_attr($agregatirovanie); ?>"
    data-kolich-estvoryadov="<?php echo esc_attr($kolich_estvoryadov); ?>"
    data-rasstoyaniemezhdu-ryadami="<?php echo esc_attr($rasstoyaniemezhdu_ryadami); ?>">

    <!-- Левая часть: изображение -->
<div class="product-card__media">
    <?php
    $gallery = get_field('product_gallery');

    if ($gallery && is_array($gallery)) :
    ?>
        <div class="product-slider" data-slider data-slides="<?php echo count($gallery); ?>">
            <div class="product-slider__track">
                <?php foreach ($gallery as $image) :

                    // ACF Gallery может вернуть ID или Array
                    if (is_array($image)) {
                        $img_html = wp_get_attachment_image(
                            $image['ID'],
                            'large',
                            false,
                            [
                                'class' => 'product-slider__image',
                                'loading' => 'lazy',
                            ]
                        );
                    } else {
                        $img_html = wp_get_attachment_image(
                            $image,
                            'large',
                            false,
                            [
                                'class' => 'product-slider__image',
                                'loading' => 'lazy',
                            ]
                        );
                    }
                ?>
                    <div class="product-slider__slide">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo $img_html; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($gallery) > 1) : ?>
                <button class="product-slider__nav product-slider__nav--prev" type="button">‹</button>
                <button class="product-slider__nav product-slider__nav--next" type="button">›</button>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>





    <!-- Правая часть: контент -->
    <div class="product-card__body">

        <h3 class="product-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php if ($subtitle) : ?>
            <div class="product-card__subtitle">
                <?php echo esc_html($subtitle); ?>
            </div>
        <?php endif; ?>

        <?php if (has_excerpt()) : ?>
            <div class="product-card__excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <div class="product-card__actions">
            <label class="product-card__checkbox">
                <input type="checkbox">
                <span>Додати в порівняння</span>
            </label>

            <label class="product-card__checkbox">
                <input type="checkbox">
                <span>У обране</span>
            </label>

            <a href="<?php the_permalink(); ?>" class="product-card__btn">
                Детальніше
            </a>
        </div>

    </div>
</article>
                    <?php endif; ?>
                    <?php
                endwhile;
                ?>
            </div>
            
            <?php if ($is_technika) : ?>
                <script>
                jQuery(document).ready(function($) {
                    if (typeof $.fn.owlCarousel !== 'undefined') {
                        $('.category-products-slider').owlCarousel({
                            items: 3,
                            loop: true,
                            margin: 20,
                            nav: true,
                            dots: false,
                            navText: ['<span class="owl-nav-prev">‹</span>', '<span class="owl-nav-next">›</span>'],
                            lazyLoad: true,
                            responsive: {
                                0: {
                                    items: 1
                                },
                                768: {
                                    items: 2
                                },
                                1024: {
                                    items: 3
                                }
                            }
                        });
                    }
                });
                </script>
            <?php endif; ?>

            <div class="products-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '← Попередня',
                    'next_text' => 'Наступна →',
                ));
                ?>
            </div>
        <?php elseif (!$subcategories || is_wp_error($subcategories) || count($subcategories) === 0) : ?>
            <div class="products-empty">
                <svg class="products-empty__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.96-2.36L6.5 17h11l-3.54-4.71z"/>
                </svg>
                <p class="products-empty__text">Товари в цій категорії поки не додані.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.features {
    padding: 80px 0;
    background: #f5f5f5 url('/wp-content/uploads/2025/12/pattern1.png') repeat;
}

.features__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}

/* Карточка */
.feature-card {
    background: #fff;
    padding: 47px 23px 26px;
    position: relative;
    box-shadow: 0 6px 20px rgba(0, 0, 0, .08);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Иконка */
.feature-card__icon {
width: 56px;
    height: 56px;
    background: #e30f1b;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
    position: absolute;
    top: -12px;
    left: -9px;
}

.feature-card__icon img {
    width: 51px;
    height: 51px;
}
/* Заголовок */
.feature-card__title {
    font-size: 18px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 15px;
    line-height: 1.3;
    max-width: 220px;
    position: relative;
    right: -40px;
    top: -30px;
    margin-bottom: -18px;
}

/* Текст */
.feature-card__text {
    font-size: 14px;
    line-height: 1.7;
    color: #333;
    margin-bottom: 25px;
}

/* Ссылка */
.feature-card__link {
    font-size: 14px;
    font-weight: 700;
    color: #e30f1b;
    text-decoration: none;
}

.feature-card__link:hover {
    text-decoration: underline;
}

</style>

<section class="features">
    <div class="container features__grid">

        <div class="feature-card">
            <div class="feature-card__icon">
                <img src="/wp-content/uploads/2025/12/625582b168e1cc9e507003eafd4eb68a.png" alt="">
            </div>
            <h3 class="feature-card__title">ФІНАНСУВАННЯ ТЕХНІКИ</h3>
            <p class="feature-card__text">
                Бракує коштів на покупку? Ми вибрали для вас найвигідніші умови
                з розрахунком платежів і відправкою заявки прямо з нашого сайту.
            </p>
            <a href="#" class="feature-card__link">ДІЗНАТИСЯ БІЛЬШЕ</a>
        </div>

        <div class="feature-card">
            <div class="feature-card__icon">
                <img src="/wp-content/uploads/2025/12/30876d2a7faa29d91427006c00b93bdf.png" alt="">
            </div>
            <h3 class="feature-card__title">СИСТЕМИ ТОЧНОГО ЗЕМЛЕРОБСТВА</h3>
            <p class="feature-card__text">
                Отримуйте максимальний урожай з кожного гектара з мінімальними
                витратами за допомогою новітніх супутникових і комп’ютерної технологій.
            </p>
            <a href="#" class="feature-card__link">ДІЗНАТИСЯ БІЛЬШЕ</a>
        </div>

        <div class="feature-card">
            <div class="feature-card__icon">
                <img src="/wp-content/uploads/2025/12/b8fb881ec0b7f4978f1861a1cb1fbef1.png" alt="">
            </div>
            <h3 class="feature-card__title">ЗАПЧАСТИНИ ДЛЯ СІВАЛОК</h3>
            <p class="feature-card__text">
                Замовляйте запчастини за каталогом на сайті і оформляйте доставку
                до вашого міста.
            </p>
            <a href="#" class="feature-card__link">ДІЗНАТИСЯ БІЛЬШЕ</a>
        </div>

    </div>
</section>

<style>
.section_grey {
background-image: none;
background: white;
}
</style>

<!-- Blog Section -->
<section class="section section_grey">
    <div class="container">
        <div class="section__head">
            <div class="section__aico">AIKo</div>
            <h2 class="section__title">Агроблог</h2>
        </div>
        
        <?php
        $blog_posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 4,
        ));
        
        if ($blog_posts->have_posts()) :
            ?>
            <div class="product-items agroblog">
                <?php
                while ($blog_posts->have_posts()) : $blog_posts->the_post();
                    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $date = get_the_date('j F Y');
                    ?>
                    <div class="agroblog__item product-items__item product-items__item--start product-items__item--with-image">
                        <?php if ($thumb) : ?>
                            <img class="image--section-bg lazyload" data-src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                        <div class="agroblog__overlay"></div>
                        <div class="product-items__item_wrap product-items__item_wrap--left content-wrap content-wrap--align-left">
                            <?php if ($date) : ?>
                                <span class="date date--gray dflex mb-1"><?php echo esc_html($date); ?></span>
                            <?php endif; ?>

                            <div class="content-wrap_full-height">
                                <h4 class="product-items__item_title">
                                    <a class="text--white" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>

                                <p class="text text--white"><?php // echo wp_kses_post(get_the_excerpt()); ?></p>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="text text--white text--link b">Детальнiше</a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<style>
.full-opis{
background-image: url('/wp-content/uploads/2025/12/pattern1.png');
}
.text-opis {max-width:980px;
margin: 0 auto;
padding: 25px 0;
}
</style>
<section class="full-opis">
<div class="text-opis">
<?php if ($desc = get_field('polnoe_opisanie', $taxonomy . '_' . $term->term_id)) : ?>
    <div class="category-full-description">
        <?php echo $desc; ?>
    </div>
    </div>
<?php endif; ?>
</section>



<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-slider]').forEach(function (slider) {
        const track = slider.querySelector('.product-slider__track');
        const slides = slider.querySelectorAll('.product-slider__slide');
        const prev = slider.querySelector('.product-slider__nav--prev');
        const next = slider.querySelector('.product-slider__nav--next');

        let index = 0;
        const total = slides.length;

        slider.setAttribute('data-slides', total);

        function update() {
            track.style.transform = 'translateX(' + (-index * 100) + '%)';
        }

        if (next) {
            next.addEventListener('click', function () {
                index = (index + 1) % total;
                update();
            });
        }

        if (prev) {
            prev.addEventListener('click', function () {
                index = (index - 1 + total) % total;
                update();
            });
        }
    });
});
</script>


<script>
jQuery(document).ready(function($) {
    var $searchInput = $('#products-search-input');
    var $productsGrid = $('.products-grid');
    var $productsCards = $('.product-card');
    var $sectionSubtitle = $('.section__subtitle').last();
    
    // Функция фильтрации товаров по словам
    function filterProducts(searchTerm) {
        var term = searchTerm.toLowerCase().trim();
        var visibleCount = 0;
        var hasEmptyMessage = $('.products-empty-search').length > 0;
        
        // Если поиск пустой или меньше 3 символов, показываем все товары
        if (term === '' || term.length < 3) {
            // Показываем все товары
            $productsCards.removeClass('hidden');
            if (hasEmptyMessage) {
                $('.products-empty-search').remove();
            }
            $sectionSubtitle.show();
            $searchInput.removeClass('has-text');
            return;
        }
        
        // Добавляем класс для сжатия поля
        $searchInput.addClass('has-text');
        
        // Скрываем заголовок при поиске
        $sectionSubtitle.hide();
        
        // Разбиваем поисковый запрос на слова
        var searchWords = term.split(/\s+/).filter(function(word) {
            return word.length > 0;
        });
        
        // Фильтруем товары по словам из названия и артикулу (SKU)
        $productsCards.each(function() {
            var $card = $(this);
            var title = $card.find('.product-card__title a').text().toLowerCase();
            var sku = ($card.data('sku') || '').toLowerCase();
            
            // Проверяем, что все слова из запроса присутствуют в названии или артикуле
            var titleMatches = searchWords.every(function(word) {
                return title.indexOf(word) !== -1;
            });
            
            var skuMatches = searchWords.every(function(word) {
                return sku.indexOf(word) !== -1;
            });
            
            // Ищем по названию товара (по словам) или артикулу (точное совпадение)
            if (titleMatches || (sku && sku.indexOf(term) !== -1)) {
                $card.removeClass('hidden');
                visibleCount++;
            } else {
                $card.addClass('hidden');
            }
        });
        
        // Показываем сообщение, если ничего не найдено
        if (visibleCount === 0) {
            if (!hasEmptyMessage) {
                $productsGrid.after('<div class="products-empty-search"><p class="products-empty-search__text">Товари не знайдено за запитом "' + searchTerm + '"</p></div>');
            }
        } else {
            if (hasEmptyMessage) {
                $('.products-empty-search').remove();
            }
        }
    }
    
    // Обработка ввода в поле поиска
    $searchInput.on('input', function() {
        var searchTerm = $(this).val();
        // Запускаем поиск только если введено больше 3 символов
        if (searchTerm.length >= 3 || searchTerm.length === 0) {
            filterProducts(searchTerm);
        }
    });
    
    // Обработка отправки формы
    $('#products-search-form').on('submit', function(e) {
        e.preventDefault();
        var searchTerm = $searchInput.val();
        if (searchTerm.length >= 3 || searchTerm.length === 0) {
            filterProducts(searchTerm);
        }
    });
    
    // Очистка поиска при клике на Escape
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $searchInput.val()) {
            $searchInput.val('');
            filterProducts('');
            $searchInput.focus();
        }
    });
    
    // Инициализация кастомных селектов для фильтра
    function initCustomSelects() {
        $('.custom_select').each(function() {
            var $select = $(this);
            if ($select.hasClass('select-hidden')) {
                return; // Уже инициализирован
            }
            
            var $wrapper = $select.closest('.select');
            var $styled = $wrapper.find('.select-styled');
            var $options = $wrapper.find('.select-options');
            
            $select.addClass('select-hidden');
            
            // Устанавливаем начальный текст
            var firstOption = $select.find('option:first');
            if ($styled.length && firstOption.length) {
                $styled.text(firstOption.text());
            }
            
            // Обработчик клика на styled элемент
            $styled.off('click').on('click', function(e) {
                e.stopPropagation();
                $('.select.active').not($wrapper).removeClass('active').find('.select-options').hide();
                $wrapper.toggleClass('active');
                $options.toggle();
            });
            
            // Обработчик клика на опцию
            $options.find('li').off('click').on('click', function(e) {
                e.stopPropagation();
                var value = $(this).attr('rel');
                var text = $(this).text();
                
                $styled.text(text);
                $select.val(value);
                $wrapper.removeClass('active');
                $options.hide();
                
                // Убираем активный класс со всех опций и добавляем к выбранной
                $options.find('li').removeClass('active');
                $(this).addClass('active');
            });
        });
        
        // Закрытие селектов при клике вне их
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.select').length) {
                $('.select').removeClass('active').find('.select-options').hide();
            }
        });
    }
    
    // Инициализация фильтра
    function initCategoryFilter() {
        if ($('#filter-category').length === 0) {
            return; // Фильтр не найден
        }
        
        // Инициализируем кастомные селекты
        initCustomSelects();
        
        // Обработчик отправки формы фильтра
        $('#filter-category').on('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });
        
        // Обработчик сброса фильтров
        $('#refresh').on('click', function(e) {
            e.preventDefault();
            resetFilters();
        });
    }
    
    // Применение фильтров
    function applyFilters() {
        var filters = {
            MODEL1: $('#MODEL1').val(),
            TYPE: $('#TYPE').val(),
            AGREGATIROVANIE: $('#AGREGATIROVANIE').val(),
            KOLICHESTVORYADOV: $('#KOLICHESTVORYADOV').val(),
            RASSTOYANIEMEZHDURYADAMI: $('#RASSTOYANIEMEZHDURYADAMI').val()
        };
        
        var visibleCount = 0;
        var hasEmptyMessage = $('.products-empty-search').length > 0;
        
        // Получаем все карточки товаров (и для слайдера, и для сетки)
        var $allCards = $('.product-card, .category__item_slider_item');
        var $container = $('.products-grid, .category-products-slider');
        
        // Проверяем, есть ли активные фильтры
        var hasActiveFilters = false;
        for (var key in filters) {
            if (filters[key] && filters[key] !== 'null') {
                hasActiveFilters = true;
                break;
            }
        }
        
        if (!hasActiveFilters) {
            // Если нет активных фильтров, показываем все товары
            $allCards.removeClass('hidden');
            if (hasEmptyMessage) {
                $('.products-empty-search').remove();
            }
            // Обновляем слайдер, если он есть
            if ($('.category-products-slider').length && typeof $.fn.owlCarousel !== 'undefined') {
                $('.category-products-slider').trigger('refresh.owl.carousel');
            }
            return;
        }
        
        // Фильтруем товары
        $allCards.each(function() {
            var $card = $(this);
            var cardData = {
                MODEL1: ($card.data('model') || '').toString().toLowerCase(),
                TYPE: ($card.data('type') || '').toString().toLowerCase(),
                AGREGATIROVANIE: ($card.data('agregatirovanie') || '').toString().toLowerCase(),
                KOLICHESTVORYADOV: ($card.data('kolich-estvoryadov') || '').toString(),
                RASSTOYANIEMEZHDURYADAMI: ($card.data('rasstoyaniemezhdu-ryadami') || '').toString()
            };
            
            var matches = true;
            for (var key in filters) {
                if (filters[key] && filters[key] !== 'null') {
                    var filterValue = filters[key].toString().toLowerCase();
                    var cardValue = cardData[key];
                    
                    // Для числовых значений сравниваем как строки
                    if (key === 'KOLICHESTVORYADOV' || key === 'RASSTOYANIEMEZHDURYADAMI') {
                        if (cardValue !== filterValue) {
                            matches = false;
                            break;
                        }
                    } else {
                        // Для текстовых значений проверяем совпадение
                        if (cardValue !== filterValue) {
                            matches = false;
                            break;
                        }
                    }
                }
            }
            
            if (matches) {
                $card.removeClass('hidden');
                visibleCount++;
            } else {
                $card.addClass('hidden');
            }
        });
        
        // Обновляем слайдер, если он есть
        if ($('.category-products-slider').length && typeof $.fn.owlCarousel !== 'undefined') {
            $('.category-products-slider').trigger('refresh.owl.carousel');
        }
        
        // Показываем сообщение, если ничего не найдено
        if (visibleCount === 0) {
            if (!hasEmptyMessage) {
                $container.after('<div class="products-empty-search"><p class="products-empty-search__text">Товари не знайдено за обраними фільтрами</p></div>');
            }
        } else {
            if (hasEmptyMessage) {
                $('.products-empty-search').remove();
            }
        }
    }
    
    // Сброс фильтров
    function resetFilters() {
        $('#MODEL1, #TYPE, #AGREGATIROVANIE, #KOLICHESTVORYADOV, #RASSTOYANIEMEZHDURYADAMI').each(function() {
            $(this).val('null');
            var $wrapper = $(this).closest('.select');
            var $styled = $wrapper.find('.select-styled');
            $styled.text('Не выбрано');
            $wrapper.find('.select-options li').removeClass('active');
            $wrapper.find('.select-options li[rel="null"]').addClass('active');
        });
        
        // Показываем все товары
        var $allCards = $('.product-card, .category__item_slider_item');
        $allCards.removeClass('hidden');
        $('.products-empty-search').remove();
        
        // Обновляем слайдер, если он есть
        if ($('.category-products-slider').length && typeof $.fn.owlCarousel !== 'undefined') {
            $('.category-products-slider').trigger('refresh.owl.carousel');
        }
    }
    
    // Инициализация фильтра при загрузке
    initCategoryFilter();
});
</script>

<?php
get_footer();
