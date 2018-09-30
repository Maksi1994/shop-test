document.addEventListener('DOMContentLoaded', function () {

    function calcCalcSumm() {
        const fullCartPrice = document.body.querySelector('.cart-summ');
        const productItemsArray = document.body.querySelectorAll('.full-price');

        let newPrice = 0;
        Array.from(productItemsArray).forEach(item => {
            newPrice += (+item.innerHTML);
        });

        fullCartPrice.innerHTML = Math.round(newPrice * 100) / 100;
    }

    document.body.addEventListener('input', (e) => {
        if (e.target.classList.contains('product-quantity') && e.target.closest('.cart-page')) {


            const productLine = e.target.closest('.product-line');
            const priceFroOne = productLine.dataset.price;

            productLine.querySelector('.full-price').innerHTML = `${(Math.round((priceFroOne * +e.target.value) * 100) / 100)}`;

            calcCalcSumm();
        }
    });

    document.body.addEventListener('click', (e) => {
        if ((e.target.classList.contains('delete-from-cart') ||
            e.target.closest('.delete-from-cart'))
            && e.target.closest('.cart-page')) {
            const userId = document.body.querySelector("script[data-name='add-to-cart-handler']").dataset.user;

            const productLine = e.target.closest('.product-line');
            const productId = productLine.dataset.id;
            const promotionId = productLine.dataset.promotion;

            const currCookies = getCookie(`${userId}-cart`);

            const options = {};
            options['expires'] = new Date(new Date().getTime() + (3600 * 1000 * 24 * 365));
            options['path'] = '/';

            const newData = currCookies.split('|').filter(productItem => {
                if (promotionId && promotionId !== undefined) {
                    return productItem.indexOf(`${productId}=`) === -1 && productItem.indexOf(`&promotion=${promotionId}`) === -1;
                } else {
                    return productItem.indexOf(`${productId}=`) === -1;
                }
            });

            setCookie(`${userId}-cart`, newData.join('|'), options);

            location.reload();
        }
    });
});