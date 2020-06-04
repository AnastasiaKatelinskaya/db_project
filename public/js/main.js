window.onload = onWindowLoaded;

function onWindowLoaded() {

    /*Наведение на телефон*/
    tryToListen('phone_div', 'mouseover', hoverPhone);
    tryToListen('phone_div', 'mouseout', outHoverPhone);

    /*нажатие на еще*/
    tryToListen('dropdownElse', 'click', showDropdownDiv);

    /*Мобильный каталог*/
    tryToListen('mob_first_catalog', 'click', showMobFirstCatalog);
    /*Мобильный каталог1*/
    tryToListen('mob_second_catalog', 'click', showMobSecondCatalog);
    /*Мобильный каталог3*/
    tryToListen('mob_third_catalog', 'click', showMobThirdCatalog);

    /*Наведение на адрес*/
    tryToListen('address_div', 'mouseover', hoverAddress);
    tryToListen('address_div', 'mouseout', outHoverAddress);

    /*Наведение на почту*/
    tryToListen('mail_div', 'mouseover', hoverMail);
    tryToListen('mail_div', 'mouseout', outHoverMail);

    /*Наведение на корзину*/
    tryToListen('shopping_card_div', 'mouseover', hoverShoppingCard);
    tryToListen('shopping_card_div', 'mouseout', outHoverShoppingCard);

    /*Наведение на каталог*/
    tryToListen('catalog_div', 'mouseover', hoverCatalog);
    tryToListen('catalog_div', 'mouseout', outHoverCatalog);

    /*Каталог md*/
    tryToListen('catalog_div', 'click', showMdCatalog);
    tryToListen('catalog_div', 'click', outMdCatalog);


    var height = $('.hit_card').height() + $('.main_page_product_category_title').height();
    $('.main_top_slider').height(height);
    $('.catalog_m').height(height);


    window.onscroll = function () {
        var toTop = document.getElementById('to_top');
        if ($(window).scrollTop() > 300) {
            toTop.style.display = 'block';
        } else {
            toTop.style.display = 'none';
        }
    };

    $('.product_slick').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.product_slick_nav'
    });
    $('.product_slick_nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.product_slick',
        dots: true,
        centerMode: true,
        focusOnSelect: true,
        variableWidth: true
    });
    $('.lazy').slick({
        dots: false,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        lazyLoad: true,
    });

    $('.responsive').slick({
        dots: true,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        lazyLoad: true,
        responsive: [
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 830,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 580,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
}

function tryToListen(id, eventName, func) {
    var el = document.getElementById(id);

    if (el)
        el.addEventListener(eventName, func);
}

/*Наведение на телефон*/
function hoverPhone() {
    var phone = document.getElementById('my_phone_icon');
    phone.classList.add('phone_icon_hover');
}

function outHoverPhone() {
    var phone = document.getElementById('my_phone_icon');
    phone.classList.remove('phone_icon_hover');
}

/*Наведение на адрес*/
function hoverAddress() {
    var address = document.getElementById('my_address_icon');
    address.classList.add('address_icon_hover');
}

function outHoverAddress() {
    var address = document.getElementById('my_address_icon');
    address.classList.remove('address_icon_hover');
}

/*Наведение на почту*/
function hoverMail() {
    var mail = document.getElementById('my_mail_icon');
    mail.classList.add('mail_icon_hover');
}

function outHoverMail() {
    var mail = document.getElementById('my_mail_icon');
    mail.classList.remove('mail_icon_hover');
}

/*Наведение на корзину*/
function hoverShoppingCard() {
    var card = document.getElementById('shopping_card_icon');
    card.classList.add('shopping_card_icon_h');
}

function outHoverShoppingCard() {
    var card = document.getElementById('shopping_card_icon');
    card.classList.remove('shopping_card_icon_h');
}

/*Наведение на каталог*/
function hoverCatalog() {
    var arrow = document.getElementById('arrow_catalog_icon');
    arrow.classList.add('main_menu_icon_hover');
}

function outHoverCatalog() {
    var arrow = document.getElementById('arrow_catalog_icon');
    arrow.classList.remove('main_menu_icon_hover');
}

/*Наведение на каталог*/
function showMdCatalog() {
    if (($('.main_menu').width() < 992) || ((($('.main_menu').width() > 991)) && (window.location.href !== "http://stil-n.itvertex.ru/#"))) {
        var catalog = document.getElementById('md_navbar');
        var arrowImg = document.getElementById('arrow_catalog_icon');

        if (catalog.style.display === 'none') {
            catalog.style.display = 'block';
            catalog.style.position = 'absolute';

            arrowImg.style.transform = 'scale(1, -1)';
        } else {
            catalog.style.display = 'none';
            arrowImg.style.transform = 'scale(1, 1)';
        }
    }
}

function outMdCatalog() {
    if (($('.main_menu').width() < 992) && ($('.main_menu').width() > 767)) {
        var catalog = document.getElementById('md_navbar');
        if (!catalog.style.display === 'none')
            catalog.style.display = 'none';
        catalog.style.position = 'relative';
        catalog.style.zIndex = '0';
    }
}

/* Input number*/
$('form').on('click', 'button:not([type="submit"])', function (e) {
    e.preventDefault();
});

/*end*/

function hamburgerMenu() {
    var div = document.getElementById("hamburgerMenu");

    if (div.style.display === "block") {
        div.style.display = "none";
    } else {
        div.style.display = "block"
    }

}

function showDropdownDiv() {
    var elseDiv = document.getElementById('dropdownElseDiv');
    if (elseDiv.style.display === "block") {
        elseDiv.style.display = "none";
    } else {
        elseDiv.style.display = "block"
    }
}

function showMobFirstCatalog() {
    var cat = document.getElementById('mob_first_cat');
    if (cat.style.display === "block") {
        cat.style.display = "none";
    } else {
        cat.style.display = "block"
    }
}

function showMobSecondCatalog() {
    var cat = document.getElementById('mob_second_cat');
    if (cat.style.display === "block") {
        cat.style.display = "none";
    } else {
        cat.style.display = "block"
    }
}

function showMobThirdCatalog() {
    var cat = document.getElementById('mob_third_cat');
    if (cat.style.display === "block") {
        cat.style.display = "none";
    } else {
        cat.style.display = "block"
    }
}