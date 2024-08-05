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

function confirmAddToBasket(name, price) {
    let quantity = parseInt(document.getElementById(`${name}-quantity`).textContent);
    if (quantity > 0) {
        Swal.fire({
            title: 'ยืนยันการสั่งซื้อ',
            text: `คุณต้องการเพิ่ม ${quantity} ${name} ในตะกร้าหรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'สั่งซื้อ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                addToBasket(name, price);
            }
        });
    } else {
        Swal.fire({
            title: 'ข้อผิดพลาด',
            text: 'กรุณาเลือกจำนวนก่อนทำการสั่งซื้อ',
            icon: 'error'
        });
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
        updateCartCount();
        document.getElementById(`${name}-quantity`).textContent = 0;

        Swal.fire({
            title: 'สำเร็จ',
            text: 'รายการถูกเพิ่มลงในตะกร้า',
            icon: 'success',
            timer: 1000,
            showConfirmButton: false
        });
    }
}

function updateCartCount() {
    let basket = JSON.parse(localStorage.getItem('basket')) || [];
    let totalItems = basket.reduce((total, item) => total + item.quantity, 0);
    document.getElementById('cart-count').textContent = totalItems;
}

function goToSummary() {
    window.location.href = "summary.html";
}

document.addEventListener('DOMContentLoaded', updateCartCount);


var loader = document.getElementById('preloader');
window.addEventListener("load", function() {
    setTimeout(function() {
        loader.style.opacity = "0"; // ตั้งค่า opacity เป็น 0 เพิ่อทำให้หายไป
        setTimeout(function() {
            loader.style.display = "none"; // ซ่อน preloader เมื่อแอนิเมชันจบ
        }, 1000); // ระยะเวลาเดียวกับ transition ใน CSS
    }, 500); // หน่วงเวลา 2000 มิลลิวินาที (2 วินาที) ก่อนเริ่ม fade out
});

