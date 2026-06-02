let cart = [];


const products = document.querySelectorAll(".product");
const cartList = document.querySelector("#cartList");
const totalEl = document.querySelector("#total");
const payBtn = document.querySelector("#payBtn");
const clearBtn = document.querySelector("#clearBtn");
const filter = document.querySelector("#categoryFilter");

const calculateTotal = () => {
  let sum = 0;
  cart.forEach(item => (sum += item.price));
  return sum;
};


const renderCart = () => {
  cartList.innerHTML = "";

  cart.forEach((item, index) => {
    const li = document.createElement("li");
    li.textContent = `${item.title} — ${item.price} руб. `;

    const delBtn = document.createElement("button");
    delBtn.textContent = "Удалить";
    delBtn.addEventListener("click", () => removeFromCart(index));

    li.appendChild(delBtn);
    cartList.appendChild(li);
  });

  totalEl.textContent = "Итого: " + calculateTotal();
};


const removeFromCart = (index) => {
  cart.splice(index, 1);
  renderCart();
};


const addToCart = (productEl) => {
  const title = productEl.dataset.title;
  const price = Number(productEl.dataset.price);
  const category = productEl.dataset.category;

  cart.push({ title, price, category });
  renderCart();
};


const applyFilter = () => {
  const value = filter.value;

  products.forEach(product => {
    const cat = product.dataset.category;

    if (value === "all" || cat === value) {
      product.style.display = "block";
    } else {
      product.style.display = "none";
    }
  });
};


products.forEach(product => {
  const btn = product.querySelector(".add-to-cart");
  btn.addEventListener("click", () => addToCart(product));
});


payBtn.addEventListener("click", () => {
  if (cart.length === 0) {
    alert("Корзина пуста");
    return;
  }

  alert("Покупка прошла успешно!");
  cart = [];
  renderCart();
});


clearBtn.addEventListener("click", () => {
  cart = [];
  renderCart();
});

filter.addEventListener("change", applyFilter);