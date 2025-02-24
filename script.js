document.addEventListener("DOMContentLoaded", function(){
  let cart = [];
  
  window.addToCart = function(name, price) {
      cart.push({name: name, price: price});
      renderCart();
  }
  
  function renderCart() {
      let cartDiv = document.getElementById("cart");
      let itemsInput = document.getElementById("itemsInput");
      let totalInput = document.getElementById("totalInput");
      cartDiv.innerHTML = "";
      let total = 0;
      cart.forEach(function(item){
         let p = document.createElement("p");
         p.textContent = item.name + " - $" + item.price;
         cartDiv.appendChild(p);
         total += item.price;
      });
      itemsInput.value = JSON.stringify(cart);
      totalInput.value = total;
  }
});
