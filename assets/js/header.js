/**
 * Header JavaScript
 * Mobile menu and search functionality - exact match with tex-k.com.ua
 */
(function ($) {
    'use strict';

    $(document).ready(function () {

        // Mobile Menu Toggle - Open
        $('.showMobileMenu--js, .mobile-header__openMenuAction').on('click', function (e) {
            e.preventDefault();
            $('.mobile-header-show').addClass('active').css('left', '0');
            $('.mobile-header-show__shadow').addClass('active');
            $('body').addClass('menu-open');
        });

        // Mobile Menu Toggle - Close
        $('.mobile-header-show__closed, .mobile-header-show__shadow').on('click', function () {
            $('.mobile-header-show').removeClass('active').css('left', '-20rem');
            $('.mobile-header-show__shadow').removeClass('active');
            $('body').removeClass('menu-open');
        });

        // Mobile Submenu Toggle
        $('.mobile-menu__item--has-children > a, .mobile-menu__item.menu-item-has-children > a').on('click', function (e) {
            e.preventDefault();
            var $parent = $(this).parent();
            var $submenu = $parent.find('.mobile-menu__submenu, .sub-menu');

            // Close other submenus
            $('.mobile-menu__item--has-children, .mobile-menu__item.menu-item-has-children').not($parent).removeClass('active');
            $('.mobile-menu__submenu, .mobile-menu .sub-menu').not($submenu).slideUp(300);

            // Toggle current
            $parent.toggleClass('active');
            $submenu.slideToggle(300);
        });

        // Mobile Search - Open
        $('.openMobileSearch--js, .mobile-header__search-icon').on('click', function () {
            $('.mobile-search-overlay').addClass('active');
            $('.mobile-search-overlay input').focus();
        });

        // Mobile Search - Close
        $('.mobile-search-overlay__close').on('click', function () {
            $('.mobile-search-overlay').removeClass('active');
        });

        // Close on overlay click
        $('.mobile-search-overlay').on('click', function (e) {
            if (e.target === this) {
                $(this).removeClass('active');
            }
        });

        // Close menu/search on escape key
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                // Close mobile search
                $('.mobile-search-overlay').removeClass('active');

                // Close mobile menu
                $('.mobile-header-show').removeClass('active').css('left', '-20rem');
                $('.mobile-header-show__shadow').removeClass('active');
                $('body').removeClass('menu-open');
            }
        });

        // Desktop header scroll behavior
        var lastScrollTop = 0;
        var $header = $('header.desktop-header');
        var headerHeight = $header.outerHeight();

        $(window).on('scroll', function () {
            var scrollTop = $(this).scrollTop();

            if (scrollTop > 100) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }

            lastScrollTop = scrollTop;
        });

        // Desktop mega menu hover intent
        var menuTimeout;

        $('.header__menu_item--submenu').on('mouseenter', function () {
            var $this = $(this);
            clearTimeout(menuTimeout);
            $this.find('.catalog-menu').css({
                display: 'flex',
                opacity: 1
            });
        }).on('mouseleave', function () {
            var $this = $(this);
            menuTimeout = setTimeout(function () {
                $this.find('.catalog-menu').css({
                    display: 'none',
                    opacity: 0
                });
            }, 100);
        });

        // Fix for menu items with sub-menu class (WordPress default)
        $('.header__menu .menu-item-has-children').addClass('header__menu_item--submenu');
        $('.header__menu .menu-item-has-children > .sub-menu').addClass('catalog-menu');

    });

})(jQuery);
