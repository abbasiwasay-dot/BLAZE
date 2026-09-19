let buttons = document.querySelectorAll(".admin-nav-item");
let views = document.querySelectorAll(".admin-view");
let addproduct=document.querySelector("#addProductBtn");
let productform=document.querySelector(".modal-overlay");
let closeform=document.querySelector("#closeModal");

buttons.forEach(function(button) {

    button.addEventListener("click", function() {

        let name = button.getAttribute("data-view");

        views.forEach(function(view) {
            view.classList.remove("active");
        });

        buttons.forEach(function(btn) {
            btn.classList.remove("active");
        });

        document.getElementById("view-" + name).classList.add("active");

        button.classList.add("active");

    });

});

addproduct.addEventListener("click",()=>{
     productform.classList.add("open");

});
closeform.addEventListener("click",()=>{
    productform.classList.remove("open");
})

let filterPills = document.querySelectorAll(".filter-pill");
let orderRows = document.querySelectorAll("#ordersTable .order-row-wide");

filterPills.forEach(function (pill) {
  pill.addEventListener("click", function () {

    filterPills.forEach(function (p) { p.classList.remove("active"); });
    pill.classList.add("active");

    let status = pill.dataset.status;

    orderRows.forEach(function (row) {
      row.style.display = (status === "all" || row.dataset.status === status) ? "" : "none";
    });

  });
});