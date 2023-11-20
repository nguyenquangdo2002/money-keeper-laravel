// Lắng nghe sự kiện khi trường input thay đổi giá trị
document
  .querySelector('input[name="sodubandau"]')
  .addEventListener("input", function (e) {
    // Lấy giá trị nhập vào từ trường input
    let value = e.target.value.replace(/\D/g, "");

    // Định dạng số với dấu phẩy sau mỗi ba chữ số 0
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    // Hiển thị giá trị đã định dạng lại vào trường input
    e.target.value = value;
  });
