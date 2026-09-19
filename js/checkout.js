/* ============ BLAZE — CHECKOUT ============ */

let cart = JSON.parse(localStorage.getItem("blazeCart") || "[]");
let discount = 0;
let payment = "Cash on Delivery";
let toast = document.getElementById("blzToast");

function msg(t) {
  toast.textContent = t;
  toast.classList.add("show");
  setTimeout(() => toast.classList.remove("show"), 1800);
}

function render() {
  let box = document.getElementById("coItems");
  if (!cart.length) {
    box.innerHTML = `<p style="color:var(--gray);padding:14px 0">Cart is Empty <a href="index.php#menu" style="color:var(--red-light)">MENU</a></p>`;
  } else {
    box.innerHTML = cart.map(i =>
      `<div class="sum-item"><span>${i.name} × ${i.qty}</span><strong>Rs. ${i.price * i.qty}</strong></div>`
    ).join("");
  }

  let sub = cart.reduce((s, i) => s + i.price * i.qty, 0);
  let del = cart.length ? 150 : 0;
  let disc = Math.round(sub * discount);

  document.getElementById("coSub").textContent = "Rs. " + sub;
  document.getElementById("coDisc").textContent = "- Rs. " + disc;
  document.getElementById("coDel").textContent = "Rs. " + del;
  document.getElementById("coTotal").textContent = "Rs. " + (sub - disc + del);
  return sub - disc + del;
}


document.querySelectorAll(".pay-opt").forEach(opt => {
  opt.addEventListener("click", () => {
    document.querySelectorAll(".pay-opt").forEach(o => o.classList.remove("active"));
    opt.classList.add("active");
    payment = opt.dataset.pay;
  });
});


document.getElementById("promoBtn").addEventListener("click", () => {
  let code = document.getElementById("promoInput").value.trim().toUpperCase();
  if (code === "BLAZE40") { discount = 0.4; msg("40% off applied 🔥"); }
  else { discount = 0; msg("Invalid code"); }
  render();
});


document.getElementById("placeOrder").addEventListener("click", () => {
  let name = document.getElementById("coName").value.trim();
  let phone = document.getElementById("coPhone").value.trim();
  let address = document.getElementById("coAddress").value.trim();

  if (!cart.length) return msg("Cart is empty");
  if (!name || !phone || !address) return msg("please fill the details");

  let total = render();

  let order = {
    id: "#BLZ" + Math.floor(1000 + Math.random() * 9000),
    name: name,
    phone: phone,
    address: address + ", " + document.getElementById("coCity").value,
    note: document.getElementById("coNote").value,
    payment: payment,
    items: cart,
    total: total
  };

  fetch("save_order.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(order)
  })
  .then(r => r.json())
  .then(res => {
    if (res.success) {
      localStorage.removeItem("blazeCart");
      msg("Order placed ✅");
      setTimeout(() => location.href = "dashboard.php", 1000);
    } else {
      msg(res.message || "Error saving order");
      if (res.message && res.message.toLowerCase().includes("log in")) {
        setTimeout(() => location.href = "login.php", 1500);
      }
    }
  })
  .catch(() => msg("Server error, try again"));
});

render();