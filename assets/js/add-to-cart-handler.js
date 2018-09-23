document.addEventListener('DOMContentLoade', () => {
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-to-cart-btn')) {
            const orderCountInput = document.body.querySelector('.product-quantity');
            const userId = orderCountInput.dataset.userId;
            const productId = orderCountInput.dataset.id;
            const count = orderCountInput.value;

            setCookie('')
        }
    });
});

