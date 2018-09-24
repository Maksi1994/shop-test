document.addEventListener('DOMContentLoaded', () => {

    document.body.addEventListener('click', function (e) {
        const options = {};
        options['expires'] = new Date(new Date().getTime() + (3600 * 1000 * 24 * 365));
        options['path'] = '/';

        if (e.target.classList.contains('add-to-cart-with-quantity')) {
            const orderCountInput = document.body.querySelector('.product-quantity');
            const userId = orderCountInput.dataset.userId;
            const productId = orderCountInput.dataset.id;
            const count = orderCountInput.value;
            const currValue = getCookie(`${userId}-cart`);

            setCookie(`${userId}-cart`, currValue  + (currValue  ? '|' : '') + `${productId}=${count}`, options);
        } else if (e.target.classList.contains('add-to-cart')) {
            const userId = e.target.dataset.userId;
            const productId = e.target.dataset.id;
            const count = 1;
            const currValue = getCookie(`${userId}-cart`);

            setCookie(`${userId}-cart`, currValue  + (currValue  ? '|' : '') + `${productId}=${count}`, options);
        }
    });
});

