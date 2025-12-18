/**
 * Простая корзина запчастей (сессия + ajax)
 */
jQuery(function ($) {
    if (typeof texkCart === 'undefined') {
        return;
    }

    const ajaxurl = texkCart.ajaxurl;
    const nonce = texkCart.nonce;

    function updateCount(count) {
        $('.header_basket__count').text(count);
    }

    // Добавить в корзину
    $(document).on('click', 'a.add2basket', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('id');
        if (!productId) {
            return;
        }

        $.post(ajaxurl, {
            action: 'texk_add_to_cart',
            nonce: nonce,
            product_id: productId
        }).done(function (res) {
            if (res && res.success) {
                updateCount(res.data.count || 0);
                if ($btn.hasClass('btn')) {
                    $btn.text('У кошику');
                } else {
                    $btn.text('У кошик');
                }
            }
        });
    });

    // Отправка заявки из модалки
    $(document).on('submit', '#basket-form', function (e) {
        e.preventDefault();
        const $form = $(this);

        $.post(ajaxurl, {
            action: 'texk_order_parts',
            nonce: nonce,
            name: $form.find('input[name="name"]').val(),
            phone: $form.find('input[name="phone"]').val(),
            email: $form.find('input[name="email"]').val(),
            comment: $form.find('textarea[name="comment"]').val()
        }).done(function (res) {
            if (res && res.success) {
                updateCount(res.data.count || 0);
                $form[0].reset();
                alert('Заявку відправлено');
            } else if (res && res.data && res.data.message) {
                alert(res.data.message);
            }
        });
    });
});

