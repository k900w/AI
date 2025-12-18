    </main>
    <style>
.top-footer__menu-items_item_lists {

padding: 0px 20px 0px 20px;
}
.sub-menu {    margin-top: 15px;}
.top-footer__menu-items_item_lists {
    width: 20%;
    padding: 0px 1rem;
    flex-direction: column;
    border-right: solid 1px rgba(255, 255, 255, .1);
}
.top-footer__logo img {
    display: flex;
    margin: auto 0;
    height: 91px;
    padding: 0;
    width: 185px;
    align-items: flex-start;
}
.top-footer__menu-items_item_lists a {
    display: -webkit-box;
    display: -webkit-box;
    font-family: "Proxima Nova Th", sans-serif;
    font-weight: 900;
   }
    .sub-menu li  a{
            font-family: "Proxima Nova Rg", sans-serif;
        font-weight: 400;}
    </style>
    <footer class="top-footer">
        <div class="container">
            <div class="top-footer__wrap">
            <div>   
            <div class="top-footer__logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/TEX_K.png" alt="<?php bloginfo('name'); ?>">
                </div>
                <div class="top-footer__logo">
                    <img src="/wp-content/themes/tex-k_test/assets/images/kuhn_logotype.svg">
                </div>
                </div>
                <div class="top-footer__menu-items">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'top-footer__menu-items',
                        'fallback_cb' => false,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </footer>
    
    <footer class="bottom-footer">
        <div class="container">
            <div class="bottom-footer__wrap dflex">
                <div class="copyrights">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Всі права захищені.
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Modal Popup for Configuration Request -->
<div id="modal-config-popup" class="modal-overlay" style="display: none;">
    <div class="modal-popup">
        <div class="modal-popup-header">
            Заявка на розрахунок вартості конфігурації
            <div class="modal-close-btn"></div>
        </div>
        <div class="modal-popup-body">
            <div class="modal-left">
                <p>Ми зв'яжемося протягом 2 робочих годин, підберемо додаткові параметри і зробимо пропозицію.</p>
                <div class="modal-type-box">
                    <span>Тип:</span>
                </div>
            </div>
            <div class="modal-right">
                <form id="config-request-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                    <input type="hidden" name="action" value="texk_config_request">
                    <input type="hidden" name="product_id" value="<?php echo is_singular('product') ? get_the_ID() : ''; ?>">
                    <input type="text" name="name" placeholder="Введіть ваше ім'я *" required>
                    <input type="tel" name="phone" placeholder="Введіть Ваш телефон *" required>
                    <input type="email" name="email" placeholder="Введіть Ваш e-mail">
                    <div class="modal-select-wrapper">
                        <select name="region" required>
                            <option value="" selected disabled>Оберіть регіон *</option>
                            <option value="Автономна республіка Крим">Автономна республіка Крим</option>
                            <option value="Вінницька область">Вінницька область</option>
                            <option value="Волинська область">Волинська область</option>
                            <option value="Дніпропетровська область">Дніпропетровська область</option>
                            <option value="Донецька область">Донецька область</option>
                            <option value="Житомирська область">Житомирська область</option>
                            <option value="Закарпатська область">Закарпатська область</option>
                            <option value="Запорізька область">Запорізька область</option>
                            <option value="Івано-Франківська область">Івано-Франківська область</option>
                            <option value="Київська область">Київська область</option>
                            <option value="Кіровоградська область">Кіровоградська область</option>
                            <option value="Луганська область">Луганська область</option>
                            <option value="Львівська область">Львівська область</option>
                            <option value="Миколаївська область">Миколаївська область</option>
                            <option value="Одеська область">Одеська область</option>
                            <option value="Полтавська область">Полтавська область</option>
                            <option value="Рівненська область">Рівненська область</option>
                            <option value="Сумська область">Сумська область</option>
                            <option value="Тернопільська область">Тернопільська область</option>
                            <option value="Харківська область">Харківська область</option>
                            <option value="Херсонська область">Херсонська область</option>
                            <option value="Хмельницька область">Хмельницька область</option>
                            <option value="Черкаська область">Черкаська область</option>
                            <option value="Чернівецька область">Чернівецька область</option>
                            <option value="Чернігівська область">Чернігівська область</option>
                        </select>
                    </div>
                    <textarea name="comment" placeholder="Додати коментар"></textarea>
                    <button type="submit" class="modal-btn">Запросити вартість конфігурації</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup for Demo Request -->
<div id="modal-demo-popup" class="modal-overlay" style="display: none;">
    <div class="modal-popup">
        <div class="modal-popup-header">
            Заявка на демопоказ
            <div class="modal-close-btn"></div>
        </div>
        <div class="modal-popup-body">
            <div class="modal-left">
                <p>Ми зв'яжемося протягом 2 робочих годин, підберемо додаткові параметри і зробимо пропозицію.</p>
                <div class="modal-type-box">
                    <span>Тип:</span>
                </div>
            </div>
            <div class="modal-right">
                <form id="demo-request-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                    <input type="hidden" name="action" value="texk_demo_request">
                    <input type="hidden" name="product_id" value="<?php echo is_singular('product') ? get_the_ID() : ''; ?>">
                    <input type="text" name="name" placeholder="Введіть ваше ім'я *" required>
                    <input type="tel" name="phone" placeholder="Введіть Ваш телефон *" required>
                    <input type="email" name="email" placeholder="Введіть Ваш e-mail">
                    <div class="modal-select-wrapper">
                        <select name="region" required>
                            <option value="" selected disabled>Оберіть регіон *</option>
                            <option value="Автономна республіка Крим">Автономна республіка Крим</option>
                            <option value="Вінницька область">Вінницька область</option>
                            <option value="Волинська область">Волинська область</option>
                            <option value="Дніпропетровська область">Дніпропетровська область</option>
                            <option value="Донецька область">Донецька область</option>
                            <option value="Житомирська область">Житомирська область</option>
                            <option value="Закарпатська область">Закарпатська область</option>
                            <option value="Запорізька область">Запорізька область</option>
                            <option value="Івано-Франківська область">Івано-Франківська область</option>
                            <option value="Київська область">Київська область</option>
                            <option value="Кіровоградська область">Кіровоградська область</option>
                            <option value="Луганська область">Луганська область</option>
                            <option value="Львівська область">Львівська область</option>
                            <option value="Миколаївська область">Миколаївська область</option>
                            <option value="Одеська область">Одеська область</option>
                            <option value="Полтавська область">Полтавська область</option>
                            <option value="Рівненська область">Рівненська область</option>
                            <option value="Сумська область">Сумська область</option>
                            <option value="Тернопільська область">Тернопільська область</option>
                            <option value="Харківська область">Харківська область</option>
                            <option value="Херсонська область">Херсонська область</option>
                            <option value="Хмельницька область">Хмельницька область</option>
                            <option value="Черкаська область">Черкаська область</option>
                            <option value="Чернівецька область">Чернівецька область</option>
                            <option value="Чернігівська область">Чернігівська область</option>
                        </select>
                    </div>
                    <textarea name="comment" placeholder="Додати коментар"></textarea>
                    <button type="submit" class="modal-btn">Замовити демопоказ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup for Consultation Request -->
<div id="modal-consultation-popup" class="modal-overlay modal-consultation" style="display: none;">
    <div class="modal-popup modal-consultation-popup">
        <div class="modal-popup-header">
            ЗАЯВКА НА КОНСУЛЬТАЦІЮ
            <div class="modal-close-btn"></div>
        </div>
        <div class="modal-popup-body modal-consultation-body">
            <form id="consultation-request-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                <input type="hidden" name="action" value="texk_consultation_request">
                <input type="hidden" name="product_id" value="<?php echo is_singular('product') ? get_the_ID() : ''; ?>">
                <div class="modal-consultation-field">
                    <label>Введите Ваше имя *</label>
                    <input type="text" name="name" required>
                </div>
                <div class="modal-consultation-field">
                    <label>Введите Ваш телефон *</label>
                    <input type="tel" name="phone" required>
                </div>
                <div class="modal-consultation-field">
                    <label>Введите Ваш e-mail</label>
                    <input type="email" name="email">
                </div>
                <div class="modal-consultation-field">
                    <label>Добавить комментарий</label>
                    <textarea name="comment" rows="4"></textarea>
                </div>
                <button type="submit" class="modal-btn modal-consultation-btn">Відправити заявку</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Popup for Test Drive Request -->
<div id="modal-test_drive-popup" class="modal-overlay modal-test-drive" style="display: none;">
    <div class="modal-popup modal-test-drive-popup">
        <section class="test-drive">
            <div class="test-drive-header">
                <h2>ЗАКАЗАТЬ<br />ТЕСТ‑ДРАЙВ</h2>
                <div class="modal-close-btn"></div>
            </div>
            <div class="test-drive-content">
                <!-- Левая колонка с описанием и преимуществами -->
                <div class="test-drive-left">
                    <p class="description">
                        Испытайте технику в реальных условиях перед тем как принять
                        решение о покупке с консультацией эксперта, обученного на заводе
                        производителя.
                    </p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <rect x="2" y="22" width="32" height="16" fill="white" />
                                    <rect x="34" y="26" width="16" height="12" fill="white" />
                                    <circle cx="14" cy="44" r="4" fill="white" />
                                    <circle cx="38" cy="44" r="4" fill="white" />
                                </svg>
                            </div>
                            <div class="feature-text">
                                <span class="feature-title">
                                    Доставка в&nbsp;любой регион Украины
                                </span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <line x1="16" y1="16" x2="48" y2="48" stroke="white" stroke-width="8" stroke-linecap="round" />
                                    <line x1="48" y1="16" x2="16" y2="48" stroke="white" stroke-width="8" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div class="feature-text">
                                <span class="feature-title">
                                    Никаких расходов и&nbsp;обязательств покупки с вашей стороны
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Правая колонка с формой -->
                <div class="test-drive-form">
                    <form id="test-drive-request-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                        <input type="hidden" name="action" value="texk_test_drive_request">
                        <input type="hidden" name="product_id" value="<?php echo is_singular('product') ? get_the_ID() : ''; ?>">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Введите Ваше имя *" required />
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Введите Ваш телефон *" required />
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Введите Ваш e-mail" />
                        </div>
                        <div class="form-group">
                            <textarea name="comment" placeholder="Добавить комментарий"></textarea>
                        </div>
                        <button type="submit" class="test-drive-submit-btn">Заказать тест‑драйв</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>




