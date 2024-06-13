function updateSubtotal(productId, price) {
    var quantity = document.getElementById('quantity-' + productId).value;
    var subtotal = quantity * price;
    document.getElementById('subtotal-' + productId).innerText = subtotal.toFixed(2) + ' грн';
    updateTotal();
}

function updateTotal() {
    var total = 0;
    var subtotals = document.querySelectorAll('.subtotal');
    subtotals.forEach(function(subtotal) {
        total += parseFloat(subtotal.innerText);
    });
    document.getElementById('total').innerText = total.toFixed(2) + ' грн';
}