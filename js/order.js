function incrementQuantity(name, price) {
    let quantityElement = document.getElementById(`${name}-quantity`);
    let quantity = parseInt(quantityElement.textContent);
    quantityElement.textContent = quantity + 1;
}

function decrementQuantity(name, price) {
    let quantityElement = document.getElementById(`${name}-quantity`);
    let quantity = parseInt(quantityElement.textContent);
    if (quantity > 0) {
        quantityElement.textContent = quantity - 1;
    }
}

function addToBasket(name, price) {
    let quantity = parseInt(document.getElementById(`${name}-quantity`).textContent);
    if (quantity > 0) {
        let basket = JSON.parse(localStorage.getItem('basket')) || [];
        let itemIndex = basket.findIndex(item => item.name === name);

        if (itemIndex > -1) {
            basket[itemIndex].quantity += quantity;
            basket[itemIndex].totalPrice += quantity * price;
        } else {
            basket.push({ name, price, quantity, totalPrice: quantity * price });
        }

        localStorage.setItem('basket', JSON.stringify(basket));
        alert('Added to basket');
        document.getElementById(`${name}-quantity`).textContent = 0;
    }
}

var loader = document.getElementById('preloader');
window.addEventListener("load", function() {
    setTimeout(function() {
        loader.style.opacity = "0"; // ตั้งค่า opacity เป็น 0 เพิ่อทำให้หายไป
        setTimeout(function() {
            loader.style.display = "none"; // ซ่อน preloader เมื่อแอนิเมชันจบ
        }, 1000); // ระยะเวลาเดียวกับ transition ใน CSS
    }, 500); // หน่วงเวลา 2000 มิลลิวินาที (2 วินาที) ก่อนเริ่ม fade out
});
