function updateBasket() {
    let basket = JSON.parse(localStorage.getItem('basket')) || [];
    let basketList = document.getElementById('basket-list');
    basketList.innerHTML = '';

    basket.forEach((item, index) => {
        let row = document.createElement('tr');
        row.innerHTML = `
            <th scope="row">${index + 1}</th>
            <td>${item.name}</td>
            <td>${item.price} บาท</td>
            <td>${item.quantity}</td>
            <td>${item.totalPrice} บาท</td>
            <td><button class="btn btn-danger" onclick="confirmRemoveFromBasket(${index})">ลบ</button></td>
        `;
        basketList.appendChild(row);
    });
}

function confirmRemoveFromBasket(index) {
    Swal.fire({
        title: 'ยืนยันการลบ',
        text: 'คุณต้องการลบรายการนี้ออกจากตะกร้าหรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            removeFromBasket(index);
        }
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
