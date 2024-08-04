function updateBasket() {
    let basket = JSON.parse(localStorage.getItem('basket')) || [];
    let basketList = document.getElementById('basket-list');
    let totalPrice = 0;
    basketList.innerHTML = '';

    basket.forEach((item, index) => {
        let row = document.createElement('tr');
        row.innerHTML = `
            <th scope="row">${index + 1}</th>
            <td>${item.name}</td>
            <td>${item.price} บาท</td>
            <td>${item.quantity}</td>
            <td>${item.totalPrice} บาท</td>
            <td><button class="btn btn-remove" onclick="confirmRemoveFromBasket(${index})">ลบ</button></td>
        `;
        basketList.appendChild(row);
        totalPrice += item.totalPrice;
    });

    document.getElementById('total-price').textContent = totalPrice;
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

function confirmOrder() {
    Swal.fire({
        title: 'ยืนยันการสั่งอาหาร',
        text: 'คุณต้องการสั่งอาหารหรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'สั่งอาหาร',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            printOrder();
            orderFood();
        }
    });
}

function orderFood() {
    Swal.fire({
        title: 'สั่งอาหารสำเร็จ',
        text: 'อาหารของคุณกำลังเตรียมการ',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        clearBasketDirect();
        window.location.href = "menu.html";
    });
}

function printOrder() {
    let basket = JSON.parse(localStorage.getItem('basket')) || [];
    let printContents = `
        <h2>สรุปการสั่งซื้อ</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
    `;

    basket.forEach((item, index) => {
        printContents += `
            <tr>
                <th scope="row">${index + 1}</th>
                <td>${item.name}</td>
                <td>${item.price} บาท</td>
                <td>${item.quantity}</td>
                <td>${item.totalPrice} บาท</td>
            </tr>
        `;
    });

    printContents += `
            </tbody>
        </table>
        <div class="text-end">
            <h4 class="total-price">รวมทั้งหมด: ${document.getElementById('total-price').textContent} บาท</h4>
        </div>
    `;

    let printWindow = window.open('', '', 'height=500,width=800');
    printWindow.document.write('<html><head><title>สรุปการสั่งซื้อ</title>');
    printWindow.document.write(`
        <style>
            @media print {
                body {
                    font-family: 'Kanit', sans-serif;
                    background-color: #fcf2d1;
                }
                h2 {
                    color: #502404;
                    text-align: center;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #502404;
                    color: white;
                }
                .total-price {
                    font-size: 1.5rem;
                    font-weight: bold;
                    text-align: right;
                    color: #502404;
                }
            }
        </style>
    `);
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

function clearBasket() {
    Swal.fire({
        title: 'ยืนยันการล้างตะกร้า',
        text: 'คุณต้องการล้างรายการอาหารทั้งหมดหรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ล้างรายการอาหาร',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            clearBasketDirect();
        }
    });
}

function clearBasketDirect() {
    localStorage.removeItem('basket');
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
    }, 500); // หน่วงเวลา 500 มิลลิวินาที (0.5 วินาที) ก่อนเริ่ม fade out
});
