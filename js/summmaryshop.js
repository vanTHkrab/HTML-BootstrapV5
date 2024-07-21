function updateBasket() {
    let basket = JSON.parse(localStorage.getItem('basket')) || [];
    let basketList = document.getElementById('basket-list');
    basketList.innerHTML = '';

    basket.forEach((item, index) => {
        let row = document.createElement('tr');
        row.innerHTML = `
            <th scope="row">${index + 1}</th>
            <td>${item.name}</td>
            <td>${item.price}</td>
            <td>${item.quantity}</td>
            <td>${item.totalPrice}</td>
            <td><button class="btn btn-danger" onclick="removeFromBasket(${index})">ลบ</button></td>
        `;
        basketList.appendChild(row);
    });
}

function removeFromBasket(index) {
    let basket = JSON.parse(localStorage.getItem('basket')) || [];
    if (index > -1) {
        basket.splice(index, 1);
    }
    localStorage.setItem('basket', JSON.stringify(basket));
    updateBasket();
}

document.addEventListener('DOMContentLoaded', updateBasket);

var loader = document.getElementById('preloader');
window.addEventListener("load", function() {
    setTimeout(function() {
        loader.style.opacity = "0"; // ตั้งค่า opacity เป็น 0 เพิ่อทำให้หายไป
        setTimeout(function() {
            loader.style.display = "none"; // ซ่อน preloader เมื่อแอนิเมชันจบ
        }, 1000); // ระยะเวลาเดียวกับ transition ใน CSS
    }, 500); // หน่วงเวลา 2000 มิลลิวินาที (2 วินาที) ก่อนเริ่ม fade out
});
