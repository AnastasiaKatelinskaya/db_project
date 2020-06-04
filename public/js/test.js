function sendBasket() {

    $.ajax({
        method: 'POST',
        url: "/createOrder",
        data: {phone: document.getElementById('phoneBasket').value, email: document.getElementById('emailBasket').value}
    }).done(function (data) {
        $('.js-last-comments').html(data);
    });
}

function checkedBasket() {
// debugger
    if (document.getElementById('save-info').checked === true) {
        document.getElementById('buttonBasket').removeAttribute("disabled")

    }
    if (document.getElementById('save-info').checked === false) {
        document.getElementById('buttonBasket').setAttribute("disabled", false)
    }

}

$("#basket_").submit(function () {
    $.ajax({
        method: 'POST',
        url: "/basket"
    }).done(function (data) {
        $('.js_basket').html(data);
    });
})

function _getDetails() {

    $.ajax({
        method: 'POST',
        url: "/basket"
    }).done(function (data) {
        $('.js_basket').html(data);
    });
}

function setPostBasket($product, $value) {

    $.ajax({
        method: 'POST',
        url: "/updatebasket",
        data: {product: $product, value: $value}
    });
    return false
}

function setPostBasketProductItem() {

    $.ajax({
        method: 'POST',
        url: "/basket",
    });
}

function getdelate($id) {

    $.ajax({
        method: 'POST',
        url: "/deleteBasket/" + $id
    }).done(function (data) {
        $('.js-last-comments').html(data);
    });
}

function addAttribute() {

    $.ajax({
        method: 'POST',
        url: "/basket"
    }).done(function (data) {
        $('.js-last-comments').html(data);
    });
}

$(document).ready(function () {
    function postBasket() {
        var form_data = $(this).serialize();
        console.log($(this).serialize());
        $.ajax({
            type: "POST",
            url: "/basket",
            data: form_data,

        });
    }


});
