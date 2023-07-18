const stk_product = document.getElementById("stk_product");
const stk_quantity = document.getElementById("stk_quantity");
const add_quantity = document.getElementById("add_quantity");
const new_quantity = document.getElementById("new_quantity");

stk_product.onchange = function () {
    stk_quantity.value = stk_product.value;
    console.log(stk_product.value);
};
add_quantity.onchange = function () {
    new_quantity.value =
        parseFloat(stk_quantity.value) + parseFloat(add_quantity.value);
    round(new_quantity.value);
};


