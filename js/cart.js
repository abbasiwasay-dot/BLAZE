/* ============ BLAZE — CART DRAWER + PRODUCT DETAIL ============ */

let cart = JSON.parse(localStorage.getItem("blazeCart") || "[]");

let overlay = document.getElementById("blzOverlay");
let drawer  = document.getElementById("cartDrawer");
let detail  = document.getElementById("detailModal");
let toast   = document.getElementById("blzToast");
let cartItemsBox   = document.getElementById("cartItems");

function saveCart(){
  localStorage.setItem("blazeCart", JSON.stringify(cart));
  renderCart();
}
function showToast(m){
  toast.textContent = m;
  toast.classList.add("show");
  setTimeout(()=> toast.classList.remove("show"), 1800);
}
function openDrawer(){ drawer.classList.add("open"); overlay.classList.add("open"); }
function closeAll(){
  drawer.classList.remove("open");
  detail.classList.remove("open");
  overlay.classList.remove("open");
}

overlay.addEventListener("click", closeAll);
document.getElementById("cartClose").addEventListener("click", closeAll);
document.getElementById("detailClose").addEventListener("click", closeAll);
document.addEventListener("keydown", e => { if(e.key === "Escape") closeAll(); });

document.getElementById("cartOpen").addEventListener("click", e => {
  e.preventDefault();
  openDrawer();
});

/* ---------- cart ---------- */
function addToCart(item, qty){
  let found = cart.find(c => c.id === item.id);
  if(found) found.qty += qty;
  else cart.push({ ...item, qty: qty });
  saveCart();
  showToast(item.name + " added to cart");
}

function renderCart(){
  let box   = document.getElementById("cartItems");
  let count = cart.reduce((s,i)=> s + i.qty, 0);
  let sub   = cart.reduce((s,i)=> s + i.price * i.qty, 0);
  let del   = cart.length ? 150 : 0;

  let badge = document.getElementById("cartCount");
  badge.textContent = count;
  badge.classList.toggle("show", count > 0);
  document.getElementById("cartCountText").textContent = count + (count === 1 ? " item" : " items");

  if(!cart.length){
    box.innerHTML = `<div class="cart-empty"><strong>Cart is empty</strong></div>`;
  } else {
    box.innerHTML = cart.map((i, idx) => `
      <div class="cart-item">
        <img src="${i.img}" alt="${i.name}">
        <div>
          <h4>${i.name}</h4>
          <span class="ci-price">Rs. ${i.price}</span>
          <div class="ci-remove" data-remove="${idx}"><i class="fa-solid fa-trash"></i></div>
        </div>
        <div class="qty">
          <button data-minus="${idx}">-</button><span>${i.qty}</span><button data-plus="${idx}">+</button>
        </div>
      </div>`).join("");
  }

  document.getElementById("cartSub").textContent   = "Rs. " + sub;
  document.getElementById("cartDel").textContent   = "Rs. " + del;
  document.getElementById("cartTotal").textContent = "Rs. " + (sub + del);
}

cartItemsBox.onclick = e => {
  let t = e.target.closest("[data-plus], [data-minus], [data-remove]");
  if (!t) return;

  if (t.dataset.plus) cart[t.dataset.plus].qty++;
  else if (t.dataset.minus) { let i = t.dataset.minus; if (--cart[i].qty < 1) cart.splice(i, 1); }
  else if (t.dataset.remove) cart.splice(t.dataset.remove, 1);

  saveCart();
};

/* ---------- product detail popup ---------- */
let current = null;
let dQty = 1;

document.querySelectorAll(".menu-card").forEach(card => {
  card.addEventListener("click", e => {
    let item = {
      id:    card.dataset.id,
      name:  card.dataset.name,
      price: Number(card.dataset.price),
      img:   card.dataset.img,
      desc:  card.dataset.desc,
      cat:   card.dataset.cat
    };

    if(e.target.classList.contains("add-btn")){
      addToCart(item, 1);
      return;
    }

    current = item;
    dQty = 1;
    document.getElementById("dImg").src        = item.img;
    document.getElementById("dCat").textContent   = item.cat;
    document.getElementById("dName").textContent  = item.name;
    document.getElementById("dDesc").textContent  = item.desc || "Fresh, hot aur fired up - Blaze kitchen .";
    document.getElementById("dPrice").textContent = "Rs. " + item.price;
    document.getElementById("dQty").textContent   = dQty;
    detail.classList.add("open");
    overlay.classList.add("open");
  });
});

document.getElementById("dPlus").addEventListener("click", () => {
  dQty++;
  document.getElementById("dQty").textContent = dQty;
});
document.getElementById("dMinus").addEventListener("click", () => {
  if(dQty > 1) dQty--;
  document.getElementById("dQty").textContent = dQty;
});
document.getElementById("dAdd").addEventListener("click", () => {
  addToCart(current, dQty);
 
  
});

renderCart();