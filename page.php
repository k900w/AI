<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package tex-k
 */

get_header();
?>
<style>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

/* Общие заголовки */
.section-title {
  font-size: 32px;
  font-weight: 900;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 15px;
}

.section-subtitle {
  font-size: 16px;
  color: #333;
  text-align: center;
  margin-bottom: 40px;
}

/* ======= Блок "Наши преимущества" ======= */
.advantages {
  padding: 60px 0;
  background-color: #fff;
}

.cards {
  display: flex;
  gap: 20px;
  justify-content: space-between;
  flex-wrap: wrap;
}

.card {
  flex: 1;
  min-width: 300px;
  border: 1px dashed #ff0000;
  padding: 20px;
  text-align: left;
  
}
.card {
    position: static !important;
    border:0px !important;
    text-align: center !important;

}
.card img {
  width: 100%;
  max-height: 180px;
  object-fit: contain;
  margin-bottom: 15px;
}

.card h3 {
  font-size: 16px;
  font-weight: 900;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.card p {
  font-size: 14px;
  color: #333;
}

/* ======= Блок "Связаться с поддержкой" ======= */
.contact {
  padding: 60px 0;
  background-color: #f9f9f9;
}

.contact-form {
  max-width: 100%;
}

.form-row {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.contact-form input,
.contact-form textarea {
  width: 100%;
  padding: 15px;
  font-size: 14px;
  border: none;
  border-bottom: 2px solid #d6d6d6;
  outline: none;
  transition: border-color 0.3s;
  background: transparent;
}

.form-row input {
  flex: 1;
  min-width: 250px;
}

.contact-form textarea {
  width: 100%;
  resize: vertical;
  min-height: 120px;
}

.contact-form input:focus,
.contact-form textarea:focus {
  border-bottom-color: red;
}

.form-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-top: 20px;
}

.contact-form button {
  background: linear-gradient(to right, #ff0000, #cc0000);
  color: #fff;
  padding: 14px 30px;
  border: none;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.3s ease;
}

.contact-form button:hover {
  background: #a80000;
}

.phone-support {
  font-size: 14px;
  text-align: right;
}

.phone-support a {
  color: #ff0000;
  font-weight: bold;
  text-decoration: none;
  display: block;
  margin-top: 5px;
}


.advantages {
  padding: 50px 20px;
  background-color: #fff;
  text-align: center;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.title {
  font-size: 32px;
  font-weight: 900;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.subtitle {
  font-size: 16px;
  color: #444;
  margin-bottom: 40px;
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
}

.cards {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
}

.card {
  background: #fff;
  border: 1px dashed #ff0000;
  padding: 20px;
  width: calc(33.333% - 13.33px);
  box-sizing: border-box;
  text-align: left;
}

.card img {
  width: 100%;
  height: auto;
  margin-bottom: 15px;
}

.card h3 {
  font-size: 16px;
  font-weight: 900;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.card p {
  font-size: 14px;
  color: #333;
}




/* Общие стили */
.section.review_page.article {
  padding: 40px 0;
  font-family: 'Roboto', sans-serif;
}

.container {
  max-width: 1240px;
  margin: 0 auto;
  padding: 0 20px;
}

/* ============================== */
/* Стилизация селекта (выпадающий список) */
.select {
  position: relative;
  width: 240px;
  margin-bottom: 30px;
}

.select-styled {
  padding: 12px 16px;
  background: #fff;
  border: 1px solid #e0e0e0;
  cursor: pointer;
  border-radius: 4px;
  font-size: 14px;
  color: #333;
  position: relative;
  box-shadow: 0 2px 4px rgba(0,0,0,0.06);
}

.select-styled::after {
  content: '▾';
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #999;
}

.select-options {
  display: none;
  position: absolute;
  z-index: 5;
  top: 100%;
  left: 0;
  right: 0;
  background: #fff;
  border: 1px solid #ccc;
  border-top: none;
}

.select-options li {
  padding: 10px 16px;
  cursor: pointer;
  font-size: 14px;
}

.select-options li:hover {
  background: #f1f1f1;
}

/* Скрываем оригинальный select */
.select-hidden {
  display: none;
}

/* ============================== */
/* Tabs Navigation */
.tabs.manuals_tab {
  display: flex;
  flex-direction: column;
}

.tabs__caption {
  display: flex;
  justify-content: flex-start;
  margin-bottom: 30px;
  gap: 5px;
}

.tabs__item {
  display: flex;
  align-items: center;
  padding: 12px 24px;
  background: #f5f5f5;
  border-radius: 4px;
  color: #000;
  font-weight: 500;
  cursor: pointer;
  transition: 0.3s ease;
}

.tabs__item_active {
  background: #e80000;
  color: #fff;
}

.tabs__item_icon {
  display: inline-flex;
  align-items: center;
  margin-right: 8px;
}

.tabs__item_icon svg {
  width: 18px;
  height: 18px;
  fill: currentColor;
}

/* ============================== */
/* Content layout */
.tabs__content {
  display: none;
}

.tabs__content_active {
  display: block;
}

/* ============================== */
/* Video Grid */
.wrap-cols {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
}

.article__item {
  width: calc(33.333% - 20px);
  box-sizing: border-box;
}

.article__item_image-wrap {
  position: relative;
  overflow: hidden;
  border-radius: 4px;
  margin-bottom: 10px;
}

.article__item iframe {
  width: 100%;
  height: auto;
  aspect-ratio: 16 / 9;
  border: none;
  display: block;
}

/* Текст под видео */
.article__item_text_inner {
  font-size: 14px;
  line-height: 1.4;
  color: #000;
  font-weight: 500;
  position: relative;
  padding-left: 10px;
}

.article__item_text_inner::before {
  content: '';
  width: 3px;
  height: 14px;
  background: #e80000;
  position: absolute;
  left: 0;
  top: 3px;
}


/* Обертка селекта */
.select {
  position: relative;
  width: 240px;
  margin-bottom: 30px;
  font-family: 'Roboto', sans-serif;
}

/* Скрываем оригинальный select */
.select .select-hidden {
  display: none;
}

/* Стилизация текущего выбранного элемента */
.select-styled {
  background: #fff;
  padding: 14px 16px;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 500;
  color: #333;
  cursor: pointer;
  position: relative;
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

/* Стрелка справа */
.select-styled::after {
  content: '';
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%) rotate(0deg);
  border: 6px solid transparent;
  border-top-color: #d20000;
  transition: 0.3s;
}

/* Активное состояние — стрелка вверх */
.select.active .select-styled::after {
  transform: translateY(-50%) rotate(180deg);
}

/* Выпадающий список */
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
}

/* Показывать список, если открыт */
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

/* Активный элемент в списке */
.select-options li.active {
  background-color: #fafafa;
  font-weight: 500;
}

.page-content p {
margin-bottom: 0px !important;
    </style>
<?php while (have_posts()) : the_post(); ?>

    <div class="page-content">
        <?php
        // Output the content - it may contain sections with custom HTML
        the_content();
        ?>
    </div>
    <script>
  document.querySelectorAll('.select').forEach(select => {
    const styled = select.querySelector('.select-styled');
    const options = select.querySelector('.select-options');

    styled.addEventListener('click', () => {
      select.classList.toggle('active');
    });

    options.querySelectorAll('li').forEach(option => {
      option.addEventListener('click', () => {
        styled.textContent = option.textContent;
        select.classList.remove('active');
        
        // Подсветка активного элемента
        options.querySelectorAll('li').forEach(li => li.classList.remove('active'));
        option.classList.add('active');
      });
    });

    // Закрытие при клике вне селекта
    document.addEventListener('click', e => {
      if (!select.contains(e.target)) {
        select.classList.remove('active');
      }
    });
  });
</script>

    <script>
  document.querySelectorAll('.tabs__item').forEach((tab, index) => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.tabs__item').forEach(t => t.classList.remove('tabs__item_active'));
      document.querySelectorAll('.tabs__content').forEach(c => c.classList.remove('tabs__content_active'));

      tab.classList.add('tabs__item_active');
      document.querySelectorAll('.tabs__content')[index].classList.add('tabs__content_active');
    });
  });
</script>

<?php endwhile; ?>

<?php get_footer(); ?>